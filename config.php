<?php 
//db credentials
$host = 'localhost';
$dbname = 'ilpxeexw_wifi_portal';
$username = 'ilpxeexw_admin';
$password = 'Techsolkamaa@1989';

try {
 //new PDO connection
 $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password );
 
 //setting the PDO error mode tp exception
 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 // Optionally set the default fetch mode to associative array
 $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // if the conn. fails, output the error
    echo "Connection failed: " . $e->getMessage();
    die(); //ending further execution if the db conn. fails
}
?>