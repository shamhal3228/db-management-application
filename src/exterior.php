<?php
session_start();

if ($_SESSION['user_group']!="Менеджер-менеджер")
{
    header("HTTP/1.0 404 Not Found");
    die();
}

global $filterquery, $userfilter;
$filterquery = "SELECT * FROM exterior WHERE ";
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
    $height = mysqli_real_escape_string($connection, $_POST['height']);
    $width = mysqli_real_escape_string($connection, $_POST['width']);
    $number_of_floors = mysqli_real_escape_string($connection, $_POST['number_of_floors']);
    $heating = mysqli_real_escape_string($connection, $_POST['heating']);
    $fire_resistance = mysqli_real_escape_string($connection, $_POST['fire_resistance']);
    $longlevity = mysqli_real_escape_string($connection, $_POST['longlevity']);

    $query = "INSERT INTO `exterior` (authorID, price, type, height, width, number_of_floors, heating, fire_resistance, longlevity) VALUES ('$authorID', '$price', '$type', '$height', '$width', '$number_of_floors', '$heating', '$fire_resistance', '$longlevity')";
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
        $query = "UPDATE `exterior` SET authorID='$authorID' WHERE modelID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $price = mysqli_real_escape_string($connection, $_POST['price']);
    if ($price!=NULL)
    {
        $query = "UPDATE `exterior` SET price='$price' WHERE modelID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    if ($type!=NULL)
    {
        $query = "UPDATE `exterior` SET type='$type' WHERE modelID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $height = mysqli_real_escape_string($connection, $_POST['height']);
    if ($height!=NULL)
    {
        $query = "UPDATE `exterior` SET height='$height' WHERE modelID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $width = mysqli_real_escape_string($connection, $_POST['width']);
    if ($width!=NULL)
    {
        $query = "UPDATE `exterior` SET width='$width' WHERE modelID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $number_of_floors = mysqli_real_escape_string($connection, $_POST['number_of_floors']);
    if ($number_of_floors!=NULL)
    {
        $query = "UPDATE `exterior` SET number_of_floors='$number_of_floors' WHERE modelID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $heating = mysqli_real_escape_string($connection, $_POST['heating']);
    if ($heating!=NULL)
    {
        $query = "UPDATE `exterior` SET heating='$heating' WHERE modelID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $fire_resistance = mysqli_real_escape_string($connection, $_POST['fire_resistance']);
    if ($fire_resistance!=NULL)
    {
        $query = "UPDATE `exterior` SET fire_resistance='$fire_resistance' WHERE modelID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $longlevity = mysqli_real_escape_string($connection, $_POST['longlevity']);
    if ($longlevity!=NULL)
    {
        $query = "UPDATE `exterior` SET longlevity='$longlevity' WHERE modelID=$ID";
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

    $first_height = mysqli_real_escape_string($connection, $_POST['first_height']);
    $last_height = mysqli_real_escape_string($connection, $_POST['last_height']);
    $multy_height = mysqli_real_escape_string($connection, $_POST['multy_height']);

    $first_width = mysqli_real_escape_string($connection, $_POST['first_width']);
    $last_width = mysqli_real_escape_string($connection, $_POST['last_width']);
    $multy_width = mysqli_real_escape_string($connection, $_POST['multy_width']);

    $first_number_of_floors = mysqli_real_escape_string($connection, $_POST['first_number_of_floors']);
    $last_number_of_floors = mysqli_real_escape_string($connection, $_POST['last_number_of_floors']);
    $multy_number_of_floors = mysqli_real_escape_string($connection, $_POST['multy_number_of_floors']);

    $heating = mysqli_real_escape_string($connection, $_POST['heating']);
    $fire_resistance = mysqli_real_escape_string($connection, $_POST['fire_resistance']);

    $first_longlevity = mysqli_real_escape_string($connection, $_POST['first_longlevity']);
    $last_longlevity = mysqli_real_escape_string($connection, $_POST['last_longlevity']);
    $multy_longlevity = mysqli_real_escape_string($connection, $_POST['multy_longlevity']);

    $andFlag=0;

    if ($firstID!=NULL && $lastID!=NULL)
        {
            $filterquery = $filterquery."modelID BETWEEN $firstID AND $lastID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID." до ".$lastID."<br/>";
        }
    elseif ($firstID!=NULL)
        {
            $filterquery = $filterquery."modelID >= $firstID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID."<br/>";
        }
    elseif ($lastID!=NULL)
        {
            $filterquery = $filterquery."modelID <= $lastID";
            $andFlag=1;
            $userfilter = "Показать ID до ".$lastID."<br/>";
        }

    if ($multyID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND modelID IN ($multyID)";
            $userfilter = $userfilter."Показать ID: ".$multyID."<br/>";
        }
        else {
            $filterquery = $filterquery."modelID IN ($multyID)";
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

    if ($first_height!=NULL && $last_height!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND height BETWEEN $first_height AND $last_height";
                $userfilter = $userfilter."Показать высоту от: ".$first_height." до ".$last_height."<br/>";
            }
        else {
            $filterquery = $filterquery."height BETWEEN $first_height AND $last_height";
            $andFlag=1;
            $userfilter = "Показать высоту от: ".$first_height." до ".$last_height."<br/>";
        }
    }
    elseif ($first_height!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND height >= $first_height";
                $userfilter = $userfilter."Показать высоту от: ".$first_height."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."height >= $first_height";
            $userfilter = "Показать высоту от: ".$first_height."<br/>";
        }
    }
    elseif ($last_height!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND height <= $last_height";
                $userfilter = $userfilter."Показать высоту до: ".$last_height."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."height <= $last_height";
            $userfilter = "Показать высоту до: ".$last_height."<br/>";
        }
        
    }

    if ($multy_height!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND height IN ($multy_height)";
            $userfilter = $userfilter."Показать высоту: ".$multy_height."<br/>";
        }
        else {
            $filterquery = $filterquery."height IN ($multy_height)";
            $andFlag=1;
            $userfilter = "Показать высоту: ".$multy_height."<br/>";
        }
    }

    if ($first_width!=NULL && $last_width!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND width BETWEEN $first_width AND $last_width";
                $userfilter = $userfilter."Показать ширину от: ".$first_width." до ".$last_width."<br/>";
            }
        else {
            $filterquery = $filterquery."width BETWEEN $first_width AND $last_width";
            $andFlag=1;
            $userfilter = "Показать ширину от: ".$first_width." до ".$last_width."<br/>";
        }
    }
    elseif ($first_width!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND width >= $first_width";
                $userfilter = $userfilter."Показать ширину от: ".$first_width."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."width >= $first_width";
            $userfilter = "Показать ширину от: ".$first_width."<br/>";
        }
    }
    elseif ($last_width!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND width <= $last_width";
                $userfilter = $userfilter."Показать ширину до: ".$last_width."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."width <= $last_width";
            $userfilter = "Показать ширину до: ".$last_width."<br/>";
        }
        
    }

    if ($multy_width!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND width IN ($multy_width)";
            $userfilter = $userfilter."Показать ширину: ".$multy_width."<br/>";
        }
        else {
            $filterquery = $filterquery."width IN ($multy_width)";
            $andFlag=1;
            $userfilter = "Показать ширину: ".$multy_width."<br/>";
        }
    }

    if ($first_number_of_floors!=NULL && $last_number_of_floors!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND number_of_floors BETWEEN $first_number_of_floors AND $last_number_of_floors";
                $userfilter = $userfilter."Показать этажи от: ".$first_number_of_floors." до ".$last_number_of_floors."<br/>";
            }
        else {
            $filterquery = $filterquery."number_of_floors BETWEEN $first_number_of_floors AND $last_number_of_floors";
            $andFlag=1;
            $userfilter = "Показать этажи от: ".$first_number_of_floors." до ".$last_number_of_floors."<br/>";
        }
    }
    elseif ($first_number_of_floors!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND number_of_floors >= $first_number_of_floors";
                $userfilter = $userfilter."Показать этажи от: ".$first_number_of_floors."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."number_of_floors >= $first_number_of_floors";
            $userfilter = "Показать этажи от: ".$first_number_of_floors."<br/>";
        }
    }
    elseif ($last_number_of_floors!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND number_of_floors <= $last_number_of_floors";
                $userfilter = $userfilter."Показать этажи до: ".$last_number_of_floors."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."number_of_floors <= $last_number_of_floors";
            $userfilter = "Показать этажи до: ".$last_number_of_floors."<br/>";
        }
        
    }

    if ($multy_number_of_floors!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND number_of_floors IN ($multy_number_of_floors)";
            $userfilter = $userfilter."Показать этажи: ".$multy_number_of_floors."<br/>";
        }
        else {
            $filterquery = $filterquery."number_of_floors IN ($multy_number_of_floors)";
            $andFlag=1;
            $userfilter = "Показать этажи: ".$multy_number_of_floors."<br/>";
        }
    }

    if ($heating!=NULL)
    {
        $arr = explode(", ", $heating);
        for ($i=0; $i<count($arr); $i++)
        {
            $arr[$i] = "'".$arr[$i]."'";
        }
        $heating = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND heating IN ($heating)";
            $userfilter = $userfilter."Показать типы: ".$heating."<br/>";
        }
        else {
            $filterquery = $filterquery."heating IN ($heating)";
            $andFlag=1;
            $userfilter = "Показать типы: ".$heating."<br/>";
        }
    }

    if ($fire_resistance!=NULL)
    {
        $arr = explode(", ", $fire_resistance);
        for ($i=0; $i<count($arr); $i++)
        {
            $arr[$i] = "'".$arr[$i]."'";
        }
        $fire_resistance = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND fire_resistance IN ($fire_resistance)";
            $userfilter = $userfilter."Показать типы: ".$fire_resistance."<br/>";
        }
        else {
            $filterquery = $filterquery."fire_resistance IN ($fire_resistance)";
            $andFlag=1;
            $userfilter = "Показать типы: ".$fire_resistance."<br/>";
        }
    }

    if ($first_longlevity!=NULL && $last_longlevity!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND longlevity BETWEEN $first_longlevity AND $last_longlevity";
                $userfilter = $userfilter."Показать долговечность от: ".$first_longlevity." до ".$last_longlevity."<br/>";
            }
        else {
            $filterquery = $filterquery."longlevity BETWEEN $first_longlevity AND $last_longlevity";
            $andFlag=1;
            $userfilter = "Показать долговечность от: ".$first_longlevity." до ".$last_longlevity."<br/>";
        }
    }
    elseif ($first_longlevity!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND longlevity >= $first_longlevity";
                $userfilter = $userfilter."Показать долговечность от: ".$first_longlevity."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."longlevity >= $first_longlevity";
            $userfilter = "Показать долговечность от: ".$first_longlevity."<br/>";
        }
    }
    elseif ($last_longlevity!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND longlevity <= $last_longlevity";
                $userfilter = $userfilter."Показать долговечность до: ".$last_longlevity."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."longlevity <= $last_longlevity";
            $userfilter = "Показать долговечность до: ".$last_longlevity."<br/>";
        }
        
    }

    if ($multy_longlevity!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND number_of_floors IN ($multy_longlevity)";
            $userfilter = $userfilter."Показать долговечность: ".$multy_longlevity."<br/>";
        }
        else {
            $filterquery = $filterquery."number_of_floors IN ($multy_longlevity)";
            $andFlag=1;
            $userfilter = "Показать долговечность: ".$multy_longlevity."<br/>";
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
<a href="exterior.php" class="btn btn-primary wid7 lin">Обновить</a>

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


<h1 class="text">Таблица характеристик экстерьеров</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>Id</th><th>ФИО автора</th><th>Цена</th><th>Тип</th><th>Высота, м</th><th>Ширина, м</th><th>Количсетво этажей</th><th>Отопление</th><th>Огнеупорность</th><th>Долговечность, года</th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM exterior");

        if ($filterquery!="SELECT * FROM exterior WHERE ")
            $result = $mysqli->query($filterquery);

        if ($userfilter != "")
        echo $userfilter;

        foreach ($result as $row){
            $author = $row['authorID'];
            $result2 = $mysqli->query("SELECT FIO FROM employee WHERE employeeID=$author");
            if ($result2!= NULL)
            foreach ($result2 as $row2){
                echo "<tr><td>{$row['modelID']}</td><td>{$row2['FIO']}</td><td>{$row['price']}</td><td>{$row['type']}</td><td>{$row['height']}</td><td>{$row['width']}</td><td>{$row['number_of_floors']}</td><td>{$row['heating']}</td><td>{$row['fire_resistance']}</td><td>{$row['longlevity']}</td><td><a class='btn btn-outline-danger' href='delete.php?ID=".$row['modelID']."&table=exterior'>Удалить</a></td></tr>";
            }
            else echo "<tr><td>{$row['modelID']}</td><td></td><td>{$row['price']}</td><td>{$row['type']}</td><td>{$row['height']}</td><td>{$row['width']}</td><td>{$row['number_of_floors']}</td><td>{$row['heating']}</td><td>{$row['fire_resistance']}</td><td>{$row['longlevity']}</td><td><a class='btn btn-outline-danger' href='delete.php?ID=".$row['modelID']."&table=exterior'>Удалить</a></td></tr>";
        }
    ?>
</tbody>
</table>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="authorID" id="authorID" placeholder="ID автора">
<input class="wid8" type="text" name="price" id="price" placeholder="Стоимость">
<input class="wid8" type="text" name="type" id="type" placeholder="Тип">
<input class="wid8" type="text" name="height" id="height" placeholder="Высота">
<input class="wid8" type="text" name="width" id="width" placeholder="Ширина">
<input class="wid8" type="text" name="number_of_floors" id="number_of_floors" placeholder="Этажи">

<select name="heating" id="heating" class="form-select wid8 lin">
    <option value="Есть">Есть</option>
    <option value="Нет">Нет</option>
</select>

<select name="fire_resistance" id="fire_resistance" class="form-select wid8 lin">
    <option value="К0">К0</option>
    <option value="К1">К1</option>
    <option value="К2">К2</option>
    <option value="К3">К3</option>
    <option value="К4">К4</option>
</select>

<input class="wid10" type="text" name="longlevity" id="longlevity" placeholder="Долговечность">

<input class="btn btn-primary" type="submit" name="add" value="Добавить интерьер">

</form>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="ID" id="ID" placeholder="ID интерьера">
<input class="wid8" type="text" name="authorID" id="authorID" placeholder="ID автора">
<input class="wid8" type="text" name="price" id="price" placeholder="Стоимость">
<input class="wid8" type="text" name="type" id="type" placeholder="Тип">
<input class="wid8" type="text" name="height" id="height" placeholder="Высота">
<input class="wid8" type="text" name="width" id="width" placeholder="Ширина">
<input class="wid8" type="text" name="number_of_floors" id="number_of_floors" placeholder="Этажи">

<select name="heating" id="heating" class="form-select wid8 lin">
    <option value="Есть">Есть</option>
    <option value="Нет">Нет</option>
</select>

<select name="fire_resistance" id="fire_resistance" class="form-select wid8 lin">
    <option value="К0">К0</option>
    <option value="К1">К1</option>
    <option value="К2">К2</option>
    <option value="К3">К3</option>
    <option value="К4">К4</option>
</select>

<input class="wid10" type="text" name="longlevity" id="longlevity" placeholder="Долговечность">

<input class="btn btn-primary" type="submit" name="update" value="Изменить интерьер">

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
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_price" placeholder="100, 2000, 30000">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные типы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="type" placeholder="Торговый центр, Больница,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать высоту от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="first_height" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="last_height" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные высоты:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_height" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать ширину от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="first_width" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="last_width" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные значения ширины:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_width" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать количество этажей от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="first_number_of_floors" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="last_number_of_floors" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные количества этажей:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_number_of_floors" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные типы отопления:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="heating" placeholder="Есть, Нет,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные типы огнеупорности:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="fire_resistance" placeholder="К0, К1,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать долговечность от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="first_longlevity" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="last_longlevity" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные долговечности:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_longlevity" placeholder="1,2,3,...">
</div>

<input class="btn btn-primary" type="submit" name="filter" value="Применить фильтры">

</form>

</body>
</html>