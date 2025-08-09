<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeDomain extends Command
{
    protected $signature = 'make:domain {name}';
    protected $description = 'Generate CRUD-ready Domain structure for API';

    public function handle()
    {
        $name = ucfirst($this->argument('name'));
        $lowername = strtolower($name);
        $basePath = app_path("Domain/{$name}");

        // Buat folder domain
        foreach (['Models', 'Services', 'Repositories', 'DataTransferObjects', 'Actions'] as $folder) {
            File::ensureDirectoryExists("{$basePath}/{$folder}");
        }

        // Buat file dari stub
        // Model, Service, Repository, DTO
        $this->generateFromStub('model', "{$basePath}/Models/{$name}.php", $name);
        $this->info("Model file berhasil dibuat: {$basePath}/Models/{$name}.php");

        $this->generateFromStub('service', "{$basePath}/Services/{$name}Service.php", $name);
        $this->info("Service file berhasil dibuat: {$basePath}/Services/{$name}Service.php");

        $this->generateFromStub('repository', "{$basePath}/Repositories/{$name}Repository.php", $name);
        $this->info("Repository file berhasil dibuat: {$basePath}/Repositories/{$name}Repository.php");

        $this->generateFromStub('dto', "{$basePath}/DataTransferObjects/{$name}Data.php", $name);
        $this->info("DTO file berhasil dibuat: {$basePath}/DataTransferObjects/{$name}Data.php");

        // Controller
        $controllerPath = app_path("Http/Controllers/Api/V1/{$name}Controller.php");
        File::ensureDirectoryExists(dirname($controllerPath));
        $this->generateFromStub('controller', $controllerPath, $name);
        $this->info("Controller file berhasil dibuat: {$controllerPath}");

        // Response
        // Cek apakah file sudah ada
        $responsePath = app_path("Http/Resources/ResponseResource.php");
        if (File::exists($responsePath)) {
            $this->warn("Response file sudah ada: {$responsePath}");
        } else {
            File::ensureDirectoryExists(dirname($responsePath));
            $this->generateFromStub('response', $responsePath, $name);
            $this->info("Response file berhasil dibuat: {$responsePath}");
        }

        // Request
        $requestPath = app_path("Http/Requests/{$name}StoreRequest.php");
        File::ensureDirectoryExists(dirname($requestPath));
        $this->generateFromStub('request', $requestPath, $name);
        $this->info("Request file berhasil dibuat: {$requestPath}");

        // Routes
        $routesPath = "{$basePath}/routes.php";
        File::ensureDirectoryExists(dirname($routesPath));
        $this->generateFromStub('routes', $routesPath, $name);
        $this->info("Routes file berhasil dibuat: {$routesPath}");
        // File::put("{$basePath}/routes.php", "<?php\n\nuse Illuminate\Support\Facades\Route;\n\n// Routes for {$name} domain\n");

        $this->info("Domain {$name} CRUD berhasil dibuat");
        return Command::SUCCESS;
    }

    private function generateFromStub(string $stubName, string $targetPath, string $name)
    {
        $stubPath = base_path("stubs/domain/{$stubName}.stub");

        // Cek apakah stub ada
        if (!File::exists($stubPath)) {
            $this->error("Stub {$stubName} tidak ditemukan!");
            return;
        }

        $replacements = [
            '{{name}}'        => $name,
            '{{lower_name}}'  => strtolower($name),
            '{{upper_name}}'  => strtoupper($name),
        ];

        $content = str_replace(array_keys($replacements), array_values($replacements), File::get($stubPath));
        File::put($targetPath, $content);
    }
}
