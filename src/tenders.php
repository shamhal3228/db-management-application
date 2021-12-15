<?php
session_start();

if ($_SESSION['user_group']!="Менеджер-менеджер")
{
    header("HTTP/1.0 404 Not Found");
    die();
}

global $filterquery, $userfilter;
$filterquery = "SELECT * FROM tenders WHERE ";
$userfilter = "";

if (isset($_POST['add'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $price = mysqli_real_escape_string($connection, $_POST['price']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);
    $importance = mysqli_real_escape_string($connection, $_POST['importance']);
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    $place_of_building = mysqli_real_escape_string($connection, $_POST['place_of_building']);
    $potential_profit = mysqli_real_escape_string($connection, $_POST['potential_profit']);

    $query = "INSERT INTO `tenders` (price, status, importance, type, place_of_building, potential_profit) VALUES ('$price', '$status', '$importance', '$type', '$place_of_building', '$potential_profit')";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
}

if (isset($_POST['update'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $tenderID = mysqli_real_escape_string($connection, $_POST['tenderID']);
    
    $price = mysqli_real_escape_string($connection, $_POST['price']);
    if ($price!=NULL)
    {
        $query = "UPDATE `tenders` SET price='$price' WHERE tenderID=$tenderID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $status = mysqli_real_escape_string($connection, $_POST['status']);
    if ($status!=NULL)
    {
        $query = "UPDATE `tenders` SET status='$status' WHERE tenderID=$tenderID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $importance = mysqli_real_escape_string($connection, $_POST['importance']);
    if ($importance!=NULL)
    {
        $query = "UPDATE `tenders` SET importance='$importance' WHERE tenderID=$tenderID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    if ($type!=NULL)
    {
        $query = "UPDATE `tenders` SET type='$type' WHERE tenderID=$tenderID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $place_of_building = mysqli_real_escape_string($connection, $_POST['place_of_building']);
    if ($place_of_building!=NULL)
    {
        $query = "UPDATE `tenders` SET place_of_building='$place_of_building' WHERE tenderID=$tenderID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $potential_profit = mysqli_real_escape_string($connection, $_POST['potential_profit']);
    if ($potential_profit!=NULL)
    {
        $query = "UPDATE `tenders` SET potential_profit='$potential_profit' WHERE tenderID=$tenderID";
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

    $first_price = mysqli_real_escape_string($connection, $_POST['first_price']);
    $last_price = mysqli_real_escape_string($connection, $_POST['last_price']);
    $multy_price = mysqli_real_escape_string($connection, $_POST['multy_price']);

    $status = mysqli_real_escape_string($connection, $_POST['status']);
    $importance = mysqli_real_escape_string($connection, $_POST['importance']);
    $type = mysqli_real_escape_string($connection, $_POST['type']);
    $place_of_building = mysqli_real_escape_string($connection, $_POST['place_of_building']);

    $first_potential_profit = mysqli_real_escape_string($connection, $_POST['first_potential_profit']);
    $last_potential_profit = mysqli_real_escape_string($connection, $_POST['last_potential_profit']);
    $multy_potential_profit = mysqli_real_escape_string($connection, $_POST['multy_potential_profit']);

    $andFlag=0;

    if ($firstID!=NULL && $lastID!=NULL)
        {
            $filterquery = $filterquery."tenderID BETWEEN $firstID AND $lastID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID." до ".$lastID."<br/>";
        }
    elseif ($firstID!=NULL)
        {
            $filterquery = $filterquery."tenderID >= $firstID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID."<br/>";
        }
    elseif ($lastID!=NULL)
        {
            $filterquery = $filterquery."tenderID <= $lastID";
            $andFlag=1;
            $userfilter = "Показать ID до ".$lastID."<br/>";
        }

    if ($multyID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND tenderID IN ($multyID)";
            $userfilter = $userfilter."Показать ID: ".$multyID."<br/>";
        }
        else {
            $filterquery = $filterquery."tenderID IN ($multyID)";
            $andFlag=1;
            $userfilter = "Показать ID: ".$multyID."<br/>";
        }
    }

    if ($first_price!=NULL && $last_price!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND price BETWEEN $first_price AND $last_price";
                $userfilter = $userfilter."Показать стоимость от: ".$first_price." до ".$last_price."<br/>";
            }
        else {
            $filterquery = $filterquery."price BETWEEN $first_price AND $last_price";
            $andFlag=1;
            $userfilter = "Показать стоимость от: ".$first_price." до ".$last_price."<br/>";
        }
    }
    elseif ($first_price!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND price >= $first_price";
                $userfilter = $userfilter."Показать стоимость от: ".$first_price."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."price >= $first_price";
            $userfilter = "Показать стоимость от: ".$first_price."<br/>";
        }
    }
    elseif ($last_price!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND price <= $last_price";
                $userfilter = $userfilter."Показать стоимость до: ".$last_price."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."price <= $last_price";
            $userfilter = "Показать стоимость до: ".$last_price."<br/>";
        }
        
    }

    if ($multy_price!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND price IN ($multy_price)";
            $userfilter = $userfilter."Показать стоимость: ".$multy_price."<br/>";
        }
        else {
            $filterquery = $filterquery."price IN ($multy_price)";
            $andFlag=1;
            $userfilter = "Показать стоимость: ".$multy_price."<br/>";
        }
    }

    if ($status!=NULL)
    {
        $arr = explode(", ", $status);
        for ($i=0; $i<count($arr); $i++)
        {
            $arr[$i] = "'".$arr[$i]."'";
        }
        $status = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND status IN ($status)";
            $userfilter = $userfilter."Показать статус: ".$status."<br/>";
        }
        else {
            $filterquery = $filterquery."status IN ($status)";
            $andFlag=1;
            $userfilter = "Показать статус: ".$status."<br/>";
        }
    }

    if ($importance!=NULL)
    {
        $arr = explode(", ", $importance);
        for ($i=0; $i<count($arr); $i++)
        {
            $arr[$i] = "'".$arr[$i]."'";
        }
        $importance = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND importance IN ($importance)";
            $userfilter = $userfilter."Показать важность: ".$importance."<br/>";
        }
        else {
            $filterquery = $filterquery."importance IN ($importance)";
            $andFlag=1;
            $userfilter = "Показать важность: ".$importance."<br/>";
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
            $userfilter = $userfilter."Показать тип: ".$status."<br/>";
        }
        else {
            $filterquery = $filterquery."type IN ($type)";
            $andFlag=1;
            $userfilter = "Показать тип: ".$status."<br/>";
        }
    }

    if ($place_of_building!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND place_of_building LIKE '%".$place_of_building."%'";
            $userfilter = $userfilter."Показать место: ".$place_of_building."<br/>";
        }
        else {
            $filterquery = $filterquery."place_of_building LIKE '%$place_of_building%'";
            $andFlag=1;
            $userfilter = "Показать место: ".$place_of_building."<br/>";
        }
    }

    if ($first_potential_profit!=NULL && $last_potential_profit!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND potential_profit BETWEEN '$first_potential_profit' AND '$last_potential_profit'";
                $userfilter = $userfilter."Показать сроки хранения от: ".$first_potential_profit." до ".$last_potential_profit."<br/>";
            }
        else {
            $filterquery = $filterquery."potential_profit BETWEEN '$first_potential_profit' AND '$last_potential_profit'";
            $andFlag=1;
            $userfilter = "Показать сроки хранения от: ".$first_potential_profit." до ".$last_potential_profit."<br/>";
        }
    }
    elseif ($first_potential_profit!=NULL)
    {
        if ($andFlag==1)
            {
            $filterquery = $filterquery." AND potential_profit >= '$first_potential_profit'";
            $userfilter = $userfilter."Показать сроки хранения от: ".$first_potential_profit."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."potential_profit >= '$first_potential_profit'";
            $userfilter = "Показать сроки хранения от: ".$first_potential_profit."<br/>";
        }
    }
    elseif ($last_potential_profit!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND potential_profit <= '$last_potential_profit'";
                $userfilter = $userfilter."Показать сроки хранения до: ".$last_potential_profit."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."potential_profit <= '$last_potential_profit'";
            $userfilter = "Показать сроки хранения до: ".$last_potential_profit."<br/>";
        }
        
    }

    if ($multy_potential_profit!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND potential_profit IN ($multy_potential_profit)";
            $userfilter = $userfilter."Показать зарплату: ".$multy_potential_profit."<br/>";
        }
        else {
            $filterquery = $filterquery."potential_profit IN ($multy_potential_profit)";
            $andFlag=1;
            $userfilter = "Показать зарплату: ".$multy_potential_profit."<br/>";
        }
    }
}
?>

<html>
<head>
<title>Склад</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>

<script src="sortTable.js"></script>

<a href="logout.php" class="btn btn-primary wid7 lin">Выйти</a>
<a href="admin.php" class="btn btn-primary wid7 lin">Главная</a>
<a href="tenders.php" class="btn btn-primary wid7 lin">Обновить</a>

<h1 class="text">Таблица тендеров</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>ID</th><th>Стоимость</th><th>Статус</th><th>Важность</th><th>Тип</th><th>Место</th><th>Потенциальный доход</th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM tenders");

        if ($filterquery!="SELECT * FROM tenders WHERE ")
            $result = $mysqli->query($filterquery);

        if ($userfilter != "")
            echo $userfilter;

        foreach ($result as $row){
            echo "<tr><td>{$row['tenderID']}</td><td>{$row['price']}</td><td>{$row['status']}</td><td>{$row['importance']}</td><td>{$row['type']}</td><td>{$row['place_of_building']}</td><td>{$row['potential_profit']}</td><td><a class='btn btn-outline-danger' href='delete.php?ID=".$row['tenderID']."&table=tenders'>Удалить</a></td></tr>";
        }
    ?>
</tbody>
</table>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="price" id="price" placeholder="Стоимость">

<select name="status" id="status" class="form-select wid10 lin">
    <option value="Выиграны">Выиграны</option>
    <option value="В процессе">В процессе</option>
</select>

<input type="text" name="importance" id="importance" placeholder="Важность">
<input class="wid8" type="text" name="type" id="type" placeholder="Тип">
<input type="text" name="place_of_building" id="place_of_building" placeholder="Место">
<input type="text" name="potential_profit" id="potential_profit" placeholder="Потенциальный доход">

<input class="btn btn-primary" type="submit" name="add" value="Добавить тендер">

</form>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="tenderID" id="tenderID" placeholder="ID">
<input class="wid8" type="text" name="price" id="price" placeholder="Стоимость">

<select name="status" id="status" class="form-select wid10 lin">
    <option value="Выиграны">Выиграны</option>
    <option value="В процессе">В процессе</option>
</select>

<input type="text" name="importance" id="importance" placeholder="Важность">
<input class="wid8" type="text" name="type" id="type" placeholder="Тип">
<input type="text" name="place_of_building" id="place_of_building" placeholder="Место">
<input type="text" name="potential_profit" id="potential_profit" placeholder="Потенциальный доход">

<input class="btn btn-primary" type="submit" name="update" value="Изменить определенный тендер">

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
    <span class="input-group-text" id="basic-addon2">Показать стоимость от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="first_price" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="last_price" placeholder="1000000">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные стоимости:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_price" placeholder="100, 2000, 30000">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные статусы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="status" placeholder="В процессе, Выиграны, ...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные важности:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="importance" placeholder="Любые символы важности">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные типы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="type" placeholder="Торговый центр, Больница,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные места:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="place_of_building" placeholder="Любые символы места">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать потенциальный доход от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="first_potential_profit" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="last_potential_profit" placeholder="1000000"> 
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные потенциальные доходы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_potential_profit" placeholder="100, 2000, 30000">
</div>

<input class="btn btn-primary" type="submit" name="filter" value="Применить фильтры">

</form>

</body>
</html>