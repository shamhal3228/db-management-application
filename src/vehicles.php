<?php
session_start();

if ($_SESSION['user_group']!="Склад-менеджер" && $_SESSION['user_group']!="Менеджер-менеджер")
{
    header("HTTP/1.0 404 Not Found");
    die();
}

global $filterquery, $userfilter;
$filterquery = "SELECT * FROM vehicles WHERE ";
$userfilter = "";

if (isset($_POST['add'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $vehical_serial_number = mysqli_real_escape_string($connection, $_POST['vehical_serial_number']);
    $arend_time = mysqli_real_escape_string($connection, $_POST['arend_time']);
    $quanity = mysqli_real_escape_string($connection, $_POST['quanity']);
    $operating_time = mysqli_real_escape_string($connection, $_POST['operating_time']);
    $rent_price = mysqli_real_escape_string($connection, $_POST['rent_price']);

    $query = "INSERT INTO `vehicles` (vehical_serial_number, arend_time, quanity, operating_time, rent_price) VALUES ('$vehical_serial_number', '$arend_time', '$quanity', '$operating_time', $rent_price)";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
}

if (isset($_POST['update'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $vehicalID = mysqli_real_escape_string($connection, $_POST['vehicalID']);
    
    $vehical_serial_number = mysqli_real_escape_string($connection, $_POST['vehical_serial_number']);
    if ($vehical_serial_number!=NULL)
    {
        $query = "UPDATE `vehicles` SET vehical_serial_number='$vehical_serial_number' WHERE vehicalID=$vehicalID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $arend_time = mysqli_real_escape_string($connection, $_POST['arend_time']);
    if ($arend_time!=NULL)
    {
        $query = "UPDATE `vehicles` SET arend_time='$arend_time' WHERE vehicalID=$vehicalID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $quanity = mysqli_real_escape_string($connection, $_POST['quanity']);
    if ($quanity!=NULL)
    {
        $query = "UPDATE `vehicles` SET quanity='$quanity' WHERE vehicalID=$vehicalID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $operating_time = mysqli_real_escape_string($connection, $_POST['operating_time']);
    if ($operating_time!=NULL)
    {
        $query = "UPDATE `vehicles` SET operating_time='$operating_time' WHERE vehicalID=$vehicalID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $rent_price = mysqli_real_escape_string($connection, $_POST['rent_price']);
    if ($rent_price!=NULL)
    {
        $query = "UPDATE `vehicles` SET rent_price='$rent_price' WHERE vehicalID=$vehicalID";
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
    $vehical_serial_number = mysqli_real_escape_string($connection, $_POST['vehical_serial_number']);
    $first_arend_time = mysqli_real_escape_string($connection, $_POST['first_arend_time']);
    $last_arend_time = mysqli_real_escape_string($connection, $_POST['last_arend_time']);
    $multy_arend_time = mysqli_real_escape_string($connection, $_POST['multy_arend_time']);

    $firstQuanity = mysqli_real_escape_string($connection, $_POST['firstQuanity']);
    $lastQuanity = mysqli_real_escape_string($connection, $_POST['lastQuanity']);
    $multyQuanity = mysqli_real_escape_string($connection, $_POST['multyQuanity']);

    $firstOperating_time = mysqli_real_escape_string($connection, $_POST['firstOperating_time']);
    $lastOperating_time = mysqli_real_escape_string($connection, $_POST['lastOperating_time']);
    $multyOperating_time = mysqli_real_escape_string($connection, $_POST['multyOperating_time']);

    $firstRent_price = mysqli_real_escape_string($connection, $_POST['firstRent_price']);
    $lastRent_price = mysqli_real_escape_string($connection, $_POST['lastRent_price']);
    $multyRent_price = mysqli_real_escape_string($connection, $_POST['multyRent_price']);

    $andFlag=0;

    if ($firstID!=NULL && $lastID!=NULL)
        {
            $filterquery = $filterquery."vehicalID BETWEEN $firstID AND $lastID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID." до ".$lastID."<br/>";
        }
    elseif ($firstID!=NULL)
        {
            $filterquery = $filterquery."vehicalID >= $firstID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID."<br/>";
        }
    elseif ($lastID!=NULL)
        {
            $filterquery = $filterquery."vehicalID <= $lastID";
            $andFlag=1;
            $userfilter = "Показать ID до ".$lastID."<br/>";
        }

    if ($multyID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND vehicalID IN ($multyID)";
            $userfilter = $userfilter."Показать ID: ".$multyID."<br/>";
        }
        else {
            $filterquery = $filterquery."vehicalID IN ($multyID)";
            $andFlag=1;
            $userfilter = "Показать ID: ".$multyID."<br/>";
        }
    }

    if ($vehical_serial_number!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND vehical_serial_number LIKE '%".$vehical_serial_number."%'";
            $userfilter = $userfilter."Показать названия модели: ".$vehical_serial_number."<br/>";
        }
        else {
            $filterquery = $filterquery."vehical_serial_number LIKE '%$vehical_serial_number%'";
            $andFlag=1;
            $userfilter = "Показать названия модели: ".$vehical_serial_number."<br/>";
        }
    }

    if ($first_arend_time!=NULL && $last_arend_time!=NULL)
    {
        if ($andFlag==1){
            $filterquery = $filterquery." AND arend_time BETWEEN '$first_arend_time' AND '$last_arend_time'";
            $userfilter = $userfilter."Показать дату аренды от: ".$first_arend_time." до ".$last_arend_time."<br/>";
        }
        else {
            $filterquery = $filterquery."arend_time BETWEEN '$first_arend_time' AND '$last_arend_time'";
            $andFlag=1;
            $userfilter = "Показать дату аренды от: ".$first_arend_time." до ".$last_arend_time."<br/>";
        }
    }
    elseif ($first_arend_time!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND arend_time >= '$first_arend_time'";
                $userfilter = $userfilter."Показать дату аренды от: ".$first_arend_time."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."arend_time >= '$first_arend_time'";
            $userfilter = "Показать дату аренды от: ".$first_arend_time."<br/>";
        }
    }
    elseif ($last_arend_time!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND arend_time <= '$last_arend_time'";
                $userfilter = $userfilter."Показать дату аренды до ".$last_arend_time."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."arend_time <= '$last_arend_time'";
            $userfilter = "Показать дату аренды до ".$last_arend_time."<br/>";
        }
        
    }

    if ($multy_arend_time!=NULL)
    {
        $arr = explode(", ", $multy_arend_time);
        for ($i=0; $i<count($arr); $i++)
        {
            $date = date_create($arr[$i]);
            $arend_time = date_format($date, 'Y-m-d');
            $arr[$i] = "'".$arend_time."'";
        }
        $multy_arend_time = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND arend_time IN ($multy_arend_time)";
            $userfilter = $userfilter."Показать дату аренды: ".$multy_arend_time."<br/>";
        }
        else {
            $filterquery = $filterquery."arend_time IN ($multy_arend_time)";
            $andFlag=1;
            $userfilter = "Показать дату аренды: ".$multy_arend_time."<br/>";
        }
    }

    if ($firstQuanity!=NULL && $lastQuanity!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND quanity BETWEEN $firstQuanity AND $lastQuanity";
                $userfilter = $userfilter."Показать дату аренды от: ".$firstQuanity." до ".$lastQuanity."<br/>";
            }
        else {
            $filterquery = $filterquery."quanity BETWEEN $firstQuanity AND $lastQuanity";
            $andFlag=1;
            $userfilter = "Показать дату аренды от: ".$firstQuanity." до ".$lastQuanity."<br/>";
        }
    }
    elseif ($firstQuanity!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND quanity >= $firstQuanity";
                $userfilter = $userfilter."Показать дату аренды от: ".$firstQuanity."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."quanity >= $firstQuanity";
            $userfilter = "Показать дату аренды от: ".$firstQuanity."<br/>";
        }
    }
    elseif ($lastQuanity!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND quanity <= $lastQuanity";
                $userfilter = $userfilter."Показать дату аренды до ".$lastQuanity."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."quanity <= $lastQuanity";
            $userfilter = "Показать дату аренды до ".$lastQuanity."<br/>";
        }
        
    }

    if ($multyQuanity!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND quanity IN ($multyQuanity)";
            $userfilter = $userfilter."Показать дату аренды: ".$lastQuanity."<br/>";
        }
        else {
            $filterquery = $filterquery."quanity IN ($multyQuanity)";
            $andFlag=1;
            $userfilter = "Показать дату аренды: ".$lastQuanity."<br/>";
        }
    }

    if ($firstOperating_time!=NULL && $lastOperating_time!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND operating_time BETWEEN $firstOperating_time AND $lastOperating_time";
                $userfilter = $userfilter."Показать время работы от: ".$firstOperating_time." до ".$lastOperating_time."<br/>";
            }
        else {
            $filterquery = $filterquery."operating_time BETWEEN $firstOperating_time AND $lastOperating_time";
            $andFlag=1;
            $userfilter = "Показать время работы от: ".$firstOperating_time." до ".$lastOperating_time."<br/>";
        }
    }
    elseif ($firstOperating_time!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND operating_time >= $firstOperating_time";
                $userfilter = $userfilter."Показать время работы от: ".$firstOperating_time."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."operating_time >= $firstOperating_time";
            $userfilter = "Показать время работы от: ".$firstOperating_time."<br/>";
        }
    }
    elseif ($lastOperating_time!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND operating_time <= $lastOperating_time";
                $userfilter = $userfilter."Показать время работы до ".$lastOperating_time."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."operating_time <= $lastOperating_time";
            $userfilter = "Показать время работы до ".$lastOperating_time."<br/>";
        }
        
    }

    if ($multyOperating_time!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND operating_time IN ($multyOperating_time)";
            $userfilter = $userfilter."Показать время работы ".$multyOperating_time."<br/>";
        }
        else {
            $filterquery = $filterquery."operating_time IN ($multyOperating_time)";
            $andFlag=1;
            $userfilter = "Показать время работы ".$multyOperating_time."<br/>";
        }
    }

    if ($firstRent_price!=NULL && $lastRent_price!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND rent_price BETWEEN $firstRent_price AND $lastRent_price";
                $userfilter = $userfilter."Показать стоимость аренды от: ".$firstRent_price." до ".$lastRent_price."<br/>";
            }
        else {
            $filterquery = $filterquery."rent_price BETWEEN $firstRent_price AND $lastRent_price";
            $andFlag=1;
            $userfilter = "Показать стоимость аренды от: ".$firstRent_price." до ".$lastRent_price."<br/>";
        }
    }
    elseif ($firstRent_price!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND rent_price >= $firstRent_price";
                $userfilter = $userfilter."Показать стоимость аренды от: ".$firstRent_price."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."rent_price >= $firstRent_price";
            $userfilter = "Показать стоимость аренды от: ".$firstRent_price."<br/>";
        }
    }
    elseif ($lastRent_price!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND rent_price <= $lastRent_price";
                $userfilter = $userfilter."Показать стоимость аренды до: ".$lastRent_price."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."rent_price <= $lastRent_price";
            $userfilter = "Показать стоимость аренды до: ".$lastRent_price."<br/>";
        }
        
    }

    if ($multyRent_price!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND rent_price IN ($multyRent_price)";
            $userfilter = $userfilter."Показать стоимость аренды: ".$multyRent_price."<br/>";
        }
        else {
            $filterquery = $filterquery."rent_price IN ($multyRent_price)";
            $andFlag=1;
            $userfilter = "Показать стоимость аренды: ".$multyRent_price."<br/>";
        }
    }
}
?>

<html>
<head>
<title>Техника</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>

<script src="sortTable.js"></script>

<a href="logout.php" class="btn btn-primary wid7 lin">Выйти</a>
<?php
if ($_SESSION['user_group'] == 'Склад-менеджер')
    echo '<a href="store-man.php" class="btn btn-primary wid7 lin">Главная</a>';
else echo '<a href="admin.php" class="btn btn-primary wid7 lin">Главная</a>';
?>
<a href="vehicles.php" class="btn btn-primary wid7 lin">Обновить</a>

<h1 class="text">Таблица техники</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>ID</th><th>Название модели</th><th>Дата аренды</th><th>Количество</th><th>Время работы, месяцы</th><th>Стоимость аренды</th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM vehicles");

        if ($filterquery!="SELECT * FROM vehicles WHERE ")
            $result = $mysqli->query($filterquery);

        if ($userfilter != "")
            echo $userfilter;

        foreach ($result as $row){
            $date = date_create($row['arend_time']);
            $arend_time = date_format($date, 'd.m.Y');
            echo "<tr><td>{$row['vehicalID']}</td><td>{$row['vehical_serial_number']}</td><td>{$arend_time}</td><td>{$row['quanity']}</td><td>{$row['operating_time']}</td><td>{$row['rent_price']}</td><td><a class='btn btn-outline-danger' href='delete.php?ID=".$row['vehicalID']."&table=vehicles'>Удалить</a></td></tr>";
        }
    ?>
</tbody>
</table>

<form name="form" action="" method="POST">

<input type="text" name="vehical_serial_number" id="vehical_serial_number" placeholder="Название модели">
<span>Дата аренды: </span><input type="date" name="arend_time" id="arend_time" placeholder="Время аренды">
<input class="wid8" type="text" name="quanity" id="quanity" placeholder="Количество">
<input class="wid8" type="text" name="operating_time" id="operating_time" placeholder="Время работы">
<input type="text" name="rent_price" id="rent_price" placeholder="Стоимость аренды">

<input class="btn btn-primary" type="submit" name="add" value="Добавить технику">

</form>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="vehicalID" id="vehicalID" placeholder="ID техники">
<input type="text" name="vehical_serial_number" id="vehical_serial_number" placeholder="Название модели">
<span>Дата аренды: </span><input type="date" name="arend_time" id="arend_time" placeholder="Время аренды">
<input class="wid8" type="text" name="quanity" id="quanity" placeholder="Количество">
<input class="wid8" type="text" name="operating_time" id="operating_time" placeholder="Время работы">
<input type="text" name="rent_price" id="rent_price" placeholder="Стоимость аренды">

<input class="btn btn-primary" type="submit" name="update" value="Изменить определенную технику">

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
    <span class="input-group-text" id="basic-addon2">Показать техники определенной модели:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="vehical_serial_number" placeholder="Любые символы модели">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать время аренды от:</span>
    <input type="date" class="form-control input_height" aria-describedby="basic-addon2" name="first_arend_time">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="date" class="form-control input_height" aria-describedby="basic-addon2" name="last_arend_time">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные времена аренды:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_arend_time" placeholder="01.01.01, 12.12.12, ...">
</div>



<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать количество от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="firstQuanity" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="lastQuanity" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенное количество:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multyQuanity" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать время работы от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="firstOperating_time" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="lastOperating_time" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные времена работы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multyOperating_time" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать стоимость аренды от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="firstRent_price" placeholder="0">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="lastRent_price" placeholder="1000000">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные стоимости аренды:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multyRent_price" placeholder="100,2000,30000,...">
</div>

<input class="btn btn-primary" type="submit" name="filter" value="Применить фильтры">

</form>

</body>
</html>