<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 19/12/2014
 * Time: 11:25
 */

$db_server = mysql_connect('localhost','pactoadmin','pactoadmin');
mysql_select_db('el_pacto_game');
$result = mysql_query('SELECT * FROM players;',$db_server);
mysql_close($db_server);

if (!$result) {
    echo mysql_error();
} else {
    echo mysql_num_rows($result);
}


if (!$db_server)
    die("Unable to connect to MySQL: " . mysql_error());