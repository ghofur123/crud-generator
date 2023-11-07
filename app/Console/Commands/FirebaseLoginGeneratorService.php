<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FirebaseLoginGeneratorService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud-generator:firebase-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'creato login and register firebase';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->generateLogin();
        $this->generateRegister();
    }
    private function generateLogin()
    {
        $controllersPath = app_path("Http/Controllers/API/LoginFirebaseController.php");

        if (file_exists($controllersPath)) {
            $this->error("Controller LoginFirebaseController sudah ada!");
        } else {
            $modelStubPath = base_path('resources/views/crud-generator-template/stub/controller.firebase.login.stub');
            $modelContent = file_get_contents($modelStubPath);

            if (file_put_contents($controllersPath, $modelContent) !== false) {
                $this->info("Controller LoginFirebaseController berhasil dibuat.");
            } else {
                $this->error("Gagal membuat Controller LoginFirebaseController.");
            }
        }

    }
    private function generateRegister()
    {
        $controllersPath = app_path("Http/Requests/LoginFirebaseRequest.php");

        if (file_exists($controllersPath)) {
            $this->error("Request LoginFirebaseRequest sudah ada!");
        } else {
            $modelStubPath = base_path('resources/views/crud-generator-template/stub/request.firebase.login.stub');
            $modelContent = file_get_contents($modelStubPath);

            if (file_put_contents($controllersPath, $modelContent) !== false) {
                $this->info("Request LoginFirebaseRequest berhasil dibuat.");
            } else {
                $this->error("Gagal membuat Request LoginFirebaseRequest.");
            }
        }
    }
}
