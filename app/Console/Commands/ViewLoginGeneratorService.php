<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewLoginGeneratorService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud-generator:login-template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create view template login';

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
        $this->generate();
    }

    private function generate()
    {
        $controllerStubPath = base_path('resources/views/crud-generator-template/stub/js.login.stub');
        $controllerContent = file_get_contents($controllerStubPath);

        $jsPath = public_path("assets/js/login.js");

        $vieStubPath = base_path('resources/views/crud-generator-template/stub/view.login.stub');
        $viwContent = file_get_contents($vieStubPath);

        $viewPath = resource_path("views/login/login.blade.php");

        $assetsFolderPath = public_path('assets');

        if (!is_dir($assetsFolderPath)) {
            $this->info("folder assets berhasil dibuat.");
            mkdir($assetsFolderPath, 0755, true);
        }
        $jsFolderPath = public_path('assets/js');
        if (!is_dir($jsFolderPath)) {
            $this->info("folder assets/js berhasil dibuat.");
            mkdir($jsFolderPath, 0755, true);
        }
        $viewsPath = resource_path("views/login");
        if (!is_dir($viewsPath)) {
            $this->info("folder views/login berhasil dibuat.");
            mkdir($viewsPath, 0755, true);
        }

        File::put($jsPath, $controllerContent);
        File::put($viewPath, $viwContent);

        $this->info("assets/js/login.js berhasil dibuat.");
        $this->info("view/login/login.blade.php berhasil dibuat.");
    }
}
