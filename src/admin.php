<?php
session_start();

if ($_SESSION['user_group']!="Менеджер-менеджер")
{
  header("HTTP/1.0 404 Not Found");
  die();
}
?>

<html>
<head>
<title>Менеджер-менеджер</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="mystyle.css">

</head>
<body>
<a href="logout.php" class="btn btn-primary wid7 lin">Выйти</a>

<h1 class="text">Доступные таблицы</h1>

<div class="list-group wid60">
  <a href="employee.php" class="list-group-item list-group-item-primary list-group-item-action wid60">Таблица всех сотрудников</a>
  <a href="worker.php" class="list-group-item list-group-item-primary list-group-item-action wid60">Таблица всех рабочих</a>
  <a href="engeneer.php" class="list-group-item list-group-item-primary list-group-item-action wid60">Таблица всех инженеров</a>
  <a href="vehicles.php" class="list-group-item list-group-item-primary list-group-item-action wid60">Таблица всей техники</a>
  <a href="store.php" class="list-group-item list-group-item-primary list-group-item-action wid60">Таблица склада</a>
  <a href="interior.php" class="list-group-item list-group-item-primary list-group-item-action wid60">Таблица интерьеров</a>
  <a href="exterior.php" class="list-group-item list-group-item-primary list-group-item-action wid60">Таблица экстерьеров</a>
  <a href="tenders.php" class="list-group-item list-group-item-primary list-group-item-action wid60">Таблица тендеров</a>
  <a href="clientele.php" class="list-group-item list-group-item-primary list-group-item-action wid60">Таблица клиентов</a>
  <a href="current_project.php" class="list-group-item list-group-item-primary list-group-item-action wid60">Таблица текущих проектов</a>
</div>

</body>
</html>