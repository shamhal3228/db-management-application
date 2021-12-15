<?php

include 'login_model.php';

if (isset($_POST['submit'])) 
{
    $info_reg = login_check($_POST['email'], $_POST['password']);
}
else{
    header('Location: login_view.html');
}

if ($info_reg=='Клиент')
{
    header('Location: ../client.php');
}

if ($info_reg=='HR-менеджер')
{
    header('Location: ../hr.php');
}

if ($info_reg=='Склад-менеджер')
{
    header('Location: ../store-man.php');
}

if ($info_reg=='Менеджер-менеджер')
{
    header('Location: ../admin.php');
}

echo $info_reg;

?>