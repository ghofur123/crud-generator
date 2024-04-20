<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CrudGeneratorService extends Command
{
    protected $signature = 'crud-generator:create-api {name} {fields}';
    protected $description = 'Membuat controller, model, request,resources dan view sumber daya menggunakan generator CRUD';

    public function __construct()
    {
        parent::__construct();
    }

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
        $rootNamespace = $this->laravel->getNamespace();
        $fieldArray = explode(',', $fields);
        $apiFolderPath = app_path('Http/Controllers/API');
        if (!is_dir($apiFolderPath)) {
            mkdir($apiFolderPath, 0755, true);
        }
        $resourcesFolderPath = app_path('Http/Resources');
        if (!is_dir($resourcesFolderPath)) {
            mkdir($resourcesFolderPath, 0755, true);
        }
        $requestsFolderPath = app_path('Http/Requests');
        if (!is_dir($requestsFolderPath)) {
            mkdir($requestsFolderPath, 0755, true);
        }
        $generateStoreUpdate = $this->generateStoreUpdate($ucName, $fieldArray);

        $this->generateModel($ucName, $controllerNamespace);
        $this->generateController($ucName, $controllerNamespace, $rootNamespace, $generateStoreUpdate);
        $this->generateResourceModel($ucName, $fieldArray);
        $this->generateRequestFile($ucName, $fieldArray); // Menggunakan $ucName
        $this->generateMigration($ucName, $fieldArray);

        $this->info('Controller, Model, View, Request dan Resources sumber daya telah berhasil dibuat.');
    }

    private function generateStoreUpdate($name, $fieldArray)
    {
        $ucName = Str::ucfirst($name);
        $validationRules = [];
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $validationRules[] = "$${ucName}->{$fieldName} = \$request->input('$fieldName');";
        }
        return implode("\n        ", $validationRules);
    }

    private function generateModel($name, $controllerNamespace)
    {
        $modelContent = $this->generateModelContent($controllerNamespace, $name);
        $modelFilePath = app_path("Models/$name.php");
        file_put_contents($modelFilePath, $modelContent);
    }

    private function generateModelContent($namespace, $className)
    {
        $modelStubPath = base_path('resources/views/crud-generator-template/stub/model.stub');
        $modelContent = file_get_contents($modelStubPath);
        return str_replace(['{{ namespace }}', '{{ class }}'], [$namespace, $className], $modelContent);
    }

    private function generateController($name, $controllerNamespace, $rootNamespace, $validationRules)
    {
        $controllerContent = $this->generateControllerContent($controllerNamespace, $rootNamespace, $name, $validationRules);
        $controllerFilePath = app_path("Http/Controllers/API/{$name}Controller.php");
        file_put_contents($controllerFilePath, $controllerContent);
    }

    private function generateControllerContent($namespace, $rootNamespace, $className, $validationRules)
    {
        $controllerStubPath = base_path('resources/views/crud-generator-template/stub/controller.stub');
        $controllerContent = file_get_contents($controllerStubPath);
        return str_replace(['{{ namespace }}', '{{ rootNamespace }}', '{{ class }}', '{{ validateForm }}'], [$namespace, $rootNamespace, $className, $validationRules], $controllerContent);
    }

    private function generateResourceModel($name, $fieldArray)
    {
        $resourceModelStubPath = base_path('resources/views/crud-generator-template/stub/resource.stub');
        $resourceModelContent = file_get_contents($resourceModelStubPath);
        $arrayResourceContent = '';
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $arrayResourceContent .= "'$fieldName' => \$this->$fieldName,\n";
        }
        $resourceModelContent = str_replace('{{ arrayResource }}', $arrayResourceContent, $resourceModelContent);
        $resourceModelContent = str_replace('{{ namespace }}', 'App\\Http\\Resources', $resourceModelContent);
        $resourceModelContent = str_replace('{{ class }}', "${name}Resource", $resourceModelContent);
        $resourceModelFilePath = app_path("Http/Resources/${name}Resource.php");
        file_put_contents($resourceModelFilePath, $resourceModelContent);
    }

    private function generateRequestFile($name, $fieldArray)
    {
        $ucName = Str::ucfirst($name);
        $requestContent = $this->generateRequestContent($ucName, $fieldArray); // Menggunakan $ucName
        $requestFilePath = app_path("Http/Requests/{$ucName}Request.php");
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
        $requestContent = str_replace('{{ class }}', $ucName, $requestContent);
        $requestContent = str_replace('{{ rules }}', $rulesContent, $requestContent);
        return $requestContent;
    }
    private function generateMigration($name, $fieldArray)
    {
        $migrationStubPath = base_path('resources/views/crud-generator-template/stub/migration.create.stub');
        $migrationContent = file_get_contents($migrationStubPath);

        $tableName = Str::plural(Str::snake($name));
        $tableNameUc = Str::ucfirst(Str::plural(Str::snake($name)));
        $migrationContent = str_replace(['{{ class }}', '{{ table }}'], ["Create{$tableNameUc}Table", $tableName], $migrationContent);

        $columnDefinitions = '';
            foreach ($fieldArray as $field) {
                $fieldName = str_replace(':', '', $field);
                $columnDefinitions .= "\$table->string('$fieldName');\n";
            }

        $migrationContent = str_replace('{{ columns }}', $columnDefinitions, $migrationContent);
        $migrationFileName = date('Y_m_d_His') . '_create_' . $tableName . '_table.php';

        $migrationPath = database_path('migrations/' . $migrationFileName);

        file_put_contents($migrationPath, $migrationContent);

        $this->info("Migration file created: $migrationFileName");
    }
}