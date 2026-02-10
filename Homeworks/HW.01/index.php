<?php
$greeting = "Добрый день, ";
$greeting .= (isset($_GET['role']) && $_GET['role'] == "admin") ? "админ" : "";
$greeting .= isset($_GET['name']) ? $_GET['name'] :'';
echo htmlspecialchars($greeting, ENT_QUOTES,"UTF-8");
echo "<br/>";
echo "Метод: " . $_SERVER['REQUEST_METHOD'];
echo "<br/>";
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
echo "URI: "  . $protocol, $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'];
?>
