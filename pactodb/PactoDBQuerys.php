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

    public static function getPlayer($playerName) {
        $dbResource = PactoDBQuery::getDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        $strQuery = PactoSQLQueryParser::selectPlayerByName($playerName);
        $queryResult = mysql_query($strQuery, $dbResource);
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

    private static function playerExist($playerName, $dbResource) {
        $response = false;
        $strQuery = PactoSQLQueryParser::selectPlayerByName($playerName);
        $queryResult = mysql_query($strQuery, $dbResource);
        $numResults = mysql_num_rows($queryResult);
        if ($numResults > 0) {
            $response = true;
        }

        return $response;
    }

    public static function savePlayerScore($playerName, $level, $score) {
        // Seleccionar el jugador
        // Seleccionar el id de la fila
        // Crear la fecha? MySQL o PHP?
        // Crear el registro
    }
}