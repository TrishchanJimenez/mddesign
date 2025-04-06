<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro District Designs - Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .navbar {
            background-color: #1E1E1E;
            padding: 10px 0;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: white !important;
            font-weight: bold;
        }

        .navbar-nav {
            flex-grow: 1;
            justify-content: center;
        }

        .navbar-nav .nav-link {
            color: white !important;
            text-transform: uppercase;
            font-weight: bold;
            margin: 0 10px;
        }

        .navbar-nav.ms-auto {
            margin-right: 0 !important;
            align-items: center;
        }

        .nav-icons {
            display: flex;
            align-items: center;
            color: white;
        }

        .nav-icons i {
            cursor: pointer;
            margin-left: 15px;
        }

        .cart-icon {
            transition: color 0.3s ease;
        }

        .cart-icon:hover {
            color: #aaa;
        }

        .cart-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .order-item {
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .order-item-image {
            width: 100px;
            height: 100px;
            background-color: #d3d3d3;
            margin-right: 15px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 5px 10px;
        }

        .checkout-btn {
            width: 100%;
            background-color: #1E1E1E;
            color: white;
        }
        
        .remove-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        
        .remove-btn:hover {
            background-color: #bd2130;
        }
        
        .item-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="Homepage.php">
                <img src="/api/placeholder/40/40" class="rounded-circle">
                Metro District Designs
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="Homepage.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Products.php">PRODUCTS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Inquiry.php">INQUIRY</a>
                    </li>
                </ul>
                    <li class="nav-item nav-icons">
                        <i class="bi bi-cart cart-icon" id="cartIcon"></i>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Container -->
    <div class="container">
        <div class="cart-container">
            <h2 class="mb-4">ORDERS</h2>
            <div class="order-item">
                <div class="order-item-image"></div>
                <div class="flex-grow-1">
                    <h5>Test Design</h5>
                    <p>Price: ₱</p>
                    <div class="item-controls">
                        <div class="quantity-control">
                            <button class="btn quantity-btn">-</button>
                            <input type="text" class="form-control mx-2 text-center" value="1" style="width: 60px;">
                            <button class="btn quantity-btn">+</button>
                        </div>
                        <button class="remove-btn" id="removeItem"><i class="bi bi-trash"></i> Remove</button>
                    </div>
                </div>
            </div>
            <button class="btn checkout-btn mt-3">Check Out</button>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cart icon navigation
            const cartIcon = document.getElementById('cartIcon');
            cartIcon.addEventListener('click', function() {
                // Navigate to Cart.php when cart icon is clicked
                window.location.href = 'Cart.php';
            });
            
            // Remove item functionality
            const removeButton = document.getElementById('removeItem');
            removeButton.addEventListener('click', function() {
                // Here you would typically send an AJAX request to remove the item
                // For now, just remove the element from the DOM
                const orderItem = this.closest('.order-item');
                orderItem.remove();
                
                // You might want to check if cart is empty and show a message
                const orderItems = document.querySelectorAll('.order-item');
                if (orderItems.length === 0) {
                    const cartContainer = document.querySelector('.cart-container');
                    const emptyMessage = document.createElement('p');
                    emptyMessage.textContent = 'Your cart is empty';
                    emptyMessage.className = 'text-center mt-4';
                    cartContainer.insertBefore(emptyMessage, document.querySelector('.checkout-btn'));
                    
                    // Disable checkout button
                    document.querySelector('.checkout-btn').disabled = true;
                }
            });
        });
    </script>
</body>
</html>