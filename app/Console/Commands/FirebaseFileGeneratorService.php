<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FirebaseFileGeneratorService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud-generator:firebase-image {name_form} {name_folder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'firebase crud';

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
        $nameForm = $this->argument('name_form');
        $nameFolder = $this->argument('name_folder');
        $this->generateCrud($nameForm, $nameFolder);
    }
    private function generateCrud($name_form, $name_folder)
    {
        $nameForm = strtolower($name_form);
        $ucName = Str::ucfirst($name_form);
        $nameFolder = strtolower($name_folder);

        $apiFolderPath = app_path('Http/Controllers/API');
        if (!is_dir($apiFolderPath)) {
            $this->info("folder Http/Controllers/API berhasil dibuat.");
            mkdir($apiFolderPath, 0755, true);
        }
        $this->generateController($ucName, $nameForm, $nameFolder);
    }
    private function generateController($ucName, $nameForm, $nameFolder)
    {
        $requestPath = app_path("Http/Controllers/API/{$ucName}FirebaseFileController.php");

        if (file_exists($requestPath)) {
            $this->error("Controllers {$ucName}FirebaseFileController sudah ada!");
            return;
        }
        $controllerContent = $this->generateControllerContent($ucName, $fieldArray, $classLower);
        $controllerFilePath = app_path("Http/Controllers/API/{$ucName}FirebaseController.php");
        file_put_contents($controllerFilePath, $controllerContent);
        $this->info("Controller {$ucName}FirebaseFileController berhasil dibuat.");
    }
}
