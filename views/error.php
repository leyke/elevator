<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 19.07.2019
 * Time: 22:20
 */

/* @var $e Exception */
?>
<? if ($e): ?>
    <h1><?= $e->getCode() ?></h1>
    <p><?= $e->getMessage() ?></p>
<? else: ?>
    <h1>Не найдено</h1>
<? endif; ?>
<p>
    <a href="/">На главную</a>
</p>
