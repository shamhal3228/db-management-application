<?php
session_start();

if ($_SESSION['user_group']!="Клиент")
{
    header("HTTP/1.0 404 Not Found");
    die();
}
?>

<html>
<head>
<title>Клиент</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="mystyle.css">

</head>
<body>
<script src="sortTable.js"></script>
<a href="logout.php" class="btn btn-primary wid7 lin">Выйти</a>
<h1 class="text">Таблица характеристик интерьеров</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>Id</th><th>ФИО автора</th><th>Цена</th><th>Тип</th><th>Стиль</th><th>Материалы</th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM interior");
        foreach ($result as $row){
            $author = $row['authorID'];
            $result2 = $mysqli->query("SELECT FIO FROM employee WHERE employeeID=$author");
            if ($result2!= NULL)
            foreach ($result2 as $row2){
                echo "<tr><td>{$row['schemeID']}</td><td>{$row2['FIO']}</td><td>{$row['price']}</td><td>{$row['type']}</td><td>{$row['style']}</td><td>{$row['materials']}</td></tr>";
            }
            else echo "<tr><td>{$row['schemeID']}</td><td></td><td>{$row['price']}</td><td>{$row['type']}</td><td>{$row['style']}</td><td>{$row['materials']}</td></tr>";
        }
    ?>
<tbody>
</table>

<br>

<h1 class="text">Таблица характеристик экстерьеров</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>Id</th><th>ФИО автора</th><th>Цена</th><th>Тип</th><th>Высота, м</th><th>Ширина, м</th><th>Количсетво этажей</th><th>Отопление</th><th>Огнеупорность</th><th>Долговечность, года</th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM exterior");
        foreach ($result as $row){
            $author = $row['authorID'];
            $result2 = $mysqli->query("SELECT FIO FROM employee WHERE employeeID=$author");
            if ($result2!= NULL)
            foreach ($result2 as $row2){
                echo "<tr><td>{$row['modelID']}</td><td>{$row2['FIO']}</td><td>{$row['price']}</td><td>{$row['type']}</td><td>{$row['height']}</td><td>{$row['width']}</td><td>{$row['number_of_floors']}</td><td>{$row['heating']}</td><td>{$row['fire_resistance']}</td><td>{$row['longlevity']}</td></tr>";
            }
            else echo "<tr><td>{$row['modelID']}</td><td></td><td>{$row['price']}</td><td>{$row['type']}</td><td>{$row['height']}</td><td>{$row['width']}</td><td>{$row['number_of_floors']}</td><td>{$row['heating']}</td><td>{$row['fire_resistance']}</td><td>{$row['longlevity']}</td></tr>";
        }
    ?>
</tbody>
</table>

</body>
</html>