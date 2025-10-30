<?php
   include __DIR__ . "/../connector/connection.php";
   //$path = $_SERVER['DOCUMENT_ROOT'];
   //$path .= "/customer/postgres/connection.php";
   //include_once($path);

// Connect to database

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

// Fetch students
//$query = "SELECT * FROM student ORDER BY id ASC";
$query = "SELECT * FROM lpg_cylinder_basic_data";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>LPG Cylinder Basic Data</title>
</head>
<body>
     <img src="/customer/logos/makeen_logo.png" alt="MAKEEN ENERGY LOGO"
    width="350" 
    height="100"> 
    <h1>LPG Cylinder Basic Data</h1>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Tag</th>
            <th>Qr Code</th>
            <th>Serial</th>
            <th>Brand</th>
            <th>Production Year</th>
            <th>Inspection Year</th>
            <th>Tare</th>
            <th>Net</th>
            <th>Type</th>
            <th>Gas</th>
            <th>Valve</th>
            <th>Owner</th>
            <th>Device</th>
            <th>Operator</th>
        </tr>

        <?php
        if (pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['time']}</td>
                        <td>{$row['tag']}</td>
                        <td>{$row['qrcode']}</td>
                        <td>{$row['serial']}</td>
                        <td>{$row['brand']}</td>
                        <td>{$row['year']}</td>
                        <td>{$row['year_insp']}</td>
                        <td>{$row['tare']}</td>
                        <td>{$row['net']}</td>
                        <td>{$row['type']}</td>
                        <td>{$row['gas']}</td>
                        <td>{$row['valve']}</td>
                        <td>{$row['owner']}</td>
                        <td>{$row['device']}</td>
                        <td>{$row['operator']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No LPG cylinders found.</td></tr>";
        }

        pg_close($conn);
        ?>
    </table>
    <br>
    <a href="cyl_add.html">← Add New LPG Cylinder</a>
</body>
</html>