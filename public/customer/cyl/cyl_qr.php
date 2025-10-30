<?php
// Database connection info
//$dsn = "pgsql:host=localhost;port=5432;dbname=webapp;";
//$user = "postgres";      // <- change this
//$password = "testepr001";  // <- change this
include __DIR__ . "/../connector/connection.php";
 //$path = $_SERVER['DOCUMENT_ROOT'];
 //$path .= "/customer/postgres/connection.php";
 //include_once($path);


// Get POST data
$qrcode = $_GET['id'];
$page1 = '../cyl/cyl_qr_found.html';
$page2 = '../cyl/cyl_qr_exists.html';
var_dump($qrcode);


function getCurrentUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];           
    $requestUri = $_SERVER['REQUEST_URI'];   
    return $protocol . "://" . $host . $requestUri;
}


$currentUrl = getCurrentUrl();
//echo "The current file URL is: " . $currentUrl;

try {
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Value to check (for example, from URL)
    $qrcode = $_GET['id'] ?? null;

    if ($qrcode !== null) {
        // Check if value exists in the column
        $sql = "SELECT EXISTS (SELECT 1 FROM lpg_cylinder_basic_data WHERE qrcode = :value)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':value' => $qrcode]);

        $exists = $stmt->fetchColumn();

        if ($exists) {
            header('Location: ' .$page2);
                    
            // echo "✅ The value '$qrcode' exists.";
        } else {
            header("Location: cyl_qr_found.html?id=" . urlencode($currentUrl));
            
            //header('Location: ' .$page1);
            //echo "❌ The value '$qrcode' does not exist.";
        }
    } else {
        echo "⚠️ Qr code not valide.";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
pg_close($conn);
?>

