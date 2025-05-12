<?php
require_once "db_connection.php";

// Fetch products with the SQL query
$query = "
    SELECT 
        dp.id AS display_id,
        dp.product_name,
        dp.description,
        MIN(di.image_path) AS image_path, -- Get one image per product
        SUM(p.stock) AS total_stock, -- Sum the stock across all variations
        CASE 
            WHEN SUM(p.stock) = 0 THEN 'SOLD OUT' -- Check if total stock is 0
            ELSE NULL
        END AS badge,
        MIN(p.price) AS price, -- Get the minimum price for the product
        MAX(CASE WHEN p.original_price IS NOT NULL THEN p.original_price END) AS original_price
    FROM 
        display_product dp
    INNER JOIN 
        products p ON dp.product_name = p.name -- Only include products with a match
    LEFT JOIN 
        display_images di ON dp.id = di.product_id
    GROUP BY 
        dp.id, dp.product_name, dp.description;
";

$result = $conn->query($query);
$all_products = $result->fetch_all(MYSQLI_ASSOC);

// Create a separate array for products that are not sold out
$in_stock_products = array_filter($all_products, function($product) {
    return $product['badge'] !== 'SOLD OUT';
});
?>
<?php 
    session_start();
    $page_title = "Products - Metro District Designs";
    require_once "header.php" 
?>
<style>
    * {
        font-family: Helvetica, sans-serif;
    }
    
    body {
        background-color: #E5E4E2;
        font-family: Helvetica, sans-serif;
        font-weight: bold; 
    }
    .navbar-custom {
        background-color: #1E1E1E; 
        height: 70px;
    }
    .navbar-custom .navbar-brand {
        display: flex;
        align-items: center;
        color: white;
    }
    .navbar-custom .navbar-brand img {
        height: 40px;
        width: 40px;
        margin-right: 10px;
    }
    .navbar-custom .nav-link {
        color: white;
        font-weight: bold;
        margin: 0 15px;
    }
    .login-links {
        color: white;
        text-decoration: none;
        margin-left: 15px;
        font-weight: bold;
    }
    .login-links:hover {
        color: #888;
    }
    .content {
        background-color: #E5E4E2;
        color: black;
    }
    
    /* Product card styles */
    .product-card {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        height: 100%;
        cursor: pointer;
        position: relative;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
    }
    
    .product-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #e74c3c;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: bold;
        z-index: 1;
    }
    
    .carousel-item img {
        height: 250px;
        object-fit: cover;
        width: 100%;
    }
    
    .product-info {
        padding: 15px;
    }
    
    .product-info h5 {
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .view-details {
        background-color: #1E1E1E;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        margin-top: 5px;
        transition: background-color 0.3s ease;
        width: 100%;
        cursor: pointer;
    }
    
    .view-details:hover {
        background-color: #444;
    }
    
    .quick-view {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: rgba(255, 255, 255, 0.8);
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .product-card:hover .quick-view {
        opacity: 1;
    }
    
    /* Product Detail Styles from first file */
    .product-detail-container {
        background-color: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    
    .product-gallery {
        background-color: #f8f8f8;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .product-thumbnail {
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    
    .product-thumbnail.active {
        border-color: #1E1E1E;
    }
    
    .product-details h2 {
        margin-bottom: 10px;
    }
    
    .product-price {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }
    
    .product-description {
        margin-bottom: 20px;
        line-height: 1.6;
    }
    
    .size-options, .color-options {
        margin-bottom: 20px;
    }
    
    .size-btn, .color-btn {
        margin-right: 10px;
        margin-bottom: 10px;
        border: 2px solid #ddd;
        background-color: white;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .size-btn:hover, .color-btn:hover,
    .size-btn.active, .color-btn.active {
        border-color: #1E1E1E;
        background-color: #1E1E1E;
        color: white;
    }
    
    .quantity-selector {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .quantity-btn {
        width: 40px;
        height: 40px;
        border: 1px solid #ddd;
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    
    .quantity-input {
        width: 60px;
        height: 40px;
        border: 1px solid #ddd;
        text-align: center;
        margin: 0 5px;
    }
    
    .detail-view-details {
        background-color: #1E1E1E;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 4px;
        font-weight: bold;
        transition: background-color 0.3s ease;
        width: 100%;
        cursor: pointer;
    }
    
    .detail-view-details:hover {
        background-color: #444;
    }
    
    .related-products {
        margin-top: 40px;
    }
    
    /* Category navigation styles */
    .category-nav {
        background-color: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 30px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .category-btn {
        margin-right: 10px;
        padding: 8px 20px;
        border: 2px solid #1E1E1E;
        background-color: white;
        color: #1E1E1E;
        border-radius: 4px;
        font-weight: bold;
        transition: all 0.2s ease;
    }
    
    .category-btn.active, .category-btn:hover {
        background-color: #1E1E1E;
        color: white;
    }
    
    .section-heading {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .section-heading hr {
        flex-grow: 1;
        margin-left: 15px;
        border-top: 2px solid #1E1E1E;
    }
</style>
<body class="content">
    <?php require_once "navbar.php" ?>
    
    <!-- Category Navigation - Removed commissioned designs button -->
    <div class="container py-4">
        <div class="category-nav text-center">
            <button class="category-btn active" data-target="all">All Products</button>
            <button class="category-btn" data-target="premade">Premade Designs</button>
        </div>
    </div>
    
    <!-- All Products Section -->
    <div class="container py-4 product-section" id="all-section">
        <div class="section-heading">
            <h2>ALL PRODUCTS</h2>
            <hr>
        </div>
        <div class="row">
            <?php foreach ($all_products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="product-card" onclick="location.href='ProductDetail.php?id=<?php echo $product['display_id']; ?>'">
                        <?php if ($product['badge']): ?>
                            <div class="product-badge"><?php echo $product['badge']; ?></div>
                        <?php endif; ?>
                        <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="img-fluid">
                        <button class="quick-view" onclick="event.stopPropagation();">
                            <i class="bi bi-eye"></i>
                        </button>
                        <div class="p-3">
                            <h5><?php echo htmlspecialchars($product['product_name']); ?></h5>
                            <p>₱
                                <?php if ($product['original_price']): ?>
                                    <span style="text-decoration: line-through;">
                                        <?php echo htmlspecialchars(number_format($product['original_price'], 2)); ?>
                                    </span>
                                <?php endif; ?>
                                <span>
                                    <?php echo htmlspecialchars(number_format($product['price'], 2)); ?>
                                </span>
                            </p>
                            <button class="view-details" onclick="event.stopPropagation(); location.href='ProductDetail.php?id=<?php echo $product['display_id']; ?>'">
                                <i class="bi bi-info-circle"></i> View Details
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Premade Designs Section -->
    <div class="container py-4 product-section" id="premade-section" style="display: none;">
        <div class="section-heading">
            <h2>PREMADE DESIGNS</h2>
            <hr>
        </div>
        <div class="row">
            <?php foreach ($in_stock_products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="product-card" onclick="location.href='ProductDetail.php?id=<?php echo $product['display_id']; ?>'">
                        <?php if ($product['badge']): ?>
                            <div class="product-badge"><?php echo $product['badge']; ?></div>
                        <?php endif; ?>
                        <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="img-fluid">
                        <button class="quick-view" onclick="event.stopPropagation();">
                            <i class="bi bi-eye"></i>
                        </button>
                        <div class="p-3">
                            <h5><?php echo htmlspecialchars($product['product_name']); ?></h5>
                            <p>
                                <?php if ($product['original_price']): ?>
                                    <span style="text-decoration: line-through;">
                                        ₱<?php echo htmlspecialchars(number_format($product['original_price'], 2)); ?>
                                    </span>
                                <?php endif; ?>
                                test
                                <span>
                                    <?php echo htmlspecialchars(number_format($product['price'], 2)); ?>
                                </span>
                            </p>
                            <button class="view-details" onclick="event.stopPropagation(); location.href='ProductDetail.php?id=<?php echo $product['display_id']; ?>'">
                                <i class="bi bi-info-circle"></i> View Details
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div> 
    </div>
    
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize carousels
        const productCarousels = document.querySelectorAll('.carousel');
        productCarousels.forEach(carousel => {
            const carouselInstance = new bootstrap.Carousel(carousel, {
                interval: false
            });
        });
        
        // Category navigation
        const categoryButtons = document.querySelectorAll('.category-btn');
        const productSections = document.querySelectorAll('.product-section');
        
        // Initially show "All Products" section by default
        showSection('all');
        
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Show corresponding section
                const targetSection = this.getAttribute('data-target');
                showSection(targetSection);
            });
        });
        
        function showSection(sectionId) {
            // Hide all sections
            productSections.forEach(section => {
                section.style.display = 'none';
            });
            
            // Show selected section
            if(sectionId === 'all') {
                document.getElementById('all-section').style.display = 'block';
            } else if(sectionId === 'premade') {
                document.getElementById('premade-section').style.display = 'block';
            }
        }
        
        // Make the quick view button open the product detail page
        const quickViewButtons = document.querySelectorAll('.quick-view');
        
        quickViewButtons.forEach((button, index) => {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
                // Get the parent product card and simulate a click
                const productCard = this.closest('.product-card');
                if (productCard) {
                    // Manually trigger the onclick event of the product card
                    const href = productCard.getAttribute('onclick').split("'")[1];
                    window.location.href = href;
                }
            });
        });
    });
    </script>
</body>
</html>