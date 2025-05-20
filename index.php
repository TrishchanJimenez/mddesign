<?php
    session_start();
    require_once "header.php";
    require_once "db_connection.php";
    require_once "chat-box.php";
?>

<style>
body {
font-family: Helvetica, sans-serif;
font-weight: bold;
}

.hero-banner {
background: gray;
text-align: center;
font-style: italic;
padding: 15px 0;
}

.hero-banner h1 {
color: black;
font-size: 2.5rem;
margin-bottom: 10px;
font-family: Helvetica, sans-serif;
font-weight: bold;
}

.hero-banner p {
color: black;
font-style: italic;
font-size: 1.2rem;
font-family: Helvetica, sans-serif;
font-weight: bold;
}

.colorful-divider {
height: 5px;
background: gray;
}

.design-card {
background-color: #f8f9fa;
border: none;
margin-bottom: 20px;
transition: transform 0.3s;
font-family: Helvetica, sans-serif;
font-weight: bold;
}

.design-card:hover {
transform: scale(1.05);
}
.pre-made-designs {
background-color: #E5E4E2;
}

.design-placeholder {
background-color: #B0A8B9;
height: 450px;
width: 100%;
overflow: hidden;
position: relative;
cursor: pointer; /* Add cursor pointer to indicate clickable */
transition: transform 0.3s ease;
}

.design-placeholder:hover {
transform: scale(1.03); /* Subtle scale effect on hover */
}

.design-placeholder img {
width: 100%;
height: 100%;
object-fit: cover;
}

.pre-made-designs h2 {
font-weight: bold;
font-family: Helvetica, sans-serif;
}

.pre-made-designs h4 {
font-weight: bold;
font-family: Helvetica, sans-serif;
cursor: pointer; /* Add cursor pointer to indicate clickable */
}

.carousel-item img {
width: 80%;
height: 700px;
object-fit: flex;
}

.grid-layout {
display: grid;
grid-template-columns: 1fr 1fr 1fr;
grid-template-rows: 1fr 1fr;
gap: 10px;
height: 600px;
margin-top: 30px;
}

.grid-item {
background-color: #D3D3D3;
border: 2px solid #f0f0f0;
position: relative;
overflow: hidden;
}

.grid-item img {
width: 100%;
height: 100%;
object-fit: cover;
transition: transform 0.3s ease;
}

.grid-item:hover img {
transform: scale(1.05);
}

.grid-item-1 {
grid-row: span 2;
grid-column: 1;
}

.grid-item-2 {
grid-column: 2 / span 2;
}

.grid-item-3 {
grid-column: 2;
}

.grid-item-4 {
grid-column: 3;
grid-row: 2;
}

.long-horizontal-bar {
height: 300px;
background-color: #E0E0E0;
margin-top: 50px;
margin-bottom: 50px;
position: relative;
overflow: hidden;
}

.long-horizontal-bar img {
width: 100%;
height: 100%;
object-fit: cover;
}

.overlay-text {
position: absolute;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
color: white;
text-align: center;
z-index: 10;
text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
font-family: Helvetica, sans-serif;
font-weight: bold;
}

.overlay-text h2 {
font-size: 2.5rem;
font-weight: bold;
margin-bottom: 10px;
font-family: Helvetica, sans-serif;
}

.overlay-text p {
font-size: 1.2rem;
max-width: 80%;
margin: 0 auto;
font-family: Helvetica, sans-serif;
font-weight: bold;
}
    /* Footer Styles */
.footer {
background-color: #1E1E1E;
color: white;
padding: 40px 0 20px;
margin-top: 40px;
}

.footer h5 {
font-weight: bold;
margin-bottom: 20px;
}

.social-icon {
display: inline-flex;
align-items: center;
justify-content: center;
width: 60px;
height: 60px;
border-radius: 50%;
background-color: white;
color: #4a90e2;
transition: transform 0.3s ease, box-shadow 0.3s ease;
text-decoration: none;
box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}


.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background-color: black; /* Changed from white to black */
    color: white; /* Changed from #4a90e2 to white for better contrast */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-decoration: none;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.social-icon:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 8px rgba(0,0,0,0.2);
}

.social-icon i {
    font-size: 30px;
    color: inherit; /* Ensures icon color matches parent element */
}

.social-icon.facebook:hover {
    color: #3b5998;
    background-color: black; /* Maintain black background on hover */
}

.social-icon.instagram:hover {
    color: #e1306c;
    background-color: black; /* Maintain black background on hover */
}

@media (max-width: 767px) {
.footer .row {
    text-align: center;
}

.footer-text {
    margin-bottom: 30px;
}
}
.dark-overlay {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-color: rgba(0,0,0,0.4);
}

.btn {
font-family: Helvetica, sans-serif;
font-weight: bold;
}
</style>
<body>
    <!-- Navbar -->
    <?php require_once "navbar.php"; ?>
    
    <!-- Colorful Divider -->
    <div class="colorful-divider"></div>

    <!-- Hero Banner -->
    <div class="hero-banner">
        <div class="container">
            <h1>Welcome to Metro District Designs</h1>
            <p>"Explore unique designs, commission custom work, and showcase your creativity."</p>
        </div>
    </div>

    <!-- Carousel -->
    <div class="container mt-5">
        <div id="tshirtCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#tshirtCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#tshirtCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#tshirtCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <?php
            // Define the directory where featured banner images are stored
            $bannerDir = "images/BANNERS/";
            
            // Get all files with these extensions
            $fileTypes = array('jpg', 'jpeg', 'png', 'gif');
            
            // Try to get banner files from directory
            $bannerFiles = array();
            foreach($fileTypes as $type) {
                $typeFiles = glob($bannerDir . "*." . $type);
                if($typeFiles) {
                    $bannerFiles = array_merge($bannerFiles, $typeFiles);
                }
            }
            ?>
            <div class="carousel-inner">
                <?php
                // If banner files are found, use them in the carousel
                if(count($bannerFiles) > 0) {
                    foreach($bannerFiles as $index => $file) {
                        $activeClass = ($index === 0) ? 'active' : '';
                        echo '<div class="carousel-item ' . $activeClass . '">';
                        echo '<img src="' . $file . '" class="d-block w-100" alt="Banner Image ' . ($index + 1) . '">';
                        echo '</div>';
                    }
                } else {
                    // Default fallback images if no files are found
                ?>
                <div class="carousel-item active">
                    <img src="images/MockUp/PANTA.png" class="d-block w-100" alt="Anime T-Shirt 1">
                </div>
                <div class="carousel-item">
                    <img src="images/Mockup/NNK.png" class="d-block w-100" alt="Anime T-Shirt 2">
                </div>
                <div class="carousel-item">
                    <img src="images/MockUp/GOOD GUYS.png" class="d-block w-100" alt="Anime T-Shirt 3">
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    // Fetch 3 random products from the database
    $query = "
        SELECT 
            dp.id AS display_id,
            dp.product_name,
            dp.description,
            (
                SELECT di.image_path
                FROM display_images di
                WHERE di.product_id = dp.id
                ORDER BY di.image_path ASC
                LIMIT 1
            ) AS image_path,
            MIN(p.price) AS price
        FROM 
            display_product dp
        INNER JOIN 
            products p ON dp.product_name = p.name
        GROUP BY 
            dp.id, dp.product_name, dp.description
        ORDER BY RAND() -- Randomize the selection
        LIMIT 3; -- Limit to 3 products
    ";

    $result = $conn->query($query);
    $premade_products = $result->fetch_all(MYSQLI_ASSOC);
    ?>
    <!-- Pre-Made Designs -->
    <div class="container my-5 pre-made-designs">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>PRE-MADE DESIGNS</h2>
            <a href="Products.php" class="btn btn-link text-dark">SEE ALL →</a>
        </div>
    
        <div class="row g-3">
            <?php if (!empty($premade_products)): ?>
                <?php foreach ($premade_products as $product): ?>
                    <div class="col-md-4">
                        <a href="ProductDetail.php?id=<?php echo urlencode($product['display_id']); ?>" class="text-decoration-none text-dark">
                            <div class="design-placeholder">
                                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                            </div>
                            <div class="text-center mt-2">
                                <h4><?php echo htmlspecialchars($product['product_name']); ?></h4>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>

                <?php
                // Calculate the number of placeholders needed
                $placeholders_needed = 3 - count($premade_products);
                for ($i = 0; $i < $placeholders_needed; $i++): ?>
                    <div class="col-md-4">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="design-placeholder">
                                <img src="/api/placeholder/450/450?text=No+Image" alt="Design Placeholder">
                            </div>
                            <div class="text-center mt-2">
                                <h4>Sample Design <?php echo $i + 1; ?></h4>
                            </div>
                        </a>
                    </div>
                <?php endfor; ?>
            <?php else: ?>
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <div class="col-md-4">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="design-placeholder">
                                <img src="/api/placeholder/450/450?text=No+Image" alt="Design Placeholder">
                            </div>
                            <div class="text-center mt-2">
                                <h4>Sample Design <?php echo $i + 1; ?></h4>
                            </div>
                        </a>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Updated Grid Layout Section with Images -->
    <div class="container">
        <div class="grid-layout">
            <div class="grid-item grid-item-1">
                <img src="images/MockUp/Ground Person.jpg" alt="Fashion Model">
            </div>
            <div class="grid-item grid-item-2">
                <img src="images/MockUp/One Piece.png" alt="Design Process">
            </div>
            <div class="grid-item grid-item-3">
                <img src="images/MockUp/WHITE.png" alt="Design Studio">
            </div>
            <div class="grid-item grid-item-4">
                <img src="images/MockUp/Ground.jpg" alt="Custom Designs">
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-3">
                    <img id="footerLogo" src="/api/placeholder/75/75" class="me-2 rounded-circle">
                    <span class="logo-text">Metro District Design</span>
                </div>
                <div class="footer-text text-center text-md-start">
                    <p><i class="bi bi-geo-alt me-2"></i><a href="" target="_blank" style="color: white; text-decoration: none;">Parañaque, Philippines</a></p>
                    <p><i class="bi bi-envelope me-2"></i><a href="" style="color: white; text-decoration: none;">metrodistrictd@gmail.com</a></p>
                    <p><i class="bi bi-telephone me-2"></i><a href="" style="color: white; text-decoration: none;"></a> 0968 597 9776<a href="4" style="color: white; text-decoration: none;"></a></p>
                </div>
            </div>
            
            <div class="col-md-4 d-flex align-items-end justify-content-center">
                <p>© 2025 Metro District Design. All rights reserved.</p>
            </div>
            
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-end mb-3">
                    <h5 class="mb-0">Follow Us</h5>
                </div>
                <div class="text-center text-md-end">
                    <a href="https://www.facebook.com/MetroDistrictDesigns" class="social-icon facebook" style="background-color: black; color: white;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/metrodistrict_ig/" class="social-icon instagram" style="background-color: black; color: white;">
                        <i class="bi bi-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="globals.js"></script>
</body>
</html> 