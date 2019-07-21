<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 20.07.2019
 * Time: 1:58
 */

/* @var $lastCall stdClass */

$orderClass = new \classes\OrderClass();
?>

<? if (!empty($lastCall)): ?>
    <p><b>Лифт</b> № <?= $lastCall->elevator_id ?></p>
    <p><b>Путь</b> <?= $orderClass->getPrevFloor(serialize($lastCall)) ?> -> <?= $lastCall->floor ?></p>
    <p><b>Время</b> <?= date( "H:i Y-m-d", strtotime($lastCall->datetime))?></p>
    <p><b>Направление</b> <?= ($lastCall->direction > 0) ? 'Вверх' : 'Вниз' ?></p>
<? endif; ?>
