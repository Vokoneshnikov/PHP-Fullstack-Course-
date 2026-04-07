<?php

namespace App\Core;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Dotenv\Exception\ValidationException;
// Импортируем твои исключения
use App\Core\Exceptions\FirstException;
use App\Core\Exceptions\SecondException;

class Config
{
    private static array $config = [];

    public static function load(string $path): void
    {
        try {
            $dotenv = Dotenv::createImmutable($path);
            $dotenv->load();

            $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);
            
            self::$config = $_ENV;

        } catch (InvalidPathException $e) {
            $msg = "Файл .env не найден: " . $e->getMessage();
            self::logError($msg); 
            throw new FirstException($msg);

        } catch (ValidationException $e) {
            $msg = "Ошибка обязательных параметров: " . $e->getMessage();
            self::logError($msg); 
            throw new SecondException($msg);

        } catch (\Exception $e) {
            $msg = "Общая ошибка конфига: " . $e->getMessage();
            self::logError($msg);
            throw new \Exception($msg);
        }
    }

    public static function get(string $key, $default = null)
    {
        return self::$config[$key] ?? $default;
    }

    private static function logError(string $message): void
    {
        $logDir = __DIR__ . '/../../runtime/logs';
        
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $logFile = $logDir . '/error.log';
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($logFile, "[$timestamp] $message" . PHP_EOL, FILE_APPEND);
    }
}
