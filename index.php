<?php
// File: index.php (FIXED - Best Rating System)
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
// Prioritas: Rating tinggi (4-5 bintang) dengan jumlah review terbanyak
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

// Get IDs dari trending movies
$trendingIds = array_column($trendingMovies, 'id');
$excludeIds = !empty($trendingIds) ? implode(',', $trendingIds) : '0';

// Rekomendasi (3 film terbaik yang TIDAK masuk trending)
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

// Generate link film
function generateMovieCardLink($movie) {
    $movieLinks = array(
        1 => 'ulasan_sore.php',
        2 => 'ulasan_petaka_gunung_gede.php',
        3 => 'ulasan_dilan1990.php',
        4 => 'ulasan_rest_area.php',
        5 => 'ulasan_tukartakdir.php',
        6 => 'ulasan_rangga&cinta.php'
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
    outline: none;
    transition: border-color 0.3s ease;
}

.search-input:focus {
    border-color: #e50914;
}

.search-btn {
    padding: 0.8rem 1rem;
    background-color: #e50914;
    border: none;
    border-radius: 0 4px 4px 0;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.search-btn:hover {
    background-color: #b8070f;
}

.hero {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                url('banner.jpg') center/cover no-repeat;
    height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    border-bottom: 2px solid #e50914;
}

.hero-content {
    max-width: 800px;
    padding: 0 20px;
}

.hero-content h2 {
    font-size: 3rem;
    margin-bottom: 1.5rem;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}

.hero-content p {
    font-size: 1.3rem;
    color: #ccc;
    margin-bottom: 2.5rem;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
}

.hero-buttons {
    display: flex;
    gap: 1.5rem;
    justify-content: center;
}

.btn {
    padding: 1rem 2rem;
    border-radius: 5px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.1rem;
}

.btn-primary {
    background-color: #e50914;
    color: white;
}

.btn-primary:hover {
    background-color: #b8070f;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4);
}

.btn-secondary {
    background-color: rgba(255, 255, 255, 0.1);
    color: white;
    border: 2px solid #fff;
}

.btn-secondary:hover {
    background-color: rgba(255, 255, 255, 0.2);
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
    font-weight: 700;
}

.section-title i {
    color: #e50914;
    margin-right: 10px;
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
    font-size: 0.95rem;
    font-weight: 600;
}

.trending-badge, .new-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgba(229, 9, 20, 0.95);
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
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

.footer {
    background-color: #111;
    padding: 3rem 0 1rem;
    margin-top: 4rem;
    border-top: 1px solid #333;
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

@media (max-width: 768px) {
    .nav-container {
        flex-direction: column;
        gap: 1rem;
    }

    .nav-search {
        margin: 1rem 0;
        max-width: 100%;
    }

    .hero-content h2 {
        font-size: 2rem;
    }

    .hero-content p {
        font-size: 1rem;
    }

    .hero-buttons {
        flex-direction: column;
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
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="nav-brand">
            <h1>CineScope</h1>
        </div>

        <div class="nav-search">
            <input type="text" id="searchInput" placeholder="Cari film..." class="search-input">
            <button class="search-btn" id="searchBtn"><i class="fas fa-search"></i></button>
        </div>
    </div>
</nav>

<section class="hero">
    <div class="hero-content">
        <h2>Jelajahi, Review, dan Bagikan Pengalaman Film Anda</h2>
        <p>Bergabunglah dengan komunitas pencinta film terbesar di Indonesia</p>
        <div class="hero-buttons">
            <a href="bergabung_sekarang.php" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Bergabung Sekarang
            </a>
            <a href="login.php" class="btn btn-secondary">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    </div>
</section>

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
                            ⭐ <?php echo number_format($movie['avg_rating'], 1); ?>/5.0
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
<section class="section">
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
                            ⭐ <?php echo number_format($movie['avg_rating'], 1); ?>/5.0
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

<section class="section">
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

                            <div class="new-badge"><i class="fas fa-clock"></i> Coming Soon</div>
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
                <a href="tentang kami.php">Tentang Kami</a>
                <a href="kebijakan privasi.php">Kebijakan Privasi</a>
                <a href="syarat & ketentuan.php">Syarat & Ketentuan</a>
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
            if (!section.classList.contains('hero')) {
                section.style.display = "none";
            }
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
        
        const hero = document.querySelector(".hero");
        hero.insertAdjacentElement("afterend", searchResultsContainer);

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