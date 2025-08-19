<?php

namespace Modules\Iuser\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{

    /**
     * GET TOKEN | REFRESH | PASSPORT
     */
    public function getToken($type = "password", $data)
    {

        $endpoint = env('APP_URL') . '/oauth/token';

        //Base Attributes
        $attributes = [
            'grant_type' => $type,
            'client_id' => $data['clientId'] ?? env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => $data['clientSecret'] ?? env('PASSPORT_PASSWORD_CLIENT_SECRET'),
            'scope' => $data['scope'] ?? ''
        ];

        //Validation By Type
        if ($type == "password") {
            $attributes['username'] = $data['email'];
            $attributes['password'] = $data['password'];
        }

        if ($type == "refresh_token") {
            $attributes['refresh_token'] = $data['token'];
        }

        //Get
        $responseToken = Http::asForm()->post($endpoint, $attributes);

        if (!$responseToken->successful())
            throw new \Exception("Error to get Token |" . ($responseToken['message'] ?? 'Error desconocido'), Response::HTTP_UNAUTHORIZED);


        //Format Response
        $tokenData = json_decode((string) $responseToken->getBody(), true);

        //Transform Data
        return [
            'tokenType' => $tokenData['token_type'] ?? null,
            'accessToken' => $tokenData['access_token'] ?? null,
            'refreshToken' => $tokenData['refresh_token'] ?? null,
            'expiresIn' => $tokenData['expires_in']
        ];
    }
}
