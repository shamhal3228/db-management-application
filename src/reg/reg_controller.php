<?php

include 'reg_model.php';

if (isset($_POST['submit'])) 
{
    $info_reg = reg_check($_POST['login'], $_POST['email'], $_POST['password'], $_POST['password2'], $_POST['user_group'], $_POST['secretWord']);
}
else header('Location: ../index.html');

if ($info_reg=='')
{
    header('Location: ../login/login_view.html');
}
echo $info_reg;
?>