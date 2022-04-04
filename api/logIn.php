<?php
include("../../index.php");
$login = $_REQUEST['login'];
$pass = $_REQUEST['password'];

/**
 * проверка на налличие такого пользователя в базе данных и вывод его данных, если пользователь найден
 */
$result = $mysqli->query('SELECT * FROM registration WHERE login=' . $login . ' AND password=' . $pass);
$row = $result->fetch_assoc();
var_dump($row);