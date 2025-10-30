<?php
include __DIR__ . "/../connector/connection.php";

// Get POST data
$qrcode = $_GET['id'];
$page1 = '../cyl/index.html';
$page2 = '../pal/index.html';
$page3 = '../cyl/cyl_qr_found.html?id=';
$page4 = '../cyl/cyl_qr_exists.html';
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

    $first_character = $qrcode[0];


        if ($first_character == 'A') {
            
            $sql = "SELECT EXISTS (SELECT 1 FROM lpg_cylinder_basic_data WHERE qrcode = :value)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':value' => $qrcode]);
            $exists = $stmt->fetchColumn();
       
            if ($exists) {

               header('Location: ' .$page4); 
                
            } else{

            //header('Location: ' .$page1);
            header("location: " . $page3. urlencode($currentUrl));
            }
            
        }else {

            if ($first_character == 'P') {
            header('Location: ' .$page2);
            
                 
            }
            else {
            echo "⚠️ Qr code not valide or already in list. ⚠️";
             }}
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
pg_close($conn);







