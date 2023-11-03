<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class LivewireGeneratorService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud-generator:livewire {name} {fields}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Livewire crud';

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

        $livewireFolderPath = resource_path('views/livewire');
        if (!is_dir($livewireFolderPath)) {
            $this->info("Folder view/livewire berhasil dibuat.");
            mkdir($livewireFolderPath, 0755, true);
        }

        $this->generateController($ucName, $lowerName, $fieldArray);
        $this->generateViews($ucName, $lowerName, $fieldArray);
    }
    private function generateController($ucName, $lowerName, $fieldArray)
    {
        $ControllersPath = app_path("Http/Controllers/API/{$ucName}LivewireController.php");

        if (file_exists($ControllersPath)) {
            $this->error("Controllers {$ucName}LivewireController sudah ada!");
            return;
        }

        $modelContent = $this->generateControllersContent($ucName, $lowerName, $fieldArray);

        file_put_contents($ControllersPath, $modelContent);

        $this->info("Controllers {$ucName}LivewireController berhasil dibuat.");
    }

    private function generateControllersContent($ucName, $lowerName, $fieldArray)
    {

        $public = [];
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $public[] = "public \$$fieldName";
        }
        $publicString = implode("\n", $public);

        $rulesCreate = [];
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $rulesCreate[] = "'$fieldName' => \$this->$fieldName,";
        }
        $rulesCreateString = implode("\n", $rulesCreate);

        $rulesEdit = [];
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $rulesEdit[] = "\$this->$fieldName = $lowerName->$fieldName;";
        }
        $rulesEditString = implode("\n", $rulesEdit);


        $modelStubPath = base_path('resources/views/crud-generator-template/stub/controller.Livewire.stub');
        $modelContent = file_get_contents($modelStubPath);
        $modelContent = str_replace(['{{ class }}', '{{ class_lower }}', '{{ public_string }}', '{{ rules_create }}', '{{ rules_edit }}'], [$ucName, $lowerName, $publicString, $rulesCreateString, $rulesEditString], $modelContent);

        return $modelContent;
    }

    private function generateViews($ucName, $lowerName, $fieldArray)
    {
        $viewsPath = resource_path("views/livewire/{$lowerName}.php");

        if (file_exists($viewsPath)) {
            $this->error("views {$lowerName} sudah ada!");
            return;
        }

        $modelContent = $this->generateViewsContent($ucName, $lowerName, $fieldArray);

        file_put_contents($viewsPath, $modelContent);

        $this->info("Views {$ucName} berhasil dibuat.");
    }
    private function generateViewsContent($ucName, $lowerName, $fieldArray)
    {
        $formInput = [];
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $formInput[] = "<input wire:model='$fieldName' type='text' placeholder='$fieldName'>";
        }
        $formInputString = implode("\n", $formInput);

        $tableData = [];
        foreach ($fieldArray as $field) {
            $fieldName = str_replace(':', '', $field);
            $tableData[] = "<td>{{ \$$lowerName->{$fieldName} }}</td>";
        }
        $tableDataString = implode("\n", $tableData);

        $modelStubPath = base_path('resources/views/crud-generator-template/stub/view.livewire.stub');
        $modelContent = file_get_contents($modelStubPath);
        $modelContent = str_replace(['{{ class }}', '{{ class_lower }}', '{{ form_input }}', '{{ table_data }}'], [$ucName, $lowerName, $formInputString, $tableDataString], $modelContent);

        return $modelContent;
    }
}
