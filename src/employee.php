<?php
session_start();

if ($_SESSION['user_group']!="Менеджер-менеджер" && $_SESSION['user_group']!="HR-менеджер")
{
    header("HTTP/1.0 404 Not Found");
    die();
}

global $filterquery, $userfilter;
$filterquery = "SELECT * FROM employee WHERE ";
$userfilter = "";

if (isset($_POST['addE'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $FIO = mysqli_real_escape_string($connection, $_POST['FIO']);
    $salary = mysqli_real_escape_string($connection, $_POST['salary']);
    $form_of_employment = mysqli_real_escape_string($connection, $_POST['form_of_employment']);
    $shift = mysqli_real_escape_string($connection, $_POST['shift']);
    $experience = mysqli_real_escape_string($connection, $_POST['experience']);

    $query = "INSERT INTO `employee` (FIO, salary, form_of_employment, shift, experience) VALUES ('$FIO', '$salary', '$form_of_employment', '$shift', $experience)";
    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
}

if (isset($_POST['updateE'])) 
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $ID = mysqli_real_escape_string($connection, $_POST['ID']);
    
    $FIO = mysqli_real_escape_string($connection, $_POST['FIO']);
    if ($FIO!=NULL)
    {
        $query = "UPDATE `employee` SET FIO='$FIO' WHERE employeeID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    $salary = mysqli_real_escape_string($connection, $_POST['salary']);
    if ($salary!=NULL)
    {
        $query = "UPDATE `employee` SET salary='$salary' WHERE employeeID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $form_of_employment = mysqli_real_escape_string($connection, $_POST['form_of_employment']);
    if ($form_of_employment!=NULL)
    {
        $query = "UPDATE `employee` SET form_of_employment='$form_of_employment' WHERE employeeID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $shift = mysqli_real_escape_string($connection, $_POST['shift']);
    if ($shift!=NULL)
    {
        $query = "UPDATE `employee` SET shift='$shift' WHERE employeeID=$ID";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
    
    $experience = mysqli_real_escape_string($connection, $_POST['experience']);
    if ($experience!=NULL)
    {
        $query = "UPDATE `employee` SET experience='$experience' WHERE employeeID=$ID";
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
    $firstSalary = mysqli_real_escape_string($connection, $_POST['firstSalary']);
    $lastSalary = mysqli_real_escape_string($connection, $_POST['lastSalary']);
    $multySalary = mysqli_real_escape_string($connection, $_POST['multySalary']);
    $firstSalaryNDFL = mysqli_real_escape_string($connection, $_POST['firstSalaryNDFL']);
    $lastSalaryNDFL = mysqli_real_escape_string($connection, $_POST['lastSalaryNDFL']);
    $multySalaryNDFL = mysqli_real_escape_string($connection, $_POST['multySalaryNDFL']);
    $form = mysqli_real_escape_string($connection, $_POST['form']);
    $shift = mysqli_real_escape_string($connection, $_POST['shift']);
    $firstExp = mysqli_real_escape_string($connection, $_POST['firstExp']);
    $lastExp = mysqli_real_escape_string($connection, $_POST['lastExp']);
    $multyExp = mysqli_real_escape_string($connection, $_POST['multyExp']);

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

    if ($FIO!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND FIO LIKE '%".$FIO."%'";
            $userfilter = $userfilter."Показать ФИО: ".$FIO."<br/>";
        }
        else {
            $filterquery = $filterquery."FIO LIKE '%$FIO%'";
            $andFlag=1;
            $userfilter = "Показать ФИО: ".$FIO."<br/>";
        }
    }

    if ($firstSalary!=NULL && $lastSalary!=NULL)
    {
        if ($andFlag==1){
            $filterquery = $filterquery." AND salary BETWEEN $firstSalary AND $lastSalary";
            $userfilter = $userfilter."Показать зарплату от: ".$firstSalary." до ".$lastSalary."<br/>";
        }
        else {
            $filterquery = $filterquery."salary BETWEEN $firstSalary AND $lastSalary";
            $andFlag=1;
            $userfilter = "Показать зарплату от: ".$firstSalary." до ".$lastSalary."<br/>";
        }
    }
    elseif ($firstSalary!=NULL)
    {
        if ($andFlag==1){
            $filterquery = $filterquery." AND salary >= $firstSalary";
            $userfilter = $userfilter."Показать зарплату от: ".$firstSalary."<br/>";
        }
        else{
            $andFlag=1;
            $filterquery = $filterquery."salary >= $firstSalary";
            $userfilter = "Показать зарплату от: ".$firstSalary."<br/>";
        }
    }
    elseif ($lastSalary!=NULL)
    {
        if ($andFlag==1){
            $filterquery = $filterquery." AND salary <= $lastSalary";
            $userfilter = $userfilter."Показать зарплату до: ".$lastSalary."<br/>";
        }
        else {
            $andFlag=1;
            $filterquery = $filterquery."salary <= $lastSalary";
            $userfilter = "Показать зарплату до: ".$lastSalary."<br/>";
        }
        
    }

    if ($multySalary!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND salary IN ($multySalary)";
            $userfilter = $userfilter."Показать зарплату: ".$multySalary."<br/>";
        }
        else {
            $filterquery = $filterquery."salary IN ($multySalary)";
            $andFlag=1;
            $userfilter = "Показать зарплату: ".$multySalary."<br/>";
        }
    }

    if ($firstSalaryNDFL!=NULL && $lastSalaryNDFL!=NULL)
    {
        if ($andFlag==1){
            $filterquery = $filterquery." AND salaryNDFL BETWEEN $firstSalaryNDFL AND $lastSalaryNDFL";
            $userfilter = $userfilter."Показать зарплату с учетом налогов от: ".$firstSalaryNDFL." до ".$lastSalaryNDFL."<br/>";
        }
        else {
            $filterquery = $filterquery."salaryNDFL BETWEEN $firstSalaryNDFL AND $lastSalaryNDFL";
            $andFlag=1;
            $userfilter = "Показать зарплату с учетом налогов от: ".$firstSalaryNDFL." до ".$lastSalaryNDFL."<br/>";
        }
    }
    elseif ($firstSalaryNDFL!=NULL)
    {
        if ($andFlag==1){
            $filterquery = $filterquery." AND salaryNDFL >= $firstSalaryNDFL";
            $userfilter = $userfilter."Показать зарплату с учетом налогов от: ".$firstSalaryNDFL."<br/>";
        }
        else{
            $andFlag=1;
            $filterquery = $filterquery."salaryNDFL >= $firstSalaryNDFL";
            $userfilter = "Показать зарплату с учетом налогов от: ".$firstSalaryNDFL."<br/>";
        }
    }
    elseif ($lastSalaryNDFL!=NULL)
    {
        if ($andFlag==1){
            $filterquery = $filterquery." AND salaryNDFL <= $lastSalaryNDFL";
            $userfilter = $userfilter."Показать зарплату с учетом налогов до: ".$lastSalaryNDFL."<br/>";
        }
        else {
            $andFlag=1;
            $filterquery = $filterquery."salaryNDFL <= $lastSalaryNDFL";
            $userfilter = "Показать зарплату с учетом налогов до: ".$lastSalaryNDFL."<br/>";
        }
        
    }

    if ($multySalaryNDFL!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND salaryNDFL IN ($multySalaryNDFL)";
            $userfilter = $userfilter."Показать зарплату с учетом налогов: ".$multySalaryNDFL."<br/>";
        }
        else {
            $filterquery = $filterquery."salaryNDFL IN ($multySalaryNDFL)";
            $andFlag=1;
            $userfilter = "Показать зарплату с учетом налогов: ".$multySalaryNDFL."<br/>";
        }
    }

    if ($form!=NULL)
    {
        $arr = explode(", ", $form);
        for ($i=0; $i<count($arr); $i++)
        {
            $arr[$i] = "'".$arr[$i]."'";
        }
        $form = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND form_of_employment IN ($form)";
            $userfilter = $userfilter."Показать типы трудоустройств: ".$form."<br/>";
        }
        else {
            $filterquery = $filterquery."form_of_employment IN ($form)";
            $andFlag=1;
            $userfilter = "Показать типы трудоустройств: ".$form."<br/>";
        }
    }

    if ($shift!=NULL)
    {
        $arr = explode(", ", $shift);
        for ($i=0; $i<count($arr); $i++)
        {
            $arr[$i] = "'".$arr[$i]."'";
        }
        $shift = implode(", ", $arr);

        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND shift IN ($shift)";
            $userfilter = $userfilter."Показать смены: ".$shift."<br/>";
        }
        else {
            $filterquery = $filterquery."shift IN ($shift)";
            $andFlag=1;
            $userfilter = "Показать смены: ".$shift."<br/>";
        }
    }

    if ($firstExp!=NULL && $lastExp!=NULL)
    {
        if ($andFlag==1){
            $filterquery = $filterquery." AND experience BETWEEN $firstExp AND $lastExp";
            $userfilter = $userfilter."Показать опыт от: ".$firstExp." до ".$lastExp."<br/>";
        }
        else {
            $userfilter = "Показать опыт от: ".$firstExp." до ".$lastExp."<br/>";
            $andFlag=1;
        }
    }
    elseif ($firstExp!=NULL)
    {
        if ($andFlag==1){
            $filterquery = $filterquery." AND experience >= $firstExp";
            $userfilter = $userfilter."Показать опыт от: ".$firstExp."<br/>";
        }
        else{
            $andFlag=1;
            $filterquery = $filterquery."experience >= $firstExp";
            $userfilter = "Показать опыт от: ".$firstExp."<br/>";
        }
    }
    elseif ($lastExp!=NULL)
    {
        if ($andFlag==1){
            $filterquery = $filterquery." AND experience <= $lastExp";
            $userfilter = $userfilter."Показать опыт до: ".$lastExp."<br/>";
        }
        else {
            $andFlag=1;
            $filterquery = $filterquery."experience <= $lastExp";
            $userfilter = "Показать опыт до: ".$lastExp."<br/>";
        }
        
    }

    if ($multyExp!=NULL)
    {
        if ($andFlag==1)
        {
            $filterquery = $filterquery." AND experience IN ($multyExp)";
            $userfilter = $userfilter."Показать опыт: ".$multyExp."<br/>";
        }
        else {
            $filterquery = $filterquery."experience IN ($multyExp)";
            $andFlag=1;
            $userfilter = "Показать опыт: ".$multyExp."<br/>";
        }
    }
}
?>

<html>
<head>
<title>Сотрудники</title>
    <meta charset="utf-8">
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
<a href="employee.php" class="btn btn-primary wid7 lin">Обновить</a>
<h1 class="text">Таблица всех сотрудников</h1>

<table class="table table-striped table_sort">
<thead>
    <tr><th>Id</th><th>ФИО</th><th>ЗП</th><th>ЗП (с учетом налогов)</th><th>Трудоустройство</th><th>Смена</th><th>Опыт работы, месяцы</th></tr>
</thead>
<tbody>
    <?php
        $mysqli = new mysqli("db", "user", "password", "appDB");
        $result = $mysqli->query("SELECT * FROM employee");

        if ($filterquery!="SELECT * FROM employee WHERE ")
            $result = $mysqli->query($filterquery);
        if ($userfilter != "")
            echo $userfilter;
        
        foreach ($result as $row){
            echo "<tr><td>{$row['employeeID']}</td><td>{$row['FIO']}</td><td>{$row['salary']}</td><td>{$row['salaryNDFL']}</td><td>{$row['form_of_employment']}</td><td>{$row['shift']}</td><td>{$row['experience']}</td><td><a class='btn btn-outline-danger' href='delete.php?ID=".$row['employeeID']."&table=employee'>Удалить</a></td></tr>";
        }
    ?>
</tbody>
</table>

<form name="form" action="" method="POST">

<input type="text" name="FIO" id="FIO" placeholder="Фио">
<input type="text" name="salary" id="salary" placeholder="ЗП">

<select name="form_of_employment" id="form_of_employment" class="form-select wid10 lin">
    <option value="Полная">Полная</option>
    <option value="Частичная">Частичная</option>
    <option value="Стажировка">Стажировка</option>
</select>

<select name="shift" id="shift" class="form-select wid8 lin">
    <option value="Дневная">Дневная</option>
    <option value="Ночная">Ночная</option>
</select>

<input type="text" name="experience" id="experience" placeholder="Опыт">

<input class="btn btn-primary" type="submit" name="addE" value="Добавить сотрудника">

</form>

<form name="form" action="" method="POST">

<input class="wid8" type="text" name="ID" id="ID" placeholder="ID">
<input type="text" name="FIO" id="FIO" placeholder="Фио">
<input type="text" name="salary" id="salary" placeholder="ЗП">

<select name="form_of_employment" id="form_of_employment" class="form-select wid10 lin">
    <option value="Полная">Полная</option>
    <option value="Частичная">Частичная</option>
    <option value="Стажировка">Стажировка</option>
</select>

<select name="shift" id="shift" class="form-select wid8 lin">
    <option value="Дневная">Дневная</option>
    <option value="Ночная">Ночная</option>
</select>

<input type="text" name="experience" id="experience" placeholder="Опыт">

<input class="btn btn-primary" type="submit" name="updateE" value="Изменить определенного сотрудника">

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
    <span class="input-group-text" id="basic-addon2">Показать ЗП от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="firstSalary" placeholder="1000">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="lastSalary" placeholder="1000000">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные ЗП:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multySalary" placeholder="1000,5000,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать ЗП с учетом налогов от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="firstSalaryNDFL" placeholder="1000">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="lastSalaryNDFL" placeholder="1000000">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные ЗП с учетом налогов:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multySalaryNDFL" placeholder="1000,5000,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные типы трудоустройств:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="form" placeholder="Полная, Стажировка,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные типы смены:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="shift" placeholder="Дневная, Ночная,...">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать опыт работы от:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="firstExp" placeholder="1">
    <span class="input-group-text" id="basic-addon2">До</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="lastExp" placeholder="1000">
</div>

<div class="input-group mb-3 wid40">
    <span class="input-group-text" id="basic-addon2">Показать определенные значения опыта работы:</span>
    <input type="text" class="form-control input_height" aria-describedby="basic-addon2" name="multyExp" placeholder="1, 12, 21,...">
</div>

<input class="btn btn-primary" type="submit" name="filter" value="Применить фильтры">

</form>

</body>
</html>