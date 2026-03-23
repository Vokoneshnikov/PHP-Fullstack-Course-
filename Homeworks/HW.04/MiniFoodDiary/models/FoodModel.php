<?php
class FoodModel {
    public function __construct() {
        if (!isset($_SESSION['foods'])) {
            $_SESSION['foods'] = [];
        }
    }
    
    public function getAll() {
        return $_SESSION['foods'] ?? [];
    }
    
    public function getById($id) {
        $foods = $this->getAll();
        foreach ($foods as $food) {
            if ($food['id'] == $id) {
                return $food;
            }
        }
        return null;
    }
    
    public function create($data) {
        $foods = $this->getAll();
        
        $newId = count($foods) > 0 ? max(array_column($foods, 'id')) + 1 : 1;
        
        $foods[] = [
            'id' => $newId,
            'title' => $data['title'],
            'description' => $data['description'],
            'proteins' => (float) $data['proteins'],
            'fats' => (float) $data['fats'],
            'carbohydrates' => (float) $data['carbohydrates'],
        ];
        
        $_SESSION['foods'] = $foods;
        
        return $newId;
    }
    
    public function update($id, $data) {
        $foods = $this->getAll();
        
        foreach ($foods as $key => $food) {
            if ($food['id'] == $id) {
                $foods[$key]['title'] = $data['title'];
                $foods[$key]['description'] = $data['description'];
                $foods[$key]['proteins'] = (float) $data['proteins'];
                $foods[$key]['fats'] = (float) $data['fats'];
                $foods[$key]['carbohydrates'] = (float) $data['carbohydrates'];
                break;
            }
        }
        
        $_SESSION['foods'] = $foods;
        return true;
    }
}