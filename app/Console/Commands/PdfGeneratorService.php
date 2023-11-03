<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PdfGeneratorService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud-generator:excel {name} {fields}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'pdf use dompdf';

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
    public function generateCrud($name, $fields)
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
        $dompdfFolderPath = resource_path('views/dompdf');
        if (!is_dir($dompdfFolderPath)) {
            $this->info("Folder view/dompdf berhasil dibuat.");
            mkdir($dompdfFolderPath, 0755, true);
        }

        $this->generateController($ucName, $lowerName);
        $this->generateView($lowerName, $fieldArray);
    }

    private function generateController($ucName, $lowerName)
    {
        $ControllersPath = app_path("Http/Controllers/API/{$ucName}PdfController.php");

        if (file_exists($ControllersPath)) {
            $this->error("Controllers {$ucName}PdfController sudah ada!");
            return;
        }

        $modelContent = $this->generateControllersContent($ucName, $lowerName);

        file_put_contents($ControllersPath, $modelContent);

        $this->info("Controllers {$ucName}PdfController berhasil dibuat.");
    }
    private function generateControllersContent($ucName, $lowerName)
    {
        $modelStubPath = base_path('resources/views/crud-generator-template/stub/dompdf.controller.stub');
        $modelContent = file_get_contents($modelStubPath);
        $modelContent = str_replace(['{{ class }}', '{{ class_lower }}'], [$ucName, $lowerName], $modelContent);

        return $modelContent;
    }

    private function generateView($lowerName, $fieldArray)
    {
        $viewsPath = resource_path("views/dompdf/{$lowerName}.blade.php");

        if (file_exists($viewsPath)) {
            $this->error("views {$lowerName} sudah ada!");
            return;
        }

        $modelContent = $this->generateViewContent($lowerName, $fieldArray);

        file_put_contents($viewsPath, $modelContent);

        $this->info("views {$lowerName} berhasil dibuat.");
    }

    private function generateViewContent($lowerName, $fieldArray)
    {
        $tableHeader = [];
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $tableHeader[] = "<th>$fieldName</th>";
        }
        $tableHeaderString = implode("\n", $tableHeader);

        $tableData = [];
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $tableData[] = "<td>{{ $$lowerName->$fieldName }}</td>";
        }
        $tableDataString = implode("\n", $tableData);

        $modelStubPath = base_path('resources/views/crud-generator-template/stub/view.dompdf.stub');
        $modelContent = file_get_contents($modelStubPath);
        $modelContent = str_replace(['{{ class_lower }}', '{{ table_header }}', '{{ table_data }}'], [$lowerName, $tableHeaderString, $tableDataString], $modelContent);

        return $modelContent;
    }
}
