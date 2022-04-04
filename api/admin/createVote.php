<?php
include("../../../index.php");
$voteName = $_REQUEST['name'];

/**
 * количество вариантов ответа
 */
$quantity = $_REQUEST['quantity'];

/**
 * массив вариантов голосования
 */
$variants = [];

for($i = 0; $i < $quantity; $i++)
    $variants[$i] = $_REQUEST['variants'  . $i];

$addVoteName = $mysqli->query('INSERT INTO vote (name) VALUES ("' . $voteName . '")');

/**
 * получаю id только что добавленного голосования
 */
$voteId = $mysqli->query('SELECT * FROM vote WHERE name = "' . $voteName . '"');
$voteId = $voteId->fetch_assoc();
$voteId = $voteId["id"];

$count = 0;

for($i = 0; $i < $quantity; $i++)
{

    $res = $mysqli->query('INSERT INTO variants (name) VALUES ("' . $variants[$i] . '")');

    /**
     * получаю id только что добавленного варианта
     */
    $variantId = $mysqli->query('SELECT * FROM variants WHERE name = "' . $variants[$i] . '"');
    $variantId = $variantId->fetch_assoc();
    $variantId = $variantId["id"];

    if($res)
    {
        /**
         * добавление вариантов в таблицу, связывающую элементы и варианты
         */
        $add = $mysqli->query('INSERT INTO connections (id_vote, id_variants) VALUES ("' . $voteId . '", "' .  $variantId . '")');
        if($add)
            $count++;
    }
}

/**
 * Проверка
 */
if($addVoteName == 1 && $count == $quantity)
    print_r('successfully compiled');
else
    print_r('some mistake must be there');