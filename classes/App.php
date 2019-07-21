<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 19.07.2019
 * Time: 21:19
 */

namespace classes;

class App
{
    public $action;

    public static function getAction()
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        } else {
            $controller_name = 'index';
        }

        return $controller_name;
    }

    public static function loadElevators()
    {
        unset($_SESSION['elevators']);
        $elevators = [];

        for ($i = 1; $i <= ELEVATORS_COUNT; $i++) {
            $elevators[$i] = new Elevator($i);
            $_SESSION['elevators'][$i] = serialize($elevators[$i]);
        }

        return $elevators;
    }

    public static function init()
    {
        $order = new OrderClass();
        $orders = $order->read();

        if (count($orders) < ELEVATORS_COUNT) {
            for ($i = 1; $i <= ELEVATORS_COUNT; $i++) {
                $order->create($i, mt_rand(1, FLOORS_COUNT), 1);
            }
        }
        self::checkFreeElevators();

        return self::loadElevators();
    }

    public static function checkFreeElevators()
    {
        $orderClass = new OrderClass();
        $res = false;
        if (empty($orderClass->read(['status' => 0])) && empty(self::getFirstFloorElevators())) {
            $orderClass->call(1);

            $res = true;
        }

        return $res;
    }

    public static function getFirstFloorElevators()
    {
        $elevators = self::loadElevators();
        $result = [];

        foreach ($elevators as $elevator) {
            if ($elevator->curFloor == 1) {
                $result[] = $elevator;
            }
        }

        return $result;

    }

    public static function renderTemplate($tmp, $vars = array())
    {
        if (file_exists('views/' . $tmp)) {
            ob_start();
            if (is_array($vars)) {
                extract($vars);
            }
            require 'views/' . $tmp;
            return ob_get_clean();
        } else {
            return null;
        }

    }

}