<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 17.07.2019
 * Time: 23:02
 */

namespace classes;

/* @var $lastOrder OrderClass */
class Elevator
{
    public $id;
    public $curFloor;
    public $tableName = 'elevator';

    public function __construct($id = null)
    {
        $this->id = ($id) ? $id : mt_rand(1, ELEVATORS_COUNT);
        $this->curFloor = $this->getCurFloor();
    }

    /**
     * $array($id, $status, $floor, $elevator_id, $direction)
     * @param array|null $args
     * @return array
     */
    public function getOrders(array $args = null)
    {
        $order = new OrderClass();
        $args['elevator_id'] = $this->id;

        $orders = $order->read($args);

        return $orders;
    }

    public function move($order)
    {
        $curFloor = $this->getCurFloor();
        $direction = $this->getDirection($order->floor);
        $iter = 0;

        while ($this->getOrders(['direction' => $direction, 'status' => 0])) {
            sleep(1);

            $curFloor += $direction;
            $this->closeOrders($curFloor);

            $iter++;
        }

        return App::loadElevators();
    }

    public function getCurFloor()
    {
        $lastOrder = end($this->getOrders(['status' => 1]));

        $floor = $lastOrder->floor;

        return $floor;
    }

    public function closeOrders($curFloor)
    {
        $orders = $this->getOrders(['floor' => $curFloor, 'status' => 0]);
        if ($orders) {
            foreach ($orders as $order) {
                (new OrderClass)->done($order->id);
            }
        }
    }

    public function getDirection($floor)
    {
        if ($this->curFloor == $floor) {
            $direction = 0;
        } else {
            $direction = ($this->curFloor > $floor) ? -1 : 1;
        }

        return $direction;
    }
}