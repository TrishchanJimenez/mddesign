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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #222;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            display: flex;
            align-items: center;
            font-size: 20px;
            font-weight: bold;
        }
        .nav-links {
            display: flex;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
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
    <div class="navbar">
        <div class="logo">
            🌎 Metro District Designs
        </div>
        <div class="nav-links">
            <a href="#">HOME</a>
            <a href="#">PRODUCTS</a>
            <a href="#">INQUIRY</a>
            <a href="#" class="cart-icon">🛒</a>
        </div>
    </div>

    <div class="container">
        <h1>CHECKOUT</h1>
        
        <div class="order-summary">
            <h2>Order Summary</h2>
            <div class="order-item">
                <div class="item-details">
                    <div class="item-image"></div>
                    <div class="item-info">
                        <h3>Test Design T-Shirt</h3>
                        <div class="item-variants">
                            <span class="variant-item">Color: Black</span>
                            <span class="variant-item">Size: Medium</span>
                        </div>
                        <p>Quantity: 1</p>
                    </div>
                </div>
                <div class="item-price">₱ 1,500.00</div>
            </div>
            <div class="total-row">
                <span>Subtotal</span>
                <span>₱ 1,500.00</span>
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
                <div class="payment-option">
                    <input type="radio" name="payment" id="card" class="payment-radio">
                    <div>Credit/Debit Card</div>
                </div>
                <div class="payment-option">
                    <input type="radio" name="payment" id="bank" class="payment-radio">
                    <div>Bank Transfer</div>
                </div>
            </div>
            
            <div class="total-row" style="font-size: 18px; margin: 30px 0;">
                <span>Total Payment</span>
                <span id="total-payment">₱ 1,600.00</span>
            </div>
            
            <button type="submit" class="btn">Place Order</button>
        </form>
    </div>
</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
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

    const cart = JSON.parse(localStorage.getItem("cart")) || [];
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
            // Clear the cart and redirect to a success page
            localStorage.removeItem("cart");
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