<?php
include("../../../index.php");
$name = $_REQUEST['username'];
$login = $_REQUEST['login'];
$password = $_REQUEST['password'];

/**
 * добавление пользователя в базу данных
 */
$result = $mysqli->query('INSERT INTO Registration (login, password, username) VALUES ("' . $name . '", "' . $login . '", "' . $name . '")');

/**
 * программа выведет true при корректном выполнении
 */
var_dump($result);