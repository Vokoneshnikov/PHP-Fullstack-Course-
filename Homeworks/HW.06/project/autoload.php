<?php
spl_autoload_register(function (string $className) : void{
    $prefix = "App\\";
    $baseDir = __DIR__ . "/src/";

    $prefixlength = strlen($prefix);

    if (strncmp($prefix, $className, $prefixlength) != 0) {
        return;
    }

    $filePath = $baseDir . str_replace("\\", "/", substr($className, $prefixlength)) . ".php";

    if (file_exists($filePath)) {
        require $filePath;
    }
    else {
        throw new \RuntimeException("Class file not found: {$filePath}");
    }

}
);
