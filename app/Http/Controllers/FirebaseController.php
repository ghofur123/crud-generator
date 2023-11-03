<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;


class FirebaseController extends Controller
{
    public function __construct(){
        $factory = (new Factory)
        ->withServiceAccount('firebase-credentials.json')
        ->withDatabaseUri('https://companyprofile-fb284-default-rtdb.firebaseio.com/');

        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
    }
    public function index()
    {
        // $ref = $this->database->getReference('hewan/herbivora')->getSnapshot();
        // dump($ref);
        // $ref = $this->database->getReference('hewan/herbivora')->getValue();
        // dump($ref);
        $ref = $this->database->getReference('hewan/karnivora')->getValue();
        // dump($ref);
        // $ref = $this->database->getReference('hewan/karnivora')->getSnapshot()->exists();
        // dump($ref);

        return response()->json($ref);
    }
    public function show()
    {

    }
    public function store()
    {
        $ref = $this->database->getReference('hewan')->getValue();
        dump($ref);

        // set data
        $ref = $this->database->getReference('hewan/karnivora')
        ->set([
            "harimau" => [
                "benggala" => "galak",
                "sumatera" => "jinak"
            ]
        ]);

        // after
        $ref = $this->database->getReference('hewan')->getValue();
        dump($ref);
    }
    public function update()
    {

    }
    public function destroy()
    {

    }
    
}
