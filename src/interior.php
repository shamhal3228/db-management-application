<?php
session_start();

if ($_SESSION['user_group']!="Менеджер-менеджер")
{
    header("HTTP/1.0 404 Not Found");
    die();
}

global $filterquery, $userfilter;
$filterquery = "SELECT * FROM interior WHERE ";
$userfilter = "";

if (isset($_POST['add'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $authorID = mysqli_real_escape_string($connection, $_POST['authorID']);
    $fetching_employeeID = mysqli_query($connection, "SELECT `employeeID` FROM `employee` WHERE `employeeID` = '$authorID'");
    $employeeID = mysqli_fetch_array($fetching_employeeID);

    if (empty($employeeID['employeeID']))
    {
        echo "Нет такого сотрудника";
        return;
    }

    $price = mysqli_real_escape_string($connection, $_POST['price']);
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    $style = mysqli_real_escape_string($connection, $_POST['style']);
    $materials = mysqli_real_escape_string($connection, $_POST['materials']);

    $query = "INSERT INTO `interior` (authorID, price, type, style, materials) VALUES ('$authorID', '$price', '$type', '$style', '$materials')";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
}

if (isset($_POST['update'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $ID = mysqli_real_escape_string($connection, $_POST['ID']);
    
    $authorID = mysqli_real_escape_string($connection, $_POST['authorID']);
    $fetching_employeeID = mysqli_query($connection, "SELECT `employeeID` FROM `employee` WHERE `employeeID` = '$authorID'");
    $employeeID = mysqli_fetch_array($fetching_employeeID);

    if (empty($employeeID['employeeID']))
    {
        echo "Нет такого сотрудника";
        return;
    }
    if ($authorID!=NULL)
    {
        $query = "UPDATE `interior` SET authorID='$authorID' WHERE schemeID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $price = mysqli_real_escape_string($connection, $_POST['price']);
    if ($price!=NULL)
    {
        $query = "UPDATE `interior` SET price='$price' WHERE schemeID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    if ($type!=NULL)
    {
        $query = "UPDATE `interior` SET type='$type' WHERE schemeID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $style = mysqli_real_escape_string($connection, $_POST['style']);
    if ($style!=NULL)
    {
        $query = "UPDATE `interior` SET style='$style' WHERE schemeID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $materials = mysqli_real_escape_string($connection, $_POST['materials']);
    if ($materials!=NULL)
    {
        $query = "UPDATE `interior` SET materials='$materials' WHERE schemeID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
}

if (isset($_POST['filter'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $firstID = mysqli_real_escape_string($connection, $_POST['firstID']);
    $lastID = mysqli_real_escape_string($connection, $_POST['lastID']);
    $multyID = mysqli_real_escape_string($connection, $_POST['multyID']);
    $FIO = mysqli_real_escape_string($connection, $_POST['FIO']);

    $first_price = mysqli_real_escape_string($connection, $_POST['first_price']);
    $last_price = mysqli_real_escape_string($connection, $_POST['last_price']);
    $multy_price = mysqli_real_escape_string($connection, $_POST['multy_price']);
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    $style = mysqli_real_escape_string($connection, $_POST['style']);
    $materials = mysqli_real_escape_string($connection, $_POST['materials']);

    $andFlag=0;

    if ($firstID!=NULL && $lastID!=NULL)
        {
            $filterquery = $filterquery."schemeID BETWEEN $firstID AND $lastID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID." до ".$lastID."<br/>";
        }
    elseif ($firstID!=NULL)
        {
            $filterquery = $filterquery."schemeID >= $firstID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID."<br/>";
        }
    elseif ($lastID!=NULL)
        {
            $filterquery = $filterquery."schemeID <= $lastID";
            $andFlag=1;
            $userfilter = "Показать ID до ".$lastID."<br/>";
        }

    if ($multyID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND schemeID IN ($multyID)";
            $userfilter = $userfilter."Показать ID: ".$multyID."<br/>";
        }
        else {
            $filterquery = $filterquery."schemeID IN ($multyID)";
            $andFlag=1;
            $userfilter = "Показать ID: ".$multyID."<br/>";
        }
    }

    if ($FIO!=NULL)
    {
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $temp = "SELECT * FROM employee WHERE FIO LIKE '%$FIO%'";
        $temp_result = $mysqli->query($temp);
        $temp = "";
        foreach ($temp_result as $row){
            $temp=$temp.$row['employeeID'].",";
        }
        $temp = substr($temp,0,-1);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND authorID IN (".$temp.")";
            $userfilter = $userfilter."Показать ФИО: ".$FIO."<br/>";
        }
        else {
            $filterquery = $filterquery."authorID IN (".$temp.")";
            $andFlag=1;
            $userfilter = "Показать ФИО: ".$FIO."<br/>";
        }
    }

    if ($first_price!=NULL && $last_price!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND price BETWEEN $first_price AND $last_price";
                $userfilter = $userfilter."Показать цену от: ".$first_price." до ".$last_price."<br/>";
            }
        else {
            $filterquery = $filterquery."price BETWEEN $first_price AND $last_price";
            $andFlag=1;
            $userfilter = "Показать цену от: ".$first_price." до ".$last_price."<br/>";
        }
    }
    elseif ($first_price!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND price >= $first_price";
                $userfilter = $userfilter."Показать цену от: ".$first_price."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."price >= $first_price";
            $userfilter = "Показать цену от: ".$first_price."<br/>";
        }
    }
    elseif ($last_price!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND price <= $last_price";
                $userfilter = $userfilter."Показать цену до: ".$last_price."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."price <= $last_price";
            $userfilter = "Показать цену до: ".$last_price."<br/>";
        }
        
    }

    if ($multy_price!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND price IN ($multy_price)";
            $userfilter = $userfilter."Показать цену: ".$multy_price."<br/>";
        }
        else {
            $filterquery = $filterquery."price IN ($multy_price)";
            $andFlag=1;
            $userfilter = "Показать цену: ".$multy_price."<br/>";
        }
    }

    if ($type!=NULL)
    {
        $arr = explode(", ", $type);
        for ($i=0; $i<count($arr); $i++)
        {
            $arr[$i] = "'".$arr[$i]."'";
        }
        $type = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND type IN ($type)";
            $userfilter = $userfilter."Показать типы: ".$type."<br/>";
        }
        else {
            $filterquery = $filterquery."type IN ($type)";
            $andFlag=1;
            $userfilter = "Показать типы: ".$type."<br/>";
        }
    }

    if ($style!=NULL)
    {
        $arr = explode(", ", $style);
        for ($i=0; $i<count($arr); $i++)
        {
            $arr[$i] = "'".$arr[$i]."'";
        }
        $style = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND style IN ($style)";
            $userfilter = $userfilter."Показать стили: ".$style."<br/>";
        }
        else {
            $filterquery = $filterquery."style IN ($style)";
            $andFlag=1;
            $userfilter = "Показать стили: ".$style."<br/>";
        }
    }

    if ($materials!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND materials LIKE '%".$materials."%'";
            $userfilter = $userfilter."Показать материалы: ".$materials."<br/>";
        }
        else {
            $filterquery = $filterquery."materials LIKE '%".$materials."%'";
            $andFlag=1;
            $userfilter = "Показать материалы: ".$materials."<br/>";
        }
    }
}
?>

<html>
<head>
<title>Интерьеры</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>

<script src="sortTable.js"></script>

<a href="logout.php" class="btn btn-primary wid7 lin">Выйти</a>
<a href="admin.php" class="btn btn-primary wid7 lin">Главная</a>
<a href="interior.php" class="btn btn-primary wid7 lin">Обновить</a>

<h1 class="text">Таблица всех сотрудников</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>Id</th><th>ФИО</th><th>ЗП</th><th>Трудоустройство</th><th>Смена</th><th>Опыт работы, месяцы</th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM employee");
        
        foreach ($result as $row){
            echo "<tr><td>{$row['employeeID']}</td><td>{$row['FIO']}</td><td>{$row['salary']}</td><td>{$row['form_of_employment']}</td><td>{$row['shift']}</td><td>{$row['experience']}</td></tr>";
        }
    ?>
</tbody>
</table>

<h1 class="text">Таблица характеристик интерьеров</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>Id</th><th>ФИО автора</th><th>Цена</th><th>Тип</th><th>Стиль</th><th>Материалы</th><th></th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM interior");

        if ($filterquery!="SELECT * FROM interior WHERE ")
            $result = $mysqli->query($filterquery);

        if ($userfilter != "")
            echo $userfilter;

        foreach ($result as $row){
            $author = $row['authorID'];
            $result2 = $mysqli->query("SELECT FIO FROM employee WHERE employeeID=$author");
            if ($result2!= NULL)
            foreach ($result2 as $row2){
                echo "<tr><td>{$row['schemeID']}</td><td>{$row2['FIO']}</td><td>{$row['price']}</td><td>{$row['type']}</td><td>{$row['style']}</td><td>{$row['materials']}</td><td><a class='btn btn-outline-danger' href='delete.php?ID=".$row['schemeID']."&table=interior'>Удалить</a></td></tr>";
            }
            else echo "<tr><td>{$row['schemeID']}</td><td></td><td>{$row['price']}</td><td>{$row['type']}</td><td>{$row['style']}</td><td>{$row['materials']}</td><td><a class='btn btn-outline-danger' href='delete.php?ID=".$row['schemeID']."&table=interior'>Удалить</a></td></tr>";
        }
    ?>
<tbody>
</table>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="authorID" id="authorID" placeholder="ID автора">
<input type="text" name="price" id="price" placeholder="Стоимость">
<input type="text" name="type" id="type" placeholder="Тип">
<input type="text" name="style" id="style" placeholder="Стиль">
<input type="text" name="materials" id="materials" placeholder="Материалы">

<input class="btn btn-primary" type="submit" name="add" value="Добавить интерьер">

</form>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="ID" id="ID" placeholder="ID интерьера">
<input class="wid8" type="text" name="authorID" id="authorID" placeholder="ID автора">
<input type="text" name="price" id="price" placeholder="Стоимость">
<input type="text" name="type" id="type" placeholder="Тип">
<input type="text" name="style" id="style" placeholder="Стиль">
<input type="text" name="materials" id="materials" placeholder="Материалы">

<input class="btn btn-primary" type="submit" name="update" value="Изменить характеристики интерьера">

</form>


<h1 class="text">Фильтр</h1>

<form name="form" action="" method="POST">

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать ID от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="firstID" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="lastID" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные ID:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multyID" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные ФИО:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="FIO" placeholder="Любые символы ФИО">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать цену от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="first_price" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="last_price" placeholder="1000000">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные цены:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_price" placeholder="100, 2000, 30000">>
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные типы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="type" placeholder="Торговый центр, Больница,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные стили:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="style" placeholder="Любые символы стиля">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные материалы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="materials" placeholder="Любые символы материала">
</div>

<input class="btn btn-primary" type="submit" name="filter" value="Применить фильтры">

</form>


</body>
</html>