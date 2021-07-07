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

$html_page = file_get_contents("https://vsekonkursy.ru");
$pq = phpQuery::newDocument($html_page);

$posts = $pq->find('.post-title>a');


foreach($posts as $post){
    $pqPost = pq($post)->attr('href');
    
    $html_page = file_get_contents($pqPost);
    $pq = phpQuery::newDocument($html_page);

    $str = (string)$pq->find('.entry-inner>p:first');
    $split = explode('Дедлайн', $str);
    $temp = explode(' ', $split[1]);
    // $split2 = explode('.', implode(' ', ));
    echo $temp[3] . '-' . $months[$temp[2]] . '-' . $temp[1];
    echo "<br><hr>";
    
}


?>