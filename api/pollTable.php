<?php
include("../../index.php");
$polls =[];
$idRegistration = $_REQUEST['id_registration'];

/**
 * подсчёт количества строк в таблице vote
 */
$count = $mysqli->query("SELECT count(*) FROM vote");
$count = $count->fetch_row();
$count = $count[0];


/**
 * создание массива $v с данными о количестве проголосовавших в i-том голосовании
 */
$voted = $mysqli->query("SELECT id_vote, COUNT(*) FROM votes GROUP BY id_vote");
$v = $voted->fetch_assoc();

/**
 * программа пробегается по таблице vote
 */
$lineNumber = 0;
$voteId = 1;
while ($lineNumber < $count)
{

    /**
     * поиск в бд голосования с данным id
     */
    $poll = $mysqli->query('SELECT * FROM vote WHERE id=' . $voteId);
    $poll = $poll->fetch_assoc();

    if($poll != 0)
    {
        /**
         * каждый элемент в массиве это массив, в котором записаны данные об i-том голосовании
         */
        $polls [$lineNumber]['name'] = $poll['name'];

        /**
         * проверка: голосовал ли данный пользователь в этом голосовании
         */
        $vote = $mysqli->query('SELECT * FROM votes WHERE id_vote=' . $voteId . '&& id_registration="' . $idRegistration . '"');
        $vote = $vote->fetch_assoc();

        if($vote != 0)
            $polls[$lineNumber]['am_i_voted'] = 1;
        else
            $polls[$lineNumber]['am_i_voted'] = 0;

        /**
         * проверка на налчие голосов в данном опросе
         */
        if ($v['id_vote'] == $voteId)
        {
            $polls[$lineNumber]['voted'] = $v['COUNT(*)'];
            $v = $voted->fetch_assoc();
        }
        else
            $polls[$lineNumber]['voted'] = 0;

        $lineNumber++;
    }

    $voteId++;
}

/**
 * вывод получившегося двумерного массива для проверки
 */
var_dump($polls);