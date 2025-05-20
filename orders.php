<?php
    session_start();
    require_once "header.php";
    require_once "db_connection.php";
    
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page if not logged in
        header("Location: Login.php");
        exit();
    }
    
    $user_id = $_SESSION['user_id'];
    
    // Define status filter if provided
    $status_filter = isset($_GET['status']) ? $_GET['status'] : 'to_pay'; // Default to 'To Pay' instead of 'all'
    
    // Updated query to join with reference tables for addresses
    $query = "
        SELECT 
            o.id AS order_id,
            o.order_date,
            o.total_amount,
            o.status,
            o.shipping_method,
            o.payment_method,
            o.shipping_fee,
            CONCAT(
                a.street_address, ', ',
                b.brgyDesc, ', ',
                c.citymunDesc, ', ',
                p.provDesc, ', ',
                r.regDesc, ' ',
                a.postal_code
            ) AS shipping_address
        FROM 
            orders o
        JOIN 
            addresses a ON o.address_id = a.id
        LEFT JOIN 
            refbrgy b ON a.brgyCode = b.brgyCode
        LEFT JOIN 
            refcitymun c ON a.citymunCode = c.citymunCode
        LEFT JOIN 
            refprovince p ON a.provCode = p.provCode
        LEFT JOIN 
            refregion r ON a.regCode = r.regCode
        WHERE 
            o.user_id = ?
            AND o.status = ?
        ORDER BY o.order_date DESC;
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $user_id, $status_filter);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);
?>
<style>
    body {
        font-family: Helvetica, sans-serif;
        font-weight: bold;
    }
    
    .colorful-divider {
        height: 5px;
        background: gray;
    }
    
    .hero-banner {
        background: gray;
        text-align: center;
        font-style: italic;
        padding: 15px 0;
    }
    
    .hero-banner h1 {
        color: black;
        font-size: 2.5rem;
        margin-bottom: 10px;
        font-family: Helvetica, sans-serif;
        font-weight: bold;
    }
    
    .order-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .order-header {
        background-color: #f8f9fa;
        padding: 15px;
        border-bottom: 1px solid #ddd;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .order-body {
        padding: 20px;
    }
    
    .order-status {
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 15px;
        display: inline-block;
        text-transform: uppercase;
        font-size: 0.8rem;
    }
    
    .status-processing, .status-to-pay {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-shipped, .status-to-ship {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    .status-delivered, .status-to-receive {
        background-color: #cce5ff;
        color: #004085;
    }
    
    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .status-return, .status-refund {
        background-color: #e2e3e5;
        color: #383d41;
    }
    
    .order-details {
        margin: 15px 0;
    }
    
    .order-details p {
        margin-bottom: 8px;
    }
    
    .tracking-info {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin-top: 15px;
    }
    
    .order-items-toggle {
        background-color: transparent;
        border: none;
        color: #007bff;
        padding: 0;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
    }
    
    .order-items-toggle i {
        margin-left: 5px;
        transition: transform 0.3s;
    }
    
    .order-items-toggle.collapsed i {
        transform: rotate(-90deg);
    }
    
    .order-items {
        margin-top: 15px;
    }
    
    .item-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    
    .item-row:last-child {
        border-bottom: none;
    }
    
    .no-orders {
        text-align: center;
        padding: 40px 0;
        background-color: #f8f9fa;
        border-radius: 8px;
        margin-top: 20px;
    }
    
    .btn-track {
        background-color: #222;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s;
    }
    
    .btn-track:hover {
        background-color: #444;
        color: white;
    }
    
    /* Status filter tabs styles */
    .status-tabs {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin: 20px 0;
        border-bottom: 1px solid #ddd;
    }
    
    .status-tab {
        padding: 10px 20px;
        margin: 0 5px;
        cursor: pointer;
        position: relative;
        text-align: center;
        color: #495057;
        transition: all 0.3s;
        font-weight: 500;
    }
    
    .status-tab:hover {
        color: #007bff;
    }
    
    .status-tab.active {
        color: #007bff;
        border-bottom: 2px solid #007bff;
    }
    
    .status-tab .badge {
        position: absolute;
        top: 0;
        right: 5px;
        background-color: #007bff;
        color: white;
        font-size: 0.7rem;
        border-radius: 50%;
        padding: 0.2em 0.45em;
    }
    
    @media (max-width: 768px) {
        .status-tab {
            padding: 8px 12px;
            font-size: 0.9rem;
        }
    }
</style>

<body>
    <!-- Navbar -->
    <?php require_once "navbar.php"; ?>
    <?php require_once "chat-box.php"; ?>
    
    <!-- Colorful Divider -->
    <div class="colorful-divider"></div>
    
    <!-- Hero Banner -->
    <div class="hero-banner">
        <div class="container">
            <h1>My Orders</h1>
        </div>
    </div>
    
    <!-- Status Filter Tabs -->
    <div class="container mt-4">
        <div class="status-tabs">
            <?php
                // Define the status categories - removed 'all' => 'All Orders'
                $statuses = [
                    'to_pay ' => 'To Pay',
                    'to_ship' => 'To Ship',
                    'to_receive' => 'To Receive',
                    'completed' => 'Completed',
                    'return/refund' => 'Return/Refund',
                    'cancelled' => 'Cancelled'
                ];
                
                // Count orders for each status
                $status_counts = [];
                
                // Query to get counts
                $count_query = "
                    SELECT 
                        status, 
                        COUNT(*) as count
                    FROM 
                        orders
                    WHERE 
                        user_id = ?
                    GROUP BY 
                        status
                ";
                
                $count_stmt = $conn->prepare($count_query);
                $count_stmt->bind_param("i", $user_id);
                $count_stmt->execute();
                $count_result = $count_stmt->get_result();
                
                while ($row = $count_result->fetch_assoc()) {
                    $status_counts[$row['status']] = $row['count'];
                }
                
                // Output tabs
                foreach ($statuses as $status_key => $status_name) {
                    $active_class = $status_filter === $status_key ? 'active' : '';
                    $count = isset($status_counts[$status_key]) ? $status_counts[$status_key] : 0;
                    
                    echo '<a href="?status=' . urlencode($status_key) . '" class="status-tab ' . $active_class . '">';
                    echo $status_name;
                    if ($count > 0) {
                        echo '<span class="badge">' . $count . '</span>';
                    }
                    echo '</a>';
                }
            ?>
        </div>
    </div>
    
    <!-- Orders List -->
    <div class="container mt-4 mb-5">
        <?php if (empty($orders)): ?>
            <div class="no-orders">
                <h3>No orders found in this category</h3>
                <p>You don't have any orders with the selected status</p>
                <a href="Products.php" class="btn btn-track mt-3">Browse Products</a>
            </div>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <h5>Order #<?php echo htmlspecialchars($order['order_id']); ?></h5>
                            <small>Placed on <?php echo date('F j, Y', strtotime($order['order_date'])); ?></small>
                        </div>
                        <div>
                            <?php
                                $statusClass = '';
                                switch(strtolower(str_replace('/', '-', $order['status']))) {
                                    case 'to pay':
                                        $statusClass = 'status-to-pay';
                                        break;
                                    case 'to ship':
                                        $statusClass = 'status-to-ship';
                                        break;
                                    case 'to receive':
                                        $statusClass = 'status-to-receive';
                                        break;
                                    case 'completed':
                                        $statusClass = 'status-completed';
                                        break;
                                    case 'return-refund':
                                        $statusClass = 'status-return';
                                        break;
                                    case 'cancelled':
                                        $statusClass = 'status-cancelled';
                                        break;
                                    case 'processing':
                                        $statusClass = 'status-processing';
                                        break;
                                    case 'shipped':
                                        $statusClass = 'status-shipped';
                                        break;
                                    case 'delivered':
                                        $statusClass = 'status-delivered';
                                        break;
                                    default:
                                        $statusClass = 'status-processing';
                                }
                            ?>
                            <span class="order-status <?php echo $statusClass; ?>">
                                <?php echo htmlspecialchars($order['status']); ?>
                            </span>
                        </div>
                    </div>
                    <div class="order-body">
                        <div class="order-details">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Total Amount:</strong> ₱<?php echo number_format($order['total_amount'], 2); ?></p>
                                    <p style="text-transform: capitalize;"><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <?php
                            // Query to get order items for this order
                            $items_query = "
                                SELECT 
                                    oi.quantity,
                                    oi.item_total_price AS price,
                                    p.name AS product_name,
                                    p.price AS item_price,
                                    p.size,
                                    p.color
                                FROM 
                                    order_items oi
                                JOIN 
                                    products p ON oi.product_id = p.id
                                WHERE 
                                    oi.order_id = ?
                            ";
                            
                            $items_stmt = $conn->prepare($items_query);
                            $items_stmt->bind_param("i", $order['order_id']);
                            $items_stmt->execute();
                            $items_result = $items_stmt->get_result();
                            $order_items = $items_result->fetch_all(MYSQLI_ASSOC);
                        ?>
                        
                        <button class="order-items-toggle collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#items-<?php echo $order['order_id']; ?>" 
                                aria-expanded="false" aria-controls="items-<?php echo $order['order_id']; ?>">
                            View Order Items
                            <i class="bi bi-chevron-down ms-1"></i>
                        </button>
                        
                        <div class="collapse" id="items-<?php echo $order['order_id']; ?>">
                            <div class="order-items">
                                <?php foreach ($order_items as $item): ?>
                                    <div class="item-row">
                                        <div>
                                            <strong><?php echo htmlspecialchars($item['product_name']); ?></strong>
                                            <div>Size: <?php echo htmlspecialchars($item['size']); ?></div>
                                            <div>Color: <?php echo htmlspecialchars($item['color']); ?></div>
                                        </div>
                                        <div>
                                            <div>₱<?php echo number_format($item['item_price'], 2); ?> × <?php echo $item['quantity']; ?></div>
                                            <div><strong>₱<?php echo number_format($item['price'], 2); ?></strong></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>   
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle icons for order items collapse
            const toggleButtons = document.querySelectorAll('.order-items-toggle');
            
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.classList.toggle('collapsed');
                });
            });
        });
    </script>
</body>
</html>