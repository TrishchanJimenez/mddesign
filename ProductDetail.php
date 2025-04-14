<?php
require_once "db_connection.php";

// Get product ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$productQuery = "
    SELECT 
        dp.product_name,
        dp.description,
        p.stock,
        p.price,
        p.color,
        p.size
    FROM 
        display_product dp
    INNER JOIN 
        products p ON dp.product_name = p.name
    WHERE 
        dp.id = ?
";
$productStmt = $conn->prepare($productQuery);
$productStmt->bind_param("i", $id);
$productStmt->execute();
$productResult = $productStmt->get_result();
$productDetails = $productResult->fetch_all(MYSQLI_ASSOC);
$productStmt->close();

// Fetch product images
$imageQuery = "SELECT image_path FROM display_images WHERE product_id = ?";
$imageStmt = $conn->prepare($imageQuery);
$imageStmt->bind_param("i", $id);
$imageStmt->execute();
$imageResult = $imageStmt->get_result();
$productImages = $imageResult->fetch_all(MYSQLI_ASSOC);
$imageStmt->close();

// Organize data by size and color
$sizeColorStock = [];
foreach ($productDetails as $detail) {
    $size = $detail['size'];
    $color = $detail['color'];
    $stock = $detail['stock'];

    if (!isset($sizeColorStock[$size])) {
        $sizeColorStock[$size] = [];
    }
    $sizeColorStock[$size][$color] = $stock;
}

$sizes = [];
$colors = [];
foreach ($productDetails as $detail) {
    if (!in_array($detail['size'], $sizes)) {
        $sizes[] = $detail['size'];
    }
    if (!in_array($detail['color'], $colors)) {
        $colors[] = $detail['color'];
    }
}

// Set default product details
$productName = $productDetails[0]['product_name'] ?? 'Product Name';
$description = $productDetails[0]['description'] ?? 'No description available.';
$price = $productDetails[0]['price'] ?? '0.00';
?>

<?php
    $page_title = htmlspecialchars($productName) . " - Metro District Designs ";
    require_once "header.php";
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

        &.disabled {
            opacity: 0.8;
            cursor: not-allowed;
        }
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

        &:hover {
            background-color: #444;
        }

        &:disabled {
            opacity: 0.8;
        }

        &:disabled:hover {
            background-color: #1E1E1E;
            opacity: 0.8;
            cursor: not-allowed;
        }
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
<body class="content">
    <!-- <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="index.php">
                <img src="/api/placeholder/40/40" class="rounded-circle" alt="Logo">
                Metro District Designs
            </a>
            <div class="mx-auto">
                <a href="index.php" class="nav-link d-inline-block">HOME</a>
                <a href="Products.php" class="nav-link d-inline-block">PRODUCTS</a>
                <a href="Inquiry.php" class="nav-link d-inline-block">INQUIRY</a>
            </div>
            <div>
                <a href="Signup.php" class="login-links">SIGN-UP</a>
                <a href="Login.php" class="login-links">LOGIN</a>
            </div>
        </div>
    </nav> -->
    <?php require_once "navbar.php"; ?>

    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="Products.php">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($productName); ?></li>
            </ol>
        </nav>
        
        <!-- Product Detail Section -->
        <div class="product-detail-container">
            <div class="row">
                <!-- Product Images -->
                <div class="col-md-6">
                    <img src="<?php echo htmlspecialchars($productImages[0]['image_path'] ?? '/api/placeholder/500/400'); ?>" alt="<?php echo htmlspecialchars($productName); ?>" class="product-main-image" id="mainImage">
                    <div class="product-thumbnails">
                        <?php foreach ($productImages as $image): ?>
                            <img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="Product Image" class="product-thumbnail" onclick="changeImage(this, '<?php echo htmlspecialchars($image['image_path']); ?>')">
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="col-md-6">
                    <h2 class="product-title"><?php echo htmlspecialchars($productName); ?></h2>
                    <div class="product-price">₱<?php echo htmlspecialchars($price); ?></div>
                    <div class="product-description"><?php echo htmlspecialchars($description); ?></div>

                    
                    <div class="mb-3">
                        <label class="option-label">Size:</label>
                        <div class="size-options">
                            <?php foreach ($sizes as $size): ?>
                                <div class="size-btn" onclick="selectSize(this)"><?php echo htmlspecialchars($size); ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="option-label">Color:</label>
                        <div class="color-options">
                            <?php foreach ($colors as $color): ?>
                                <div class="color-btn" onclick="selectColor(this)"><?php echo htmlspecialchars($color); ?></div>
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

                    <button class="add-to-cart-btn" id="addToCartBtn" <?php echo $stock === 0 ? 'disabled' : ''; ?>>
                        <?php echo $stock === 0 ? 'Out of Stock' : '<i class="bi bi-cart-plus"></i> Add to Cart'; ?>
                    </button>
                </div>
            </div>
        </div>
        
        <?php
            // Fetch related products with unique names and stock
            $relatedProductsQuery = "
                SELECT 
                    p.name, 
                    MIN(p.id) AS id, 
                    MIN(p.price) AS price,
                    dp.id AS display_id,
                    (SELECT di.image_path 
                    FROM display_images di 
                    INNER JOIN display_product dp ON dp.id = di.product_id 
                    WHERE dp.product_name = p.name 
                    LIMIT 1) AS image_path
                FROM products p
                INNER JOIN display_product dp ON dp.product_name = p.name
                WHERE p.stock > 0 AND p.name != ?
                GROUP BY p.name, dp.id
                LIMIT 3
            ";
            $relatedProductsStmt = $conn->prepare($relatedProductsQuery);
            $relatedProductsStmt->bind_param("s", $productName);
            $relatedProductsStmt->execute();
            $relatedProductsResult = $relatedProductsStmt->get_result();
            $relatedProducts = $relatedProductsResult->fetch_all(MYSQLI_ASSOC);
            $relatedProductsStmt->close();
        ?>
        <!-- Related Products -->
        <?php if(!empty($relatedProducts)): ?>
            <div class="related-products">
                <h3 class="mb-4">You May Also Like</h3>
                <div class="row">
                    <?php foreach ($relatedProducts as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="related-product-card" onclick="location.href='ProductDetail.php?id=<?php echo $product['display_id'] ?>'">
                            <img src="<?php echo $product['image_path']?>" alt="<?php echo $product['name']; ?>" class="related-product-img">
                            <div class="related-product-info">
                                <h5 class="related-product-title"><?php echo $product['name']; ?></h5>
                                <div class="related-product-price">₱<?php echo $product['price']; ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    
    <script>
    let selectedColor = null;
    let selectedSize = null;
    let quantityBtnDisabled = true;
    let sizeColorStock = <?php echo json_encode($sizeColorStock); ?>;

    function selectSize(element) {
        console.log("selected size");
        const sizeOptions = document.querySelectorAll('.size-btn');
        sizeOptions.forEach(option => option.classList.remove('active'));
        element.classList.add('active');
        selectedSize = element.textContent.trim();

        // Update the available colors
        updateAvailableColors();
        validateSelections();
    }

    function updateAvailableColors() {
        const colorContainer = document.querySelector('.color-options');
        colorContainer.innerHTML = ''; // Clear existing colors

        if (selectedSize && sizeColorStock[selectedSize]) {
            const colors = Object.keys(sizeColorStock[selectedSize]);
            colors.forEach(color => {
                const colorBtn = document.createElement('div');
                colorBtn.className = 'color-btn';
                colorBtn.textContent = color;
                colorBtn.onclick = () => selectColor(colorBtn);
                colorContainer.appendChild(colorBtn);
            });
        }

        // Reset selected color
        selectedColor = null;
    }

    // Change main product image
    function changeImage(element, src) {
        document.getElementById('mainImage').src = src;
        const thumbnails = document.querySelectorAll('.product-thumbnail');
        thumbnails.forEach(thumb => thumb.classList.remove('active'));
        element.classList.add('active');
    }

    // Color selection
    function selectColor(element) {
        const colorOptions = document.querySelectorAll('.color-btn');
        colorOptions.forEach(option => option.classList.remove('active'));
        element.classList.add('active');
        selectedColor = element.textContent.trim();
        validateSelections();
    }

    // Quantity controls
    function incrementQuantity() {
        if(quantityBtnDisabled) return;
        const quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        const maxQuantity = parseInt(quantityInput.max);
        if(maxQuantity === 0) return;

        if (quantity < maxQuantity) {
            quantityInput.value = quantity + 1;
        } else {
            alert(`Only ${maxQuantity} item(s) are in stock.`);
        }
    }

    function decrementQuantity() {
        if(quantityBtnDisabled) return;
        const quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantityInput.value = quantity - 1;
        }
    }

    // Add to Cart functionality
    document.getElementById('addToCartBtn').addEventListener('click', function () {
        const quantity = parseInt(document.getElementById('quantity').value);
        const mainImage = document.getElementById('mainImage').src;

        if (!selectedSize || !selectedColor) {
            alert('Please select both size and color.');
            return;
        }

        // Create cart item object
        const cartItem = {
            id: <?php echo $id; ?>, // Product ID
            name: "<?php echo htmlspecialchars($productName); ?>", // Product name
            image: "<?php echo htmlspecialchars($productImages[0]['image_path']); ?>",
            size: selectedSize, // Selected size
            color: selectedColor, // Selected color
            quantity: quantity, // Selected quantity
            price: <?php echo $price; ?> // Product price
        };

        // Retrieve existing cart from localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Check if the item already exists in the cart
        const existingItemIndex = cart.findIndex(item => 
            item.id === cartItem.id && 
            item.size === cartItem.size && 
            item.color === cartItem.color
        );

        if (existingItemIndex > -1) {
            // Update quantity if the item already exists
            cart[existingItemIndex].quantity = quantity;
        } else {
            // Add new item to the cart
            cart.push(cartItem);
        }

        // Save updated cart back to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
        location.href = "cart.php";
    });

    // Validate if both color and size are selected
    function validateSelections() {
        const addToCartBtn = document.getElementById('addToCartBtn');
        const quantityControls = document.querySelectorAll('.quantity-btn');
        const quantityInput = document.getElementById('quantity');
        

        if (selectedSize && selectedColor) {
            const stock = sizeColorStock[selectedSize][selectedColor] || 0;
        

            if (stock > 0) {
                quantityBtnDisabled = false;
                addToCartBtn.disabled = false;
                quantityControls.forEach(btn => btn.classList.remove("disabled"));
                quantityInput.disabled = false;
                quantityInput.value = 1; // Reset quantity to 1
                quantityInput.max = stock; // Set max quantity
                addToCartBtn.innerHTML = '<i class="bi bi-cart-plus"></i> Add to Cart';
            } else {
                addToCartBtn.disabled = true;
                quantityControls.forEach(btn => btn.disabled = true);
                quantityInput.disabled = true;
                quantityInput.value = 0; // Reset quantity to 0
                quantityInput.max = stock; // Set max quantity
                addToCartBtn.innerHTML = "Out of Stock";

            }
        } else {
            addToCartBtn.disabled = true;
            addToCartBtn.innerHTML = '<i class="bi bi-cart-plus"></i> Add to Cart';
            quantityControls.forEach(btn => btn.classList.add("disabled"));
            quantityInput.disabled = true;
            quantityInput.value = 0; // Reset quantity to 0
        }
    }
    
    validateSelections();
    </script>
</body>
</html>