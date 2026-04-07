<?php

require_once __DIR__ . '/../vendor/autoload.php';


use App\Core\Config;
use App\Core\Exceptions\FirstException;
use App\Core\Exceptions\SecondException;

try {
    echo "--- Попытка загрузки конфигурации ---" . PHP_EOL;

    Config::load(__DIR__ . '/../'); 

    echo "Успешно! Имя приложения: " . Config::get('APP_NAME') . PHP_EOL;

} catch (FirstException $e) {
    echo "ПОЙМАНО FirstException: " . $e->getMessage() . PHP_EOL;
    echo "Проверьте наличие файла .env в корне проекта." . PHP_EOL;

} catch (SecondException $e) {
    echo "ПОЙМАНО SecondException: " . $e->getMessage() . PHP_EOL;
    echo "Проверьте содержимое файла .env." . PHP_EOL;

} catch (\Exception $e) {
    echo "Общая ошибка: " . $e->getMessage() . PHP_EOL;
}
