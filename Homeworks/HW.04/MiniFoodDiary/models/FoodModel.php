<?php

class FoodModel {
    private $dataFile;

    public function __construct($dataFile) {
        $this->dataFile = $dataFile;
        $this->initializeStorage();
    }
    
    private function initializeStorage() {
        if (!file_exists($this->dataFile)) {
            file_put_contents($this->dataFile, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    public function getAll() {
        $content = file_get_contents($this->dataFile);
        return json_decode($content, true) ?: [];
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
            'fats' => (float) $data['fats'],
            'proteins' => (float) $data['proteins'],
            'carbohydrates' => (float) $data['carbohydrates'],
        ];

        $this->save($foods);
        return $newId;

    }
    public function update($id, $data) {
        $foods = $this->getAll();
        
        foreach ($foods as $key => $food) {
            if ($food['id'] == $id) {
                $foods[$key]['title'] = $data['title'];
                $foods[$key]['description'] = $data['description'];
                $foods[$key]['fats'] = (int) $data['fats'];
                $foods[$key]['proteins'] = (int) $data['proteins'];
                $foods[$key]['carbohydrates'] = (int) $data['carbohydrates'];
                break;
            }
        }
        
        $this->save($foods);
        return true;
    }
    // public function delete($id) {
    //     $foods = $this->getAll();
        
    //     foreach ($foods as $key => $food) {
    //         if ($food['id'] == $id) {
    //             unset($foods[$key]);
    //             break;
    //         }
    //     }
        
    //     $this->save(array_values($foods));
    //     return true;
    // }

    private function save($foods) {
        file_put_contents($this->dataFile, json_encode($foods, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

?>
