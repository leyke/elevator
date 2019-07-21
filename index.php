<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 17.07.2019
 * Time: 22:56
 */

spl_autoload_register(function ($class) {
    require_once str_replace('\\', '/', $class) . '.php';
});

use classes\App;

define("ELEVATORS_COUNT", 4);
define("FLOORS_COUNT", 10);


switch (App::getAction()) {
    case "index" :
        App::init();

        $elevators = App::loadElevators();
        $orderClass = new \classes\OrderClass();
        $orderedFloors = array_column($orderClass->read(['status' => 0]), 'floor');

        echo App::renderTemplate('main.php', array('elevators' => $elevators, 'orderedFloors' => $orderedFloors));
        break;

    case "call" :
        /* @var $elevator \classes\Elevator */
        $floor = isset($_POST['floor']) ? $_POST['floor'] : null;
        if ($floor) {
            $orderClass = new \classes\OrderClass();
            $orderResult = $orderClass->call($floor);

            $elevators = $orderResult['elevators'];
            $order = $orderResult['order'];

            $orderedFloors = array_column($orderClass->read(['status' => 0]), 'floor');
            $house = App::renderTemplate('_house.php',
                array('elevators' => $elevators, 'orderedFloors' => $orderedFloors));

            $lastCall = App::renderTemplate('_last-call.php', ['lastCall' => $order]);

            echo json_encode(['house' => $house, 'lastCall' => $lastCall]);
        }

        break;
    case "check-first-floor":
        if (App::checkFreeElevators()) {
            $elevators = App::loadElevators();
            $orderClass = new \classes\OrderClass();
            $orderedFloors = array_column($orderClass->read(['status' => 0]), 'floor');

            echo App::renderTemplate('_house.php', array('elevators' => $elevators, 'orderedFloors' => $orderedFloors));
        }
        break;
    default :
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        echo App::renderTemplate('error.php');

        break;
}



//try {
//    var_dump($elevator->read());
//} catch (Exception $e) {
//    echo "<h1>" . $e->getMessage() . "</h1>";
//}


