<?php header('Content-type: application/json'); header('Access-Control-Allow-Origin: *');
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 19/12/2014
 * Time: 17:31
 */

include("PactoLib.php");
$lib = new PactoLib();
error_reporting(E_ERROR | E_PARSE);

if (isset($_GET['action'])) {
    switch($_GET['action']) {
        case "getPlayersList":
            $data = $lib->getPlayersList();
            break;
        case "createPlayer":
            $data = $lib->createPlayer(
                filter_input(INPUT_GET, 'playerName', FILTER_SANITIZE_STRING),
                filter_input(INPUT_GET, 'playerPassword', FILTER_SANITIZE_STRING)
            );
            break;
        case "getUser":
            $data = $lib->getUser(
                filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING)
            );
            break;
        default:
            http_response_code(400);
            $data = array("error" => "bad request");
    }
    header("Content-Type: application/json");
    echo json_encode($data);
}