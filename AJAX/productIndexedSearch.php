<?php
//Include libraries
require __DIR__ . '/../vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->Qwerty;

//Extract the data that was sent to the server
$search_string = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

//Create a PHP array with the search criterion
$findCriteria = [
    '$text' => [ '$search' => $search_string ] 
 ];

//Find all shirts that match  this criteria
$cursor = $db->Shirts->find($findCriteria);

//Initialise the JSON string
$jsonStr = '['; 

//Format the response into a JSON readable in JavaScript
foreach ($cursor as $shirt){

    $jsonStr .= '{"_id" : "'. $shirt['_id'] .'", "shirtName" : "'. $shirt['shirtName'] .'","colour" : "'. $shirt['colour'] .'","price" : '. $shirt['price'] .',"stockQuantity" : '. $shirt['stockQuantity'] .',"description" : "'. $shirt['description'] .'","img" : "'. $shirt['img'] .'"},';
}

//Remove last comma
$jsonStr = substr($jsonStr, 0, strlen($jsonStr) - 1);

//Close array
$jsonStr .= ']';