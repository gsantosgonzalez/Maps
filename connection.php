<?php
require("credentials.php");

// Start XML file, create parent node
$doc = new DOMDocument ("1.0");
$node = $doc->createElement("markers");
$parnode = $doc->appendChild($node);

// Opens a connection to a MySQL server
$connection=mysqli_connect ('localhost', $username, $password, $database);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}


// Select all the rows in the markers table
$query = "SELECT * FROM markers WHERE 1";
$result = $connection->query($query, MYSQLI_STORE_RESULT);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = mysqli_fetch_assoc($result)){
  // Add to XML document node
  $node = $doc->createElement("marker");
  $newnode = $parnode->appendChild($node);

  $newnode->setAttribute("name", $row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", $row['type']);
}

echo $doc->saveXML();

?>