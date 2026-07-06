<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(name="Auth")
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(path="/api/v1/auth/register", tags={"Auth"}, summary="Register a customer")
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create($data);

        return response()->json([
            'token' => $user->createToken('storefront')->plainTextToken,
        ], 201);
    }

    /**
     * @OA\Post(path="/api/v1/auth/login", tags={"Auth"}, summary="Login a customer")
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        abort_unless($user && Hash::check($credentials['password'], $user->password), 422, 'Invalid credentials');

        return response()->json([
            'token' => $user->createToken('storefront')->plainTextToken,
        ]);
    }

    /**
     * @OA\Post(path="/api/v1/auth/logout", tags={"Auth"}, summary="Revoke the current token")
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
