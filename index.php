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


function parsing_konkursgrant($conn, $months){
    $count = 0;


    $html_page = file_get_contents('https://konkursgrant.ru');
    $pq = phpQuery::newDocument($html_page);

    $links = $pq->find('.latestnewstitle1>li');


    foreach ($links as $item) {
        $link = 'https://konkursgrant.ru' . pq($item)->find('a')->attr('href');

        $sql = "SELECT link FROM contests WHERE contests.link = '$link'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            $html_page = file_get_contents($link);
            $pq = phpQuery::newDocument($html_page);

            $date = $pq->find('strong:first');

            $raw_deadline = explode(" ", $date->text());

            if ($link == 'https://konkursgrant.ru/spetsialistam/24949-konkurs-grantov-na-issledovatelskie-stazhirovki-v-sfere-filantropii.html') {
                continue;
            } else {
                $deadline = $raw_deadline[4] . '-' . $months[$raw_deadline[3]] . '-' . $raw_deadline[2];
            }

            $sql = "INSERT INTO contests VALUES (null, '$link', '$deadline')";

            if ($conn->query($sql) === TRUE) {
                $count++;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    $conn->close();

}


parsing_konkursgrant($conn, $months);
