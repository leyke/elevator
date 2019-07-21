<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 19.07.2019
 * Time: 22:33
 */

/* @var $elevators \classes\Elevator[] */
/* @var $lastCall  \classes\OrderClass */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Лифты</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>

<h1>
    Лифты
</h1>

<h2>Вызов</h2>
<section class="section">
    <div class="section__column">
        <h3>Управление</h3>
        <div class="call-btns-wrap">
            <?= \classes\App::renderTemplate('_call.php') ?>
        </div>
    </div>
    <div class="section__column">
        <h3>Последний вызов</h3>

        <div class="js-last-call">
            <?= \classes\App::renderTemplate('_last-call.php', ['lastCall' => $lastCall]) ?>
        </div>
    </div>
</section>

<h2>Положение</h2>
<section class="section js-house-wrap">

    <?= \classes\App::renderTemplate('_house.php', ['elevators' => $elevators, 'orderedFloors' => $orderedFloors]) ?>
</section>

<script type="text/javascript" src="/js/script.js"></script>
</body>
</html>