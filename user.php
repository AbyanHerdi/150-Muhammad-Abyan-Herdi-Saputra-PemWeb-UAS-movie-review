<?php
// File: user.php (FIXED VERSION - Pure Database Only)
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Database Configuration
$host = '127.0.0.1';
$dbname = 'movie_review_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("❌ Database Connection Error: " . $e->getMessage());
}

// Login check
$isLoggedIn = isset($_SESSION['user_id']);
$currentUserName = $_SESSION['username'] ?? 'Guest';

// Cek jika baru login (untuk popup)
$loginSuccess = isset($_GET['login_success']) ? htmlspecialchars($_GET['login_success']) : null;

// Upload Poster (FIXED)
if (isset($_POST['uploadPoster'])) {
    $movieId = $_POST['movie_id'];
    $posterFile = $_FILES['poster'];

    $uploadDir = __DIR__ . "/uploads/posters/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = "poster_" . $movieId . "_" . time() . "_" . basename($posterFile['name']);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($posterFile['tmp_name'], $filePath)) {
        $dbPath = "uploads/posters/" . $fileName;
        
        $updateStmt = $pdo->prepare("UPDATE movies SET poster = ?, updated_at = NOW() WHERE id = ?");
        $updateStmt->execute(array($dbPath, $movieId));
        
        $movieStmt = $pdo->prepare("SELECT title FROM movies WHERE id = ?");
        $movieStmt->execute(array($movieId));
        $movieData = $movieStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($movieData) {
            $baseTitle = getBaseMovieTitle($movieData['title']);
            $allMoviesStmt = $pdo->query("SELECT id, title FROM movies");
            $allMovies = $allMoviesStmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($allMovies as $movie) {
                if ($movie['id'] == $movieId) continue;
                if ($baseTitle === getBaseMovieTitle($movie['title'])) {
                    $syncStmt = $pdo->prepare("UPDATE movies SET poster = ?, updated_at = NOW() WHERE id = ?");
                    $syncStmt->execute(array($dbPath, $movie['id']));
                }
            }
        }
        
        echo "<script>alert('✅ Poster berhasil diupload dan di-sync!');</script>";
    } else {
        echo "<script>alert('❌ Upload gagal!');</script>";
    }
}

// Helper function for base title
function getBaseMovieTitle($title) {
    $baseTitle = preg_replace('/\s*\d{4}\s*/', ' ', $title);
    $baseTitle = preg_split('/[:\-–—]/', $baseTitle);
    $baseTitle = $baseTitle[0];
    $baseTitle = preg_replace('/\s*(part|bagian|episode|ep)?\s*\d+\s*$/i', '', $baseTitle);
    return strtolower(trim($baseTitle));
}

// Helper function for poster
function getPosterPath($posterFromDB) {
    if (empty($posterFromDB)) {
        return null;
    }
    
    $possiblePaths = array(
        __DIR__ . '/' . $posterFromDB,
        $posterFromDB,
    );
    
    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            return $posterFromDB;
        }
    }
    
    return null;
}

// 🔥 FIXED: Top 3 Trending - Rating tertinggi dengan ulasan terbanyak
$trendingStmt = $pdo->query("
    SELECT m.*, 
           COALESCE(AVG(r.rating), 0) as avg_rating, 
           COUNT(r.id) as review_count
    FROM movies m
    LEFT JOIN reviews r ON m.id = r.movie_id
    WHERE m.id <= 6
    GROUP BY m.id
    HAVING review_count > 0
    ORDER BY avg_rating DESC, review_count DESC
    LIMIT 3
");
$trendingMovies = $trendingStmt->fetchAll(PDO::FETCH_ASSOC);

// Get IDs dari trending movies untuk exclude dari rekomendasi
$trendingIds = array_column($trendingMovies, 'id');
$excludeIds = !empty($trendingIds) ? implode(',', $trendingIds) : '0';

// FIXED: Rekomendasi (3 film terbaik yang TIDAK masuk trending, hanya dari ID 1-6)
$recommendedStmt = $pdo->query("
    SELECT m.*, 
           COALESCE(AVG(r.rating), 0) as avg_rating, 
           COUNT(r.id) as review_count
    FROM movies m
    LEFT JOIN reviews r ON m.id = r.movie_id
    WHERE m.id <= 6 
    AND m.id NOT IN ($excludeIds)
    GROUP BY m.id
    ORDER BY avg_rating DESC, review_count DESC
    LIMIT 3
");
$recommendedMovies = $recommendedStmt->fetchAll(PDO::FETCH_ASSOC);

// Coming Soon (ID > 6)
$newMoviesStmt = $pdo->query("
    SELECT m.*, 
           COALESCE(AVG(r.rating), 0) as avg_rating, 
           COUNT(r.id) as review_count
    FROM movies m
    LEFT JOIN reviews r ON m.id = r.movie_id
    WHERE m.id > 6
    GROUP BY m.id
    ORDER BY m.id DESC
");
$newMovies = $newMoviesStmt->fetchAll(PDO::FETCH_ASSOC);

// FIXED: Generate link film
function generateMovieCardLink($movie) {
    $titleLower = strtolower($movie['title']);
    
    if (strpos($titleLower, 'dilan') !== false) {
        return 'dilan 1990.php';
    }
    
    $movieLinks = array(
        1 => 'film.sore.php',
        2 => 'Petaka Gunung Gede.php',
        3 => 'dilan 1990.php',
        4 => 'rest area.php',
        5 => 'tukar takdir.php',
        6 => 'rangga & cinta.php'
    );
    return isset($movieLinks[$movie['id']]) ? $movieLinks[$movie['id']] : '#';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineScope - Movie Review Community</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    line-height: 1.6;
    background-color: #0a0a0a;
    color: #ffffff;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.navbar {
    background-color: #111;
    padding: 1rem 0;
    position: sticky;
    top: 0;
    z-index: 1000;
    border-bottom: 1px solid #333;
}

.nav-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-brand h1 {
    color: #e50914;
    font-size: 1.8rem;
    font-weight: 700;
}

.nav-search {
    display: flex;
    align-items: center;
    flex: 1;
    max-width: 400px;
    margin: 0 2rem;
}

.search-input {
    flex: 1;
    padding: 0.8rem 1rem;
    border: 1px solid #333;
    border-radius: 4px 0 0 4px;
    background-color: #1a1a1a;
    color: white;
    font-size: 0.9rem;
}

.search-btn {
    padding: 0.8rem 1rem;
    background-color: #e50914;
    border: none;
    border-radius: 0 4px 4px 0;
    color: white;
    cursor: pointer;
}

.nav-menu {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.nav-link {
    color: #ccc;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: #e50914;
}

.nav-btn {
    background-color: #e50914;
    color: #ffffff;
    padding: 0.6rem 1.2rem;
    border: none;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.nav-btn:hover {
    background-color: #b8070f;
    transform: translateY(-2px);
}

.section {
    padding: 4rem 0;
}

.section-title {
    font-size: 2rem;
    margin-bottom: 2rem;
    color: white;
    text-align: center;
}

.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.movie-card {
    background-color: #1a1a1a;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
}

.movie-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(229, 9, 20, 0.3);
}

.movie-card a {
    display: block;
    position: relative;
    padding-top: 150%;
    overflow: hidden;
}

.movie-poster {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.movie-info {
    padding: 1rem;
}

.movie-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: white;
}

.movie-genre {
    color: #999;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.movie-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    color: #ffc107;
    font-weight: 600;
}

.trending-badge, .new-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgba(229, 9, 20, 0.9);
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 10;
}

.empty-section {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.empty-section i {
    font-size: 4em;
    margin-bottom: 20px;
    color: #333;
}

.empty-section h3 {
    font-size: 1.5em;
    margin-bottom: 10px;
    color: #999;
}

.empty-section p {
    color: #666;
}

.footer {
    background-color: #111;
    padding: 3rem 0 1rem;
    margin-top: 4rem;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.footer-section h4 {
    color: #e50914;
    margin-bottom: 1rem;
    font-size: 1.2rem;
}

.footer-section p {
    color: #ccc;
    line-height: 1.6;
}

.footer-section a {
    display: block;
    color: #ccc;
    text-decoration: none;
    margin-bottom: 0.5rem;
    transition: color 0.3s ease;
}

.footer-section a:hover {
    color: #e50914;
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-links a {
    font-size: 1.5rem;
}

.footer-bottom {
    border-top: 1px solid #333;
    padding-top: 1rem;
    text-align: center;
    color: #888;
}

.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    padding: 40px;
    border-radius: 15px;
    text-align: center;
    max-width: 400px;
    box-shadow: 0 10px 50px rgba(229, 9, 20, 0.5);
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal-content i {
    font-size: 4em;
    color: #e50914;
    margin-bottom: 20px;
}

.modal-content h3 {
    font-size: 1.8em;
    margin-bottom: 15px;
    color: #fff;
}

.modal-content p {
    color: #ccc;
    font-size: 1.1em;
    margin-bottom: 25px;
}

.modal-close-btn {
    background: #e50914;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 5px;
    font-size: 1em;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease;
}

.modal-close-btn:hover {
    background: #b8070f;
}

@media (max-width: 768px) {
    .nav-container {
        flex-direction: column;
        gap: 1rem;
    }

    .nav-search {
        margin: 1rem 0;
        max-width: 100%;
    }

    .movies-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }

    .footer-content {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .social-links {
        justify-content: center;
    }
}

.login-success-popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    padding: 40px 60px;
    border-radius: 15px;
    box-shadow: 0 10px 50px rgba(229, 9, 20, 0.5);
    z-index: 9999;
    text-align: center;
    border: 2px solid #e50914;
    animation: popupSlideIn 0.5s ease;
    display: none;
}

@keyframes popupSlideIn {
    from {
        transform: translate(-50%, -60%);
        opacity: 0;
    }
    to {
        transform: translate(-50%, -50%);
        opacity: 1;
    }
}

@keyframes popupSlideOut {
    from {
        transform: translate(-50%, -50%);
        opacity: 1;
    }
    to {
        transform: translate(-50%, -40%);
        opacity: 0;
    }
}

.login-success-popup.hide {
    animation: popupSlideOut 0.5s ease forwards;
}

.login-success-popup i {
    font-size: 4em;
    color: #00ff40ff;
    margin-bottom: 20px;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.login-success-popup h2 {
    font-size: 2em;
    margin-bottom: 10px;
    color: #e50914;
}

.login-success-popup p {
    font-size: 1.2em;
    color: #ccc;
}

.login-success-popup .username {
    color: #fff;
    font-weight: 700;
    font-size: 1.4em;
}

.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    z-index: 9998;
    display: none;
}

    </style>
</head>
<body>

<?php if ($loginSuccess): ?>
<div class="popup-overlay" id="popupOverlay"></div>
<div class="login-success-popup" id="loginSuccessPopup">
    <i class="fas fa-check-circle"></i>
    <h2>SELAMAT DATANG</h2>
    <p class="username"><?php echo $loginSuccess; ?></p>
    <p style="margin-top: 10px; font-size: 0.9em; color: #999;">Login berhasil! 🎉</p>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const popup = document.getElementById('loginSuccessPopup');
        const overlay = document.getElementById('popupOverlay');
        
        popup.style.display = 'block';
        overlay.style.display = 'block';

        setTimeout(() => {
            popup.classList.add('hide');
            setTimeout(() => {
                popup.style.display = 'none';
                overlay.style.display = 'none';
                
                const url = new URL(window.location);
                url.searchParams.delete('login_success');
                window.history.replaceState({}, document.title, url);
            }, 500);
        }, 5000);
    });
</script>
<?php endif; ?>

<?php if ($isLoggedIn && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
<div style="padding:20px;margin:20px;background:#1a1a1a;border-radius:10px;border:1px solid #333;">
    <h2 style="color:#e50914;">Upload Poster Film</h2>
    <p style="color:#999;margin-bottom:15px;">
        <i class="fas fa-info-circle"></i> 
        <strong>Catatan:</strong> Upload poster untuk film. Poster akan otomatis ter-sync ke series film yang sama.
    </p>

    <form action="" method="POST" enctype="multipart/form-data">
        <label style="color:#ccc;">Pilih Film:</label><br>
        <select name="movie_id" required style="width:100%;padding:10px;margin:10px 0;border-radius:5px;border:1px solid #333;background:#1a1a1a;color:#fff;">
            <?php
            $moviesList = $pdo->query("SELECT id, title FROM movies ORDER BY title")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($moviesList as $m):
            ?>
                <option value="<?php echo $m['id']; ?>"><?php echo htmlspecialchars($m['title']); ?></option>
            <?php endforeach; ?>
        </select>

        <br>

        <label style="color:#ccc;">Upload Poster (JPG/PNG):</label><br>
        <input type="file" name="poster" accept="image/*" required style="margin:10px 0;color:#ccc;">

        <br><br>

        <button type="submit" name="uploadPoster" style="background:#e50914;color:white;padding:12px 24px;border:none;border-radius:5px;cursor:pointer;font-weight:bold;">
            <i class="fas fa-upload"></i> Upload Poster
        </button>
    </form>
</div>
<?php endif; ?>

<nav class="navbar">
    <div class="nav-container">
        <div class="nav-brand"><h1>CineScope</h1></div>

        <div class="nav-search">
            <input type="text" id="searchInput" placeholder="Cari film..." class="search-input">
            <button class="search-btn" id="searchBtn"><i class="fas fa-search"></i></button>
        </div>

        <div class="nav-menu">
            <a href="jelajahi.php" class="nav-link">Jelajahi</a>
            <a href="daftar tonton.php" class="nav-link">Daftar Tonton</a>
            <a href="artikel.php" class="nav-link">Artikel</a>

            <?php if ($isLoggedIn): ?>
                <a href="logout.php" class="nav-link">Akun</a>
            <?php else: ?>
               <a href="logout.php" class="nav-link">Akun</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<?php if (count($trendingMovies) > 0): ?>
<section class="section trending-section">
    <div class="container">
        <h2 class="section-title"><i class="fas fa-fire"></i> Top 3 Film Trending</h2>

        <div class="movies-grid">
            <?php foreach ($trendingMovies as $index => $movie): ?>
                <div class="movie-card">
                    <a href="<?php echo generateMovieCardLink($movie); ?>">
                        <?php 
                        $posterPath = getPosterPath($movie['poster']);
                        if ($posterPath): ?>
                            <img src="<?php echo htmlspecialchars($posterPath); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="movie-poster">
                        <?php else: ?>
                            <div class="movie-poster" style="background:#666;display:flex;align-items:center;justify-content:center;color:#fff;font-size:40px;">
                                🎬
                            </div>
                        <?php endif; ?>

                        <div class="trending-badge">🔥 Top <?php echo $index+1; ?></div>
                    </a>

                    <div class="movie-info">
                        <div class="movie-title"><?php echo htmlspecialchars($movie['title']); ?></div>
                        <div class="movie-genre"><?php echo htmlspecialchars($movie['genre']); ?></div>
                        <div class="movie-rating">
                            ⭐ <?php echo number_format($movie['avg_rating'],1); ?>/5.0 
                            <span style="color: #999; font-weight: normal;">(<?php echo $movie['review_count']; ?> ulasan)</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (count($recommendedMovies) > 0): ?>
<section class="section new-section">
    <div class="container">
        <h2 class="section-title"><i class="fas fa-thumbs-up"></i> Rekomendasi</h2>

        <div class="movies-grid">
            <?php foreach ($recommendedMovies as $movie): ?>
                <div class="movie-card">
                    <a href="<?php echo generateMovieCardLink($movie); ?>">
                        <?php 
                        $posterPath = getPosterPath($movie['poster']);
                        if ($posterPath): ?>
                            <img src="<?php echo htmlspecialchars($posterPath); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="movie-poster">
                        <?php else: ?>
                            <div class="movie-poster" style="background:#0277bd;display:flex;align-items:center;justify-content:center;color:#fff;font-size:40px;">
                                🎬
                            </div>
                        <?php endif; ?>

                        <div class="new-badge"><i class="fas fa-star"></i> Rekomendasi</div>
                    </a>

                    <div class="movie-info">
                        <div class="movie-title"><?php echo htmlspecialchars($movie['title']); ?></div>
                        <div class="movie-genre"><?php echo htmlspecialchars($movie['genre']); ?></div>
                        <div class="movie-rating">
                            ⭐ <?php echo number_format($movie['avg_rating'],1); ?>/5.0
                            <?php if ($movie['review_count'] > 0): ?>
                                <span style="color: #999; font-weight: normal;">(<?php echo $movie['review_count']; ?> ulasan)</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section new-section">
    <div class="container">
        <h2 class="section-title"><i class="fas fa-calendar-alt"></i> Coming Soon!</h2>

        <?php if (count($newMovies) > 0): ?>
            <div class="movies-grid">
                <?php foreach ($newMovies as $movie): ?>
                    <div class="movie-card">
                        <a href="#" onclick="showComingSoonAlert(event)">
                            <?php 
                            $posterPath = getPosterPath($movie['poster']);
                            if ($posterPath): ?>
                                <img src="<?php echo htmlspecialchars($posterPath); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="movie-poster">
                            <?php else: ?>
                                <div class="movie-poster" style="background:#558b2f;display:flex;align-items:center;justify-content:center;color:#fff;font-size:40px;">
                                    🎬
                                </div>
                            <?php endif; ?>

                            <div class="new-badge"><i class="fas fa-star"></i> Coming Soon</div>
                        </a>

                        <div class="movie-info">
                            <div class="movie-title"><?php echo htmlspecialchars($movie['title']); ?></div>
                            <div class="movie-genre"><?php echo htmlspecialchars($movie['genre']); ?></div>
                            <div class="movie-rating">⭐ Segera Hadir</div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-section">
                <i class="fas fa-film"></i>
                <h3>Belum Ada Film Baru</h3>
                <p>Film baru akan segera hadir. Nantikan update selanjutnya!</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<div class="modal-overlay" id="comingSoonModal">
    <div class="modal-content">
        <i class="fas fa-calendar-times"></i>
        <h3>Film Belum Dirilis</h3>
        <p>Maaf, film ini belum dirilis. Nantikan segera!</p>
        <button class="modal-close-btn" onclick="closeComingSoonModal()">Tutup</button>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h4>CineScope</h4>
                <p>Platform review film terbaik untuk komunitas pencinta sinema Indonesia</p>
            </div>
            <div class="footer-section">
                <h4>Tautan</h4>
                <a href="tentang kami user.html">Tentang Kami</a>
                <a href="kebijakan privasi user.html">Kebijakan Privasi</a>
                <a href="syarat & ketentuan user.html">Syarat & Ketentuan</a>
            </div>
            <div class="footer-section">
                <h4>Ikuti Kami</h4>
                <div class="social-links">
                    <a href="https://x.com/piesekkn?t=n4wxmydCKx6Oy_aQHDTZTQ&s=09" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.facebook.com/share/17aUUywEem/" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/fernandokinansyah_?igsh=MTdrNGplNThmNTVvdw==" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 CineScope. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
function showComingSoonAlert(event) {
    event.preventDefault();
    const modal = document.getElementById('comingSoonModal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

function closeComingSoonModal() {
    const modal = document.getElementById('comingSoonModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

window.onclick = function(event) {
    const modal = document.getElementById('comingSoonModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    const searchBtn = document.getElementById("searchBtn");
    const movieCards = document.querySelectorAll(".movie-card");
    const sections = document.querySelectorAll(".section");

    function performSearch() {
        const query = searchInput.value.toLowerCase().trim();
        
        let foundCount = 0;
        let searchResultsContainer = document.getElementById("searchResultsContainer");
        
        if (searchResultsContainer) {
            searchResultsContainer.remove();
        }

        if (query === "") {
            sections.forEach(section => {
                section.style.display = "";
            });
            movieCards.forEach(card => {
                card.style.display = "";
            });
            return;
        }

        sections.forEach(section => {
            section.style.display = "none";
        });

        searchResultsContainer = document.createElement("section");
        searchResultsContainer.id = "searchResultsContainer";
        searchResultsContainer.className = "section";
        searchResultsContainer.style.cssText = "padding: 2rem 0; margin-top: 20px;";

        const container = document.createElement("div");
        container.className = "container";
        
        const resultTitle = document.createElement("h2");
        resultTitle.className = "section-title";
        resultTitle.style.cssText = "text-align: left; margin-bottom: 1.5rem;";
        resultTitle.innerHTML = `<i class="fas fa-search"></i> Hasil Pencarian: "${query}"`;
        container.appendChild(resultTitle);

        const moviesGrid = document.createElement("div");
        moviesGrid.className = "movies-grid";
        moviesGrid.style.cssText = "margin-top: 1rem;";

        movieCards.forEach(card => {
            const title = card.querySelector(".movie-title")?.textContent.toLowerCase() || "";
            const genre = card.querySelector(".movie-genre")?.textContent.toLowerCase() || "";
            
            if (title.includes(query) || genre.includes(query)) {
                const clonedCard = card.cloneNode(true);
                clonedCard.style.display = "";
                moviesGrid.appendChild(clonedCard);
                foundCount++;
            }
        });

        if (foundCount === 0) {
            const noResultMessage = document.createElement("div");
            noResultMessage.className = "empty-section";
            noResultMessage.style.cssText = "padding: 80px 20px; text-align: center;";
            noResultMessage.innerHTML = `
                <i class="fas fa-search" style="font-size: 5em; margin-bottom: 25px; color: #333;"></i>
                <h3 style="font-size: 1.8em; margin-bottom: 15px; color: #999;">Tidak Ditemukan</h3>
                <p style="color: #666; font-size: 1.1em;">Film dengan kata kunci "<strong style="color:#e50914;">${query}</strong>" tidak ditemukan.</p>
                <p style="color: #555; margin-top: 10px;">Coba kata kunci lain atau telusuri film di kategori lain.</p>
            `;
            container.appendChild(noResultMessage);
        } else {
            const resultCount = document.createElement("p");
            resultCount.style.cssText = "color: #aaa; margin-bottom: 20px; font-size: 0.95em;";
            resultCount.textContent = `Ditemukan ${foundCount} film`;
            container.appendChild(resultCount);
            container.appendChild(moviesGrid);
        }

        searchResultsContainer.appendChild(container);
        
        const navbar = document.querySelector(".navbar");
        navbar.insertAdjacentElement("afterend", searchResultsContainer);

        searchResultsContainer.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
    }

    if (searchInput) {
        searchInput.addEventListener("keyup", performSearch);
        
        searchInput.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                performSearch();
            }
        });
    }

    if (searchBtn) {
        searchBtn.addEventListener("click", (e) => {
            e.preventDefault();
            performSearch();
        });
    }
});
</script>

</body>
</html>