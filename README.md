## Standarisasi: Cara Generate Command Data Transfer Object (DTO) Domainn
1. Buat folder stubs/domain di dalam folder project
2. Create file controller.stub dto.stub model.stub repository.stub request.stub service.stub response.stub routes.stub
3. Create file command make domain:
```
php artisan make:command MakeDomain

```
4. Gunakan generator command:
```
php artisan make:domain [Nama domain misal: Product]

```
5. Folder dan file akan otomatis terbuat
```
app/Domain/Product/
    ├── Actions/
    ├── DataTransferObjects/
    ├── Models/
    ├── Repositories/
    ├── Services/
    └── routes.php

app/Http/
    ├── Controllers/Api/v1
    ├── Requests/
    ├── Resources/

app/Http/Controllers/Api/v1/ProductController.php
app/Http/Request/ProductStoreRequest.php
app/Http/Resources/ResponseResource.php

```

6. Install api route
```
php artisan install:api

```

7. Setup api route supaya semua routes.php yang ada di folder domain ke load otomatis
```
<?php

use Illuminate\Support\Facades\File;

$domainPath = app_path('Domain');

foreach (File::directories($domainPath) as $domainDir) {
    $routeFile = $domainDir . '/routes.php';
    if (File::exists($routeFile)) {
        require $routeFile;
    }
}

```

8. Cek list route:
```
php artisan route:list

```

9. Setup connection di file .env
10. Update Models: app/Domain/Product/Models/Product.php sesuaikan dengan migration database
11. Update Requests: app/Http/Requests/ProductStoreRequest.php
12. Update DataTransferObjects: app/Domain/Product/DataTransferObjects/ProductData.php sesuaikan dengan migration database
13. Running aplikasi
```
php artisan serve

```


## Standarisasi: Script Membuat Domain DTO Otomatis


MakeDomain.php
```
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

```


#powerby: Coretan Digital Aspullah



