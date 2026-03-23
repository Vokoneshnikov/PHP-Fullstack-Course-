<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/FoodModel.php';

class FoodController extends BaseController {
    private $model;

    public function __construct() {
        $this->model = new FoodModel(__DIR__ . '/../data/foods.json');
    }

    public function index() {
        $foods = $this->model->getAll();
        
        $this->render('home', [
            'foods' => $foods,
            'title' => 'Кулинарная книга'
        ]);
    }

    public function create() {
        $data = [
            'title' => $this->getFromPost('title'),
            'description' => $this->getFromPost('description'),
            'fats' => $this->getFromPost('fats'),
            'proteins' => $this->getFromPost('proteins'),
            'carbohydrates' => $this->getFromPost('carbohydrates'),
        ];

        //TODO РАЗОБРАТЬСЯ С ВАЛИДАЦИЕЙ

        // $errors = $this->validate($data, [
        //     'title' => ['required', 'min:3', 'max:100'],
        //     'description' => ['required', 'min:10', 'max:500'],
        //     'calories' => ['required', 'numeric']
        // ]);
        
        // if (!empty($errors)) {
        //     $this->render('food/form', [
        //         'title' => 'Добавить блюдо',
        //         'action' => '/food/create',
        //         'food' => $data,
        //         'errors' => $errors,
        //         'isEdit' => false
        //     ]);
        //     return;
        // }

        $this->model->create($data);
        
        $this->redirect('/food');

    }

    public function update() {
        $id = $this->getFromPost('id');

        if (!$id) {

        //TODO ВЫВЕСТИ ОШИБКА
            $this->redirect('/food');
            return;
        }

        $data = [
            'title' => $this->getFromPost('title'),
            'description' => $this->getFromPost('description'),
            'fats' => $this->getFromPost('fats'),
            'proteins' => $this->getFromPost('proteins'),
            'carbohydrates' => $this->getFromPost('carbohydrates'),
        ];


        // TODO ДОДЕЛАТЬ ВАЛИДАЦИЮ
        // $errors = $this->validate($data, [
        //     'title' => ['required', 'min:3', 'max:100'],
        //     'description' => ['required', 'min:10', 'max:500'],
        //     'calories' => ['required', 'numeric']
        // ]);
        
        // // Если есть ошибки - показываем форму с ошибками
        // if (!empty($errors)) {
        //     $food = $this->model->getById($id);
        //     $this->render('food/form', [
        //         'title' => 'Редактировать блюдо',
        //         'action' => '/food/edit',
        //         'food' => array_merge($food, $data),
        //         'errors' => $errors,
        //         'isEdit' => true
        //     ]);
        //     return;
        // }

        $this->model->update($id, $data);

        $this->redirect('/food');
    }
    //TODO ЧЕ ЭТО ДЕЛАЕТ ПОНЯТЬ
    public function showCreateForm() {
        $this->render('createForm', [
            'title' => 'Добавить блюдо',
            'action' => '/food/create',
            'food' => ['title' => '', 'description' => '', 'calories' => ''],
            'errors' => [],
            'isEdit' => false
        ]);
    }


    public function showEditForm() {
        $id = $this->getFromGet('id');
        
        if (!$id) {
            $this->redirect('/food');
            return;
        }
        
        $food = $this->model->getById($id);
        
        if (!$food) {
            $this->redirect('/food');
            return;
        }
        
        $this->render('updateForm', [
            'title' => 'Редактировать блюдо',
            'action' => '/food/update',
            'food' => $food,
            'errors' => [],
            'isEdit' => true
        ]);
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
}

?>