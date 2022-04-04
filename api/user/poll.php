<?php
include("../../../index.php");
$vote = $_REQUEST['vote'];
$idRegistration = $_REQUEST['id_registration'];
$variants = [];
$variantsInTotal = 0;

/**
 * подсчёт количества записей в таблице connections
 */
$count = $mysqli->query("SELECT count(*) FROM connections");
$count = $count->fetch_row();
$count = $count[0];

/**
 * получение id данного голосования
 */
$voteId = $mysqli->query('SELECT * FROM vote WHERE name="' . $vote . '"');
$voteId = $voteId->fetch_assoc();
$voteId = $voteId['id'];

/**
 * программа пробегается по таблице connections
 */
$lineNumber = 0;
$variantId = 1;

while($lineNumber < $count)
{

    /**
     * поиск в бд варианта с данным id
     */
    $amount = $mysqli->query('SELECT * FROM connections WHERE id=' . $variantId);
    $am = $amount->fetch_assoc();
    if($am != 0)
    {

        $lineNumber++;

        /**
         * проверка на принадлежность данного варианта данному голосованию и добавление в массив вариантов, если это так
         */
        if($am['id_vote'] == $voteId)
        {
            $variants[] = $am['id_variants'];
            $variantsInTotal++;
        }
    }
    $variantId++;
}

/**
 * приём ответа пользователя и добавление его голосо в таблицу
 */
for($i = 0; $i < $variantsInTotal; $i++)
{
    $answer = $_REQUEST['variant' . $i ];
    if($answer == 1)
    {
        $add = $mysqli->query('INSERT INTO votes (id_vote, id_variants, id_registration) VALUE ("' . $voteId . '",  "' . $variants[$i] . '", "'  . $idRegistration . '")');
        break;
    }
}
var_dump($variants, $add);