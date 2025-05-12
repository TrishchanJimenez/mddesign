<?php
    session_start();
    $page_title = "Metro District Designs - Cart";
    require_once "header.php";
?>
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

    .cart-container {
        max-width: 800px;
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
        margin-top: 10px;
    }

    .quantity-btn {
        background-color: #f0f0f0;
        border: 1px solid #ddd;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .quantity-input {
        width: 50px !important;
        text-align: center;
        margin: 0 5px;
    }

    .checkout-btn {
        width: 100%;
        background-color: #1E1E1E;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .checkout-btn:disabled {
        cursor: not-allowed;
        opacity: 0.8;
    }

    .remove-btn {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .item-details {
        flex-grow: 1;
    }
    
    /* Size and color styles */
    .option-group {
        margin-top: 5px;
    }
    
    .option-label {
        font-weight: bold;
        margin-right: 5px;
    }
    
    .size-selector, .color-selector {
        padding: 4px 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    /* Cart summary styles */
    .cart-summary {
        margin-top: 20px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 6px;
    }

    .cart-total {
        display: flex;
        justify-content: space-between;
        font-size: 18px;
        font-weight: bold;
        padding: 10px 0;
        border-top: 1px solid #ddd;
    }
    
    /* Select All styles */
    .select-all-container {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 6px;
    }
    
    /* Item selection checkbox */
    .item-checkbox {
        margin-right: 10px;
        width: 18px;
        height: 18px;
    }
    
    .checkbox-container {
        display: flex;
        align-items: center;
    }
</style>
<body>
    <!-- Navbar -->
    <?php require_once "navbar.php"; ?>

    <!-- Cart Container -->
    <div class="container">
        <div class="cart-container">
            <h2 class="mb-4">ORDERS</h2>
            
            <!-- Select All Container -->
            <div class="select-all-container">
                <div class="checkbox-container">
                    <input type="checkbox" id="select-all-checkbox" class="item-checkbox">
                    <label for="select-all-checkbox"><strong>Select All Products</strong></label>
                </div>
            </div>
            
            <div id="cart-items">
                 
            </div>
            <!-- Cart Summary Section -->
            <div class="cart-summary">
                <div class="cart-total">
                    <span>Total Amount:</span>
                    <span>₱<span id="cart-total-amount">0.00</span></span>
                </div>
                <div class="mt-2">
                    <span>Total Items: <span id="total-items-count">0</span></span>
                </div>
            </div>
            <button class="checkout-btn" id="checkout-btn" onclick="proceedToCheckout()">Check Out</button>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartItemsContainer = document.getElementById('cart-items');
            const checkoutBtn = document.getElementById('checkout-btn');
            const cartTotalAmount = document.getElementById('cart-total-amount');
            const totalItemsCount = document.getElementById('total-items-count');
            const selectAllCheckbox = document.getElementById('select-all-checkbox');

            // Fetch cart data from localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Add selected property to each cart item if it doesn't exist
            cart = cart.map(item => ({
                ...item,
                selected: item.selected !== undefined ? item.selected : true
            }));
            
            // Update cart in localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Function to fetch stock data from the server
            async function fetchStockData(productId) {
                const response = await fetch(`api/get_stock.php?id=${productId}`);
                const data = await response.json();
                return data.stock || {};
            }

            async function renderCartItem(item, index) {
                const stockData = await fetchStockData(item.id);
                if(item.size && item.color) {
                    if(cart[index]?.productId !== stockData[item.size][item.color].id) {
                        cart[index].productId = stockData[item.size][item.color].id;
                        updateCart();
                    }
                }

                const cartItem = document.createElement('div');
                cartItem.className = 'order-item';
                cartItem.dataset.index = index; // Add a data attribute for easy identification
                cartItem.innerHTML = `
                    <div class="checkbox-container">
                        <input type="checkbox" class="item-checkbox" data-index="${index}" ${item.selected ? 'checked' : ''}>
                    </div>
                    <div class="order-item-image">
                        <img src="${item.image}" alt="${item.name}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="item-details">
                        <h5>${item.name}</h5>
                        <p>Price: ₱<span class="item-price">${item.price}</span></p>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="option-group">
                                <span class="option-label">Size:</span>
                                <select class="size-selector" data-index="${index}" ${!item.selected ? 'disabled' : ''}>
                                    <option value="">Select Size</option>
                                    ${Object.keys(stockData)
                                        .filter(size => Object.values(stockData[size]).some(colorData => colorData.quantity > 0)) // Only show sizes with available stock
                                        .map(size => `
                                            <option value="${size}" ${size === item.size ? 'selected' : ''}>${size}</option>
                                        `).join('')}
                                </select>
                            </div>
                            <div class="option-group">
                                <span class="option-label">Color:</span>
                                <select class="color-selector" data-index="${index}" ${!item.selected || !item.size ? 'disabled' : ''}>
                                    <option value="">Select Color</option>
                                    ${item.size && stockData[item.size] 
                                        ? Object.keys(stockData[item.size])
                                            .filter(color => stockData[item.size][color].quantity > 0) // Only show colors with available stock
                                            .map(color => `
                                                <option value="${color}" ${color === item.color ? 'selected' : ''}>${color}</option>
                                            `).join('')
                                        : ''}
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="quantity-control">
                                <button class="quantity-btn decrease-btn" data-index="${index}" ${!item.selected || !item.size || !item.color ? 'disabled' : ''}>-</button>
                                <input type="text" class="quantity-input" value="${item.quantity}" max="${item.size && item.color ? stockData[item.size][item.color]?.quantity || 0 : 0}" readonly>
                                <button class="quantity-btn increase-btn" data-index="${index}" ${!item.selected || !item.size || !item.color ? 'disabled' : ''}>+</button>
                            </div>
                            <button class="remove-btn" data-index="${index}">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                        </div>
                        <p class="mt-2">Subtotal: ₱<span class="item-subtotal">${(item.price * item.quantity).toFixed(2)}</span></p>
                    </div>
                `;
                return cartItem;
            }

            // Function to calculate and update the total amount for all items
            function updateTotalAmount() {
                const total = cart.reduce((sum, item) => {
                    // Only include selected items with size and color in the total
                    if (item.selected && item.size && item.color) {
                        return sum + (item.price * item.quantity);
                    }
                    return sum;
                }, 0);
                
                cartTotalAmount.textContent = total.toFixed(2);
                
                // Store the total in localStorage for checkout
                localStorage.setItem('cartTotal', total.toFixed(2));
                
                // Update total items count
                const validItemsCount = cart.filter(item => item.selected && item.size && item.color).length;
                totalItemsCount.textContent = validItemsCount;
                
                // Disable checkout button if no valid items
                checkoutBtn.disabled = validItemsCount === 0;
                
                return total;
            }

            // Function to render cart items
            async function renderCart() {
                cartItemsContainer.innerHTML = ''; // Clear existing items
                if (cart.length === 0) {
                    cartItemsContainer.innerHTML = '<p>Your cart is empty. <a href="Products.php">Continue shopping</a>.</p>';
                    checkoutBtn.disabled = true;
                    cartTotalAmount.textContent = '0.00';
                    totalItemsCount.textContent = '0';
                    selectAllCheckbox.disabled = true;
                    return;
                }

                selectAllCheckbox.disabled = false;

                for (let index = 0; index < cart.length; index++) {
                    const item = cart[index];
                    const cartItem = await renderCartItem(item, index);
                    cartItemsContainer.appendChild(cartItem);
                }

                // Update select all checkbox state
                updateSelectAllCheckbox();
                updateTotalAmount();
                
                // Apply selections to UI automatically
                applySelections();
            }

            async function updateCartItem(index) {
                const item = cart[index];
                const existingItem = document.querySelector(`.order-item[data-index="${index}"]`);
                if (existingItem) {
                    const updatedItem = await renderCartItem(item, index);
                    cartItemsContainer.replaceChild(updatedItem, existingItem);
                    updateTotalAmount();
                } 
            }

            // Update cart in localStorage
            function updateCart() {
                localStorage.setItem('cart', JSON.stringify(cart));
                updateTotalAmount();
                
                // Automatically apply selections whenever cart is updated
                applySelections();
            }
            
            // Update select all checkbox based on individual item selections
            function updateSelectAllCheckbox() {
                if (cart.length === 0) {
                    selectAllCheckbox.checked = false;
                    return;
                }
                
                const allSelected = cart.every(item => item.selected);
                selectAllCheckbox.checked = allSelected;
            }
            
            // Apply selections to enable/disable controls based on selection state
            function applySelections() {
                cart.forEach((item, index) => {
                    const sizeSelector = document.querySelector(`.size-selector[data-index="${index}"]`);
                    const colorSelector = document.querySelector(`.color-selector[data-index="${index}"]`);
                    const decreaseBtn = document.querySelector(`.decrease-btn[data-index="${index}"]`);
                    const increaseBtn = document.querySelector(`.increase-btn[data-index="${index}"]`);
                    
                    if (sizeSelector) {
                        sizeSelector.disabled = !item.selected;
                    }
                    
                    if (colorSelector) {
                        colorSelector.disabled = !item.selected || !item.size;
                    }
                    
                    if (decreaseBtn && increaseBtn) {
                        const disabled = !item.selected || !item.size || !item.color;
                        decreaseBtn.disabled = disabled;
                        increaseBtn.disabled = disabled;
                    }
                });
            }

            // Handle select all checkbox
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                
                // Update all items' selected property
                cart = cart.map(item => ({
                    ...item,
                    selected: isChecked
                }));
                
                // Update checkboxes in the UI
                document.querySelectorAll('.item-checkbox:not(#select-all-checkbox)').forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                
                // Apply selections automatically
                updateCart();
            });

            cartItemsContainer.addEventListener('change', async function (event) {
                const target = event.target;
                
                if (target.classList.contains('item-checkbox') && !target.id) {
                    const index = parseInt(target.dataset.index, 10);
                    cart[index].selected = target.checked;
                    
                    // Update select all checkbox state
                    updateSelectAllCheckbox();
                    updateCart();
                }

                if (target.classList.contains('size-selector')) {
                    const index = parseInt(target.dataset.index, 10);
                    const selectedSize = target.value;

                    const cartItem = cart[index];

                    cartItem.size = selectedSize;
                    cartItem.quantity = 1;  // Set default quantity to 1 when size is selected
                    cartItem.color = ''; // Reset color when size changes
                    updateCart();
                    await updateCartItem(index);
                }

                if (target.classList.contains('color-selector')) {
                    const index = parseInt(target.dataset.index, 10);
                    const selectedColor = target.value;

                    const cartItem = cart[index];

                    cartItem.color = selectedColor;
                    if (cartItem.quantity === 0) {
                        cartItem.quantity = 1;  // Set default quantity to 1 when color is selected
                    }

                    updateCart();
                    await updateCartItem(index);
                }
            });

            // Handle quantity changes
            cartItemsContainer.addEventListener('click', async function (event) {
                const target = event.target;

                if (target.classList.contains('increase-btn')) {
                    const index = parseInt(target.dataset.index, 10);
                    const cartItem = cart[index];

                    const quantityInput = target.previousElementSibling;
                    const maxStock = parseInt(quantityInput.max);

                    if (cartItem.quantity < maxStock) {
                        cartItem.quantity++;
                        quantityInput.value = cartItem.quantity;
                        
                        // Update subtotal display
                        const orderItem = target.closest('.order-item');
                        const subtotalElement = orderItem.querySelector('.item-subtotal');
                        subtotalElement.textContent = (cartItem.price * cartItem.quantity).toFixed(2);
                        
                        updateCart();
                    } else {
                        alert(`Only ${maxStock} item(s) are in stock`);
                    }
                }

                if (target.classList.contains('decrease-btn')) {
                    const index = parseInt(target.dataset.index, 10);
                    const cartItem = cart[index];

                    const quantityInput = target.nextElementSibling;

                    if (cartItem.quantity > 1) {
                        cartItem.quantity--;
                        quantityInput.value = cartItem.quantity;
                        
                        // Update subtotal display
                        const orderItem = target.closest('.order-item');
                        const subtotalElement = orderItem.querySelector('.item-subtotal');
                        subtotalElement.textContent = (cartItem.price * cartItem.quantity).toFixed(2);
                        
                        updateCart();
                    }
                }

                if (target.classList.contains('remove-btn')) {
                    const index = parseInt(target.dataset.index, 10);

                    cart.splice(index, 1); // Remove the item from the cart array
                    updateCart();
                    renderCart(); // Re-render the entire cart since the indices have changed
                }
            });
            
            // Function to proceed to checkout with selected valid items
            window.proceedToCheckout = function() {
                // Filter only selected items with size and color selected
                const validItems = cart.filter(item => item.selected && item.size && item.color);
                
                if (validItems.length === 0) {
                    alert('Please select at least one item with size and color to checkout');
                    return;
                }
                
                // Store items for checkout page
                localStorage.setItem('checkoutItems', JSON.stringify(validItems));
                
                // Navigate to checkout page
                window.location.href = 'checkout-form.php';
            };

            // Initial render
            renderCart();
        });
    </script>
</body>
</html>