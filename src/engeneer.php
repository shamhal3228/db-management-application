<?php
session_start();

if ($_SESSION['user_group']!="Менеджер-менеджер" && $_SESSION['user_group']!="HR-менеджер")
{
    header("HTTP/1.0 404 Not Found");
    die();
}

if (isset($_POST['addEn']))
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $engeneerID = mysqli_real_escape_string($connection, $_POST['engeneerID']);
    $activity = mysqli_real_escape_string($connection, $_POST['activity']);

    $fetching_employeeID = mysqli_query($connection, "SELECT `employeeID` FROM `employee` WHERE `employeeID` = '$engeneerID'");
    $employeeID = mysqli_fetch_array($fetching_employeeID);

    if (empty($employeeID['employeeID']))
    {
        echo "Нет такого сотрудника";
        return;
    }
    else
    {
        $fetching_engeneerID = mysqli_query($connection, "SELECT `employeeID` FROM `worker` WHERE `employeeID` = '$engeneerID'");
        $user_group = mysqli_fetch_array($fetching_engeneerID);
        if (!empty($user_group['employeeID']))
        {
            echo "Данный сотрудник- рабочий";
            return;
        }
        else{
            $query = "INSERT INTO `engeneer` VALUES ('$engeneerID', '$activity')";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        }
    }
}

if (isset($_POST['updateEn'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $ID = mysqli_real_escape_string($connection, $_POST['ID']);
    
    $activity = mysqli_real_escape_string($connection, $_POST['activity']);
    if ($activity!=NULL)
    {
        $query = "UPDATE `engeneer` SET activity='$activity' WHERE employeeID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
}

global $filterquery, $userfilter;
$filterquery = "SELECT * FROM engeneer WHERE ";
$userfilter = "";

if (isset($_POST['filter'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $firstID = mysqli_real_escape_string($connection, $_POST['firstID']);
    $lastID = mysqli_real_escape_string($connection, $_POST['lastID']);
    $multyID = mysqli_real_escape_string($connection, $_POST['multyID']);
    $activity = mysqli_real_escape_string($connection, $_POST['activity']);

    $andFlag=0;

    if ($firstID!=NULL && $lastID!=NULL)
        {
            $filterquery = $filterquery."employeeID BETWEEN $firstID AND $lastID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID." до ".$lastID."<br/>";
        }
    elseif ($firstID!=NULL)
        {
            $filterquery = $filterquery."employeeID >= $firstID";
            $andFlag=1;
            $userfilter = "Показать ID от: ".$firstID."<br/>";
        }
    elseif ($lastID!=NULL)
        {
            $filterquery = $filterquery."employeeID <= $lastID";
            $andFlag=1;
            $userfilter = "Показать ID до ".$lastID."<br/>";
        }

    if ($multyID!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND employeeID IN ($multyID)";
            $userfilter = $userfilter."Показать ID: ".$multyID."<br/>";
        }
        else {
            $filterquery = $filterquery."employeeID IN ($multyID)";
            $andFlag=1;
            $userfilter = "Показать ID: ".$multyID."<br/>";
        }
    }

    if ($activity!=NULL)
    {
        $arr = explode(", ", $activity);
        for ($i=0; $i<count($arr); $i++)
        {
            $arr[$i] = "'".$arr[$i]."'";
        }
        $activity = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND activity IN ($activity)";
            $userfilter = $userfilter."Показать определенные состояния инженеров: ".$form."<br/>";
        }
        else {
            $filterquery = $filterquery."activity IN ($activity)";
            $andFlag=1;
            $userfilter = "Показать определенные состояния инженеров: ".$form."<br/>";
        }
    }
}
?>

<html>
<head>
<title>Инженеры</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>

<script src="sortTable.js"></script>

<a href="logout.php" class="btn btn-primary wid7 lin">Выйти</a>
<?php
if ($_SESSION['user_group'] == 'HR-менеджер')
    echo '<a href="hr.php" class="btn btn-primary wid7 lin">Главная</a>';
else echo '<a href="admin.php" class="btn btn-primary wid7 lin">Главная</a>';
?>
<a href="engeneer.php" class="btn btn-primary wid7 lin">Обновить</a>

<h1 class="text">Таблица всех сотрудников</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>Id</th><th>ФИО</th><th>ЗП</th><th>ЗП (с учетом налогов)</th><th>Трудоустройство</th><th>Смена</th><th>Опыт работы, месяцы</th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM employee");
        
        foreach ($result as $row){
            echo "<tr><td>{$row['employeeID']}</td><td>{$row['FIO']}</td><td>{$row['salary']}</td><td>{$row['salaryNDFL']}</td><td>{$row['form_of_employment']}</td><td>{$row['shift']}</td><td>{$row['experience']}</td></tr>";
        }
    ?>
</tbody>
</table>

<h1 class="text">Таблица всех инженеров</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>Id</th><th>ФИО</th><th>Работает ли в компании</th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM engeneer");

        if ($filterquery!="SELECT * FROM engeneer WHERE ")
            $result = $mysqli->query($filterquery);

            if ($userfilter != "")
            echo $userfilter;

        foreach ($result as $row){
            $employeeFIO = $row['employeeID'];
            $result2 = $mysqli->query("SELECT FIO FROM employee WHERE employeeID=$employeeFIO");
            foreach ($result2 as $row2){
                echo "<tr><td>{$row['employeeID']}</td><td>{$row2['FIO']}</td><td>{$row['activity']}</td><td><a class='btn btn-outline-danger' href='delete.php?ID=".$row['employeeID']."&table=engeneer'>Удалить</a></td></tr>";
            }
        }
    ?>
</tbody>
</table>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="engeneerID" id="engeneerID" placeholder="ID инженера">

<select name="activity" id="activity" class="form-select wid10 lin">
    <option value="Работает">Работает</option>
    <option value="Не работает">Не работает</option>
</select>

<input class="btn btn-primary" type="submit" name="addEn" value="Добавить инженера">

</form>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="ID" id="ID" placeholder="ID рабочего">

<select name="activity" id="activity" class="form-select wid10 lin">
    <option value="Работает">Работает</option>
    <option value="Не работает">Не работает</option>
</select>

<input class="btn btn-primary" type="submit" name="updateEn" value="Изменить определенного инженера">

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
    <span class="input-group-text" id="basic-addon2">Показать определенные состояния:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="activity" placeholder="Работает, Не работает,...">
</div>

<input class="btn btn-primary" type="submit" name="filter" value="Применить фильтры">

</form>

</body>
</html>