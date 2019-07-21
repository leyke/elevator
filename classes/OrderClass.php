<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 19.07.2019
 * Time: 21:17
 */

namespace classes;

use mysql_xdevapi\Exception;

class OrderClass
{
    public $logTableName = 'order';
    public $db;

    public function __construct()
    {
        $this->db = new DataBaseHelper();
    }

    public function genSqlSelectArgs(array $args)
    {
        $result = '';
        $argsSql = [];
        if (!empty($args)) {
            foreach ($args as $key => $value) {
                $argsSql[] = "$key = $value";
            }
            $result = implode(' AND ', $argsSql);
        }
        return $result;
    }

    public function read(array $args = null)
    {
        $sql = "SELECT * FROM {$this->db->dbName}.{$this->logTableName}";
        if ($args) {
            $sql .= " WHERE ";
            $sql .= self::genSqlSelectArgs($args);
        }
        $result = $this->db->getRows($sql);

        return $result;
    }

    public function create($elevator_id, $floor, $status = 0, $direction = 0)
    {
        $sql = "INSERT INTO {$this->db->dbName}.{$this->logTableName} (\"elevator_id\", \"floor\", \"status\", \"direction\") VALUES ($elevator_id, $floor, $status, '$direction')";
        $result = $this->db->insert($sql);

        return $result;
    }

    public function call($floor)
    {
        $call = $this->getNearestElevator($floor);
        $elevator = $call['elevator'];
        $status = ($call['direction'] != 'none') ? 0 : 1;
        $order_id = $this->create($elevator->id, $floor, $status, $call['direction']);
        if (!$order_id) {
            throw new Exception('Ошибка заказа лифта', 500);
        }
        $result['order'] = end(self::read(['id' => $order_id]));
        $result['elevators'] = $elevator->move($result['order']);
        return $result;
    }

    public function getNearestElevator($floor)
    {
        $elevators = App::loadElevators();
        $minPathLength = FLOORS_COUNT;
        $elevatorRes = $elevators[mt_rand(1, ELEVATORS_COUNT)];

        if (!empty($elevators)) {
            foreach ($elevators as $elevator) {
                /* @var $elevator Elevator */
                if (empty($elevator->getOrders(['status' => 0]))) {
                    $pathLength = abs($elevator->getCurFloor() - $floor);
                    if ($pathLength < $minPathLength) {
                        $minPathLength = $pathLength;
                        $elevatorRes = $elevator;
                    }
                }
            }
        }

        $direction = $elevatorRes->getDirection($floor);

        return ['direction' => $direction, 'elevator' => $elevatorRes];
    }

    public function done($id)
    {
        $sql = "UPDATE {$this->db->dbName}.{$this->logTableName} SET status=1 WHERE id={$id}";

        return $this->db->exec($sql);
    }

    public function getPrevFloor($stdClass)
    {
        $std = unserialize($stdClass);

        $sql = "SELECT * FROM {$this->db->dbName}.{$this->logTableName}";
        $sql .= " WHERE id <> {$std->id} AND datetime < '{$std->datetime}'  ORDER BY datetime DESC ";
        $prevOrder = $this->db->getRow($sql);
        return $prevOrder->floor;

    }

}