<?php

header('Access-Control-Allow-Origin: *');

/**
 * @SWG\Info(title="My First API", version="0.1")
 */

require_once 'lib/limonade.php';


function before()
{
header('Content-Type: application/json');
}



/**
 * @SWG\Get(
 *     path="/helios",
 *     @SWG\Response(response="404", description="Nie ma takiego elementu")
 * )
 */
dispatch_get('/:nazwa', function ()
    {


       $nazwa = params('nazwa');
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

$query = new MongoDB\Driver\Query([]);

$cursor = $manager->executeQuery("Kina.$nazwa",$query);



$myJSON = json($cursor->toArray());

echo $myJSON;
    }
);
/**
 * @SWG\Get(
 *     path="/helios/{ulica}",
 *     @SWG\Response(response="200", description="Pobrano elementy")
 * )
 */
dispatch_get('/:nazwa/:miasto', function ()
    {
       $nazwa = params('nazwa');
       $miasto = params('miasto');
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

$query = new MongoDB\Driver\Query(array('ulica'=>$miasto));

$cursor = $manager->executeQuery("Kina.$nazwa",$query);



$myJSON = json($cursor->toArray()[0]);

echo $myJSON;



    }
);



/**
 * @SWG\Post(
 *     path="/helios",
 *     @SWG\Response(response="200", description="Nie dziala :(")
 * )
 */
dispatch_post('/:nazwa', function ()
    {

/*
if (($_SERVER['PHP_AUTH_USER']!='admin')||($_SERVER['PHP_AUTH_PW']!='admin'))
 {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    exit;
}

*/


  $hed = apache_request_headers();

if(empty($hed['Authorization'])){
exit;
}
else{

$klucz = explode(" ",$hed['Authorization']);
if($klucz[1]!="abc")
exit;
}

       $nazwa = params('nazwa');



$bulk = new MongoDB\Driver\BulkWrite;


$obj = file_get_contents("php://input", "r");




$tresc=json_decode($obj,true);



$_id1 = $bulk->insert($tresc);





$manager = new MongoDB\Driver\Manager('mongodb://localhost:27017');
$result = $manager->executeBulkWrite("Kina.$nazwa", $bulk);



    }
);
    

/**
 * @SWG\Put(
 *     path="/helios/{ulica}",
 *     @SWG\Response(response="200", description="Zmieniono")
 * )
 */

dispatch_put('/:nazwa/:miasto', function ()
    {




  $hed = apache_request_headers();

if(empty($hed['Authorization'])){
exit;
}
else{

$klucz = explode(" ",$hed['Authorization']);
if($klucz[1]!="abc")
exit;
}
   
       $nazwa = params('nazwa');
       $miasto = params('miasto');


 
        $string=file_get_contents("php://input");
  $tresc=json_decode($string,true);
        $bulk = new MongoDB\Driver\BulkWrite;

        $bulk->update(['ulica'=>$miasto],
                      ['$set' => $tresc],
                      ['multi' => true]);
 
        $manager = new MongoDB\Driver\Manager('mongodb://localhost:27017');
        $result = $manager->executeBulkWrite("Kina.$nazwa", $bulk);



    }
);

/**
 * @SWG\Delete(
 *     path="/helios",
 *     @SWG\Response(response="204", description="Nie dziala :(")
 * )
 */
dispatch_delete('/:nazwa', function ()
    {


  $hed = apache_request_headers();

if(empty($hed['Authorization'])){
exit;
}
else{

$klucz = explode(" ",$hed['Authorization']);
if($klucz[1]!="abc")
exit;
}

       $nazwa = params('nazwa');
        echo "DELETE $nazwa";
    }
);

/**
 * @SWG\Delete(
 *     path="/helios/{ulica}",
 *     @SWG\Response(response="204", description="Usuniecie kina z ulicy")
 * )
 */
dispatch_delete('/:nazwa/:miasto', function ()
    {


  $hed = apache_request_headers();

if(empty($hed['Authorization'])){
exit;
}
else{

$klucz = explode(" ",$hed['Authorization']);
if($klucz[1]!="abc")
exit;
}

       $nazwa = params('nazwa');
       $miasto = params('miasto');


$bulk = new MongoDB\Driver\BulkWrite;
$bulk->delete(['ulica' => $miasto]);

$manager = new MongoDB\Driver\Manager('mongodb://localhost:27017');
$result = $manager->executeBulkWrite("Kina.$nazwa", $bulk);




    }
);



run();

?>
