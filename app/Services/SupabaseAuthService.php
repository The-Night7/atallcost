<?php

declare(strict_types=1);

namespace App\Services;

use App\Support\SupabaseClient;
use RuntimeException;

final class SupabaseAuthService
{
    public function __construct(
        private SupabaseClient $supabase,
        private SessionService $session,
        private ProfileService $profiles,
        private array $config
    ) {
    }

    public function register(array $data, bool $loginUser = true): array
    {
        $payload = [
            'email' => $data['email'],
            'password' => $data['password'],
            'data' => [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
            ],
        ];

        $auth = $this->supabase->auth('POST', 'signup', [], $payload, false);
        $authUser = $auth['user'] ?? null;
        if (!is_array($authUser) || !isset($authUser['id'])) {
            throw new RuntimeException("Creation du compte impossible.");
        }

        $profile = $this->profiles->createPendingProfile([
            'auth_user_id' => $authUser['id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'study_year' => $data['study_year'],
            'birth_date' => $data['birth_date'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'major' => $data['major'],
            'status' => 'pending',
            'is_google_account' => false,
        ]);

        if ($loginUser && !empty($auth['session'])) {
            $this->session->login($profile, $auth['session']);
        }

        return $profile;
    }

    public function login(string $email, string $password): array
    {
        $auth = $this->supabase->auth('POST', 'token', ['grant_type' => 'password'], [
            'email' => $email,
            'password' => $password,
        ], false);

        $authUser = $auth['user'] ?? null;
        if (!is_array($authUser) || !isset($authUser['id'])) {
            throw new RuntimeException('Identifiants invalides.');
        }

        $profile = $this->profiles->findByAuthUserId($authUser['id']);
        if ($profile === null) {
            throw new RuntimeException('Profil introuvable.');
        }

        if (($profile['status'] ?? null) === 'archived') {
            throw new RuntimeException('Compte archive.');
        }

        $this->session->login($profile, $auth);
        return $profile;
    }

    public function beginGoogleLogin(): string
    {
        $verifier = bin2hex(random_bytes(32));
        $challenge = rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');

        $this->session->put('oauth_verifier', $verifier);

        $query = http_build_query([
            'provider' => 'google',
            'redirect_to' => $this->config['google']['redirect_uri'],
            'code_challenge' => $challenge,
            'code_challenge_method' => 'S256',
        ], '', '&', PHP_QUERY_RFC3986);

        return $this->supabase->url('/auth/v1/authorize?' . $query);
    }

    public function completeGoogleLogin(string $code): array
    {
        $verifier = (string) $this->session->get('oauth_verifier', '');
        if ($verifier === '') {
            throw new RuntimeException('Session OAuth expirée.');
        }

        $auth = $this->supabase->auth('POST', 'token', ['grant_type' => 'pkce'], [
            'auth_code' => $code,
            'code_verifier' => $verifier,
        ], false);

        $user = $auth['user'] ?? null;
        if (!is_array($user) || !isset($user['id'])) {
            throw new RuntimeException('Connexion Google invalide.');
        }

        $profile = $this->profiles->findByAuthUserId($user['id']);
        if ($profile === null) {
            $profile = $this->profiles->createPendingProfile([
                'auth_user_id' => $user['id'],
                'first_name' => $user['user_metadata']['full_name'] ?? 'Prenom',
                'last_name' => $user['user_metadata']['family_name'] ?? 'Nom',
                'study_year' => '',
                'birth_date' => null,
                'email' => $user['email'] ?? '',
                'phone' => '',
                'major' => '',
                'status' => 'pending',
                'is_google_account' => true,
            ]);
        }

        if (($profile['status'] ?? null) === 'archived') {
            throw new RuntimeException('Compte archive.');
        }

        $this->session->forget('oauth_verifier');
        $this->session->login($profile, $auth);

        return $profile;
    }
}
