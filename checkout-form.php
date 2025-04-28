<?php
    session_start();
    require "db_connection.php";
    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT first_name, last_name, username, email, contact_number, address, postal_code FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result-> fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro District Designs - Checkout</title>
    <!-- Bootstrap CSS (required for the new navbar) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .cart-icon {
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
        }
        
        .cart-count {
            font-size: 0.6rem;
            transform: translate(-50%, -50%);
        }
        
        .nav-icons {
            display: flex;
            align-items: center;
            margin-left: 15px;
        }
        
        /* New styles for layout */
        .navbar {
            padding: 0.5rem 2rem;
            background-color: #222;
        }
        
        .navbar-brand {
            margin-right: 2rem;
            display: flex;
            align-items: center;
            color: white;
            width: 250px; /* Fixed width for brand */
            font-weight: bold; /* Added bold font weight */
        }
        
        .navbar-nav .nav-link {
            text-transform: uppercase;
            font-weight: 700; /* Changed from 500 to 700 for bolder text */
            padding-left: 1rem;
            padding-right: 1rem;
            color: white !important;
        }
        
        .dropdown-toggle {
            color: white !important;
            font-weight: bold; /* Added bold font weight */
        }
        
        .user-controls {
            display: flex;
            align-items: center;
            width: 250px; /* Fixed width to match the brand */
            justify-content: flex-end;
        }
        
        /* Make sure no underline appears on hover for the dropdown */
        .dropdown-toggle:hover {
            text-decoration: none;
        }
        
        .auth-buttons {
            margin-right: 15px;
        }
        
        .auth-buttons .nav-link {
            display: inline-block;
            margin-left: 10px;
            color: white !important;
            text-transform: uppercase;
            font-weight: bold; /* Added bold font weight */
        }
        
        /* Keep nav items truly centered */
        .center-nav {
            display: flex;
            justify-content: center;
            flex-grow: 1;
        }
        /* Original checkout form styles */
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .order-summary {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .item-details {
            display: flex;
        }
        .item-image {
            width: 80px;
            height: 80px;
            background-color: #ddd;
            margin-right: 15px;
        }
        .item-info h3 {
            margin: 0 0 5px 0;
        }
        .item-variants {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 5px;
            font-size: 14px;
            color: #666;
        }
        .variant-item {
            background-color: #f0f0f0;
            padding: 3px 8px;
            border-radius: 3px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #ddd;
        }
        .form-section {
            margin-bottom: 30px;
        }
        .section-title {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group.disabled label {
            color: #888;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            background-color: white;
        }
        input[disabled] {
            background-color: #f9f9f9;
            color: #666;
        }
        .form-row {
            display: flex;
            gap: 20px;
        }
        .form-row > div {
            flex: 1;
        }
        .payment-option {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .payment-option:hover {
            border-color: #999;
        }
        .payment-option.selected {
            border-color: #555;
            background-color: #f9f9f9;
        }
        .payment-radio {
            margin-right: 10px;
        }
        .btn {
            background-color: #222;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
            width: 100%;
        }
        .btn:hover {
            background-color: #444;
        }
        .shipping-option {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .shipping-option:hover {
            border-color: #999;
        }
        .shipping-option.selected {
            border-color: #555;
            background-color: #f9f9f9;
        }
        .shipping-radio {
            margin-right: 10px;
        }
        .shipping-info {
            flex: 1;
        }
        .shipping-price {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- New Navbar with Bold Text -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Logo positioned on the left with fixed width -->
            <a class="navbar-brand" href="index.php">
                <img src="/api/placeholder/40/40" alt="Logo">
                <strong>Metro District Designs</strong>
            </a>
            
            <!-- Mobile toggle button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navbar content with fixed structure -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Centered navigation items in their own container -->
                <div class="center-nav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><strong>HOME</strong></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Products.php"><strong>PRODUCTS</strong></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Inquiry.php"><strong>INQUIRY</strong></a>
                        </li>
                    </ul>
                </div>
                
                <!-- Right-aligned user controls with fixed width -->
                <div class="user-controls">
                    <?php if (isset($_SESSION['username'])): ?>
                        <!-- If logged in: Show Welcome User dropdown and Cart -->
                        <li class="nav-item dropdown list-unstyled">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <strong>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <!-- Admin dropdown items -->
                                    <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                <?php else: ?>
                                    <!-- Regular user dropdown items -->
                                    <li><a class="dropdown-item" href="profile-user.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="messages.php">Messages</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        
                        <!-- Cart icon -->
                        <div class="position-relative d-inline-block nav-icons">
                            <i class="bi bi-cart cart-icon" id="cartIcon"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">
                                0
                            </span>
                        </div>
                    <?php else: ?>
                        <!-- If not logged in: Show Sign-up and Login buttons -->
                        <div class="auth-buttons">
                            <a class="nav-link" href="Signup.php"><strong>SIGN-UP</strong></a>
                            <a class="nav-link" href="Login.php"><strong>LOGIN</strong></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>CHECKOUT</h1>
        
        <div class="order-summary">
            <h2>Order Summary</h2>
            <!-- Order items will be populated here by JavaScript -->
            <div class="total-row">
                <span>Subtotal</span>
                <span>₱ 0.00</span>
            </div>
        </div>

        <form>
            <div class="form-section">
                <h2 class="section-title">Delivery Address</h2>
                <div class="form-row">
                    <div class="form-group disabled">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" value="<?php echo $user['first_name'] ?>" disabled>
                    </div>
                    <div class="form-group disabled">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" value="<?php echo $user['last_name'] ?>" disabled>
                    </div>
                </div>
                
                <div class="form-group disabled">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" value="<?php echo $user['contact_number'] ?>" disabled>
                </div>
                
                <div class="form-group disabled">
                    <label for="address">Complete Address</label>
                    <input type="text" id="address" value="<?php echo $user['address'] ?>" disabled>
                </div>
                
                <div class="form-group disabled">
                    <label for="postalCode">Postal Code</label>
                    <input type="text" id="postalCode" value="<?php echo $user['postal_code'] ?>" disabled>
                </div>
            </div>
            
            <div class="form-section">
                <h2 class="section-title">Shipping Method</h2>
                <div class="shipping-option selected">
                    <input type="radio" name="shipping" id="standard" checked class="shipping-radio" value="standard" checked>
                    <div class="shipping-info">
                        <div><strong>Standard Delivery</strong></div>
                        <div>Receive by Apr 12-15</div>
                    </div>
                    <div class="shipping-price">₱ 100.00</div>
                </div>
                <div class="shipping-option">
                    <input type="radio" name="shipping" id="express" class="shipping-radio" value="express">
                    <div class="shipping-info">
                        <div><strong>Express Delivery</strong></div>
                        <div>Receive by Apr 9-11</div>
                    </div>
                    <div class="shipping-price">₱ 200.00</div>
                </div>
            </div>
            
            <div class="form-section">
                <h2 class="section-title">Payment Method</h2>
                <div class="payment-option selected">
                    <input type="radio" name="payment" id="cod" checked class="payment-radio" checked>
                    <div>Cash on Delivery</div>
                </div>
                <div class="payment-option">
                    <input type="radio" name="payment" id="gcash" class="payment-radio">
                    <div>GCash</div>
                </div>
                <!-- Removed Credit/Debit Card and Bank Transfer payment options -->
            </div>
            
            <div class="total-row" style="font-size: 18px; margin: 30px 0;">
                <span>Total Payment</span>
                <span id="total-payment">₱ 0.00</span>
            </div>
            
            <button type="submit" class="btn">Place Order</button>
        </form>
    </div>

    <!-- Bootstrap JS (required for dropdown functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Cart icon script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cart icon navigation
            const cartIcon = document.getElementById('cartIcon');
            const cartCountBadge = document.querySelector('.cart-count');
            
            if (cartIcon) {
                cartIcon.addEventListener('click', function() {
                    // Navigate to Cart.php when cart icon is clicked
                    window.location.href = 'Cart.php';
                });
            }
            
            // Update cart count from localStorage
            function updateCartCount() {
                if (cartCountBadge) {
                    const cart = JSON.parse(localStorage.getItem('cart')) || [];
                    cartCountBadge.textContent = cart.length;
                    
                    // Hide badge if cart is empty
                    if (cart.length === 0) {
                        cartCountBadge.style.display = 'none';
                    } else {
                        cartCountBadge.style.display = 'block';
                    }
                }
            }
            
            // Initial update
            updateCartCount();
            
            // Listen for storage events to update the count when cart changes
            window.addEventListener('storage', function(e) {
                if (e.key === 'cart') {
                    updateCartCount();
                }
            });
            
            // Also check every few seconds in case local changes are made
            setInterval(updateCartCount, 2000);
        });
    </script>
    
    <!-- Original checkout scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Use checkoutItems instead of cart to get only selected items
            const cart = JSON.parse(localStorage.getItem("checkoutItems")) || [];
            const orderSummaryContainer = document.querySelector(".order-summary");
            const totalRow = document.querySelector(".total-row");
            const shippingOptions = document.querySelectorAll(".shipping-option");
            const totalPaymentElement = document.getElementById("total-payment");

            let shippingFee = 100; // Default shipping fee for standard delivery

            // Function to calculate totals
            function calculateTotals() {
                let subtotal = 0;

                // Calculate subtotal
                cart.forEach(item => {
                    const itemTotal = item.quantity * item.price;
                    subtotal += itemTotal;
                });

                // Update subtotal and total
                const total = subtotal + shippingFee;
                document.querySelector(".total-row span:first-child").textContent = "Subtotal";
                document.querySelector(".total-row span:last-child").textContent = `₱ ${subtotal.toFixed(2)}`;
                totalPaymentElement.textContent = `₱ ${total.toFixed(2)}`;
            }

            // Function to render the cart items in the order summary
            function renderOrderSummary() {
                // Clear existing items
                const existingItems = orderSummaryContainer.querySelectorAll(".order-item");
                existingItems.forEach(item => item.remove());

                // Add cart items to the order summary
                cart.forEach(item => {
                    const itemTotal = item.quantity * item.price;

                    const orderItem = document.createElement("div");
                    orderItem.className = "order-item";
                    orderItem.innerHTML = `
                        <div class="item-details">
                            <div class="item-image" style="background-image: url('${item.image}'); background-size: cover;"></div>
                            <div class="item-info">
                                <h3>${item.name}</h3>
                                <div class="item-variants">
                                    <span class="variant-item">Color: ${item.color}</span>
                                    <span class="variant-item">Size: ${item.size}</span>
                                </div>
                                <p>Quantity: ${item.quantity}</p>
                            </div>
                        </div>
                        <div class="item-price">₱ ${itemTotal.toFixed(2)}</div>
                    `;
                    orderSummaryContainer.insertBefore(orderItem, totalRow);
                });

                // Recalculate totals
                calculateTotals();
            }

            shippingOptions.forEach(option => {
                option.addEventListener("click", function () {
                    // Remove 'selected' class from all options
                    shippingOptions.forEach(opt => opt.classList.remove("selected"));
                    // Add 'selected' class to the clicked option
                    this.classList.add("selected");
                    // Check the corresponding radio button
                    this.querySelector(".shipping-radio").checked = true;
                    shippingFee = parseFloat(this.querySelector(".shipping-price").textContent.replace("₱", "").trim());
                    calculateTotals();
                });
            });

            // Handle payment method selection
            const paymentOptions = document.querySelectorAll(".payment-option");
            paymentOptions.forEach(option => {
                option.addEventListener("click", function () {
                    // Remove 'selected' class from all options
                    paymentOptions.forEach(opt => opt.classList.remove("selected"));
                    // Add 'selected' class to the clicked option
                    this.classList.add("selected");
                    // Check the corresponding radio button
                    this.querySelector(".payment-radio").checked = true;
                });
            });

            renderOrderSummary();
        });
    </script>
    <script>
    document.querySelector("form").addEventListener("submit", async function (event) {
        event.preventDefault();

        // Use checkoutItems instead of cart
        const cart = JSON.parse(localStorage.getItem("checkoutItems")) || [];
        const shippingMethod = document.querySelector(".shipping-option.selected .shipping-radio").value;
        const paymentMethod = document.querySelector(".payment-option.selected .payment-radio").id;
        const shippingFee = parseFloat(document.querySelector(".shipping-option.selected .shipping-price").textContent.replace("₱", "").trim());

        const requestData = {
            items: cart,
            shipping_method: shippingMethod,
            payment_method: paymentMethod,
            shipping_fee: shippingFee
        };

        try {
            const response = await fetch("api/checkout.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(requestData)
            });

            const result = await response.json();

            if (response.ok) {
                // Clear only the selected items from the cart
                const allCartItems = JSON.parse(localStorage.getItem("cart")) || [];
                const checkoutItemIds = cart.map(item => item.productId);
                
                // Filter out the items that were checked out
                const remainingItems = allCartItems.filter(item => 
                    !checkoutItemIds.includes(item.productId)
                );
                
                // Update the main cart
                localStorage.setItem("cart", JSON.stringify(remainingItems));
                
                // Clear checkout items
                localStorage.removeItem("checkoutItems");
                
                alert("Order placed successfully!");
                location.href = "Products.php";
            } else {
                // Handle errors
                alert(result.error || "An error occurred during checkout.");
            }
        } catch (error) {
            console.error("Checkout error:", error);
            alert("An error occurred. Please try again.");
        }
    });
    </script>
</body>
</html>