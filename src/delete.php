<?php
$connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
mysqli_set_charset($connection, "utf8mb4_unicode_ci");

$ID = $_GET['ID'];
$table = $_GET['table'];

if ($table == "employee" || $table == "worker" || $table == "engeneer"){
    $fetching_employeeID = mysqli_query($connection, "DELETE FROM `$table` WHERE `employeeID` = '$ID'");
    header("Location: $table.php");
}

if ($table == "vehicles"){
    $fetching_employeeID = mysqli_query($connection, "DELETE FROM `$table` WHERE `vehicalID` = '$ID'");
    header("Location: $table.php");
}

if ($table == "store"){
    $fetching_employeeID = mysqli_query($connection, "DELETE FROM `$table` WHERE `materialID` = '$ID'");
    header("Location: $table.php");
}

if ($table == "interior"){
    $fetching_employeeID = mysqli_query($connection, "DELETE FROM `$table` WHERE `schemeID` = '$ID'");
    header("Location: $table.php");
}

if ($table == "exterior"){
    $fetching_employeeID = mysqli_query($connection, "DELETE FROM `$table` WHERE `modelID` = '$ID'");
    header("Location: $table.php");
}

if ($table == "clientele"){
    $fetching_employeeID = mysqli_query($connection, "DELETE FROM `$table` WHERE `clienteleID` = '$ID'");
    header("Location: $table.php");
}

if ($table == "tenders"){
    $fetching_employeeID = mysqli_query($connection, "DELETE FROM `$table` WHERE `tenderID` = '$ID'");
    header("Location: $table.php");
}

if ($table == "current_project"){
    $fetching_employeeID = mysqli_query($connection, "DELETE FROM `$table` WHERE `projectID` = '$ID'");
    header("Location: $table.php");
}

?>