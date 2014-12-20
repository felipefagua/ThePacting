<?php header('Content-type: application/json'); header('Access-Control-Allow-Origin: *'); header('Access-Control-Allow-Methods: GETPLAYERSLIST');

/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 19/12/2014
 * Time: 9:09
 */

require("PactoLib.php");

$options = array("uri" => "*");

$server = new SoapServer(null, $options);
$server->setClass('PactoLib');
$server->handle();