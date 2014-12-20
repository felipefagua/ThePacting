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

    private static function GetDatabaseConnection() {
        $dbResource = mysql_connect(PactoDBQuery::$databaseHost,PactoDBQuery::$databaseUsername,PactoDBQuery::$databaseUserPassword);

        if (!$dbResource)
            $dbResource = null;

        return $dbResource;
    }

    private static function CloseDatabaseConnection($dbResource) {
        if ($dbResource != null)
            mysql_close($dbResource);

        return $dbResource;
    }

    // CRUD Player
    public static function CreatePlayer($playerName, $playerPassword) {
        $response = false;
        $dbResource = PactoDBQuery::GetDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        $strQuery = PactoSQLQueryParser::SelectPlayerByName($playerName);
        $queryResult = mysql_query($strQuery, $dbResource);
        $numResults = mysql_num_rows($queryResult);
        if ($numResults==0)
        {
            $strQuery = PactoSQLQueryParser::InsertPlayer($playerName,$playerPassword);
            mysql_query($strQuery, $dbResource);
            $response = true;
        }
        PactoDBQuery::CloseDatabaseConnection($dbResource);
        return $response;
    }

    public static function GetPlayer($playerName) {
        $dbResource = PactoDBQuery::GetDatabaseConnection();
        $strQuery = PactoSQLQueryParser::SelectPlayerByName($playerName);
        $queryResult = $dbResource->query($strQuery);
        PactoDBQuery::CloseDatabaseConnection($dbResource);
        return $queryResult;
    }

    public static function GetPlayersList() {
        $dbResource = PactoDBQuery::GetDatabaseConnection();
        mysql_select_db(PactoDBQuery::$databaseName);
        $queryResult = null;
        if ($dbResource != null) {
            $strQuery = PactoSQLQueryParser::SelectPlayers();
            $queryResult = mysql_query($strQuery, $dbResource);
        }
        //PactoDBQuery::CloseDatabaseConnection($dbResource);
        return $queryResult;
    }

    public static function UpdatePlayer($playerName, $newPlayerName, $newPlayerPassword) {
        $response = 'false';
        $dbResource = PactoDBQuery::GetDatabaseConnection();
        $strQuery = PactoSQLQueryParser::SelectPlayerByName($playerName);
        $queryResult = $dbResource->query($strQuery);
        $numResults = $queryResult->num_rows;
        if ($numResults>0)
        {
            $strQuery = PactoSQLQueryParser::UpdatePlayer($playerName, $newPlayerName, $newPlayerPassword);
            $dbResource->query($strQuery);
            $response = 'true';
        }
        PactoDBQuery::CloseDatabaseConnection($dbResource);
        return $response;
    }

    public static function DeletePlayer($playerName) {
        $response = 'false';
        $dbResource = PactoDBQuery::GetDatabaseConnection();
        $strQuery = PactoSQLQueryParser::SelectPlayerByName($playerName);
        $queryResult = $dbResource->query($strQuery);
        $numResults = $queryResult->num_rows;
        if ($numResults>0)
        {
            $strQuery = PactoSQLQueryParser::DeletePlayer($playerName);
            $dbResource->query($strQuery);
            $response = 'true';
        }
        PactoDBQuery::CloseDatabaseConnection($dbResource);
        return $response;
    }
}