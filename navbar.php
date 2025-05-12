<?php
require_once "db_connection.php";
?>
<style>
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
</style>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <!-- Logo positioned on the left with fixed width -->
        <a class="navbar-brand" href="index.php">
            <img src="images/TSHIRTS/LOGO.jpg" alt="Logo">
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
                                <li><a class="dropdown-item" href="orders.php">Orders</a></li>
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