<?php

function login_check(&$email, &$password)
{
    session_start();

    $connection = mysqli_connect("db", "user", "password", "appDB") or die(mysqli_error());
    mysqli_set_charset($connection, "utf8mb4_unicode_ci");

    $info_input = '';

    if (empty($email)) 
    {
        $info_input = 'Вы не ввели почту';
    }
    elseif (empty($password))
    {
        $info_input = 'Вы не ввели пароль';
    }
    else 
    {    
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);
        $user = mysqli_query($connection, "SELECT `id` FROM `users` WHERE `email` = '$email'");
        $id_user = mysqli_fetch_array($user);

	    $fetching_group = mysqli_query($connection, "SELECT `user_group` FROM `users` WHERE `email` = '$email'");
        $user_group = mysqli_fetch_array($fetching_group);

        $find_login = mysqli_query($connection, "SELECT `login` FROM `users` WHERE `email` = '$email'");
        $login = mysqli_fetch_array($find_login);
        
        if (empty($id_user['id'])) 
        {
            $info_input = 'Введенные данные неверны- попробуйте снова или зарегистрируйтесь';
        }
        else 
        {
            $_SESSION['login'] = $login['login']; 
            $_SESSION['email'] = $email; 
            $_SESSION['id'] = $id_user['id'];
	        $_SESSION['user_group'] = $user_group['user_group'];
            $info_input = $user_group['user_group'];
        }     
    }

    return $info_input;
}
?>