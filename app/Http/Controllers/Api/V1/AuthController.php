<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Info(title="SnappMarket", version="1")
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     @OA\RequestBody(
     *         description="Login",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/User")
     *         )
     *     ),
     *     tags={"auth"},
     *     @OA\Response(response="401", description="login failed"),
     *     @OA\Response(response="200", description="login successfully")
     * )
     */
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     @OA\RequestBody(
     *         description="Register",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/User")
     *         )
     *     ),
     *     tags={"auth"},
     *     @OA\Response(response="401", description="regitser failed"),
     *     @OA\Response(response="200", description="register successfully")
     * )
     */
    /**
     * Register user
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $email = $request->input("email");
        $password = $request->input("password");
        $credentials = [$email, $password];
        $user = new User();
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        if (!$token = auth()->attempt([
            "email" => $email,
            "password" => $password
        ])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/me",
     *     tags={"auth"},
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="200", description="success")
     * )
     */
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"auth"},
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="200", description="logout successfully")
     * )
     */
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     tags={"auth"},
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="200", description="Refresh successfully")
     * )
     */
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }


}
