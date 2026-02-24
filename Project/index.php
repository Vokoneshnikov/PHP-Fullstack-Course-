<?php 
$name = $_GET["name"] ?? '';
$role = $_GET["role"] ?? '';
$skills = $_GET["skills"] ?? [];


$skills = array_map('trim', $skills);
$skills = array_filter($skills);

$name_screened = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$role_screened = htmlspecialchars($role, ENT_QUOTES, 'UTF-8');

$profile = ['name' => $name_screened, 'role' => $role_screened, 'skills' => $skills];


echo "<h1>";
echo "Имя и роль: " . $profile['name'], " ", $profile['role'];
echo "</h1>";
echo "<br/>";
foreach ($profile['skills'] as $value) {
    echo htmlspecialchars($value, ENT_QUOTES, "UTF-8");
    echo "<br/>";
}
unset($value);
?>