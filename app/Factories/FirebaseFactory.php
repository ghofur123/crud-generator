<?php

namespace App\Factories;

use Kreait\Firebase\Factory;

class FirebaseFactory
{
    public function create()
    {
        return (new Factory)
            ->withServiceAccount(env('FIREBASE_CREDENTIALS_FILE'))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));
    }
}