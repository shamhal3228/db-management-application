<?php
session_start();

if ($_SESSION['user_group']!="Склад-менеджер")
{
  header("HTTP/1.0 404 Not Found");
  die();
}

?>

<html>
<head>
<title>Склад-менеджер</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="mystyle.css">

</head>
<body>
<a href="logout.php" class="btn btn-primary wid7 lin">Выйти</a>

<h1 class="text">Доступные таблицы</h1>

<div class="list-group wid60">
  <a href="vehicles.php" class="list-group-item list-group-item-primary list-group-item-action wid60">Таблица всей техники</a>
  <a href="store.php" class="list-group-item list-group-item-primary list-group-item-action wid60">Таблица склада</a>
</div>

</body>
</html>