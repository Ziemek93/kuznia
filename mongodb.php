<?php


$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

$query = new MongoDB\Driver\Query(array('ulica'=>"Kopernika"));

$cursor = $manager->executeQuery('kina.helios',$query);

print_r($cursor->toArray());

?>
