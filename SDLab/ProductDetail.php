<?php
// Get product information from URL parameters
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$name = isset($_GET['name']) ? $_GET['name'] : 'Product Name';
$price = isset($_GET['price']) ? $_GET['price'] : '25.99';
$badge = isset($_GET['badge']) ? $_GET['badge'] : '';

// Placeholder values for product details
$description = "This premium Metro District Design t-shirt features high-quality print and fabric. Perfect for urban style enthusiasts who appreciate unique designs. Made from 100% cotton for maximum comfort and durability.";
$sizes = array('S', 'M', 'L', 'XL', 'XXL');
$colors = array('Black', 'White', 'Gray', 'Blue', 'Red');
$material = "100% Cotton";
$care = "Machine wash cold, tumble dry low";

// Placeholder related products
$relatedProducts = array(
    array("id" => 1, "name" => "Urban Metro Tee", "price" => "25.99"),
    array("id" => 2, "name" => "District Line Hoodie", "price" => "35.99"),
    array("id" => 3, "name" => "City Skyline Tee", "price" => "22.99")
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?> - Metro District Designs</title>
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
        
        /* Product Detail Page Styles */
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 20px;
        }
        
        .product-detail-container {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .product-main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        
        .product-thumbnails {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .product-thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s ease;
        }
        
        .product-thumbnail.active {
            border-color: #1E1E1E;
        }
        
        .product-title {
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .product-price {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .product-description {
            margin-bottom: 20px;
            line-height: 1.6;
            font-weight: normal;
        }
        
        .product-meta {
            margin-bottom: 20px;
        }
        
        .product-meta-item {
            margin-bottom: 8px;
        }
        
        .option-label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .size-options, .color-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .size-btn, .color-btn {
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
        
        .add-to-cart-btn {
            background-color: #1E1E1E;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            margin-top: 5px;
            transition: background-color 0.3s ease;
            width: 100%;
            font-weight: bold;
            cursor: pointer;
        }
        
        .add-to-cart-btn:hover {
            background-color: #444;
        }
        
        .product-tabs {
            margin-top: 30px;
        }
        
        .nav-tabs .nav-link {
            color: #555;
            font-weight: bold;
        }
        
        .nav-tabs .nav-link.active {
            color: #1E1E1E;
            font-weight: bold;
        }
        
        .tab-content {
            background-color: white;
            border: 1px solid #dee2e6;
            border-top: none;
            padding: 20px;
            font-weight: normal;
        }
        
        .related-products {
            margin-top: 40px;
        }
        
        .related-product-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        
        .related-product-card:hover {
            transform: translateY(-5px);
        }
        
        .related-product-img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }
        
        .related-product-info {
            padding: 15px;
            text-align: center;
        }
        
        .related-product-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .related-product-price {
            color: #555;
        }
        
        /* Product Badge Style */
        .product-badge {
            display: inline-block;
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            margin-bottom: 10px;
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

    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="Homepage.php">Home</a></li>
                <li class="breadcrumb-item"><a href="Products.php">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $name; ?></li>
            </ol>
        </nav>
        
        <!-- Product Detail Section -->
        <div class="product-detail-container">
            <div class="row">
                <!-- Product Images -->
                <div class="col-md-6">
                    <img src="/api/placeholder/500/400" alt="<?php echo $name; ?>" class="product-main-image" id="mainImage">
                    <div class="product-thumbnails">
                        <img src="/api/placeholder/500/400" alt="Front View" class="product-thumbnail active" onclick="changeImage(this, '/api/placeholder/500/400')">
                        <img src="/api/placeholder/500/400?2" alt="Back View" class="product-thumbnail" onclick="changeImage(this, '/api/placeholder/500/400?2')">
                        <img src="/api/placeholder/500/400?3" alt="Side View" class="product-thumbnail" onclick="changeImage(this, '/api/placeholder/500/400?3')">
                        <img src="/api/placeholder/500/400?4" alt="Detail View" class="product-thumbnail" onclick="changeImage(this, '/api/placeholder/500/400?4')">
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="col-md-6">
                    <?php if (!empty($badge)): ?>
                    <div class="product-badge"><?php echo $badge; ?></div>
                    <?php endif; ?>
                    
                    <h2 class="product-title"><?php echo $name; ?></h2>
                    <div class="product-price">$<?php echo $price; ?></div>
                    <div class="product-description"><?php echo $description; ?></div>
                    
                    <div class="product-meta">
                        <div class="product-meta-item"><strong>SKU:</strong> MDD-<?php echo $id; ?></div>
                        <div class="product-meta-item"><strong>Material:</strong> <?php echo $material; ?></div>
                        <div class="product-meta-item"><strong>Care:</strong> <?php echo $care; ?></div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="option-label">Size:</label>
                        <div class="size-options">
                            <?php foreach ($sizes as $size): ?>
                            <div class="size-btn" onclick="selectSize(this)"><?php echo $size; ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="option-label">Color:</label>
                        <div class="color-options">
                            <?php foreach ($colors as $color): ?>
                            <div class="color-btn" onclick="selectColor(this)"><?php echo $color; ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="option-label">Quantity:</label>
                        <div class="quantity-selector">
                            <div class="quantity-btn" onclick="decrementQuantity()">-</div>
                            <input type="text" class="quantity-input" id="quantity" value="1" readonly>
                            <div class="quantity-btn" onclick="incrementQuantity()">+</div>
                        </div>
                    </div>
                    
                    <button class="add-to-cart-btn">
                        <i class="bi bi-cart-plus"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Product Tabs -->
        <div class="product-tabs">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">Details</button>
                </li>
            </ul>
            <div class="tab-content" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <p>The <?php echo $name; ?> is a premium quality t-shirt designed for comfort and style. This unique design captures the essence of urban metro aesthetics, making it perfect for casual outings or as a statement piece.</p>
                    <p>Our designs are printed using high-quality techniques that ensure durability and vibrancy even after multiple washes. The fabric is soft to the touch and breathable, making it comfortable for all-day wear.</p>
                </div>
                <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <ul>
                        <li><strong>Material:</strong> 100% Premium Cotton</li>
                        <li><strong>Weight:</strong> 180 gsm</li>
                        <li><strong>Fit:</strong> Regular</li>
                        <li><strong>Print Technique:</strong> Digital Printing</li>
                        <li><strong>Care Instructions:</strong> Machine wash cold, tumble dry low</li>
                        <li><strong>Origin:</strong> Designed and printed in the USA</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        <div class="related-products">
            <h3 class="mb-4">You May Also Like</h3>
            <div class="row">
                <?php foreach ($relatedProducts as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="related-product-card" onclick="location.href='ProductDetail.php?id=<?php echo $product['id']; ?>&name=<?php echo urlencode($product['name']); ?>&price=<?php echo urlencode($product['price']); ?>'">
                        <img src="/api/placeholder/400/300" alt="<?php echo $product['name']; ?>" class="related-product-img">
                        <div class="related-product-info">
                            <h5 class="related-product-title"><?php echo $product['name']; ?></h5>
                            <div class="related-product-price">$<?php echo $product['price']; ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    
    <script>
    // Change main product image
    function changeImage(element, src) {
        document.getElementById('mainImage').src = src;
        
        // Update active thumbnail
        const thumbnails = document.querySelectorAll('.product-thumbnail');
        thumbnails.forEach(thumb => {
            thumb.classList.remove('active');
        });
        element.classList.add('active');
    }
    
    // Size selection
    function selectSize(element) {
        const sizeOptions = document.querySelectorAll('.size-btn');
        sizeOptions.forEach(option => {
            option.classList.remove('active');
        });
        element.classList.add('active');
    }
    
    // Color selection
    function selectColor(element) {
        const colorOptions = document.querySelectorAll('.color-btn');
        colorOptions.forEach(option => {
            option.classList.remove('active');
        });
        element.classList.add('active');
    }
    
    // Quantity controls
    function incrementQuantity() {
        const quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        quantityInput.value = quantity + 1;
    }
    
    function decrementQuantity() {
        const quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantityInput.value = quantity - 1;
        }
    }
    
    // Add to Cart functionality
    document.querySelector('.add-to-cart-btn').addEventListener('click', function() {
        // Here you would normally add the product to the cart via AJAX
        // For now, simply redirect to cart page
        window.location.href = 'Cart.php';
    });
    </script>
</body>
</html>