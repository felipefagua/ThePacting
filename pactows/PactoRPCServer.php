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
        //Player's CRUD
        case "createPlayer":
            $data = $lib->createPlayer(
                filter_input(INPUT_GET, 'playerName', FILTER_SANITIZE_STRING),
                filter_input(INPUT_GET, 'playerPassword', FILTER_SANITIZE_STRING)
            );
            break;
        case "getPlayersList":
            $data = $lib->getPlayersList();
            break;
        case "getPlayer":
            $data = $lib->getPlayer(
                filter_input(INPUT_GET, 'playerName', FILTER_SANITIZE_STRING)
            );
            break;
        case "updatePlayer":
            $data = $lib->updatePlayer(
                filter_input(INPUT_GET, 'playerName', FILTER_SANITIZE_STRING),
                filter_input(INPUT_GET, 'playerPassword', FILTER_SANITIZE_STRING)
            );
            break;
        case "deletePlayer":
            $data = $lib->deletePlayer(
                filter_input(INPUT_GET, 'playerName', FILTER_SANITIZE_STRING)
            );
            break;
        case "savePlayerScore":
            $data = $lib->savePlayerScore(
                filter_input(INPUT_GET, 'playerName', FILTER_SANITIZE_STRING),
                filter_input(INPUT_GET, 'levelName', FILTER_SANITIZE_STRING),
                filter_input(INPUT_GET, 'score', FILTER_SANITIZE_STRING)
            );
            break;
        case "deletePlayerScores":
            $data = $lib->deletePlayerScore(
                filter_input(INPUT_GET, 'playerName', FILTER_SANITIZE_STRING)
            );
            break;
        case "getPlayerScoreByLevel":
            $data = $lib->getPlayerScoreByLevel(
                filter_input(INPUT_GET, 'playerName', FILTER_SANITIZE_STRING),
                filter_input(INPUT_GET, 'levelName', FILTER_SANITIZE_STRING)
            );
            break;
        case "getPlayerScores":
            $data = $lib->getPlayerScores(
                filter_input(INPUT_GET, 'playerName', FILTER_SANITIZE_STRING)
            );
            break;
        case "savePlayerProgress":
            $data = $lib->savePlayerProgress(
                filter_input(INPUT_GET, 'playerName', FILTER_SANITIZE_STRING),
                filter_input(INPUT_GET, 'levelName', FILTER_SANITIZE_STRING)
            );
            break;
        case "getPlayerProgress":
            $data = $lib->getPlayerProgress(
                filter_input(INPUT_GET, 'playerName', FILTER_SANITIZE_STRING)
            );
            break;
        case "deletePlayerProgress":
            $data = $lib->deletePlayerProgress(
                filter_input(INPUT_GET, 'playerName', FILTER_SANITIZE_STRING)
            );
            break;
        default:
            http_response_code(400);
            $data = array("error" => "bad request");
    }
    header("Content-Type: application/json");
    echo json_encode($data);
}