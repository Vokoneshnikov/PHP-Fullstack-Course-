<?php
namespace App\Core\Exceptions;
class FirstException extends \Exception {
    public function getFirstException() {
        return "Это первая ошибка";
    }
} 