<!DOCTYPE HTML>
<html>
<head>
    <title>Загрузка изображения</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<h1>Загрузка csv файла</h1>

<form method="post" enctype="multipart/form-data" action="import.php">
    <input type="file" name="csv_file">
   <!-- <input type="text" name="table" required>-->
    <input type="submit" value="Загрузить">
</form>
<br>
<a href="export.php">Экспорт из mysql в csv файл</a>
</body>
</html>