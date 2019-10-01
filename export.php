<?php

$host = 'localhost';
$db   = 'imp_csv';
$user = 'daniil';
$pass = 'password';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_LOCAL_INFILE => true,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
$table = "goods";
//написать имя таблицы в форме
//$table =$_POST[''];

try {
    $stm = $pdo->query("SELECT * FROM goods");
    $fp =fopen('/var/www/html/eightday/output/out.csv', 'w');
    while($row = $stm->fetch(PDO::FETCH_ASSOC)) {  // Перебираем строки
        fputcsv($fp, $row, ",");  // Записываем строки в поток
    }
    fclose($fp);
    echo "Записано в файл .csv ". "<a href='/eightday/output/out.csv'>Скачать файл</a> ". "<a href='form.php'>Вернуться</a>";
} catch (PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
}
?>
