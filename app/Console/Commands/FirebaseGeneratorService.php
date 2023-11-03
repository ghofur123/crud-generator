<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FirebaseGeneratorService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud-generator:firebase {name} {fields}';

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
        $name = $this->argument('name');
        $fields = $this->argument('fields');
        $this->generateCrud($name, $fields);
    }

    private function generateCrud($name, $fields)
    {
        $lowerName = strtolower($name);
        $ucName = Str::ucfirst($name);
        $controllerNamespace = "Http\\Controllers\\$ucName";
        $fieldArray = explode(',', $fields);
        $rootNamespace = $this->laravel->getNamespace();

        $apiFolderPath = app_path('Http/Controllers/API');
        if (!is_dir($apiFolderPath)) {
            $this->info("folder Http/Controllers/API berhasil dibuat.");
            mkdir($apiFolderPath, 0755, true);
        }
    }

    private function generateController($ucName,$fields)
    {
        $requestPath = app_path("Http/Controllers/API/{$ucName}Controller.php");

        if (file_exists($requestPath)) {
            $this->error("Controllers {$ucName}FirebaseController sudah ada!");
            return;
        }
        $controllerContent = $this->generateControllerContent($controllerNamespace, $rootNamespace, $ucName, $validationRules);
        $controllerFilePath = app_path("Http/Controllers/API/{$ucName}FirebaseController.php");
        file_put_contents($controllerFilePath, $controllerContent);
        $this->info("Controller {$ucName}FirebaseController berhasil dibuat.");
    }
    private function generateControllerContent($namespace, $rootNamespace, $className, $validationRules)
    {
        $controllerStubPath = base_path('resources/views/crud-generator-template/stub/controller.firebase.stub');
        $controllerContent = file_get_contents($controllerStubPath);
        return str_replace(['{{ class }}', '{{ class_lower }}'], [$className, $classLower], $controllerContent);
    }
}
