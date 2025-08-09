<?php

use Illuminate\Support\Facades\File;

$domainPath = app_path('Domain');

foreach (File::directories($domainPath) as $domainDir) {
    $routeFile = $domainDir . '/routes.php';
    if (File::exists($routeFile)) {
        require $routeFile;
    }
}
