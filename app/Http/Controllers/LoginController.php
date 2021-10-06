<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\PassportServiceProvider;

class LoginController extends Controller
{
    /**
     * Login with username and password
     * 
     * @param \App\Http\Requests\LoginRequest
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        return $this->requestPasswordGrantToken($request->input('email'), $request->input('password'));
    }

    /**
     * Request Password Grant type token
     * 
     * @param string $username
     * @param string $password
     * @return \Illuminate\Http\Response
     */
    public function requestPasswordGrantToken(string $username, string $password)
    {
        $request = Request::create('oauth/token', 'POST', [
            'client_id' => config('auth.proxy.client_id'),
            'client_secret' => config('auth.proxy.client_secret'),
            'grant_type' => config('auth.proxy.grant_type'),
            'username' => $username,
            'password' => $password
        ]);

        $response = app()->handle($request);

        if ($response->isSuccessful()) {
            return $this->sendSuccessfulResponse($response);
        }

        $message = [
            'message' => 'Invalid login credentials'
        ];
        return response()->json($message, 400);
    }

    public function sendSuccessfulResponse(Response $response)
    {
        $data = json_decode($response->getContent());

        $content = [
            'access_token' => $data->access_token,
            'expires_in'    => $data->expires_in
        ];

        return response()->json($content)->cookie(
            'refresh_token',
            $data->refresh_token,
            24 * 60
        );
    }
}
