<?php
// config.php - Konfigurasi Database

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'cinescope');

// Fungsi untuk koneksi database
function getDBConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            throw new Exception("Koneksi database gagal: " . $conn->connect_error);
        }
        
        $conn->set_charset("utf8mb4");
        return $conn;
        
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

// Fungsi helper untuk sanitasi input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk menghitung rata-rata rating film
function calculateAverageRating($conn, $movie_id) {
    $stmt = $conn->prepare("SELECT AVG(rating) as avg_rating FROM user_reviews WHERE movie_id = ?");
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    return $row['avg_rating'] ? round($row['avg_rating'], 1) : 0;
}
?>