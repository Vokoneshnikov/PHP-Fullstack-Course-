<?php
namespace App\Core\Exceptions;
class SecondException extends \Exception {
    public function getFirstException() {
        return "Это вторая ошибка";
    }
}