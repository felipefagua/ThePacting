<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 13/12/2014
 * Time: 10:25
 */

class PactoDBQuery {
    private static $databaseHost = 'localhost';
    private static $databaseUsername = 'pactoadmin';
    private static $databaseUserPassword = 'pactoadmin';
    private static $databaseName = 'el_pacto_game';

    private static function getDatabaseConnection() {
        $dbResource = mysql_connect(PactoDBQuery::$databaseHost,PactoDBQuery::$databaseUsername,PactoDBQuery::$databaseUserPassword);

        if (!$dbResource)
            $dbResource = null;

        return $dbResource;
    }

    private static function closeDatabaseConnection($dbResource) {
        if ($dbResource != null)
            mysql_close($dbResource);

        return $dbResource;
    }

    // Basic Player's CRUD
    public static function createPlayer($playerName, $playerPassword) {
        $response = false;
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        if (!PactoDBQuery::playerExist($playerName, $dbResource))
        {
            $strQuery = PactoSQLQueryParser::insertPlayer($playerName,$playerPassword);
            mysql_query($strQuery, $dbResource);
            $response = true;
        }
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $response;
    }

    public static function getPlayer($playerName, $dbResource=null) {
        if ($dbResource==null)
            $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        $strQuery = PactoSQLQueryParser::selectPlayerByName($playerName);
        $queryResult = mysql_query($strQuery, $dbResource);
        if ($dbResource==null)
            PactoDBQuery::closeDatabaseConnection($dbResource);
        return $queryResult;
    }

    public static function getPlayersList() {
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        $queryResult = null;
        if ($dbResource != null) {
            $strQuery = PactoSQLQueryParser::selectPlayers();
            $queryResult = mysql_query($strQuery, $dbResource);
        }
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $queryResult;
    }

    public static function updatePlayer($playerName, $newPlayerName, $newPlayerPassword) {
        $response = 'false';
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        if (PactoDBQuery::playerExist($playerName, $dbResource)) {
            $strQuery2 = PactoSQLQueryParser::updatePlayer($playerName, $newPlayerName, $newPlayerPassword);
            mysql_query($strQuery2,$dbResource);
            $response = 'true';
        }
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $response;
    }

    public static function deletePlayer($playerName) {
        $response = 'false';
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        if (PactoDBQuery::playerExist($playerName,$dbResource))
        {
            $strQuery = PactoSQLQueryParser::deletePlayer($playerName);
            mysql_query($strQuery, $dbResource);
            $response = 'true';
        }
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $response;
    }

    // Player progress's CRUD
    public static function savePlayerScore($playerName, $levelName, $score) {
        $couldSavePlayerScore = 'false';
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        if (PactoDBQuery::playerExist($playerName, $dbResource) &&
            PactoDBQuery::levelExist($levelName, $dbResource)) {
            $playerId = PactoDBQuery::getPlayerId($playerName, $dbResource);
            $levelId = PactoDBQuery::getLevelId($levelName, $dbResource);
            $scoreTimeStamp = PactoDBQuery::getTimeStamp();
            if (PactoDBQuery::scoreExist($playerId, $levelId, $dbResource))
                $strQuery = PactoSQLQueryParser::updatePlayerScore($playerId, $levelId, $score, $scoreTimeStamp);
            else
                $strQuery = PactoSQLQueryParser::insertPlayerScore($playerId, $levelId, $score, $scoreTimeStamp);

            mysql_query($strQuery, $dbResource);
            $couldSavePlayerScore = 'true';
        }
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $couldSavePlayerScore;
    }

    public static function getPlayerScoreByLevel($playerName, $levelName) {
        $playerScore = 'false';
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        if (PactoDBQuery::playerExist($playerName, $dbResource) &&
            PactoDBQuery::levelExist($levelName, $dbResource)) {
            $playerId = PactoDBQuery::getPlayerId($playerName, $dbResource);
            $levelId = PactoDBQuery::getLevelId($levelName, $dbResource);
            $strQuery = PactoSQLQueryParser::selectPlayerScore($playerId, $levelId);
            $queryResult = mysql_query($strQuery, $dbResource);
            $numResults = mysql_num_rows($queryResult);
            if ($numResults > 0) {
                $playerProgressRow = mysql_fetch_row($queryResult);
                $playerScore = $playerProgressRow[0];
            }
        }
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $playerScore;
    }

    public static function getPlayerScores($playerName) {
        $playerScores = 'false';
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        if (PactoDBQuery::playerExist($playerName, $dbResource)) {
            $playerId = PactoDBQuery::getPlayerId($playerName, $dbResource);
            $strQuery = PactoSQLQueryParser::selectPLayerScores($playerId);
            $queryResult = mysql_query($strQuery, $dbResource);
            return $queryResult;
        }
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $playerScores;
    }

    public static function deletePlayerScores($playerName) {
        $couldDeletePlayerScore = 'false';
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        if (PactoDBQuery::playerExist($playerName, $dbResource)) {
            $playerId = PactoDBQuery::getPlayerId($playerName, $dbResource);
            $strQuery = PactoSQLQueryParser::deletePlayerScore($playerId);
            mysql_query($strQuery, $dbResource);
            $couldDeletePlayerScore = 'true';
        }
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $couldDeletePlayerScore;
    }

    // Player progress's CRUD
    public static function savePlayerProgress($playerName, $levelName) {
        $couldSavePlayerProgress = 'false';
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        if (PactoDBQuery::playerExist($playerName, $dbResource) &&
            PactoDBQuery::levelExist($levelName, $dbResource)) {
            $playerId = PactoDBQuery::getPlayerId($playerName, $dbResource);
            $levelId = PactoDBQuery::getLevelId($levelName, $dbResource);
            if (PactoDBQuery::playerProgressExist($playerId, $dbResource))
                $strQuery = PactoSQLQueryParser::updatePlayerProgress($playerId, $levelId);
            else
                $strQuery = PactoSQLQueryParser::insertPlayerProgress($playerId, $levelId);
            mysql_query($strQuery, $dbResource);
            $couldSavePlayerProgress = 'true';
        }
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $couldSavePlayerProgress;
    }

    public static function getPlayerProgress($playerName){
        $playerProgress = 'false';
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        if (PactoDBQuery::playerExist($playerName,$dbResource)) {
            $strQuery = PactoSQLQueryParser::selectPlayerProgressByName($playerName);
            $queryResult = mysql_query($strQuery, $dbResource);
            $numResults = mysql_num_rows($queryResult);
            if ($numResults > 0) {
                $playerProgressRow = mysql_fetch_row($queryResult);
                $playerProgress = $playerProgressRow[0];
            }
        }
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $playerProgress;
    }

    public static function deletePlayerProgress($playerName) {
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        $strQuery = PactoSQLQueryParser::deletePlayerProgress($playerName);
        mysql_query($strQuery, $dbResource);
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return 'true';
    }

    // Scores
    public static function getScoresByLevel($levelName){
        $scores = 'false';
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        if (PactoDBQuery::levelExist($levelName, $dbResource)){
            $levelId = PactoDBQuery::getLevelId($levelName, $dbResource);
            $strQuery = PactoSQLQueryParser::selectScoresByLevel($levelId);
            $scores = mysql_query($strQuery, $dbResource);
        }
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $scores;
    }

    public static function getScoresByLevelFromLastWeek($levelName){
        $scores = 'false';
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        if (PactoDBQuery::levelExist($levelName, $dbResource)){
            $endDate = PactoDBQuery::getTimeStamp();
            $startDate = PactoDBQuery::getLastWeekTimeStamp();
            $levelId = PactoDBQuery::getLevelId($levelName, $dbResource);
            $strQuery = PactoSQLQueryParser::selectScoresByLevelBetweenDates($levelId, $startDate, $endDate);
            $scores = mysql_query($strQuery, $dbResource);
        }
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $scores;
    }

    public static function getTopScoresFromEachLevel() {
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        $strQuery = PactoSQLQueryParser::selectTopScoresFromEachLevel();
        $scores = mysql_query($strQuery, $dbResource);
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $scores;
    }

    public static function selectTopScoresFromEachLevelFromLastWeek() {
        $endDate = PactoDBQuery::getTimeStamp();
        $startDate = PactoDBQuery::getLastWeekTimeStamp();
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        $strQuery = PactoSQLQueryParser::selectTopScoresFromEachLevelBetweenDates($startDate, $endDate);
        $scores = mysql_query($strQuery, $dbResource);
        PactoDBQuery::closeDatabaseConnection($dbResource);
        return $scores;
    }

    // Util
    private static function playerProgressExist($playerId, $dbResource) {
        $playerExist = false;
        $strQuery = PactoSQLQueryParser::selectPlayerProgress($playerId);
        $queryResult = mysql_query($strQuery, $dbResource);
        $numResults = mysql_num_rows($queryResult);
        if ($numResults > 0) {
            $playerExist = true;
        }
        return $playerExist;
    }

    private static function playerExist($playerName, $dbResource) {
        $playerExist = false;
        $strQuery = PactoSQLQueryParser::selectPlayerByName($playerName);
        $queryResult = mysql_query($strQuery, $dbResource);
        $numResults = mysql_num_rows($queryResult);
        if ($numResults > 0) {
            $playerExist = true;
        }
        return $playerExist;
    }

    private static function levelExist($levelName, $dbResource) {
        $levelExist = false;
        $strQuery = PactoSQLQueryParser::selectLevelByName($levelName, $dbResource);
        $queryResult = mysql_query($strQuery, $dbResource);
        $numResults = mysql_num_rows($queryResult);
        if ($numResults > 0) {
            $levelExist = true;
        }
        return $levelExist;
    }

    private static function scoreExist($playerId, $levelId, $dbResource) {
        $scoreExist = false;
        $strQuery = PactoSQLQueryParser::selectPlayerScore($playerId, $levelId);
        $queryResult = mysql_query($strQuery, $dbResource);
        $numResults = mysql_num_rows($queryResult);
        if ($numResults > 0) {
            $scoreExist = true;
        }
        return $scoreExist;
    }

    private static function getPlayerId($playerName, $dbResource=null) {
        $playerId = null;
        $getPlayerQueryResult = PactoDBQuery::getPlayer($playerName, $dbResource);
        $numResults = mysql_num_rows($getPlayerQueryResult);
        if ($numResults > 0) {
            $playerRow = mysql_fetch_row($getPlayerQueryResult);
            $playerId = $playerRow[0];
        }
        return $playerId;
    }

    private static function getLevelId($levelName, $dbResource=null) {
        $levelId = null;
        $getLevelQueryResult = PactoDBQuery::getLevelByName($levelName, $dbResource);
        $numResults = mysql_num_rows($getLevelQueryResult);
        if ($numResults > 0) {
            $levelRow = mysql_fetch_row($getLevelQueryResult);
            $levelId = $levelRow[0];
        }
        return $levelId;
    }

    private static function getLevelByName($levelName, $dbResource=null) {
        if ($dbResource==null)
            $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        $strQuery = PactoSQLQueryParser::selectLevelByName($levelName);
        $queryResult = mysql_query($strQuery, $dbResource);
        if ($dbResource==null)
            PactoDBQuery::closeDatabaseConnection($dbResource);
        return $queryResult;
    }

    private static function getLastWeekTimeStamp() {
        $timeStamp = time();
        $timeStamp -= (7 * 24 * 60 * 60);
        $format = "Y-m-d G:i:s";
        return date($format, $timeStamp);
    }

    private static function getTimeStamp() {
        $timeStamp = time();
        $format = "Y-m-d G:i:s";
        return date($format, $timeStamp);
    }
}