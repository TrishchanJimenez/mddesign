<?php
require_once "db_connection.php";
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="/api/placeholder/40/40" class="rounded-circle" alt="Logo">
            Metro District Designs
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Products.php">PRODUCTS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Inquiry.php">INQUIRY</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="Signup.php">SIGN-UP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Login.php">LOGIN</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item nav-icons">
                    <?php if (isset($_SESSION['username'])): ?>
                        <i class="bi bi-cart cart-icon" id="cartIcon"></i>
                    <?php endif; ?>
                    <div class="search-container">
                        <i class="bi bi-search search-icon" id="searchToggle"></i>
                        <div class="search-popup" id="searchPopup">
                            <input type="text" placeholder="Search designs..." id="searchInput">
                        </div>
                    </div>
                    <?php if (isset($_SESSION['username'])): ?>
                        <i class="fas fa-user" onclick='location.href="profile-user.php"'></i>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Search popup functionality
    const searchToggle = document.getElementById('searchToggle');
    const searchPopup = document.getElementById('searchPopup');
    const searchInput = document.getElementById('searchInput');

    // Toggle search popup
    searchToggle.addEventListener('click', function(e) {
        searchPopup.classList.toggle('show');
        if (searchPopup.classList.contains('show')) {
            searchInput.focus();
        }
        e.stopPropagation();
    });

    // Close search popup when clicking outside
    document.addEventListener('click', function() {
        searchPopup.classList.remove('show');
    });

    // Prevent search popup from closing when clicking inside
    searchPopup.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Cart icon navigation
    const cartIcon = document.getElementById('cartIcon');
    cartIcon.addEventListener('click', function() {
        // Navigate to Cart.php when cart icon is clicked
        window.location.href = 'Cart.php';
    });
});
</script>