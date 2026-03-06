<?php
$productsArray = [
    ['id' =>  1, 'name' => 'JBL 520T', 'price' => 3999, 'tags' => ['JBL', 'Headphones', 'Electronics']],
    ['id' =>  2, 'name' => 'PlayStation 5', 'price' => 55000, 'tags' => ['Console', 'PlayStation', 'Electronics']],
    ['id' =>  3, 'name' => 'Samsung S25', 'price' => 49999, 'tags' => ['Samsung', 'Phone', 'Electronics']],
    ['id' =>  4, 'name' => 'JBL Clip 3', 'price' => 4499, 'tags' => ['JBL', 'Wireless speaker', 'Electronics']],
    ['id' =>  5, 'name' => 'Samsung A32', 'price' => 21999, 'tags' => ['Samsung', 'Phone', 'Electronics']],
    ['id' =>  6, 'name' => 'IPhone 16 Pro Max', 'price' => 119999, 'tags' => ['Apple', 'Phone', 'Electronics']],
    ['id' =>  7, 'name' => 'Xbox 360', 'price' => 38999, 'tags' => ['Electronics', 'Console', 'Xbox']],
    ['id' =>  8, 'name' => 'Apple Watch', 'price' => 11999, 'tags' => ['Apple', 'Watch', 'Electronics']],
    ['id' =>  9, 'name' => 'Tissot PRX', 'price' => 27999, 'tags' => ['Watch', 'Tissot']],
    ['id' =>  10, 'name' => 'Air Pods', 'price' => 9999.9, 'tags' => ['Apple', 'Headphones', 'Electronics']],
];

$query = isset($_GET['q']) ? strtolower($_GET['q']) : '';
$minPrice = isset($_GET['min']) ? floatval($_GET['min']) : 0;
$maxPrice = isset($_GET['max']) ? floatval($_GET['max']) : PHP_FLOAT_MAX;
$sortType = isset($_GET['sort']) ? $_GET['sort'] : '';
$sortDirection = isset($_GET['dir']) ? $_GET['dir'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage =  isset($_GET['perPage']) ? intval($_GET['perPage']) : 1;


$filteredArray = filter($productsArray, $minPrice, $maxPrice, $query);

$sortedArray = sorted($filteredArray, $sortType, $sortDirection);
$pagedArray = paginate($sortedArray, $page, $perPage);


echo '<h1>Страница номер ' . $page, '</h1>', '<br><br>';

foreach ($pagedArray as $product) {
    echo '<p>'. $product['name'], ' - ', $product['price'], 'р</p>', '<br/>';
}

function filter(array $arr, float $minimalPrice, float $maximalPrice, string $query): array {
    $query = trim(strtolower($query));

    $result = [];
    foreach ($arr as $product) {

        if ($product['price'] < $minimalPrice || $product['price'] > $maximalPrice) {
            continue;
        }
        if (str_contains(strtolower($product['name']), $query)) {
            $result[] = $product;
            continue;
        }
        foreach ($product['tags'] as $tag) {
            if (str_contains(strtolower($tag), $query)) {
                $result[] = $product;  
                break;
            }
        }
    }
    return $result;
}
function sorted(array $arr, string $sortType, string $sortDirection): array {

    if ($sortDirection == '' && $sortType === '') {
        return $arr;
    }

    if ($sortDirection == 'desc'){
        if ($sortType == 'name'){
            usort($arr, function($a, $b) {
                return strcmp($b['name'], $a['name']);
            });
        }
        else {
            usort($arr, function($a, $b) {
                return $b['price'] - $a['price'];
            }); 
        }
    }
    else {
        if ($sortType == 'name'){
            usort($arr, function($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
        }
        else {
            usort($arr, function($a, $b){
            return $a['price'] - $b['price'];
            }); 
        }
    }
    return $arr;
}

function paginate(array $arr, int $page, int $perPage): array {

    $start = ($page -1) * $perPage;

    if ($start + $perPage - 1 >= count($arr)){
    $arr = array_splice($arr, $start);
    }
    else {
        $arr = array_splice($arr, $start, $perPage);
    }
    return $arr;
}
?>