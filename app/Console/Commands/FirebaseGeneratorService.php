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
        $classLower = strtolower($name);
        $ucName = Str::ucfirst($name);
        $controllerNamespace = "Http\\Controllers\\$ucName";
        $fieldArray = explode(',', $fields);
        $rootNamespace = $this->laravel->getNamespace();

        $apiFolderPath = app_path('Http/Controllers/API');
        if (!is_dir($apiFolderPath)) {
            $this->info("folder Http/Controllers/API berhasil dibuat.");
            mkdir($apiFolderPath, 0755, true);
        }
        $apiFolderPath = app_path('Helpers');
        if (!is_dir($apiFolderPath)) {
            $this->info("folder App/Helpers berhasil dibuat.");
            mkdir($apiFolderPath, 0755, true);
        }
        $apiFolderPath = app_path('Factories');
        if (!is_dir($apiFolderPath)) {
            $this->info("folder App/Factories berhasil dibuat.");
            mkdir($apiFolderPath, 0755, true);
        }
        $this->generateController($ucName,$fieldArray, $classLower);
        $this->generateRequest($name, $fieldArray);
        $this->generatePaginationHelper();
        $this->generateFirebaseFactory();
    }

    private function generateController($ucName,$fieldArray, $classLower)
    {
        $requestPath = app_path("Http/Controllers/API/{$ucName}FirebaseController.php");

        if (file_exists($requestPath)) {
            $this->error("Controllers {$ucName}FirebaseController sudah ada!");
            return;
        }
        $controllerContent = $this->generateControllerContent($ucName, $fieldArray, $classLower);
        $controllerFilePath = app_path("Http/Controllers/API/{$ucName}FirebaseController.php");
        file_put_contents($controllerFilePath, $controllerContent);
        $this->info("Controller {$ucName}FirebaseController berhasil dibuat.");
    }
    private function generateControllerContent($className, $fieldArray, $classLower)
    {
        $rules = [];
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $rules[] = "'$fieldName' => \$request->input('$fieldName'),";
        }
        $rulesContent = implode("\n\t\t", $rules);

        $controllerStubPath = base_path('resources/views/crud-generator-template/stub/controller.firebase.stub');
        $controllerContent = file_get_contents($controllerStubPath);
        return str_replace(['{{ class }}', '{{ class_lower }}', '{{ rules_input }}'], [$className, $classLower, $rulesContent], $controllerContent);
    }

    private function generateRequest($name, $fieldArray)
    {
        $ucName = Str::ucfirst($name);
        $requestContent = $this->generateRequestContent($ucName, $fieldArray);
        $requestFilePath = app_path("Http/Requests/{$ucName}FirebaseRequest.php");
        file_put_contents($requestFilePath, $requestContent);
    }

    private function generateRequestContent($className, $fieldArray)
    {
        $ucName = Str::ucfirst($className);
        $rules = [];
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $rules[] = "'$fieldName' => 'required',";
        }
        $rulesContent = implode("\n\t\t", $rules);
        $requestStubPath = base_path('resources/views/crud-generator-template/stub/request.stub');
        $requestContent = file_get_contents($requestStubPath);
        $requestContent = str_replace(['{{ class }}', '{{ rules }}'], [$ucName.'Firebase', $rulesContent],$requestContent);

        $requestPath = app_path("Http/Requests/{$ucName}FirebaseRequest.php");
        if (file_exists($requestPath)) {
            $this->error("Request {$ucName}FirebaseRequest sudah ada!");
            return;
        }
        $this->info("Request {$ucName}FirebaseRequest berhasil dibuat.");
        return $requestContent;
    }
    private function generatePaginationHelper()
    {
        $controllersPath = app_path("Helpers/PaginationHelper.php");

        if (file_exists($controllersPath)) {
            $this->error("Helpers PaginationHelper sudah ada!");
        } else {
            $modelStubPath = base_path('resources/views/crud-generator-template/stub/PaginationHelper.stub');
            $modelContent = file_get_contents($modelStubPath);

            if (file_put_contents($controllersPath, $modelContent) !== false) {
                $this->info("Helpers PaginationHelper berhasil dibuat.");
            } else {
                $this->error("Gagal membuat Helpers PaginationHelper.");
            }
        }
    }
    private function generateFirebaseFactory()
    {
        $controllersPath = app_path("Factories/FirebaseFactory.php");

        if (file_exists($controllersPath)) {
            $this->error("Factories FirebaseFactory sudah ada!");
        } else {
            $modelStubPath = base_path('resources/views/crud-generator-template/stub/FirebaseFactory.stub');
            $modelContent = file_get_contents($modelStubPath);

            if (file_put_contents($controllersPath, $modelContent) !== false) {
                $this->info("Factories FirebaseFactory berhasil dibuat.");
            } else {
                $this->error("Gagal membuat Factories FirebaseFactory.");
            }
        }
    }
}
