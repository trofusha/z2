<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use OpenApi\Attributes as OAT;

class JWTController extends Controller
{

    #[OAT\Post(
                path: '/api/auth/login',
                description: 'Get a JWT via given credentials.',
                requestBody: new OAT\RequestBody(
                        required: true,
                        content: new OAT\JsonContent(required: ['email', 'password'], properties: [
                            new OAT\Property(property: 'email', type: 'string', format: 'email', example: 'admin@example.com'),
                            new OAT\Property(property: 'password', type: 'string', format: 'password', example: 'qwerty1234'),
                                ]),
                ),
                tags: ['auth'],
                responses: [
            new OAT\Response('#/components/responses/TokenResponse', JsonResponse::HTTP_OK),
            new OAT\Response('#/components/responses/ValidationErrorsResponse', JsonResponse::HTTP_UNPROCESSABLE_ENTITY),
                ],
        )]
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->guard('jwt')->attempt($credentials, true)) {
            throw ValidationException::withMessages([
                        'email' => __('auth.failed'),
            ]);
        }

        return $this->respondWithToken($token);
    }

    #[OAT\Post(
                path: '/api/auth/me',
                description: 'Get the authenticated User.',
                tags: ['auth'],
                responses: [
            new OAT\Response(response: JsonResponse::HTTP_OK, description: 'User', content: new OAT\JsonContent(ref: '#/components/schemas/User')),
            new OAT\Response('#/components/responses/MessageResponse', JsonResponse::HTTP_UNAUTHORIZED),
                ],
        )]
    public function me(): JsonResponse
    {
        return response()->json(auth()->guard('jwt')->user());
    }

    #[OAT\Post(
                path: '/api/auth/logout',
                description: 'Log the user out (Invalidate the token).',
                tags: ['auth'],
                responses: [
            new OAT\Response('#/components/responses/MessageResponse', JsonResponse::HTTP_OK),
            new OAT\Response('#/components/responses/MessageResponse', JsonResponse::HTTP_UNAUTHORIZED),
                ],
        )]
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    #[OAT\Post(
                path: '/api/auth/refresh',
                description: 'Refresh a token.',
                tags: ['auth'],
                responses: [
            new OAT\Response('#/components/responses/TokenResponse', JsonResponse::HTTP_OK),
            new OAT\Response('#/components/responses/MessageResponse', JsonResponse::HTTP_UNAUTHORIZED),
                ],
        )]
    public function refresh(): JsonResponse
    {
        try {
            $token = $this->respondWithToken(auth()->guard('jwt')->refresh());
        } catch (JWTException $exc) {
            throw new AuthenticationException();
        }

        return $token;
    }

    #[OAT\Response(
                response: 'TokenResponse',
                description: 'Get the token array structure.',
                content: new OAT\JsonContent(required: ['access_token', 'token_type', 'expires_in'], properties: [
                    new OAT\Property('access_token', type: 'string', example: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWV9.TJVA95OrM7E2cBab30RMHrHDcEfxjoYZgeFONFh7HgQ'),
                    new OAT\Property('token_type', type: 'string', example: 'bearer'),
                    new OAT\Property('expires_in', type: 'integer', example: 3600),
                        ]),
        ),
        OAT\Response(
                response: 'MessageResponse',
                description: 'Message',
                content: new OAT\JsonContent(required: ['message'], properties: [
                    new OAT\Property('message', type: 'string'),
                        ]),
        )]
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->guard('jwt')->factory()->getTTL() * 60
        ]);
    }
}
