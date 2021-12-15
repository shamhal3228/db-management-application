<?php
session_start();

if ($_SESSION['user_group']!="Склад-менеджер" && $_SESSION['user_group']!="Менеджер-менеджер")
{
    header("HTTP/1.0 404 Not Found");
    die();
}

global $filterquery, $userfilter;
$filterquery = "SELECT * FROM store WHERE ";
$userfilter = "";

if (isset($_POST['add'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $material_type = mysqli_real_escape_string($connection, $_POST['material_type']);
    $material_amount = mysqli_real_escape_string($connection, $_POST['material_amount']);
    $place = mysqli_real_escape_string($connection, $_POST['place']);
    $expiration_date = mysqli_real_escape_string($connection, $_POST['expiration_date']);
    $cost = mysqli_real_escape_string($connection, $_POST['cost']);

    $query = "INSERT INTO `store` (material_type, material_amount, place, expiration_date, cost) VALUES ('$material_type', '$material_amount', '$place', '$expiration_date', $cost)";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
}

if (isset($_POST['update'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $materialID = mysqli_real_escape_string($connection, $_POST['materialID']);
    
    $material_type = mysqli_real_escape_string($connection, $_POST['material_type']);
    if ($material_type!=NULL)
    {
        $query = "UPDATE `store` SET material_type='$material_type' WHERE materialID=$materialID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $material_amount = mysqli_real_escape_string($connection, $_POST['material_amount']);
    if ($material_amount!=NULL)
    {
        $query = "UPDATE `store` SET material_amount='$material_amount' WHERE materialID=$materialID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $place = mysqli_real_escape_string($connection, $_POST['place']);
    if ($place!=NULL)
    {
        $query = "UPDATE `store` SET place='$place' WHERE materialID=$materialID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $expiration_date = mysqli_real_escape_string($connection, $_POST['expiration_date']);
    if ($expiration_date!=NULL)
    {
        $query = "UPDATE `store` SET expiration_date='$expiration_date' WHERE materialID=$materialID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $cost = mysqli_real_escape_string($connection, $_POST['cost']);
    if ($cost!=NULL)
    {
        $query = "UPDATE `store` SET cost='$cost' WHERE materialID=$materialID";
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

    $material_type = mysqli_real_escape_string($connection, $_POST['material_type']);

    $firstMaterial_amount = mysqli_real_escape_string($connection, $_POST['firstMaterial_amount']);
    $lastMaterial_amount = mysqli_real_escape_string($connection, $_POST['lastMaterial_amount']);
    $multyMaterial_amount = mysqli_real_escape_string($connection, $_POST['multyMaterial_amount']);

    $place = mysqli_real_escape_string($connection, $_POST['place']);

    $first_expiration_date = mysqli_real_escape_string($connection, $_POST['first_expiration_date']);
    $last_expiration_date = mysqli_real_escape_string($connection, $_POST['last_expiration_date']);
    $multy_expiration_date = mysqli_real_escape_string($connection, $_POST['multy_expiration_date']);

    $firstСost = mysqli_real_escape_string($connection, $_POST['firstСost']);
    $lastСost = mysqli_real_escape_string($connection, $_POST['lastСost']);
    $multyСost = mysqli_real_escape_string($connection, $_POST['multyСost']);

    $andFlag=0;

    if ($firstID!=NULL && $lastID!=NULL)
        {
            $filterquery = $filterquery."materialID BETWEEN $firstID AND $lastID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID." до ".$lastID."<br/>";
        }
    elseif ($firstID!=NULL)
        {
            $filterquery = $filterquery."materialID >= $firstID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID."<br/>";
        }
    elseif ($lastID!=NULL)
        {
            $filterquery = $filterquery."materialID <= $lastID";
            $andFlag=1;
            $userfilter = "Показать ID до ".$lastID."<br/>";
        }

    if ($multyID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND materialID IN ($multyID)";
            $userfilter = $userfilter."Показать ID: ".$multyID."<br/>";
        }
        else {
            $filterquery = $filterquery."materialID IN ($multyID)";
            $andFlag=1;
            $userfilter = "Показать ID: ".$multyID."<br/>";
        }
    }

    if ($material_type!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND material_type LIKE '%".$material_type."%'";
            $userfilter = $userfilter."Показать тип материала: ".$material_type."<br/>";
        }
        else {
            $filterquery = $filterquery."material_type LIKE '%$material_type%'";
            $andFlag=1;
            $userfilter = "Показать тип материала: ".$material_type."<br/>";
        }
    }

    if ($firstMaterial_amount!=NULL && $lastMaterial_amount!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND material_amount BETWEEN $firstMaterial_amount AND $lastMaterial_amount";
                $userfilter = $userfilter."Показать количество материала от: ".$firstMaterial_amount." до ".$lastMaterial_amount."<br/>";
            }
        else {
            $filterquery = $filterquery."material_amount BETWEEN $firstMaterial_amount AND $lastMaterial_amount";
            $andFlag=1;
            $userfilter = "Показать количество материала от: ".$firstMaterial_amount." до ".$lastMaterial_amount."<br/>";
        }
    }
    elseif ($firstMaterial_amount!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND material_amount >= $firstMaterial_amount";
                $userfilter = $userfilter."Показать количество материала от: ".$firstMaterial_amount."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."material_amount >= $firstMaterial_amount";
            $userfilter = "Показать количество материала от: ".$firstMaterial_amount."<br/>";
        }
    }
    elseif ($lastMaterial_amount!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND material_amount <= $lastMaterial_amount";
                $userfilter = $userfilter."Показать количество материала до: ".$lastMaterial_amount."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."material_amount <= $lastMaterial_amount";
            $userfilter = "Показать количество материала до: ".$lastMaterial_amount."<br/>";
        }
        
    }

    if ($multyMaterial_amount!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND material_amount IN ($multyMaterial_amount)";
            $userfilter = $userfilter."Показать количество материала: ".$multyMaterial_amount."<br/>";
        }
        else {
            $filterquery = $filterquery."material_amount IN ($multyMaterial_amount)";
            $andFlag=1;
            $userfilter = "Показать количество материала: ".$multyMaterial_amount."<br/>";
        }
    }

    if ($place!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND place LIKE '%".$place."%'";
            $userfilter = $userfilter."Показать места: ".$place."<br/>";
        }
        else {
            $filterquery = $filterquery."place LIKE '%$place%'";
            $andFlag=1;
            $userfilter = "Показать места: ".$place."<br/>";
        }
    }

    if ($first_expiration_date!=NULL && $last_expiration_date!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND expiration_date BETWEEN '$first_expiration_date' AND '$last_expiration_date'";
                $userfilter = $userfilter."Показать сроки хранения от: ".$first_expiration_date." до ".$last_expiration_date."<br/>";
            }
        else {
            $filterquery = $filterquery."expiration_date BETWEEN '$first_expiration_date' AND '$last_expiration_date'";
            $andFlag=1;
            $userfilter = "Показать сроки хранения от: ".$first_expiration_date." до ".$last_expiration_date."<br/>";
        }
    }
    elseif ($first_expiration_date!=NULL)
    {
        if ($andFlag==1)
            {
            $filterquery = $filterquery." AND expiration_date >= '$first_expiration_date'";
            $userfilter = $userfilter."Показать сроки хранения от: ".$first_expiration_date."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."expiration_date >= '$first_expiration_date'";
            $userfilter = "Показать сроки хранения от: ".$first_expiration_date."<br/>";
        }
    }
    elseif ($last_expiration_date!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND expiration_date <= '$last_expiration_date'";
                $userfilter = $userfilter."Показать сроки хранения до: ".$last_expiration_date."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."expiration_date <= '$last_expiration_date'";
            $userfilter = "Показать сроки хранения до: ".$last_expiration_date."<br/>";
        }
        
    }

    if ($multy_expiration_date!=NULL)
    {
        $arr = explode(", ", $multy_expiration_date);
        for ($i=0; $i<count($arr); $i++)
        {
            $date = date_create($arr[$i]);
            $expiration_date = date_format($date, 'Y-m-d');
            $arr[$i] = "'".$expiration_date."'";
        }
        $multy_expiration_date = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND expiration_date IN ($multy_expiration_date)";
            $userfilter = $userfilter."Показать сроки хранения: ".$multy_expiration_date."<br/>";
        }
        else {
            $filterquery = $filterquery."expiration_date IN ($multy_expiration_date)";
            $andFlag=1;
            $userfilter = "Показать сроки хранения: ".$multy_expiration_date."<br/>";
        }
    }

    if ($firstСost!=NULL && $lastСost!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND cost BETWEEN $firstСost AND $lastСost";
                $userfilter = $userfilter."Показать стоимость от: ".$firstСost." до ".$lastСost."<br/>";
            }
        else {
            $filterquery = $filterquery."cost BETWEEN $firstСost AND $lastСost";
            $andFlag=1;
            $userfilter = "Показать стоимость от: ".$firstСost." до ".$lastСost."<br/>";
        }
    }
    elseif ($firstСost!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND cost >= $firstСost";
                $userfilter = $userfilter."Показать стоимость от: ".$firstСost."<br/>";
            }
        else{
            $andFlag=1;
            $filterquery = $filterquery."cost >= $firstСost";
            $userfilter = "Показать стоимость от: ".$firstСost."<br/>";
        }
    }
    elseif ($lastСost!=NULL)
    {
        if ($andFlag==1)
            {
                $filterquery = $filterquery." AND cost <= $lastСost";
                $userfilter = $userfilter."Показать стоимость до: ".$lastСost."<br/>";
            }
        else {
            $andFlag=1;
            $filterquery = $filterquery."cost <= $lastСost";
            $userfilter = "Показать стоимость до: ".$lastСost."<br/>";
        }
        
    }

    if ($multyСost!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND cost IN ($multyСost)";
            $userfilter = $userfilter."Показать стоимость: ".$multyСost."<br/>";
        }
        else {
            $filterquery = $filterquery."cost IN ($multyСost)";
            $andFlag=1;
            $userfilter = $userfilter."Показать стоимость: ".$multyСost."<br/>";
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
<?php
if ($_SESSION['user_group'] == 'Склад-менеджер')
    echo '<a href="store-man.php" class="btn btn-primary wid7 lin">Главная</a>';
else echo '<a href="admin.php" class="btn btn-primary wid7 lin">Главная</a>';
?>
<a href="store.php" class="btn btn-primary wid7 lin">Обновить</a>

<h1 class="text">Таблица склада</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>ID</th><th>Тип материала</th><th>Количество материала</th><th>Место</th><th>Срок годности</th><th>Стоимость</th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM store");

        if ($filterquery!="SELECT * FROM store WHERE ")
            $result = $mysqli->query($filterquery);

        if ($userfilter != "")
            echo $userfilter;

        foreach ($result as $row){
            $date = date_create($row['expiration_date']);
            $expiration_date = date_format($date, 'd.m.Y');
            echo "<tr><td>{$row['materialID']}</td><td>{$row['material_type']}</td><td>{$row['material_amount']}</td><td>{$row['place']}</td><td>{$expiration_date}</td><td>{$row['cost']}</td><td><a class='btn btn-outline-danger' href='delete.php?ID=".$row['materialID']."&table=store'>Удалить</a></td></tr>";
        }
    ?>
</tbody>
</table>

<form name="form" action="" method="POST">

<input type="text" name="material_type" id="material_type" placeholder="Тип материала">
<input class="wid8" type="text" name="material_amount" id="material_amount" placeholder="Количество">
<input type="text" name="place" id="place" placeholder="Место">
<span>Дата аренды: </span><input type="date" name="expiration_date" id="expiration_date" placeholder="Время аренды">
<input class="wid8" type="text" name="cost" id="cost" placeholder="Стоимость">

<input class="btn btn-primary" type="submit" name="add" value="Добавить материал">

</form>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="materialID" id="materialID" placeholder="ID материала">
<input type="text" name="material_type" id="material_type" placeholder="Тип материала">
<input class="wid8" type="text" name="material_amount" id="material_amount" placeholder="Количество">
<input type="text" name="place" id="place" placeholder="Место">
<span>Дата аренды: </span><input type="date" name="expiration_date" id="expiration_date" placeholder="Время аренды">
<input class="wid8" type="text" name="cost" id="cost" placeholder="Стоимость">

<input class="btn btn-primary" type="submit" name="update" value="Изменить определенный материал">

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
    <span class="input-group-text" id="basic-addon2">Показать определенные материалы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="material_type" placeholder="Любые символы материала">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать количество от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="firstMaterial_amount" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="lastMaterial_amount" placeholder="10">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенное количество:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multyMaterial_amount" placeholder="1,2,3,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные адреса:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="place" placeholder="Любые символы адреса">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать срок годности от:</span>
    <input type="date" class="form-control input_height" aria-describedby="basic-addon2" name="first_expiration_date">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="date" class="form-control input_height" aria-describedby="basic-addon2" name="last_expiration_date">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные сроки годности:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multy_expiration_date" placeholder="01.01.01, 12.12.12, ...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать стоимость от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="firstСost" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="lastСost" placeholder="1000000">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные стоимости:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multyСost" placeholder="100, 2000, 30000">
</div>

<input class="btn btn-primary" type="submit" name="filter" value="Применить фильтры">

</form>

</body>
</html>