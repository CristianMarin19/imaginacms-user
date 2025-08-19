<?php

namespace Modules\Iuser\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Imagina\Icore\Http\Controllers\CoreApiController;

use Modules\Iuser\Models\User;
use Modules\Iuser\Repositories\UserRepository;
use Modules\Iuser\Services\AuthService;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Modules\Iuser\Transformers\UserTransformer;

class AuthApiController extends CoreApiController
{

    protected $authService;

    public function __construct(User $model, UserRepository $modelRepository, AuthService $authService)
    {
        parent::__construct($model, $modelRepository);
        $this->authService = $authService;
    }

    /**
     * Login User
     */
    public function login(Request $request)
    {
        try {
            //Validate request
            $data = $request->input('attributes') ?? [];
            $this->validateWithModelRules($data, 'login');

            //Get user by email
            $params = json_decode(json_encode(["filter" => ["field" => "email"]]));
            $user = $this->modelRepository->getItem($data['email'], $params);

            //Validate user and password
            if (!$user || !Hash::check($data['password'], $user->password)) {
                throw new \Exception(Response::$statusTexts[Response::HTTP_UNAUTHORIZED], Response::HTTP_UNAUTHORIZED);
            }

            //Get
            $tokenData = $this->authService->getToken("password", $data);

            $response = ['data' => [
                'user' => new UserTransformer($user),
                'token' => $tokenData
            ]];
        } catch (\Exception $e) {
            [$status, $response] = $this->getErrorResponse($e);
        }

        //Return response
        return response()->json($response, $status ?? Response::HTTP_OK);
    }

    /**
     * Login Client
     * You can create some logins to diferents clients
     * This token only can access with a especific Middleware (EnsureClientIsResourceOwner::class)
     */
    public function loginClient(Request $request)
    {
        try {

            $data = $request->input('attributes') ?? [];

            //Add data
            $dataVal = [
                'clientId' => $data['client_id'] ?? env('PASSPORT_CLIENT_ID') ?? null,
                'clientSecret' => $data['client_secret'] ?? env('PASSPORT_CLIENT_SECRET') ?? null
            ];

            //Validation
            if (is_null($dataVal['clientId']) || is_null($dataVal['clientSecret'])) {
                throw new \Exception('Client ID and Client Secret are required.', Response::HTTP_BAD_REQUEST);
            }

            //Get
            $tokenData = $this->authService->getToken("client_credentials", $dataVal);

            $response = ['data' => [$tokenData]];
        } catch (\Exception $e) {
            [$status, $response] = $this->getErrorResponse($e);
        }

        //Return response
        return response()->json($response, $status ?? Response::HTTP_OK);
    }

    /**
     * Refresh Token
     */
    public function refreshToken(Request $request)
    {
        try {

            //Validate request
            $data = $request->input('attributes') ?? [];
            $this->validateWithModelRules($data, 'refreshToken');

            //Get
            $tokenData = $this->authService->getToken("refresh_token", $data);

            $response = ['data' => $tokenData];
        } catch (\Exception $e) {
            [$status, $response] = $this->getErrorResponse($e);
        }

        //Return response
        return response()->json($response, $status ?? Response::HTTP_OK);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        try {

            $user = Auth::user();
            $user->token()->revoke(); //Revoke the token

            $response = ['data' => 'Logout successful'];
        } catch (\Exception $e) {
            [$status, $response] = $this->getErrorResponse($e);
        }

        //Return response
        return response()->json($response, $status ?? Response::HTTP_OK);
    }

    /**
     * Reset Password
     */
    public function reset(Request $request)
    {
        try {

            //Validate request
            $data = $request->input('attributes') ?? [];
            $this->validateWithModelRules($data, 'resetPassword');

            //Process reset password
            $result = Password::sendResetLink(['email' => $data['email']]);

            //TODO: Traducciones
            if ($result === Password::ResetLinkSent) {
                //status = passwords.sent
                $message = "We have emailed your password reset link";
            } else {
                //status = passwords.throttled
                $message = "Please wait before retrying";
            }

            $response = ['data' => $message];
        } catch (\Exception $e) {
            [$status, $response] = $this->getErrorResponse($e);
        }

        //Return response
        return response()->json($response, $status ?? Response::HTTP_OK);
    }

    /**
     * Reset Password Complete
     */
    public function resetComplete(Request $request)
    {
        try {

            //Validate request
            $data = $request->input('attributes') ?? [];
            $this->validateWithModelRules($data, 'resetPasswordComplete');

            //Process reset password complete
            $result = Password::reset(
                $data,
                function ($model, string $password) {
                    $model->forceFill([
                        'password' => $password
                    ])->setRememberToken(\Str::random(60));

                    $model->save();
                }
            );

            //TODO: Traducciones
            if ($result === Password::PasswordReset) {
                //status = passwords.reset
                $message = "Password reset successfully.";
            } else {
                //status = passwords.token
                $message = "Invalid information";
            }

            $response = ['data' => $message];
        } catch (\Exception $e) {
            [$status, $response] = $this->getErrorResponse($e);
        }

        //Return response
        return response()->json($response, $status ?? Response::HTTP_OK);
    }

    /**
     * Information about user logged
     */
    public function me(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                throw new \Exception('Unauthenticated', Response::HTTP_UNAUTHORIZED);
            }

            //Not clear cache | TODO: From v10
            //app()->instance('clearResponseCache', false);

            $response = ['data' => new UserTransformer($user)];
        } catch (\Exception $e) {
            [$status, $response] = $this->getErrorResponse($e);
        }

        //Return response
        return response()->json($response, $status ?? Response::HTTP_OK);
    }
}
