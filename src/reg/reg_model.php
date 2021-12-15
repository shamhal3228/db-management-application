<?php

function reg_check(&$login, &$email, &$password, &$password2, &$user_group, &$secretWord)
{
    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error($connection));
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $info_reg = '';

    if (empty($login)) 
    {
        $info_reg = 'Вы не ввели ФИО';
    }
    elseif (preg_match("/[0-9~`!#$%\^&*+=\-\[\]\\';,\/{}|\:<>\?\.]/", $login))
    {
        $info_reg = 'Некорректная фамилия- попробуйте снова';
    }       
    elseif (empty($email)) 
    {
        $info_reg = 'Вы не ввели почту';
    }
    elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $email)) 
    {
        $info_reg = 'Неправильно введен адрес электронной почты';
    }           
    elseif (empty($password)) 
    {
        $info_reg = 'Вы не ввели пароль';
    }
    elseif (empty($password2)) 
    {
        $info_reg = 'Вы не ввели пароль повторно';
    }
    elseif ($password != $password2) 
    {
        $info_reg = 'Пароли не совпадают';
    }
    elseif (!preg_match("/^[a-zA-Z0-9~`!@#$%()\^&*+=\-\[\]\\';,\/{}|\:<>\?\._]{3,35}$/", $password)) 
    {
        $info_reg = 'Пароль должен состоять из 3-35 символов';
    }                     
    else
    {
        $login = mysqli_real_escape_string($connection, $login);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);
	    $user_group = mysqli_real_escape_string($connection, $user_group);
        $secretWord = mysqli_real_escape_string($connection, $secretWord);

        if ($user_group == "HR-менеджер" && $secretWord != "hr577")
            return "Неверное ключевое слово";
        elseif ($user_group == "Склад-менеджер" && $secretWord != "store117")
            return "Неверное ключевое слово";
        elseif ($user_group == "Менеджер-менеджер" && $secretWord != "manager636")
            return "Неверное ключевое слово";
  
        $query = "INSERT INTO `users` (login, email, password, user_group) VALUES ('$login', '$email', '$password', '$user_group')";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    }

    return $info_reg;
}
?>