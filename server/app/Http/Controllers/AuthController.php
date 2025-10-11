<?php

namespace App\Http\Controllers;

use App\Http\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Auth::user()->append('img')->makeHidden('media'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credential)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $request->session()->regenerate();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        if (!Auth::attempt([
            'email' => Auth::user()->email,
            'password' => $request->current_password
        ])) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        Auth::user()->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Password Changed'
        ]);
    }

    /**
     * Create a personal access token for API authentication
     */
    public function createToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'token_name' => 'string|max:255',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $tokenName = $request->token_name ?? 'API Token';
        $token = Auth::user()->createToken($tokenName);

        return Api::data([
            'token' => $token->plainTextToken,
            'token_name' => $tokenName,
        ]);
    }

    /**
     * Revoke a specific token
     */
    public function revokeToken(PersonalAccessToken $token)
    {
        $token->delete();
        return Api::message('Token revoked successfully');
    }

    /**
     * Revoke all user tokens
     */
    public function revokeAllTokens()
    {
        Auth::user()->tokens()->delete();

        return Api::message('All tokens revoked successfully');
    }

    /**
     * List all user tokens
     */
    public function listTokens()
    {
        $tokens = Auth::user()->tokens()->select('id', 'name', 'last_used_at', 'created_at')->get();

        return Api::data($tokens);
    }
}
