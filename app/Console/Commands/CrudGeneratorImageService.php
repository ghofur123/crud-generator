<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class CrudGeneratorImageService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud-generator:image {name} {fields}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat controller, model, request,resources dan view sumber daya menggunakan generator CRUD Image';

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

        $apiFolderPath = app_path('Http/Controllers/API');
        if (!is_dir($apiFolderPath)) {
            $this->info("folder Http/Controllers/API berhasil dibuat.");
            mkdir($apiFolderPath, 0755, true);
        }

        $uploadsFolderPath = public_path('uploads');
        if (!is_dir($uploadsFolderPath)) {
            $this->info("folder uploads berhasil dibuat.");
            mkdir($uploadsFolderPath, 0755, true);
        }
        $rootNamespace = $this->laravel->getNamespace();
        $generateValidation = $this->generateValidation($ucName, $fieldArray);

        $this->generateModel($ucName, $controllerNamespace);

        $this->generateRequest($name, $fieldArray);

        $this->generateResourceModel($ucName, $fieldArray);

        $this->generateMigration($name, $fieldArray);

        $this->generateController($ucName, $controllerNamespace, $rootNamespace, $generateValidation);
    }

    private function generateValidation($name, $fieldArray)
    {
        $ucName = Str::ucfirst($name);
        $validationRules = [];
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $validationRules[] = "$${ucName}->{$fieldName} = \$request->input('$fieldName');";
        }
        return implode("\n        ", $validationRules);
    }

    private function generateController($ucName, $controllerNamespace, $rootNamespace, $validationRules)
    {
        $requestPath = app_path("Http/Controllers/API/{$ucName}Controller.php");

        if (file_exists($requestPath)) {
            $this->error("Controllers {$ucName}Controller sudah ada!");
            return;
        }
        $controllerContent = $this->generateControllerContent($controllerNamespace, $rootNamespace, $ucName, $validationRules);
        $controllerFilePath = app_path("Http/Controllers/API/{$ucName}Controller.php");
        file_put_contents($controllerFilePath, $controllerContent);
        $this->info("Controller {$ucName}Controller berhasil dibuat.");
    }

    private function generateControllerContent($namespace, $rootNamespace, $className, $validationRules)
    {
        $controllerStubPath = base_path('resources/views/crud-generator-template/stub/controller.image.stub');
        $controllerContent = file_get_contents($controllerStubPath);
        return str_replace(['{{ namespace }}', '{{ rootNamespace }}', '{{ class }}', '{{ validateForm }}'], [$namespace, $rootNamespace, $className, $validationRules], $controllerContent);
    }

    private function generateModel($ucName, $controllerNamespace)
    {
        $requestPath = app_path("Models/{$ucName}.php");

        if (file_exists($requestPath)) {
            $this->error("Model $ucName sudah ada!");
            return;
        }
        $modelContent = $this->generateModelContent($controllerNamespace, $ucName);
        $modelFilePath = app_path("Models/$ucName.php");
        file_put_contents($modelFilePath, $modelContent);
    }
    private function generateModelContent($namespace, $className)
    {
        $modelStubPath = base_path('resources/views/crud-generator-template/stub/model.stub');
        $modelContent = file_get_contents($modelStubPath);
        return str_replace(['{{ namespace }}', '{{ class }}'], [$namespace, $className],$modelContent);
        $this->info("Model $className berhasil dibuat.");
    }

    private function generateRequest($name, $fieldArray)
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
        $rules[] = "'file' => 'required|mimes:png,jpg,jpeg,gif',";
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $rules[] = "'$fieldName' => 'required',";
        }
        $rulesContent = implode("\n\t\t", $rules);
        $requestStubPath = base_path('resources/views/crud-generator-template/stub/request.stub');
        $requestContent = file_get_contents($requestStubPath);
        $requestContent = str_replace('{{ class }}', $ucName, $requestContent);
        $requestContent = str_replace('{{ rules }}', $rulesContent, $requestContent);

        $requestPath = app_path("Http/Requests/{$ucName}Request.php");
        if (file_exists($requestPath)) {
            $this->error("Request {$ucName}Request sudah ada!");
            return;
        }
        $this->info("Request {$ucName}Request berhasil dibuat.");
        return $requestContent;
    }
    private function generateResourceModel($ucName, $fieldArray)
    {
        $resourceModelStubPath = base_path('resources/views/crud-generator-template/stub/resource.stub');
        $resourceModelContent = file_get_contents($resourceModelStubPath);
        
        $arrayResourceContent = [
            "'name' => \$this->name,",
            "'ext_name' => \$this->ext_name,",
            "'type' => \$this->type,",
            "'size' => \$this->size,",
            "'path' => \$this->path,",
            "'url' => \$this->url,",
        ];

        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $arrayResourceContent[] = "'$fieldName' => \$this->$fieldName,";
        }

        $arrayResourceContent = implode("\n", $arrayResourceContent);

        $resourceModelContent = str_replace('{{ arrayResource }}', $arrayResourceContent, $resourceModelContent);
        $resourceModelContent = str_replace('{{ namespace }}', 'App\\Http\\Resources', $resourceModelContent);
        $resourceModelContent = str_replace('{{ class }}', "${ucName}Resource", $resourceModelContent);

        $resourceModelFilePath = app_path("Http/Resources/${ucName}Resource.php");
        file_put_contents($resourceModelFilePath, $resourceModelContent);
    }

    private function generateMigration($name, $fieldArray)
    {
        $migrationStubPath = base_path('resources/views/crud-generator-template/stub/migration.create.image.stub');
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
