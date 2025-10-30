<!DOCTYPE html>
<html>
<head>
    <title>LPG Cylinder Basic Data</title>
</head>
<body>
     <img src="/customer/logos/makeen_logo.png" alt="MAKEEN ENERGY LOGO"
    width="350" 
    height="100"> 
    <p></p>
    <p></p>
    </body>
</html>

<?php
include __DIR__ . "/../connector/connection.php";
//$path = $_SERVER['DOCUMENT_ROOT'];
//$path .= "/customer/postgres/connection.php";
//include_once($path);

// Connect to PostgreSQL
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

$page1 = '../cyl/cyl_qr_exists.html';

// Get POST data
$tag = $_POST['tag'];
$qrcode = $_POST['qrcode'];
$serial = $_POST['serial'];
$brand = $_POST['brand'];
$year = $_POST['year'];
$year_insp = $_POST['year_insp'];
$tare = $_POST['tare'];
$net = $_POST['net'];
$type = $_POST['type'];
$gas = $_POST['gas'];
$valve = $_POST['valve'];
$owner = $_POST['owner'];
$device = $_POST['device'];
$operator = $_POST['operator'];

// Insert data securely
$query = "INSERT INTO lpg_cylinder_basic_data (tag, qrcode, serial, brand, year, year_insp, tare, net, type, gas, valve, owner, device, operator) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14)";
$result = pg_query_params($conn, $query, array($tag, $qrcode, $serial, $brand, $year, $year_insp, $tare, $net, $type, $gas, $valve, $owner, $device, $operator));

if ($result) {
    echo "✅ LPg cylinder added successfully.<br><br>";
    echo '<a href="cyl_add.html">Add Another LPG Cylinder</a><br>';
    echo '<a href="cyl_list.php">View All LPG Cylinders</a>';
    die() ;
} else {
    header('Location: '.$page1) ;
    //echo "❌ Error: " . pg_last_error($conn);
   die() ;
    
}
pg_close($conn);
?>