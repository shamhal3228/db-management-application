<?php
session_start();

if ($_SESSION['user_group']!="Менеджер-менеджер")
{
    header("HTTP/1.0 404 Not Found");
    die();
}

global $filterquery, $userfilter;
$filterquery = "SELECT * FROM clientele WHERE ";
$userfilter = "";

if (isset($_POST['add'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $title = mysqli_real_escape_string($connection, $_POST['title']);

    $modelID = mysqli_real_escape_string($connection, $_POST['modelID']);
    $fetching_modelID = mysqli_query($connection, "SELECT `modelID` FROM `exterior` WHERE `modelID` = '$modelID'");
    $arr_modelID = mysqli_fetch_array($fetching_modelID);

    if (empty($arr_modelID['modelID']))
    {
        echo "Нет такой модели";
        return;
    }

    $schemeID = mysqli_real_escape_string($connection, $_POST['schemeID']);
    $fetching_schemeID = mysqli_query($connection, "SELECT `schemeID` FROM `interior` WHERE `schemeID` = '$schemeID'");
    $arr_schemeID = mysqli_fetch_array($fetching_schemeID);

    if (empty($arr_schemeID['schemeID']))
    {
        echo "Нет такой схемы";
        return;
    }

    $time_of_cooperation = mysqli_real_escape_string($connection, $_POST['time_of_cooperation']);
    if (!preg_match("/[0-9~`!#$%\^&*+=\-\[\]\\';,\/{}|\:<>\?\.]/", $_POST['telephone'])){
        echo "Некорректный номер телефона";
        return;
    }
    $telephone = mysqli_real_escape_string($connection, $_POST['telephone']);
    $number_of_orders = mysqli_real_escape_string($connection, $_POST['number_of_orders']);
    if (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $_POST['email']))
    {
        echo "Некорректная почта";
        return;
    }
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $adress = mysqli_real_escape_string($connection, $_POST['adress']);

    $query = "INSERT INTO `clientele` (title, modelID, schemeID, time_of_cooperation, telephone, number_of_orders, email, adress) VALUES ('$title', '$modelID', '$schemeID', '$time_of_cooperation', '$telephone', '$number_of_orders', '$email', '$adress')";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
}

if (isset($_POST['update'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $ID = mysqli_real_escape_string($connection, $_POST['ID']);

    $title = mysqli_real_escape_string($connection, $_POST['title']);
    if ($title!=NULL)
    {
        $query = "UPDATE `clientele` SET title='$title' WHERE clienteleID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $modelID = mysqli_real_escape_string($connection, $_POST['modelID']);
    $fetching_modelID = mysqli_query($connection, "SELECT `modelID` FROM `exterior` WHERE `modelID` = '$modelID'");
    $arr_modelID = mysqli_fetch_array($fetching_modelID);

    if (empty($arr_modelID['modelID']))
    {
        echo "Нет такой модели";
        return;
    }
    if ($modelID!=NULL)
    {
        $query = "UPDATE `clientele` SET modelID='$modelID' WHERE clienteleID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $schemeID = mysqli_real_escape_string($connection, $_POST['schemeID']);
    $fetching_schemeID = mysqli_query($connection, "SELECT `schemeID` FROM `interior` WHERE `schemeID` = '$schemeID'");
    $arr_schemeID = mysqli_fetch_array($fetching_schemeID);

    if (empty($arr_schemeID['schemeID']))
    {
        echo "Нет такой схемы";
        return;
    }
    if ($schemeID!=NULL)
    {
        $query = "UPDATE `clientele` SET schemeID='$schemeID' WHERE clienteleID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $time_of_cooperation = mysqli_real_escape_string($connection, $_POST['time_of_cooperation']);
    if ($title!=NULL)
    {
        $query = "UPDATE `clientele` SET time_of_cooperation='$time_of_cooperation' WHERE clienteleID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $telephone = mysqli_real_escape_string($connection, $_POST['telephone']);
    if ($telephone!=NULL)
    {
        $query = "UPDATE `clientele` SET telephone='$telephone' WHERE clienteleID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $number_of_orders = mysqli_real_escape_string($connection, $_POST['number_of_orders']);
    if ($number_of_orders!=NULL)
    {
        $query = "UPDATE `clientele` SET number_of_orders='$number_of_orders' WHERE clienteleID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $email = mysqli_real_escape_string($connection, $_POST['email']);
    if ($email!=NULL)
    {
        $query = "UPDATE `clientele` SET email='$email' WHERE clienteleID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $adress = mysqli_real_escape_string($connection, $_POST['adress']);
    if ($adress!=NULL)
    {
        $query = "UPDATE `clientele` SET adress='$adress' WHERE clienteleID=$ID";
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
    
    $title = mysqli_real_escape_string($connection, $_POST['title']);

    $firstModelID = mysqli_real_escape_string($connection, $_POST['firstModelID']);
    $lastModelID = mysqli_real_escape_string($connection, $_POST['lastModelID']);
    $multyModelID = mysqli_real_escape_string($connection, $_POST['multyModelID']);

    $firstSchemeID = mysqli_real_escape_string($connection, $_POST['firstSchemeID']);
    $lastSchemeID = mysqli_real_escape_string($connection, $_POST['lastSchemeID']);
    $multySchemeID = mysqli_real_escape_string($connection, $_POST['multySchemeID']);

    $first_time_of_cooperation = mysqli_real_escape_string($connection, $_POST['first_time_of_cooperation']);
    $last_time_of_cooperation = mysqli_real_escape_string($connection, $_POST['last_time_of_cooperation']);
    $multy_time_of_cooperation = mysqli_real_escape_string($connection, $_POST['multy_time_of_cooperation']);

    $telephone = mysqli_real_escape_string($connection, $_POST['telephone']);

    $first_number_of_orders = mysqli_real_escape_string($connection, $_POST['first_number_of_orders']);
    $last_number_of_orders = mysqli_real_escape_string($connection, $_POST['last_number_of_orders']);
    $multy_number_of_orders = mysqli_real_escape_string($connection, $_POST['multy_number_of_orders']);

    $email = mysqli_real_escape_string($connection, $_POST['email']);

    $adress = mysqli_real_escape_string($connection, $_POST['adress']);

    $andFlag=0;

    if ($firstID!=NULL && $lastID!=NULL)
        {
            $filterquery = $filterquery."clienteleID BETWEEN $firstID AND $lastID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID." до ".$lastID."<br/>";
        }
    elseif ($firstID!=NULL)
        {
            $filterquery = $filterquery."clienteleID >= $firstID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID."<br/>";
        }
    elseif ($lastID!=NULL)
        {
            $filterquery = $filterquery."clienteleID <= $lastID";
            $andFlag=1;
            $userfilter = "Показать ID до ".$lastID."<br/>";
        }

    if ($multyID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND clienteleID IN ($multyID)";
            $userfilter = $userfilter."Показать ID: ".$multyID."<br/>";
        }
        else {
            $filterquery = $filterquery."clienteleID IN ($multyID)";
            $andFlag=1;
            $userfilter = "Показать ID: ".$multyID."<br/>";
        }
    }

    if ($title!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND title LIKE '%".$title."%'";
            $userfilter = $userfilter."Показать наименования: ".$title."<br/>";
        }
        else {
            $filterquery = $filterquery."title LIKE '%".$title."%'";
            $andFlag=1;
            $userfilter = "Показать наименования: ".$title."<br/>";
        }
    }

    if ($firstModelID!=NULL && $lastModelID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND modelID BETWEEN $firstModelID AND $lastModelID";
                $userfilter = $userfilter."Показать ID модели от: ".$firstModelID." до ".$lastModelID."<br/>";
            }
        else {
            $filterquery = $filterquery."modelID BETWEEN $firstModelID AND $lastModelID";
            $andFlag=1;
            $userfilter = "Показать ID модели от: ".$firstModelID." до ".$lastModelID."<br/>";
        }
    }
    elseif ($firstModelID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND modelID >= $firstModelID";
                $userfilter = $userfilter."Показать ID модели от: ".$firstModelID."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."modelID >= $firstModelID";
            $userfilter = "Показать ID модели от: ".$firstModelID."<br/>";
        }
    }
    elseif ($lastModelID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND modelID <= $lastModelID";
                $userfilter = $userfilter."Показать ID модели до: ".$lastModelID."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."modelID <= $lastModelID";
            $userfilter = "Показать ID модели до: ".$lastModelID."<br/>";
        }
        
    }

    if ($multyModelID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND modelID IN ($multyModelID)";
            $userfilter = $userfilter."Показать ID модели: ".$multyModelID."<br/>";
        }
        else {
            $filterquery = $filterquery."modelID IN ($multyModelID)";
            $andFlag=1;
            $userfilter = "Показать ID модели: ".$multyModelID."<br/>";
        }
    }

    if ($firstSchemeID!=NULL && $lastSchemeID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND schemeID BETWEEN $firstSchemeID AND $lastSchemeID";
                $userfilter = $userfilter."Показать ID схемы от: ".$firstSchemeID." до ".$lastSchemeID."<br/>";
            }
        else {
            $filterquery = $filterquery."schemeID BETWEEN $firstSchemeID AND $lastSchemeID";
            $andFlag=1;
            $userfilter = "Показать ID схемы от: ".$firstSchemeID." до ".$lastSchemeID."<br/>";
        }
    }
    elseif ($firstSchemeID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND schemeID >= $firstSchemeID";
                $userfilter = $userfilter."Показать ID схемы от: ".$firstSchemeID."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."schemeID >= $firstSchemeID";
            $userfilter = "Показать ID схемы от: ".$firstSchemeID."<br/>";
        }
    }
    elseif ($lastSchemeID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND schemeID <= $lastSchemeID";
                $userfilter = $userfilter."Показать ID схемы до: ".$lastSchemeID."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."schemeID <= $lastSchemeID";
            $userfilter = "Показать ID схемы до: ".$lastSchemeID."<br/>";
        }
        
    }

    if ($multySchemeID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND schemeID IN ($multySchemeID)";
            $userfilter = $userfilter."Показать ID схемы: ".$multySchemeID."<br/>";
        }
        else {
            $filterquery = $filterquery."schemeID IN ($multySchemeID)";
            $andFlag=1;
            $userfilter = "Показать ID схемы: ".$multySchemeID."<br/>";
        }
    }

    if ($first_time_of_cooperation!=NULL && $last_time_of_cooperation!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND time_of_cooperation BETWEEN '$first_time_of_cooperation' AND '$last_time_of_cooperation'";
                $userfilter = $userfilter."Показать дату сотрудничества от: ".$first_time_of_cooperation." до ".$last_time_of_cooperation."<br/>";
            }
        else {
            $filterquery = $filterquery."time_of_cooperation BETWEEN '$first_time_of_cooperation' AND '$last_time_of_cooperation'";
            $andFlag=1;
            $userfilter = "Показать дату сотрудничества от: ".$first_time_of_cooperation." до ".$last_time_of_cooperation."<br/>";
        }
    }
    elseif ($first_time_of_cooperation!=NULL)
    {
        if ($andFlag==1)
            {
            $filterquery = $filterquery." AND time_of_cooperation >= '$first_time_of_cooperation'";
            $userfilter = $userfilter."Показать дату сотрудничества от: ".$first_time_of_cooperation."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."time_of_cooperation >= '$first_time_of_cooperation'";
            $userfilter = "Показать дату сотрудничества от: ".$first_time_of_cooperation."<br/>";
        }
    }
    elseif ($last_time_of_cooperation!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND time_of_cooperation <= '$last_time_of_cooperation'";
                $userfilter = $userfilter."Показать дату сотрудничества до: ".$last_time_of_cooperation."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."time_of_cooperation <= '$last_time_of_cooperation'";
            $userfilter = "Показать дату сотрудничества до: ".$last_time_of_cooperation."<br/>";
        }
        
    }

    if ($multy_time_of_cooperation!=NULL)
    {
        $arr = explode(", ", $multy_time_of_cooperation);
        for ($i=0; $i<count($arr); $i++)
        {
            $date = date_create($arr[$i]);
            $time_of_cooperation = date_format($date, 'Y-m-d');
            $arr[$i] = "'".$time_of_cooperation."'";
        }
        $multy_time_of_cooperation = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND time_of_cooperation IN ($multy_time_of_cooperation)";
            $userfilter = $userfilter."Показать дату сотрудничества: ".$multy_time_of_cooperation."<br/>";
        }
        else {
            $filterquery = $filterquery."time_of_cooperation IN ($multy_time_of_cooperation)";
            $andFlag=1;
            $userfilter = "Показать дату сотрудничества: ".$multy_time_of_cooperation."<br/>";
        }
    }

    if ($telephone!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND telephone LIKE '%".$telephone."%'";
            $userfilter = $userfilter."Показать телефоны: ".$telephone."<br/>";
        }
        else {
            $filterquery = $filterquery."telephone LIKE '%".$telephone."%'";
            $andFlag=1;
            $userfilter = "Показать телефоны: ".$telephone."<br/>";
        }
    }

    if ($first_number_of_orders!=NULL && $last_number_of_orders!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND number_of_orders BETWEEN $first_number_of_orders AND $last_number_of_orders";
                $userfilter = $userfilter."Показать количество заказов от: ".$first_number_of_orders." до ".$last_number_of_orders."<br/>";
            }
        else {
            $filterquery = $filterquery."number_of_orders BETWEEN $first_number_of_orders AND $last_number_of_orders";
            $andFlag=1;
            $userfilter = "Показать количество заказов от: ".$first_number_of_orders." до ".$last_number_of_orders."<br/>";
        }
    }
    elseif ($first_number_of_orders!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND number_of_orders >= $first_number_of_orders";
                $userfilter = $userfilter."Показать количество заказов от: ".$first_number_of_orders."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."number_of_orders >= $first_number_of_orders";
            $userfilter = "Показать количество заказов от: ".$first_number_of_orders."<br/>";
        }
    }
    elseif ($last_number_of_orders!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND number_of_orders <= $last_number_of_orders";
                $userfilter = $userfilter."Показать количество заказов до: ".$last_number_of_orders."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."number_of_orders <= $last_number_of_orders";
            $userfilter = "Показать количество заказов до: ".$last_number_of_orders."<br/>";
        }
        
    }

    if ($multy_number_of_orders!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND number_of_orders IN ($multy_number_of_orders)";
            $userfilter = $userfilter."Показать количество заказов: ".$multy_number_of_orders."<br/>";
        }
        else {
            $filterquery = $filterquery."number_of_orders IN ($multy_number_of_orders)";
            $andFlag=1;
            $userfilter = "Показать количество заказов: ".$multy_number_of_orders."<br/>";
        }
    }

    if ($email!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND email LIKE '%".$email."%'";
            $userfilter = $userfilter."Показать почты: ".$email."<br/>";
        }
        else {
            $filterquery = $filterquery."email LIKE '%".$email."%'";
            $andFlag=1;
            $userfilter = "Показать почты: ".$email."<br/>";
        }
    }

    if ($adress!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND adress LIKE '%".$adress."%'";
            $userfilter = $userfilter."Показать адреса: ".$adress."<br/>";
        }
        else {
            $filterquery = $filterquery."adress LIKE '%".$adress."%'";
            $andFlag=1;
            $userfilter = "Показать адреса: ".$adress."<br/>";
        }
    }
}
?>

<html>
<head>
<title>Клиентура</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>

<script src="sortTable.js"></script>

<a href="logout.php" class="btn btn-primary wid7 lin">Выйти</a>
<a href="admin.php" class="btn btn-primary wid7 lin">Главная</a>
<a href="clientele.php" class="btn btn-primary wid7 lin">Обновить</a>

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

<h1 class="text">Таблица клиентов</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>Id</th><th>Наименование</th><th>ID модели</th><th>ID схемы</th><th>Дата сотрудничества</th><th>Телефон</th><th>Колличество заказов</th><th>Почта</th><th>Адрес</th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM clientele");

        if ($filterquery!="SELECT * FROM clientele WHERE ")
            $result = $mysqli->query($filterquery);

        if ($userfilter != "")
            echo $userfilter;

        foreach ($result as $row){
            $date = date_create($row['time_of_cooperation']);
            $time_of_cooperation = date_format($date, 'd.m.Y');
            echo "<tr><td>{$row['clienteleID']}</td><td>{$row['title']}</td><td>{$row['modelID']}</td><td>{$row['schemeID']}</td><td>{$time_of_cooperation }</td><td>{$row['telephone']}</td><td>{$row['number_of_orders']}</td><td>{$row['email']}</td><td>{$row['adress']}</td><td><a class='btn btn-outline-danger' href='delete.php?ID=".$row['clienteleID']."&table=clientele'>Удалить</a></td></tr>";
        }
    ?>
<tbody>
</table>

<form name="form" action="" method="POST">

<input class="wid10" type="text" name="title" id="title" placeholder="Наименование">
<input class="wid8" type="text" name="modelID" id="modelID" placeholder="ID модели">
<input class="wid8" type="text" name="schemeID" id="schemeID" placeholder="ID схемы">

<span>Вместе с: </span><input type="date" name="time_of_cooperation" id="time_of_cooperation" placeholder="Дата сотрудничества">

<input class="wid8" type="text" name="telephone" id="telephone" placeholder="Телефон">
<input class="wid8" type="text" name="number_of_orders" id="number_of_orders" placeholder="Заказов">
<input class="wid8" type="text" name="email" id="email" placeholder="Почта">
<input class="wid10" type="text" name="adress" id="adress" placeholder="Адрес">

<input class="btn btn-primary" type="submit" name="add" value="Добавить клиента">

</form>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="ID" id="ID" placeholder="ID клиента">
<input class="wid10" type="text" name="title" id="title" placeholder="Наименование">
<input class="wid8" type="text" name="modelID" id="modelID" placeholder="ID модели">
<input class="wid8" type="text" name="schemeID" id="schemeID" placeholder="ID схемы">

<span>Вместе с: </span><input type="date" name="time_of_cooperation" id="time_of_cooperation" placeholder="Дата сотрудничества">

<input class="wid8" type="text" name="telephone" id="telephone" placeholder="Телефон">
<input class="wid8" type="text" name="number_of_orders" id="number_of_orders" placeholder="Заказов">
<input class="wid8" type="text" name="email" id="email" placeholder="Почта">
<input class="wid10" type="text" name="adress" id="adress" placeholder="Адрес">

<input class="btn btn-primary" type="submit" name="update" value="Изменить клиента">

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
    <span class="input-group-text" id="basic-addon2">Показать определенные наименования:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="title" placeholder="Любые символы наименования">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать ID модели от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="firstModelID" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="lastModelID" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные ID модели:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multyModelID" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать ID схемы от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="firstSchemeID" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="lastSchemeID" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные ID схемы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multySchemeID" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать дату сотрудничества от:</span>
    <input type="date" class="form-control input_height" aria-describedby="basic-addon2" name="first_time_of_cooperation">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="date" class="form-control input_height" aria-describedby="basic-addon2" name="last_time_of_cooperation">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные даты сотрудничества:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_time_of_cooperation" placeholder="01.01.01, 12.12.12, ...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные номера телефонов:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="telephone" placeholder="Любые символы номера">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать количество заказов от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="first_number_of_orders" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="last_number_of_orders" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные количества заказов:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_number_of_orders" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные почты:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="email" placeholder="Любые символы почты">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные адреса:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="adress" placeholder="Любые символы адреса">
</div>

<input class="btn btn-primary" type="submit" name="filter" value="Применить фильтры">

</form>


</body>
</html>