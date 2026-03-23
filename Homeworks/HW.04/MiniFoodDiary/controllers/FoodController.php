<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/FoodModel.php';
require_once __DIR__ . '/../core/Validator.php';

class FoodController extends BaseController {
    private $model;
    private $validator;
    
    public function __construct() {
        $this->model = new FoodModel(__DIR__ . '/../data/foods.json');
        $this->validator = new Validator();
    }
    
    public function index() {
        $foods = $this->model->getAll();
        $flash = $this->getFlash();
        
        $this->render('home', [
            'foods' => $foods,
            'title' => 'Кулинарная книга',
            'flash' => $flash
        ]);
    }
    
    public function showCreateForm() {
    $csrfToken = $this->getCsrfToken();
    
    // Отладка
    error_log("=== 1. showCreateForm ===");
    error_log("csrfToken value: " . ($csrfToken ?? 'NULL'));
    
    $data = [
        'title' => 'Добавить блюдо',
        'action' => '/food/create',
        'food' => ['title' => '', 'description' => '', 'proteins' => '', 'fats' => '', 'carbohydrates' => ''],
        'errors' => [],
        'csrfToken' => $csrfToken,
        'isEdit' => false
    ];
    
    error_log("Data before render: " . print_r($data, true));
    
    $this->render('createForm', $data);
}
    
    public function create() {
        $data = [
            'title' => $this->getFromPost('title'),
            'description' => $this->getFromPost('description'),
            'proteins' => $this->getFromPost('proteins'),
            'fats' => $this->getFromPost('fats'),
            'carbohydrates' => $this->getFromPost('carbohydrates')
        ];
        
        $errors = $this->validator->validate($data, [
            'title' => ['required', 'min:3', 'max:100'],
            'description' => ['required', 'min:10', 'max:500'],
            'proteins' => ['required', 'numeric', 'min:0', 'max:100'],
            'fats' => ['required', 'numeric', 'min:0', 'max:100'],
            'carbohydrates' => ['required', 'numeric', 'min:0', 'max:100']
        ]);
        
        if (!empty($errors)) {
            $this->render('createForm', [
                'title' => 'Добавить блюдо',
                'action' => '/food/create',
                'food' => $data,
                'errors' => $errors,
                'csrfToken' => $this->getCsrfToken(),
                'isEdit' => false
            ]);
            return;
        }
        
        $this->model->create($data);
        $this->setFlash('success', 'Блюдо "' . htmlspecialchars($data['title']) . '" успешно добавлено!');
        $this->redirect('/food');
    }
    
    public function showEditForm() {
        $id = $this->getFromGet('id');
        
        if (!$id) {
            $this->setFlash('error', 'ID блюда не указан');
            $this->redirect('/food');
            return;
        }
        
        $food = $this->model->getById($id);
        
        if (!$food) {
            $this->setFlash('error', 'Блюдо не найдено');
            $this->redirect('/food');
            return;
        }
        
        $csrfToken = $this->getCsrfToken();
        
        $this->render('updateForm', [
            'title' => 'Редактировать блюдо',
            'action' => '/food/update',
            'food' => $food,
            'errors' => [],
            'csrfToken' => $csrfToken,
            'isEdit' => true
        ]);
    }
    
    public function update() {
        $id = $this->getFromPost('id');
        
        if (!$id) {
            $this->setFlash('error', 'ID блюда не указан');
            $this->redirect('/food');
            return;
        }
        
        $data = [
            'title' => $this->getFromPost('title'),
            'description' => $this->getFromPost('description'),
            'proteins' => $this->getFromPost('proteins'),
            'fats' => $this->getFromPost('fats'),
            'carbohydrates' => $this->getFromPost('carbohydrates')
        ];
        
        $errors = $this->validator->validate($data, [
            'title' => ['required', 'min:3', 'max:100'],
            'description' => ['required', 'min:10', 'max:500'],
            'proteins' => ['required', 'numeric', 'min:0', 'max:100'],
            'fats' => ['required', 'numeric', 'min:0', 'max:100'],
            'carbohydrates' => ['required', 'numeric', 'min:0', 'max:100']
        ]);
        
        if (!empty($errors)) {
            $food = $this->model->getById($id);
            $this->render('updateForm', [
                'title' => 'Редактировать блюдо',
                'action' => '/food/update',
                'food' => array_merge($food, $data),
                'errors' => $errors,
                'csrfToken' => $this->getCsrfToken(),
                'isEdit' => true
            ]);
            return;
        }
        
        $this->model->update($id, $data);
        $this->setFlash('success', 'Блюдо "' . htmlspecialchars($data['title']) . '" успешно обновлено!');
        $this->redirect('/food');
    }
}