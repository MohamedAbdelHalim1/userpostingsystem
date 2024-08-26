<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * @api {post} /api/register Register a new user
     * @apiName Register
     * @apiGroup Auth
     *
     * @apiBody {String} name User's name.
     * @apiBody {String} email User's email.
     * @apiBody {String} password User's password.
     *
     * @apiSuccess {String} access_token User's access token.
     * @apiSuccess {String} token_type Token type.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * @api {post} /api/login Login a user
     * @apiName Login
     * @apiGroup Auth
     *
     * @apiBody {String} email User's email.
     * @apiBody {String} password User's password.
     *
     * @apiSuccess {String} access_token User's access token.
     * @apiSuccess {String} token_type Token type.
     */

    public function login(Request $request)
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * @api {post} /api/logout Logout a user
     * @apiName Logout
     * @apiGroup Auth
     *
     * @apiHeader {String} Authorization Bearer token.
     *
     * @apiSuccess {String} message Success message.
     */

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
