<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 21.07.2019
 * Time: 19:13
 */

/* @var $elevators \classes\Elevator[] */
?>
<table border="2">
    <thead>
    <tr>
        <td>Лифт</td>
        <td>Статистика заказов</td>
        <td>Итерации</td>
    </tr>
    </thead>
    <tbody>
    <? if ($elevators): ?>
        <? foreach ($elevators as $elevator): ?>
            <tr>
                <td><?= $elevator->id ?></td>
                <td>
                    <? for ($i = 1; $i <= FLOORS_COUNT; $i++):
                        $stat = $elevator->floorsStat[$i];
                        if ($stat) {
                            echo "$i - $stat <br>";
                        } else {
                            echo "$i - 0 <br>";
                        }
                    endfor; ?>
                </td>
                <td>
                    <ul>
                        <? foreach ($elevator->iterations as $iteration): ?>
                            <? echo "<li>" . implode(" -> ", $iteration) . "</li>" ?>
                        <? endforeach; ?>
                    </ul>
                </td>
            </tr>
        <? endforeach; ?>
    <? endif; ?>
    </tbody>
</table>