<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 19/12/2014
 * Time: 9:10
 */
include("../pactodb/PactoDBQuery.php");
include("../pactodb/PactoSQLQueryParser.php");

class PactoLib {

    // Player's CRUD
    public function createPlayer($playerName, $playerPassword) {
        $result = PactoDBQuery::createPlayer($playerName,$playerPassword);
        return array("result" => $result);
    }

    public function getPlayersList() {
        $result = PactoDBQuery::getPlayersList();
        $numResults =  mysql_num_rows($result);
        $arrResult = array();

        for ($i = 0; $i<$numResults; $i++) {
            $row = mysql_fetch_row($result);
            $keys = array("playerId","playerName","playerPassword");
            $values = array($row[0],$row[1],$row[2]);
            $arrResult[$i] = PactoLib::parseKeyValueArray($keys,$values);
        }

        return $arrResult;
    }

    public function getPlayer($playerName) {
        $result = PactoDBQuery::getPlayer($playerName);
        $row = mysql_fetch_row($result);
        $keys = array("playerId","playerName","playerPassword");
        $values = array($row[0],$row[1],$row[2]);
        $arrResult = PactoLib::parseKeyValueArray($keys, $values);
        return $arrResult;
    }

    public function updatePlayer($playerName, $newPlayerPassword) {
        $result = PactoDBQuery::updatePlayer($playerName, $playerName, $newPlayerPassword);
        return array("result" => $result);
    }

    public function deletePlayer($playerName) {
        $result = PactoDBQuery::deletePlayer($playerName);
        return array("result" => $result);
    }

    //Player score's CRUD
    public function savePlayerScore($playerName, $levelName, $score) {
        $result = PactoDBQuery::savePlayerScore($playerName, $levelName, $score);
        return array("result" => $result);
    }

    public function getPlayerScoreByLevel($playerName, $levelName){
        $result = PactoDBQuery::getPlayerScoreByLevel($playerName, $levelName);
        return array("result" => $result);
    }

    public function getPlayerScores($playerName){
        $result = PactoDBQuery::getPlayerScores($playerName);
        if ($result != 'false') {
            $numResults =  mysql_num_rows($result);
            $arrResult = array();

            for ($i = 0; $i<$numResults; $i++) {
                $row = mysql_fetch_row($result);
                $keys = array("userId","level","score");
                $values = array($row[0],$row[1],$row[2]);
                $arrResult[$i] = PactoLib::parseKeyValueArray($keys,$values);
            }
            return $arrResult;
        }
        else
            return array("result"=>$result);
    }

    public function deletePlayerScore($playerName){
        $result = PactoDBQuery::deletePlayerScores($playerName);
        return array("result" => $result);
    }

    //Player progress's CRUD
    public function savePlayerProgress($playerName, $levelName) {
        $result = PactoDBQuery::savePlayerProgress($playerName,$levelName);
        return array("result" => $result);
    }

    public function getPlayerProgress($playerName) {
        $result = PactoDBQuery::getPlayerProgress($playerName);
        return array("result" => $result);
    }

    public function deletePlayerProgress($playerName) {
        $result = PactoDBQuery::deletePlayerProgress($playerName);
        return array("result" => $result);
    }

    //Util
    private static function parseKeyValueArray($keysArray, $valuesArray) {
        $keyValueArray = array();
        $m = min(count($keysArray), count($valuesArray));

        for ($i = 0; $i<$m; $i++) {
            $key = $keysArray[$i];
            $value = $valuesArray[$i];
            $keyValueArray[$key] = $value;
        }

        return $keyValueArray;
    }
}