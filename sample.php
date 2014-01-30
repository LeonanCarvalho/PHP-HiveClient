<?php
set_time_limit(0); 
// set THRIFT_ROOT to php directory of the hive distribution
$GLOBALS['THRIFT_ROOT'] = 'lib/hive';
// load the required files for connecting to Hive
require_once $GLOBALS['THRIFT_ROOT'] . '/packages/hive_service/ThriftHive.php';
require_once $GLOBALS['THRIFT_ROOT'] . '/transport/TSocket.php';
require_once $GLOBALS['THRIFT_ROOT'] . '/transport/TBufferedTransport.php';
require_once $GLOBALS['THRIFT_ROOT'] . '/protocol/TBinaryProtocol.php';

// Set up the transport/buffer/protocol/client
try{
$transport = new TSocket('130.206.80.46', 10000);
$buffer = new TBufferedTransport($transport, 1024, 1024);
$protocol = new TBinaryProtocol($buffer);
$client = new ThriftHiveClient($protocol);

$buffer->open();

// run queries, metadata calls etc
$client->execute("select column1,column2,otherColumns " .
                 "from mytable where column1='whatever' and columns2 like '%whatever%'");

//Fetching all result:
$rows = $client->fetchAll();

//May you want to perform an fetchOne(), whatever.
//$client->fetchOne();


 // iterate on the result
foreach ($rows as $row) {
    //Spliting by tab(returns a tsv like row) to array.
    $row = preg_split('/\s+/',$value);
    
    // Do whatever you want to do with this row, here
  
}

$buffer->close();
$transport->close();
}catch(Exception $e){
    echo  "Code: " . $e->getCode();
    echo  "Message:" . $e->getMessage();
    
    echo "<pre>";
        echo $e->getTrace();
    echo "</pre><br>";
    die();
}