
<?php
//$row = 1;
$new_arr = [];
if (($handle = fopen("goods.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $new_arr[] = $data;
    }
    /*for ($i=1;$i<count($new_arr);$i++){
        //print_r($new_arr[$i]);
        foreach ($new_arr[$i] as $key=>$val){
          echo $val;
        }
    }*/
    /*foreach($new_arr[0] as $key=>$v){
        ${$v} = $v;
    }*/

    //print_r($new_arr);
    fclose($handle);

}

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
//$table = htmlspecialchars($_POST['table']);
try {
    $dbh = new PDO($dsn, $user, $pass);
    foreach($new_arr[0] as $key=>$v){
        ${$v} = $v;
    }
    $sql = "CREATE table $table(
     ".$id." INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     ".$article." VARCHAR( 250 )  NOT NULL,
     ".$name." VARCHAR( 150 )  NOT NULL,
     ".$price." VARCHAR( 150 )  NOT NULL,
     ".$description." VARCHAR( 50 )  NOT NULL);" ;
    /*$dbh = new PDO($dsn, $user, $pass);
    $sql = "CREATE table $table(
    id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    article VARCHAR( 250 ) NOT NULL,
    name VARCHAR( 150 ) NOT NULL,
    price VARCHAR( 150 ) NOT NULL,
    description VARCHAR( 50 ) NOT NULL);" ;*/


// Пути загрузки файлов
    $path = 'output/';
    $tmp_path = 'tmp/';
// Массив допустимых значений типа файла
    $types = array('text/csv', 'text/xls');
// Максимальный размер файла
    $size = 1024000;

// Обработка запроса
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!in_array($_FILES['csv_file']['type'], $types)) {
            die('<p>Запрещённый тип файла. Выберете файл с расширением csv <a href="form.php">Попробовать другой файл?</a></p>');
        }
        // Проверяем размер файла
        if ($_FILES['csv_file']['size'] > $size) {
            die('<p>Слишком большой размер файла. <a href="form.php">Попробовать другой файл?</a></p>');
        }


    }

    echo("Таблица создана!") . "<a href='form.php'>Вернуться</a>";

    $pdo->exec($sql);


    //$stm = $pdo->query("INSERT INTO goods (article, name, price, description) VALUES ('fdsfdsf', 'fdsfds', 500, 'dsadasdasda')");
    $stm = $pdo->exec("LOAD DATA LOCAL INFILE 'goods.csv'
    INTO TABLE goods 
    FIELDS TERMINATED BY ',' 
    ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'
    IGNORE 1 ROWS;");
    //header('Location: form.php');

    //$stm->execute();
    //$stm->fetch();
} catch (PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
}
?>
