<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LoginGeneratorSactumService extends Command
{
    protected $signature = 'crud-generator:login';
    protected $description = 'Membuat login menggunakan Sanctum';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controllerName = 'AuthController';
        $fieldArray = ['name', 'email', 'password'];

        $this->generateController($controllerName);
        $this->generateRequestFile($controllerName, $fieldArray);
        $this->generateModel();
    }

    private function generateController($controllerName)
    {
        $controllerStubPath = base_path('resources/views/crud-generator-template/stub/controller.login.stub');
        $controllerContent = file_get_contents($controllerStubPath);

        $controllerPath = app_path("Http/Controllers/API/{$controllerName}.php");

        if (file_exists($controllerPath)) {
            $this->error("Controller $controllerName sudah ada!");
            return;
        }

        File::put($controllerPath, $controllerContent);

        $this->info("Controller $controllerName berhasil dibuat.");
    }

    private function generateRequestFile($controllerName, $fieldArray)
    {
        $requestContent = $this->generateRequestContent($controllerName, $fieldArray);
        $requestFilePath = app_path("Http/Requests/{$controllerName}Request.php");
        file_put_contents($requestFilePath, $requestContent);
    }

    private function generateRequestContent($controllerName, $fieldArray)
    {
        $requestPath = app_path("Http/Requests/{$controllerName}Request.php");

        if (file_exists($requestPath)) {
            $this->error("Request $controllerName sudah ada!");
            return;
        }
        $rules = [
            "'name' => 'required|string|max:255',",
            "'email' => 'required|string|email|max:255|unique:users',",
            "'password' => 'required|string|min:8'"
        ];
        $rulesContent = implode("\n\t\t", $rules);
        $requestStubPath = base_path('resources/views/crud-generator-template/stub/request.stub');
        $requestContent = file_get_contents($requestStubPath);
        $requestContent = str_replace('{{ class }}', $controllerName, $requestContent);
        $requestContent = str_replace('{{ rules }}', $rulesContent, $requestContent);
        $this->info("Request $controllerName berhasil dibuat.");
        return $requestContent;
    }
    private function generateModel()
    {
        $requestContent = $this->generateModelContent();
        $requestFilePath = app_path("Models/UserSactum.php");
        file_put_contents($requestFilePath, $requestContent);

        $modeltPath = app_path("Models");
        if (file_exists($modeltPath)) {
            $this->error("Folder Models sudah ada!");
            return;
        }
    }
    private function generateModelContent()
    {

        $requestStubPath = base_path('resources/views/crud-generator-template/stub/model.sactum.stub');
        $requestContent = file_get_contents($requestStubPath);

        $this->info("Model UserSactum berhasil dibuat.");
        return $requestContent;
    }
}
