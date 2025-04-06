<?php
// Include database connection if needed
// include 'db_connection.php';

// Query products from database or use static array
// If using database:
// $query = "SELECT * FROM products";
// $result = mysqli_query($connection, $query);
// $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// For now, using static array
$products = [
    ["name" => "Urban Metro Tee", "price" => "25.99", "badge" => "NEW", "category" => "premade"],
    ["name" => "District Line Hoodie", "price" => "35.99", "badge" => "", "category" => "premade"],
    ["name" => "City Skyline Tee", "price" => "22.99", "badge" => "SALE", "category" => "premade"],
    ["name" => "Downtown Cap", "price" => "19.99", "badge" => "", "category" => "premade"],
    ["name" => "Metro Station Backpack", "price" => "45.99", "badge" => "POPULAR", "category" => "premade"],
    ["name" => "Urban District Socks", "price" => "12.99", "badge" => "", "category" => "premade"]
];

// Commissioned design examples
$commissionedDesigns = [
    ["name" => "Custom Team Jersey", "price" => "49.99", "badge" => "CUSTOM", "category" => "commissioned"],
    ["name" => "Personalized Event Hoodie", "price" => "59.99", "badge" => "CUSTOM", "category" => "commissioned"],
    ["name" => "Corporate Logo Tee", "price" => "32.99", "badge" => "CUSTOM", "category" => "commissioned"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Metro District Designs</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
        
        .add-to-cart {
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
        
        .add-to-cart:hover {
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
        
        .detail-add-to-cart {
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
        
        .detail-add-to-cart:hover {
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
        
        .commission-info {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .request-commission-btn {
            background-color: #1E1E1E;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }
        
        .request-commission-btn:hover {
            background-color: #444;
        }
        
        .badge-custom {
            background-color: #9b59b6 !important;
        }
    </style>
</head>
<body class="content">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="Homepage.php">
                <img src="/api/placeholder/40/40" class="rounded-circle" alt="Logo">
                Metro District Designs
            </a>
            <div class="mx-auto">
                <a href="Homepage.php" class="nav-link d-inline-block">HOME</a>
                <a href="Products.php" class="nav-link d-inline-block">PRODUCTS</a>
                <a href="Inquiry.php" class="nav-link d-inline-block">INQUIRY</a>
            </div>
            <div>
                <a href="Signup.php" class="login-links">SIGN-UP</a>
                <a href="Login.php" class="login-links">LOGIN</a>
            </div>
        </div>
    </nav>
    
    <!-- Category Navigation -->
    <div class="container py-4">
        <div class="category-nav text-center">
            <button class="category-btn active" data-target="all">All Products</button>
            <button class="category-btn" data-target="premade">Premade Designs</button>
            <button class="category-btn" data-target="commissioned">Commissioned Designs</button>
        </div>
    </div>
    
    <!-- Premade Designs Section -->
    <div class="container py-4 product-section" id="premade-section">
        <div class="section-heading">
            <h2>PREMADE DESIGNS</h2>
            <hr>
        </div>
        <div class="row">
            <?php
            // Loop through premade products
            $productCount = 0;
            foreach ($products as $product) {
                $productCount++;
                $productName = $product["name"];
                $price = $product["price"];
                $badge = $product["badge"];
            ?>
            <div class="col-md-4 mb-4">
                <div class="product-card" onclick="location.href='ProductDetail.php?id=<?php echo $productCount; ?>&name=<?php echo urlencode($productName); ?>&price=<?php echo urlencode($price); ?>'">
                    <?php if(!empty($badge)): ?>
                    <div class="product-badge"><?php echo $badge; ?></div>
                    <?php endif; ?>
                    
                    <!-- Product Image/Carousel -->
                    <div id="carousel-<?php echo $productCount; ?>" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/api/placeholder/400/300" class="d-block w-100" alt="Product Image 1">
                            </div>
                            <div class="carousel-item">
                                <img src="/api/placeholder/400/300?2" class="d-block w-100" alt="Product Image 2">
                            </div>
                            <div class="carousel-item">
                                <img src="/api/placeholder/400/300?3" class="d-block w-100" alt="Product Image 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $productCount; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $productCount; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    
                    <button class="quick-view" onclick="event.stopPropagation();">
                        <i class="bi bi-eye"></i>
                    </button>
                    
                    <div class="product-info">
                        <h5><?php echo $productName; ?></h5>
                        <p>$<?php echo $price; ?></p>
                        <button class="add-to-cart" onclick="event.stopPropagation(); addToCart(<?php echo $productCount; ?>)">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    
    <!-- Commissioned Designs Section -->
    <div class="container py-4 product-section" id="commissioned-section">
        <div class="section-heading">
            <h2>COMMISSIONED DESIGNS</h2>
            <hr>
        </div>
        
        <!-- Information about commissioned designs -->
        <div class="commission-info mb-4">
            <div class="row">
                <div class="col-md-8">
                    <h4>Custom Design Services</h4>
                    <p>Looking for something unique? Our design team can create custom apparel for individuals, teams, events, and businesses. We work closely with you to bring your vision to life!</p>
                    <ul>
                        <li>Personal consultation with our professional designers</li>
                        <li>Multiple revision options</li>
                        <li>Bulk order discounts available</li>
                        <li>Quick turnaround times</li>
                    </ul>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <button class="request-commission-btn" onclick="location.href='Commission.php'">
                        Request a Commission
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Example commissioned products -->
        <h4 class="mb-3">Example Commissioned Works</h4>
        <div class="row">
            <?php
            // Loop through commissioned design examples
            $commissionCount = 100; // Start at a different number range to avoid ID conflicts
            foreach ($commissionedDesigns as $design) {
                $commissionCount++;
                $designName = $design["name"];
                $price = $design["price"];
                $badge = $design["badge"];
            ?>
            <div class="col-md-4 mb-4">
                <div class="product-card" onclick="location.href='ProductDetail.php?id=<?php echo $commissionCount; ?>&name=<?php echo urlencode($designName); ?>&price=<?php echo urlencode($price); ?>&commissioned=true'">
                    <?php if(!empty($badge)): ?>
                    <div class="product-badge badge-custom"><?php echo $badge; ?></div>
                    <?php endif; ?>
                    
                    <!-- Product Image/Carousel -->
                    <div id="carousel-<?php echo $commissionCount; ?>" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/api/placeholder/400/300?custom1" class="d-block w-100" alt="Commission Example 1">
                            </div>
                            <div class="carousel-item">
                                <img src="/api/placeholder/400/300?custom2" class="d-block w-100" alt="Commission Example 2">
                            </div>
                            <div class="carousel-item">
                                <img src="/api/placeholder/400/300?custom3" class="d-block w-100" alt="Commission Example 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $commissionCount; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $commissionCount; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    
                    <button class="quick-view" onclick="event.stopPropagation();">
                        <i class="bi bi-eye"></i>
                    </button>
                    
                    <div class="product-info">
                        <h5><?php echo $designName; ?></h5>
                        <p>Starting at $<?php echo $price; ?></p>
                        <button class="add-to-cart" onclick="event.stopPropagation(); window.location.href='Commission.php'">
                            <i class="bi bi-pencil-square"></i> Request Similar
                        </button>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    
    <!-- All Products Section (initially hidden) -->
    <div class="container py-4 product-section" id="all-section" style="display: none;">
        <h2 class="mb-4">ALL PRODUCTS</h2>
        <div class="row">
            <?php
            // Combined products
            $allProducts = array_merge($products, $commissionedDesigns);
            $allProductCount = 0;
            
            foreach ($allProducts as $product) {
                $allProductCount++;
                $productName = $product["name"];
                $price = $product["price"];
                $badge = $product["badge"];
                $isCommissioned = $product["category"] === "commissioned";
                
                // Product ID to use in links
                $productId = $isCommissioned ? 100 + $allProductCount : $allProductCount;
            ?>
            <div class="col-md-4 mb-4">
                <div class="product-card" onclick="location.href='ProductDetail.php?id=<?php echo $productId; ?>&name=<?php echo urlencode($productName); ?>&price=<?php echo urlencode($price); ?><?php echo $isCommissioned ? '&commissioned=true' : ''; ?>'">
                    <?php if(!empty($badge)): ?>
                    <div class="product-badge <?php echo $isCommissioned ? 'badge-custom' : ''; ?>"><?php echo $badge; ?></div>
                    <?php endif; ?>
                    
                    <!-- Product Image/Carousel -->
                    <div id="all-carousel-<?php echo $allProductCount; ?>" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/api/placeholder/400/300<?php echo $isCommissioned ? '?custom1' : ''; ?>" class="d-block w-100" alt="Product Image 1">
                            </div>
                            <div class="carousel-item">
                                <img src="/api/placeholder/400/300<?php echo $isCommissioned ? '?custom2' : '?2'; ?>" class="d-block w-100" alt="Product Image 2">
                            </div>
                            <div class="carousel-item">
                                <img src="/api/placeholder/400/300<?php echo $isCommissioned ? '?custom3' : '?3'; ?>" class="d-block w-100" alt="Product Image 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#all-carousel-<?php echo $allProductCount; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#all-carousel-<?php echo $allProductCount; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    
                    <button class="quick-view" onclick="event.stopPropagation();">
                        <i class="bi bi-eye"></i>
                    </button>
                    
                    <div class="product-info">
                        <h5><?php echo $productName; ?></h5>
                        <p><?php echo $isCommissioned ? 'Starting at ' : ''; ?>$<?php echo $price; ?></p>
                        <button class="add-to-cart" onclick="event.stopPropagation(); <?php echo $isCommissioned ? "window.location.href='Commission.php'" : "addToCart($productId)"; ?>">
                            <?php if($isCommissioned): ?>
                            <i class="bi bi-pencil-square"></i> Request Similar
                            <?php else: ?>
                            <i class="bi bi-cart-plus"></i> Add to Cart
                            <?php endif; ?>
                        </button>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
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
        
        // Initially show only specific sections
        showSection('premade'); // Show only premade designs by default
        
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
            } else if(sectionId === 'commissioned') {
                document.getElementById('commissioned-section').style.display = 'block';
            }
        }
        
        // Modified Add to Cart functionality
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                // Stop event propagation to prevent navigation to product detail
                event.stopPropagation();
                
                // Check if this is a premade product or commissioned design
                if(button.innerHTML.includes('Request Similar')) {
                    // Redirect to Commission page
                    window.location.href = 'Commission.php';
                } else {
                    // Redirect to the Cart page when Add to Cart is clicked
                    window.location.href = 'Cart.php';
                }
            });
        });
        
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
    
    // Function to add item to cart
    function addToCart(productId) {
        // Prevent default link behavior
        event.preventDefault();
        // Here you would normally add the product to the cart via AJAX
        // For now, simply redirect to cart page
        window.location.href = 'Cart.php';
    }
    </script>
</body>
</html>