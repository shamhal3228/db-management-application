<?php
session_start();

if ($_SESSION['user_group']!="Менеджер-менеджер")
{
    header("HTTP/1.0 404 Not Found");
    die();
}

global $filterquery, $userfilter;
$filterquery = "SELECT * FROM current_project WHERE ";
$userfilter = "";

if (isset($_POST['add'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $tenderID = mysqli_real_escape_string($connection, $_POST['tenderID']);
    $schemeID = mysqli_real_escape_string($connection, $_POST['schemeID']);
    $modelID = mysqli_real_escape_string($connection, $_POST['modelID']);
    $cost = mysqli_real_escape_string($connection, $_POST['cost']);
    $duration = mysqli_real_escape_string($connection, $_POST['duration']);
    $materialID = mysqli_real_escape_string($connection, $_POST['materialID']);
    $vehicalID = mysqli_real_escape_string($connection, $_POST['vehicalID']);

    $query = "INSERT INTO `current_project` (tenderID, schemeID, modelID, cost, duration, materialID, vehicalID) VALUES ('$tenderID', '$schemeID', '$modelID', '$cost', '$duration', '$materialID', '$vehicalID')";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
}

if (isset($_POST['update'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $projectID = mysqli_real_escape_string($connection, $_POST['projectID']);

    $tenderID = mysqli_real_escape_string($connection, $_POST['tenderID']);
    if ($tenderID!=NULL)
    {
        $query = "UPDATE `current_project` SET tenderID='$tenderID' WHERE projectID=$projectID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $schemeID = mysqli_real_escape_string($connection, $_POST['schemeID']);
    if ($schemeID!=NULL)
    {
        $query = "UPDATE `current_project` SET schemeID='$schemeID' WHERE projectID=$projectID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $modelID = mysqli_real_escape_string($connection, $_POST['modelID']);
    if ($modelID!=NULL)
    {
        $query = "UPDATE `current_project` SET modelID='$modelID' WHERE projectID=$projectID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $cost = mysqli_real_escape_string($connection, $_POST['cost']);
    if ($cost!=NULL)
    {
        $query = "UPDATE `current_project` SET cost='$cost' WHERE projectID=$projectID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $duration = mysqli_real_escape_string($connection, $_POST['duration']);
    if ($duration!=NULL)
    {
        $query = "UPDATE `current_project` SET duration='$duration' WHERE projectID=$projectID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $materialID = mysqli_real_escape_string($connection, $_POST['materialID']);
    if ($materialID!=NULL)
    {
        $query = "UPDATE `current_project` SET materialID='$materialID' WHERE projectID=$projectID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $vehicalID = mysqli_real_escape_string($connection, $_POST['vehicalID']);
    if ($vehicalID!=NULL)
    {
        $query = "UPDATE `current_project` SET vehicalID='$vehicalID' WHERE projectID=$projectID";
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

    $first_tenderID = mysqli_real_escape_string($connection, $_POST['first_tenderID']);
    $last_tenderID = mysqli_real_escape_string($connection, $_POST['last_tenderID']);
    $multy_tenderID = mysqli_real_escape_string($connection, $_POST['multy_tenderID']);

    $first_schemeID = mysqli_real_escape_string($connection, $_POST['first_schemeID']);
    $last_schemeID = mysqli_real_escape_string($connection, $_POST['last_schemeID']);
    $multy_schemeID = mysqli_real_escape_string($connection, $_POST['multy_schemeID']);

    $first_modelID = mysqli_real_escape_string($connection, $_POST['first_modelID']);
    $last_modelID = mysqli_real_escape_string($connection, $_POST['last_modelID']);
    $multy_modelID = mysqli_real_escape_string($connection, $_POST['multy_modelID']);

    $first_cost = mysqli_real_escape_string($connection, $_POST['first_cost']);
    $last_cost = mysqli_real_escape_string($connection, $_POST['last_cost']);
    $multy_cost = mysqli_real_escape_string($connection, $_POST['multy_cost']);

    $first_duration = mysqli_real_escape_string($connection, $_POST['first_duration']);
    $last_duration = mysqli_real_escape_string($connection, $_POST['last_duration']);
    $multy_duration = mysqli_real_escape_string($connection, $_POST['multy_duration']);

    $material_type = mysqli_real_escape_string($connection, $_POST['material_type']);

    $vehical_serial_number = mysqli_real_escape_string($connection, $_POST['vehical_serial_number']);

    $andFlag=0;

    if ($firstID!=NULL && $lastID!=NULL)
        {
            $filterquery = $filterquery."projectID BETWEEN $firstID AND $lastID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID." до ".$lastID."<br/>";
        }
    elseif ($firstID!=NULL)
        {
            $filterquery = $filterquery."projectID >= $firstID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID."<br/>";
        }
    elseif ($lastID!=NULL)
        {
            $filterquery = $filterquery."projectID <= $lastID";
            $andFlag=1;
            $userfilter = "Показать ID до ".$lastID."<br/>";
        }

    if ($multyID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND projectID IN ($multyID)";
            $userfilter = $userfilter."Показать ID: ".$multyID."<br/>";
        }
        else {
            $filterquery = $filterquery."projectID IN ($multyID)";
            $andFlag=1;
            $userfilter = "Показать ID: ".$multyID."<br/>";
        }
    }

    if ($first_tenderID!=NULL && $last_tenderID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND tenderID BETWEEN $first_tenderID AND $last_tenderID";
                $userfilter = $userfilter."Показать ID тендера от: ".$first_tenderID." до ".$last_tenderID."<br/>";
            }
        else {
            $filterquery = $filterquery."tenderID BETWEEN $first_tenderID AND $last_tenderID";
            $andFlag=1;
            $userfilter = "Показать ID тендера от: ".$first_tenderID." до ".$last_tenderID."<br/>";
        }
    }
    elseif ($first_tenderID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND tenderID >= $first_tenderID";
                $userfilter = $userfilter."Показать ID тендера от: ".$first_tenderID."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."tenderID >= $first_tenderID";
            $userfilter = "Показать ID тендера от: ".$first_tenderID."<br/>";
        }
    }
    elseif ($last_tenderID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND tenderID <= $last_tenderID";
                $userfilter = $userfilter."Показать ID тендера до: ".$last_tenderID."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."tenderID <= $last_tenderID";
            $userfilter = "Показать ID тендера до: ".$last_tenderID."<br/>";
        }
        
    }

    if ($multy_tenderID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND tenderID IN ($multy_tenderID)";
            $userfilter = $userfilter."Показать ID тендера: ".$multy_tenderID."<br/>";
        }
        else {
            $filterquery = $filterquery."tenderID IN ($multy_tenderID)";
            $andFlag=1;
            $userfilter = "Показать ID тендера: ".$multy_tenderID."<br/>";
        }
    }

    if ($first_schemeID!=NULL && $last_schemeID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND schemeID BETWEEN $first_schemeID AND $last_schemeID";
                $userfilter = $userfilter."Показать ID схемы от: ".$first_schemeID." до ".$last_schemeID."<br/>";
            }
        else {
            $filterquery = $filterquery."schemeID BETWEEN $first_schemeID AND $last_schemeID";
            $andFlag=1;
            $userfilter = "Показать ID схемы от: ".$first_schemeID." до ".$last_schemeID."<br/>";
        }
    }
    elseif ($first_schemeID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND schemeID >= $first_schemeID";
                $userfilter = $userfilter."Показать ID схемы от: ".$first_schemeID."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."schemeID >= $first_schemeID";
            $userfilter = "Показать ID схемы от: ".$first_schemeID."<br/>";
        }
    }
    elseif ($last_schemeID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND schemeID <= $last_schemeID";
                $userfilter = $userfilter."Показать ID схемы до: ".$last_schemeID."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."schemeID <= $last_schemeID";
            $userfilter = "Показать ID схемы до: ".$last_schemeID."<br/>";
        }
        
    }

    if ($multy_schemeID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND schemeID IN ($multy_schemeID)";
            $userfilter = $userfilter."Показать ID схемы: ".$multy_schemeID."<br/>";
        }
        else {
            $filterquery = $filterquery."schemeID IN ($multy_schemeID)";
            $andFlag=1;
            $userfilter = "Показать ID схемы: ".$multy_schemeID."<br/>";
        }
    }

    if ($first_modelID!=NULL && $last_modelID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND modelID BETWEEN $first_modelID AND $last_modelID";
                $userfilter = $userfilter."Показать ID схемы от: ".$first_modelID." до ".$last_modelID."<br/>";
            }
        else {
            $filterquery = $filterquery."modelID BETWEEN $first_modelID AND $last_modelID";
            $andFlag=1;
            $userfilter = "Показать ID схемы от: ".$first_modelID." до ".$last_modelID."<br/>";
        }
    }
    elseif ($first_modelID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND modelID >= $first_modelID";
                $userfilter = $userfilter."Показать ID схемы от: ".$first_modelID."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."modelID >= $first_modelID";
            $userfilter = "Показать ID схемы от: ".$first_modelID."<br/>";
        }
    }
    elseif ($last_modelID!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND modelID <= $last_modelID";
                $userfilter = $userfilter."Показать ID схемы до: ".$last_modelID."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."modelID <= $last_modelID";
            $userfilter = "Показать ID схемы до: ".$last_modelID."<br/>";
        }
        
    }

    if ($multy_modelID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND modelID IN ($multy_modelID)";
            $userfilter = $userfilter."Показать ID схемы: ".$multy_modelID."<br/>";
        }
        else {
            $filterquery = $filterquery."modelID IN ($multy_modelID)";
            $andFlag=1;
            $userfilter = "Показать ID схемы: ".$multy_modelID."<br/>";
        }
    }

    if ($first_cost!=NULL && $last_cost!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND cost BETWEEN $first_cost AND $last_cost";
                $userfilter = $userfilter."Показать стоимость от: ".$first_cost." до ".$last_cost."<br/>";
            }
        else {
            $filterquery = $filterquery."cost BETWEEN $first_cost AND $last_cost";
            $andFlag=1;
            $userfilter = "Показать стоимость от: ".$first_cost." до ".$last_cost."<br/>";
        }
    }
    elseif ($first_cost!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND cost >= $first_cost";
                $userfilter = $userfilter."Показать стоимость от: ".$first_cost."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."cost >= $first_cost";
            $userfilter = "Показать стоимость от: ".$first_cost."<br/>";
        }
    }
    elseif ($last_cost!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND cost <= $last_cost";
                $userfilter = $userfilter."Показать стоимость до: ".$last_cost."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."cost <= $last_cost";
            $userfilter = "Показать стоимость до: ".$last_cost."<br/>";
        }
        
    }

    if ($multy_cost!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND cost IN ($multy_cost)";
            $userfilter = $userfilter."Показать стоимость: ".$multy_cost."<br/>";
        }
        else {
            $filterquery = $filterquery."cost IN ($multy_cost)";
            $andFlag=1;
            $userfilter = "Показать стоимость: ".$multy_cost."<br/>";
        }
    }

    if ($first_duration!=NULL && $last_duration!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND duration BETWEEN '$first_duration' AND '$last_duration'";
                $userfilter = $userfilter."Показать даты работ от: ".$first_duration." до ".$last_duration."<br/>";
            }
        else {
            $filterquery = $filterquery."duration BETWEEN '$first_duration' AND '$last_duration'";
            $andFlag=1;
            $userfilter = "Показать даты работ от: ".$first_duration." до ".$last_duration."<br/>";
        }
    }
    elseif ($first_duration!=NULL)
    {
        if ($andFlag==1)
            {
            $filterquery = $filterquery." AND duration >= '$first_duration'";
            $userfilter = $userfilter."Показать даты работ от: ".$first_duration."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."duration >= '$first_duration'";
            $userfilter = "Показать даты работ от: ".$first_duration."<br/>";
        }
    }
    elseif ($last_duration!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND duration <= '$last_duration'";
                $userfilter = $userfilter."Показать даты работ до: ".$last_duration."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."duration <= '$last_duration'";
            $userfilter = "Показать даты работ до: ".$last_duration."<br/>";
        }
        
    }

    if ($multy_duration!=NULL)
    {
        $arr = explode(", ", $multy_duration);
        for ($i=0; $i<count($arr); $i++)
        {
            $date = date_create($arr[$i]);
            $duration = date_format($date, 'Y-m-d');
            $arr[$i] = "'".$duration."'";
        }
        $multy_duration = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND duration IN ($multy_duration)";
            $userfilter = $userfilter."Показать даты работ: ".$multy_duration."<br/>";
        }
        else {
            $filterquery = $filterquery."duration IN ($multy_duration)";
            $andFlag=1;
            $userfilter = "Показать даты работ: ".$multy_duration."<br/>";
        }
    }

    if ($material_type!=NULL)
    {
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $temp = "SELECT * FROM store WHERE material_type LIKE '%$material_type%'";
        $temp_result = $mysqli->query($temp);
        $temp = "";
        foreach ($temp_result as $row){
            $temp=$temp.$row['materialID'].",";
        }
        $temp = substr($temp,0,-1);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND materialID IN (".$temp.")";
            $userfilter = $userfilter."Показать материалы: ".$material_type."<br/>";
        }
        else {
            $filterquery = $filterquery."materialID IN (".$temp.")";
            $andFlag=1;
            $userfilter = "Показать материалы: ".$material_type."<br/>";
        }
    }

    if ($vehical_serial_number!=NULL)
    {
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $temp = "SELECT * FROM vehicles WHERE vehical_serial_number LIKE '%$vehical_serial_number%'";
        $temp_result = $mysqli->query($temp);
        $temp = "";
        foreach ($temp_result as $row){
            $temp=$temp.$row['vehicalID'].",";
        }
        $temp = substr($temp,0,-1);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND vehicalID IN (".$temp.")";
            $userfilter = $userfilter."Показать материалы: ".$vehical_serial_number."<br/>";
        }
        else {
            $filterquery = $filterquery."vehicalID IN (".$temp.")";
            $andFlag=1;
            $userfilter = "Показать материалы: ".$vehical_serial_number."<br/>";
        }
    }
}
?>

<html>
<head>
<title>Текущий проект</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>

<script src="sortTable.js"></script>

<a href="logout.php" class="btn btn-primary wid7 lin">Выйти</a>
<a href="admin.php" class="btn btn-primary wid7 lin">Главная</a>
<a href="current_project.php" class="btn btn-primary wid7 lin">Обновить</a>

<h1 class="text">Таблица техники</h1>

<table class="table table-striped table_sort">
<thead><tr><th>ID техники</th><th>Название модели</th><th>Дата аренды</th><th>Количество</th><th>Время работы, месяцы</th><th>Стоимость аренды</th></tr></thead>
<tbody>
        <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM vehicles");
        foreach ($result as $row){
            $date = date_create($row['arend_time']);
            $arend_time = date_format($date, 'd.m.Y');
            echo "<tr><td>{$row['vehicalID']}</td><td>{$row['vehical_serial_number']}</td><td>{$arend_time}</td><td>{$row['quanity']}</td><td>{$row['operating_time']}</td><td>{$row['rent_price']}</td></tr>";
        }
    ?>
</tbody>
</table>

<h1 class="text">Таблица склада</h1>

<table class="table table-striped table_sort">
<thead><tr><th>ID материала</th><th>Название материала</th><th>Количество материала</th><th>Место нахождения</th><th>Срок хранения</th><th>Стоимость</th></tr></thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM store");
        foreach ($result as $row){
            echo "<tr><td>{$row['materialID']}</td><td>{$row['material_type']}</td><td>{$row['material_amount']}</td><td>{$row['place']}</td><td>{$row['expiration_date']}</td><td>{$row['cost']}</td></tr>";
        }
    ?>
<tbody>
</table>

<h1 class="text">Таблица тендеров</h1>

<table class="table table-striped table_sort">
<thead><tr><th>ID тендера</th><th>Стоимость</th><th>Статус</th><th>Важность</th><th>Тип</th><th>Место строительства</th><th>Потенциальный доход</th></tr></thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM tenders");
        foreach ($result as $row){
            echo "<tr><td>{$row['tenderID']}</td><td>{$row['price']}</td><td>{$row['status']}</td><td>{$row['importance']}</td><td>{$row['type']}</td><td>{$row['place_of_building']}</td><td>{$row['potential_profit']}</td></tr>";
        }
    ?>
</tbody>
</table>

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

<h1 class="text">Таблица текущего проекта</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>Id</th><th>Id тендера</th><th>ID схемы</th><th>ID модели</th><th>Стоимость</th><th>До какого числа</th><th>Материал</th><th>Техника</th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM current_project");

        if ($filterquery!="SELECT * FROM current_project WHERE ")
            $result = $mysqli->query($filterquery);

        if ($userfilter != "")
            echo $userfilter;

        foreach ($result as $row){
            $date = date_create($row['duration']);
            $duration = date_format($date, 'd.m.Y');

            $material = $row['materialID'];
            $result2 = $mysqli->query("SELECT material_type FROM store WHERE materialID=$material");

            $vehicle = $row['vehicalID'];
            $result3 = $mysqli->query("SELECT vehical_serial_number FROM vehicles WHERE vehicalID=$vehicle");

            foreach ($result2 as $row2){
                foreach ($result3 as $row3){
                    echo "<tr><td>{$row['projectID']}</td><td>{$row['tenderID']}</td><td>{$row['schemeID']}</td><td>{$row['modelID']}</td><td>{$row['cost']}</td><td>{$duration}</td><td>{$row2['material_type']}</td><td>{$row3['vehical_serial_number']}</td><td><a class='btn btn-outline-danger' href='delete.php?ID=".$row['projectID']."&table=current_project'>Удалить</a></td></tr>";
                }
            }
        }
    ?>
<tbody>
</table>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="tenderID" id="tenderID" placeholder="ID тендера">
<input class="wid8" type="text" name="schemeID" id="schemeID" placeholder="ID схемы">
<input class="wid8" type="text" name="modelID" id="modelID" placeholder="ID модели">
<input class="wid8" type="text" name="cost" id="cost" placeholder="Стоимость">

<span>Вместе до: </span><input type="date" name="duration" id="duration" placeholder="Вместе до">

<input class="wid8" type="text" name="materialID" id="materialID" placeholder="ID материала">
<input class="wid8" type="text" name="vehicalID" id="vehicalID" placeholder="ID техники">

<input class="btn btn-primary" type="submit" name="add" value="Добавить проект">

</form>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="projectID" id="projectID" placeholder="ID">
<input class="wid8" type="text" name="tenderID" id="tenderID" placeholder="ID тендера">
<input class="wid8" type="text" name="schemeID" id="schemeID" placeholder="ID схемы">
<input class="wid8" type="text" name="modelID" id="modelID" placeholder="ID модели">
<input class="wid8" type="text" name="cost" id="cost" placeholder="Стоимость">

<span>Вместе до: </span><input type="date" name="duration" id="duration" placeholder="Вместе до">

<input class="wid8" type="text" name="materialID" id="materialID" placeholder="ID материала">
<input class="wid8" type="text" name="vehicalID" id="vehicalID" placeholder="ID техники">

<input class="btn btn-primary" type="submit" name="update" value="Изменить проект">

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
    <span class="input-group-text" id="basic-addon2">Показать ID тендера от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="first_tenderID" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="last_tenderID" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные ID тендера:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_tenderID" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать ID схемы от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="first_schemeID" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="last_schemeID" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные ID схемы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_schemeID" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать ID модели от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="first_modelID" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="last_modelID" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные ID модели:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_modelID" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать стоимости от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="first_cost" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="last_cost" placeholder="1000000">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные стоимости:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_cost" placeholder="100, 2000, 30000">>
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать дату работ от:</span>
    <input type="date" class="form-control input_height" aria-describedby="basic-addon2" name="first_duration">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="date" class="form-control input_height" aria-describedby="basic-addon2" name="last_duration">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные даты работы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_duration" placeholder="01.01.01, 12.12.12, ...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные материалы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="material_type" placeholder="Любые символы материалов">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные техники:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="vehical_serial_number" placeholder="Любые символы техники">
</div>

<input class="btn btn-primary" type="submit" name="filter" value="Применить фильтры">

</form>


</body>
</html>