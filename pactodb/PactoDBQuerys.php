<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 13/12/2014
 * Time: 10:25
 */

class PactoDBQuery {
    private static $databaseHost = 'localhost';
    private static $databaseName = 'el_pacto_game';
    private static $databaseUsername = 'pactoadmin';
    private static $databaseUserPassword = 'pactoadmin';

    private static function GetDatabaseConnection() {
        $dbResource = mysqli_connect(PactoDBQuery::$databaseHost, PactoDBQuery::$databaseUsername, PactoDBQuery::$databaseUserPassword, PactoDBQuery::$databaseName);

        if (!$dbResource)
            $dbResource = null;
        
        return $dbResource;
    }

    private static function CloseDatabaseConnection($dbResource) {
        if ($dbResource != null)
            mysql_close($dbResource);

        return $dbResource;
    }

    private static function SelectPlayerByName($playerName) {
        $dbResource = PactoDBQuery::GetDatabaseConnection();

        PactoDBQuery::CloseDatabaseConnection($dbResource);
    }

}