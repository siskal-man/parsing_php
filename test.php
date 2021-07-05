<?php

require_once './phpQuery.php';


$months = array(
    'января' => 1,
    'февраля' => 2,
    'марта' => 3,
    'апреля' => 4,
    'мая' => 5,
    'июня' => 6,
    'июля' => 7,
    'августа' => 8,
    'сентября' => 9,
    'октября' => 10,
    'ноября' => 11,
    'декабря' => 12
);

$servername = "localhost";
$username = "root";
$password = null;
$dbname = "parse_db";

$conn = new mysqli($servername, $username, $password, $dbname);



if ($conn->connect_error) {
    die('Ошибка подключения: ' . $conn->connect_error);
}



?>