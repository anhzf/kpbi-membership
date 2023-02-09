<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if (!hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException();
        }

        if (!hash_equals((string) $request->get('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new Response('', 204)
                : redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($response = $this->verified($request)) {
            return $response;
        }

        return response()->json(['success' => true, 'message' => 'Akun anda berhasil diverifikasi!'], 202);
    }

    /**
     * The user has been verified.
     *
     * @return mixed
     */
    protected function verified(Request $request)
    {
        //
    }

    /**
     * Resend the email verification notification.
     *
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Akun anda sudah terverifikasi'
            ], 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'success' => true,
            'message' => "Email telah dikirim ke {$request->user()->getEmailForVerification()}"
        ], 202);
    }
}
