<?php
include("../../../index.php");
$pollId = $_REQUEST['vote_id'];
$variants = [];

/**
 * подсчитываю количество вариантов ответа для заданного голосования
 */
$count = $mysqli->query("SELECT COUNT(*) as count FROM connections WHERE id_vote=$pollId");
$count = $count->fetch_row();
$count  = $count[0];

/**
 * подсчитываю общее количество голосов в данном голосовании
 */
$totalVotes = $mysqli->query("SELECT COUNT(*) as count FROM votes WHERE id_vote = $pollId");
$totalVotes = $totalVotes->fetch_row();
$totalVotes = $totalVotes[0];

/**
 * получение id i-ого варианта голосования
 */
$variantId = $mysqli->query("SELECT * FROM connections WHERE id_vote = $pollId");
for($i = 0; $i < $count; $i++)
{
    $variantId = $variantId->fetch_assoc();
    $variantId = $variantId['id_variants'];
    $variants [$i]['variant_id'] = $variantId;

    /**
     * получение количества голосов i-ый вариант
     */
    $votes_for = $mysqli->query("SELECT COUNT(*) as count FROM votes WHERE id_vote = $pollId && id_variants = $variantId");
    $votes4 = $votes_for->fetch_row();
    $votes = $votes4[0];

    /**
     * расчёт процентов
     */
    $percent = round($votes / $totalVotes * 100, 2);
    $variants [$i]['percent'] = $percent;
}

/**
 * пользователь будет видеть на экране следующие данные
 */
var_dump($variants, $totalVotes);