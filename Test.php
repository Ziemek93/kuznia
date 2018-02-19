<?php

//Klasa Manager

$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
 
 //Klasa Query
 
 $query = new MongoDB\Driver\Query(array('ulica' => "Nic smiesznego"));
 
 //Kursor Wyjscie
 
 $cursor = $manager->executeQuery('Kina.helios', $query);
 
 //konwersja kursora do tablicy i jej wypisanie
 
 print_r($cursor->toArray());

?>