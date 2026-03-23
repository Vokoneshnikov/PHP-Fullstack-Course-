<?php
// core/Validator.php

class Validator {
    public function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $ruleSet) {
            $value = $data[$field] ?? '';
            
            foreach ($ruleSet as $rule) {
                if ($rule === 'required' && empty($value) && $value !== '0') {
                    $errors[$field][] = "Поле обязательно для заполнения";
                }
                
                if ($rule === 'numeric' && !is_numeric($value)) {
                    $errors[$field][] = "Поле должно быть числом";
                }
                
                if (strpos($rule, 'min:') === 0) {
                    $min = (int) explode(':', $rule)[1];
                    if (is_numeric($value) && $value < $min) {
                        $errors[$field][] = "Минимальное значение: $min";
                    } elseif (!is_numeric($value) && mb_strlen($value) < $min) {
                        $errors[$field][] = "Минимальная длина: $min символов";
                    }
                }
                
                if (strpos($rule, 'max:') === 0) {
                    $max = (int) explode(':', $rule)[1];
                    if (is_numeric($value) && $value > $max) {
                        $errors[$field][] = "Максимальное значение: $max";
                    } elseif (!is_numeric($value) && mb_strlen($value) > $max) {
                        $errors[$field][] = "Максимальная длина: $max символов";
                    }
                }
            }
        }
        
        return $errors;
    }
}