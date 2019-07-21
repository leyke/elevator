<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 20.07.2019
 * Time: 1:09
 */


?>

<div class="house">
    <? foreach ($elevators as $elevator): ?>
        <div class="porch">
            <? for ($i = FLOORS_COUNT; $i > 0; $i--): ?>
                <div class="floor <?= in_array($i,
                    $orderedFloors) ? 'is-called' : '' ?> <?= $i == $elevator->curFloor ? 'is-active' : '' ?>"><?= $i ?></div>
            <? endfor; ?>
        </div>
    <? endforeach; ?>
</div>
