<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 19/12/2014
 * Time: 9:10
 */
include("../pactodb/PactoDBQuerys.php");
include("../pactodb/PactoSQLQueryParser.php");

class PactoLib {

    // Player's CRUD
    public function createPlayer($playerName, $playerPassword) {
        $result = PactoDBQuery::CreatePlayer($playerName,$playerPassword);
        return array("result" => $result);
    }

    public function getPlayersList() {
        $result = PactoDBQuery::GetPlayersList();
        $numResults =  mysql_num_rows($result);
        $arrResult = array();

        for ($i = 0; $i<$numResults; $i++) {
            $row = mysql_fetch_row($result);
            $keys = array("playerId","playerName","playerPassword");
            $values = array($row[0],$row[1],$row[2]);
            $arrResult[$i] = PactoLib::ParseKeyValueArray($keys,$values);
        }

        return $arrResult;
    }

    public function getPlayer($playerName) {
        $result = PactoDBQuery::GetPlayer($playerName);
        $row = mysql_fetch_row($result);
        $keys = array("playerId","playerName","playerPassword");
        $values = array($row[0],$row[1],$row[2]);
        $arrResult = PactoLib::ParseKeyValueArray($keys, $values);
        return $arrResult;
    }

    public function updatePlayer($playerName, $newPlayerPassword) {
        $result = PactoDBQuery::UpdatePlayer($playerName, $playerName, $newPlayerPassword);
        return array("result" => $result);
    }

    public function deletePlayer($playerName) {
        $result = PactoDBQuery::DeletePlayer($playerName);
        return array("result" => $result);
    }


    //Util
    private static function ParseKeyValueArray($keysArray, $valuesArray) {
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