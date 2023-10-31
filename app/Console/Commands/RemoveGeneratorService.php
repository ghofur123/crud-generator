<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveGeneratorService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud-generator:remove {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'berhasil di hapus';

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
        $this->removeController($name);
        $this->removeResources($name);
        $this->removeRequest($name);
        $this->removeModel($name);
        // $this->removeViews($name);
        $this->info("Berhasil di hapus");
    }

    protected function removeController($name)
    {
        $controllerPath = app_path("Http/Controllers/API/{$name}Controller.php");
        if (File::exists($controllerPath)) {
            File::delete($controllerPath);
            $this->info("$name controller deleted successfully.");
        } else {
            $this->info("$name controller not found.");
        }
    }

    protected function removeResources($name)
    {
        $resourcePath = app_path("Http/Resources/{$name}Resource.php");
        if (File::exists($resourcePath)) {
            File::delete($resourcePath);
            $this->info("$name Resources deleted successfully.");
        } else {
            $this->info("$name Resources not found.");
        }
    }
    protected function removeRequest($name)
    {
        $resourcePath = app_path("Http/Requests/{$name}Request.php");
        if (File::exists($resourcePath)) {
            File::delete($resourcePath);
            $this->info("$name Requests deleted successfully.");
        } else {
            $this->info("$name Requests not found.");
        }
    }

    protected function removeModel($name)
    {
        $modelPath = app_path("Models/{$name}.php");
        if (File::exists($modelPath)) {
            File::delete($modelPath);
            $this->info("$name model deleted successfully.");
        } else {
            $this->info("$name model not found.");
        }
    }

    // protected function removeViews($name)
    // {
    //     $viewsPath = resource_path("views/{$name}");
    //     if (File::isDirectory($viewsPath)) {
    //         File::deleteDirectory($viewsPath);
    //         $this->info("$name views folder deleted successfully.");
    //     } else {
    //         $this->info("$name views folder not found.");
    //     }
    // }
}
