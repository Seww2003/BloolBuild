<?php
require 'vendor/autoload.php'; // MongoDB library

$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->BloomBuild; // your database name
$adminCollection = $db->Admins; // your collection name
?>
