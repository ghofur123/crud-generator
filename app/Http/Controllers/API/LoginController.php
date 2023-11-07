<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;

use App\Http\Requests\LoginFirebaseRequest;

class LoginController extends Controller
{
    public function __construct(){
        $factory = (new Factory)
        // file json yg di donwload dari firebase
        ->withServiceAccount('firebase-credentials.json')
        // link firebase
        ->withDatabaseUri('https://companyprofile-fb284-default-rtdb.firebaseio.com/');

        $this->auth = $factory->createAuth();
    }

    public function register(LoginFirebaseRequest $request){
        $email = $request->input('email');
        $pass = $request->input('password');

        try {
            $newUser = $this->auth->createUserWithEmailAndPassword($email, $pass);
            return response()->json($newUser, 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function login(LoginFirebaseRequest $request){
        $email = $request->input('email');
        $pass = $request->input('password');

        try {
            $signInResult = $this->auth->signInWithEmailAndPassword($email, $pass);

            Session::put('firebaseUserId', $signInResult->firebaseUserId());
            Session::put('idToken', $signInResult->idToken());
            Session::save();

            return response()->json($signInResult->idToken(), 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function signOut()
    {
        if (Session::has('firebaseUserId') && Session::has('idToken')) {
            $this->auth->revokeRefreshTokens(Session::get('firebaseUserId'));
            Session::forget('firebaseUserId');
            Session::forget('idToken');
            Session::save();
            return response()->json(["message" => "berhasil logout"], 200);
        } else {
            return response()->json(["message" => "login terlebih dulu"], 200);
        }
    }

}
