<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ExcelGeneratorService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud-generator:excel {name} {fields} {startRow}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Excel Import and Export';

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
        $startRow = $this->argument('startRow');
        $this->generateCrud($name, $fields, $startRow);
    }

    private function generateCrud($name, $fields, $startRow)
    {
        $lowerName = strtolower($name);
        $ucName = Str::ucfirst($name);
        $controllerNamespace = "Http\\Controllers\\$ucName";
        $fieldArray = explode(',', $fields);

        $apiFolderPath = app_path('Http/Controllers/API');
        if (!is_dir($apiFolderPath)) {
            $this->info("Folder Http/Controllers/API berhasil dibuat.");
            mkdir($apiFolderPath, 0755, true);
        }

        $uploadsFolderPath = app_path('Imports');
        if (!is_dir($uploadsFolderPath)) {
            $this->info("Folder Imports berhasil dibuat.");
            mkdir($uploadsFolderPath, 0755, true);
        }
        $excelFolderPath = public_path('excel');
        if (!is_dir($excelFolderPath)) {
            $this->info("folder excel berhasil dibuat.");
            mkdir($excelFolderPath, 0755, true);
        }

        $this->generateModel($ucName, $lowerName, $controllerNamespace, $fieldArray);
        $this->generateImports($ucName, $lowerName, $fieldArray, $startRow);
        $this->generateController($ucName);
    }

    private function generateModel($ucName, $lowerName, $controllerNamespace, $fieldArray)
    {
        $modelPath = app_path("Models/{$ucName}Excel.php");

        if (file_exists($modelPath)) {
            $this->error("Model $ucName sudah ada!");
            return;
        }

        $modelContent = $this->generateModelContent($ucName, $lowerName, $fieldArray);

        file_put_contents($modelPath, $modelContent);

        $this->info("Model {$ucName}Excel berhasil dibuat.");
    }

    private function generateModelContent($ucName, $lowerName, $fieldArray)
    {
        $rules = [];

        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $rules[] = "'$fieldName',"; // Atur jenis validasi yang sesuai
        }
        $rulesString = implode("\n", $rules);

        $modelStubPath = base_path('resources/views/crud-generator-template/stub/excel.model.stub');
        $modelContent = file_get_contents($modelStubPath);
        $modelContent = str_replace(['{{ class }}', '{{ table }}', '{{ rules }}'], [$ucName, $lowerName, $rulesString], $modelContent);

        return $modelContent;
    }

    private function generateImports($ucName, $lowerName, $fieldArray, $startRow)
    {
        $modelPath = app_path("Imports/{$ucName}.php");

        if (file_exists($modelPath)) {
            $this->error("Imports $ucName sudah ada!");
            return;
        }

        $modelContent = $this->generateImportsContent($ucName, $fieldArray, $startRow);

        file_put_contents($modelPath, $modelContent);

        $this->info("Imports {$ucName} berhasil dibuat.");
    }
    private function generateImportsContent($ucName, $fieldArray, $startRow)
    {
       $rules = [];
        $number = 1; // Inisialisasi $number dengan 1
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $rules[] = "'$fieldName' => \$row[{$number}],";
            $number++; // Tambahkan 1 setiap kali loop
        }
        $rulesString = implode("\n", $rules);

        $modelStubPath = base_path('resources/views/crud-generator-template/stub/excel.import.stub');
        $modelContent = file_get_contents($modelStubPath);
        $modelContent = str_replace(['{{ class }}', '{{ rules }}', '{{ startRow }}'], [$ucName, $rulesString, $startRow], $modelContent);

        return $modelContent;
    }
    private function generateController($ucName)
    {
        $ControllersPath = app_path("Http/Controllers/API/{$ucName}ExcelController.php");

        if (file_exists($ControllersPath)) {
            $this->error("Controllers $ucName sudah ada!");
            return;
        }

        $modelContent = $this->generateControllersContent($ucName);

        file_put_contents($ControllersPath, $modelContent);

        $this->info("Controllers {$ucName}ExcelController berhasil dibuat.");
    }
    private function generateControllersContent($ucName)
    {
        $modelStubPath = base_path('resources/views/crud-generator-template/stub/excel.controller.stub');
        $modelContent = file_get_contents($modelStubPath);
        $modelContent = str_replace(['{{ class }}'], [$ucName], $modelContent);

        return $modelContent;
    }
}
