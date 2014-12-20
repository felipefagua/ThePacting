<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 19/12/2014
 * Time: 11:00
 */

$options = array("location" => "http://localhost/thepacting/pactows/pactoserver.php",
    "uri" => "http://localhost");
// Create player test
try {
    $client = new SoapClient(null, $options);
    $players = $client->createPlayer("Felipe", "Felipe");
    var_dump($players);
} catch (SoapFault $soapEx){
    var_dump($soapEx);
}

// Get players test
/*try {
    $client = new SoapClient(null, $options);
    $players = $client->getPlayersList();
    var_dump($players);
} catch (SoapFault $soapEx){
    var_dump($soapEx);
}*/