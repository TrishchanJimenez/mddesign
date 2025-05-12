<?php
include_once "role-validation.php";
require_once "db_connection.php";

// Get status filter if provided
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all'; // Default to 'all'

// Process status update if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    $update_query = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        $success_message = "Order #$order_id status updated successfully to $new_status";
    } else {
        $error_message = "Error updating order status: " . $conn->error;
    }
    $stmt->close();
}

// Define the orders query based on filter
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
        ) AS shipping_address,
        CONCAT(u.first_name, ' ', u.last_name) AS customer_name,
        u.email AS customer_email
    FROM 
        orders o
    JOIN 
        users u ON o.user_id = u.id
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
";

// Only filter by status if $status_filter is set and not 'all'
$params = [];
$types = '';
if (!empty($status_filter) && strtolower($status_filter) !== 'all') {
    $query .= " WHERE o.status = ?";
    $params[] = $status_filter;
    $types .= 's';
}
$query .= " ORDER BY o.order_date DESC";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$orders = [];
if ($result) {
    $orders = $result->fetch_all(MYSQLI_ASSOC);
}
$stmt->close();

// Get count of orders by status for the status tabs
$status_counts = [];
$count_query = "
    SELECT 
        status, 
        COUNT(*) as count
    FROM 
        orders
    GROUP BY 
        status
";

$count_result = $conn->query($count_query);
if ($count_result) {
    while ($row = $count_result->fetch_assoc()) {
        $status_counts[$row['status']] = $row['count'];
    }
}

// Calculate total count for all orders
$total_count = array_sum($status_counts);

// Define the status categories (removed "all" option)
$statuses = [
    'to_pay' => 'To Pay',
    'to_ship' => 'To Ship',
    'to_receive' => 'To Receive',
    'completed' => 'Completed',
    'return/refund' => 'Return/Refund',
    'cancelled' => 'Cancelled'
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro District Designs - Order Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background-color: #1E1E1E;
            color: white;
            min-height: 100vh;
            padding-top: 20px;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
        }
        
        .sidebar-link {
            color: #f8f9fa;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-link:hover, .sidebar-link.active {
            background-color: #333333;
            border-left: 4px solid #0d6efd;
        }
        
        .sidebar-link i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .breadcrumb-container {
            padding: 10px 0;
            margin-bottom: 20px;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .card {
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .card-header {
            background-color: #212529;
            color: white;
            border-radius: 0 !important;
            font-weight: bold;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #333;
        }
        
        .logo {
            width: 40px;
            height: 40px;
            margin-right: 10px;
            border-radius: 50%;
        }
        
        .brand-name {
            color: white;
            font-weight: bold;
            font-size: 18px;
            margin: 0;
        }
        
        .status-tabs {
            display: flex;
            justify-content: flex-start;
            flex-wrap: wrap;
            margin: 20px 0;
            border-bottom: 1px solid #ddd;
            overflow-x: auto;
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
            text-decoration: none;
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
        
        .status-to-pay {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-to-ship {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-to-receive {
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
        
        .status-return {
            background-color: #e2e3e5;
            color: #383d41;
        }
        
        .tracking-info {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
        }
        
        .btn-success, .btn-primary {
            margin-top: 10px;
        }
        
        .alert {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .status-tab {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<!-- Main Container with Sidebar -->
<div class="container-fluid p-0">
    <div class="row g-0">
        <!-- Sidebar -->
        <div class="col-auto">
            <div class="sidebar">
                <div class="logo-container">
                    <img src="/api/placeholder/40/40" class="logo" alt="Logo">
                    <h5 class="brand-name">Metro District Designs</h5>
                </div>
                <a href="dashboard.php" class="sidebar-link">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="admin-orders.php" class="sidebar-link active">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
                <a href="product-stock.php" class="sidebar-link">
                    <i class="fas fa-box"></i> Product Stock
                </a>
                <a href="admininquiries.php" class="sidebar-link">
                    <i class="fas fa-envelope"></i> Inquiries
                </a>
                <a href="user-admin.php" class="sidebar-link">
                    <i class="fas fa-users"></i> Account Manager
                </a>
                <a href="profile.php" class="sidebar-link">
                    <i class="fas fa-user-cog"></i> Profile
                </a>
                <a href="index.php" class="sidebar-link">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="logout.php" class="sidebar-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="col">
            <div class="main-content">
                <!-- Breadcrumb -->
                <div class="breadcrumb-container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order Management</li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Page Title -->
                <div class="page-title">
                    <span>Order Management</span>
                </div>
                
                <!-- Status messages -->
                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $success_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Status Filter Tabs -->
                <div class="status-tabs">
                    <?php foreach ($statuses as $status_key => $status_name): ?>
                        <?php 
                            $active_class = $status_filter === $status_key ? 'active' : '';
                            $count = isset($status_counts[$status_key]) ? $status_counts[$status_key] : 0;
                        ?>
                        <a href="?status=<?php echo urlencode($status_key); ?>" class="status-tab <?php echo $active_class; ?>">
                            <?php echo $status_name; ?>
                            <?php if ($count > 0): ?>
                                <span class="badge"><?php echo $count; ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                
                <!-- Orders List -->
                <?php if (empty($orders)): ?>
                    <div class="card">
                        <div class="card-body text-center">
                            <h4>No orders found in this category</h4>
                            <p>There are no orders with the selected status.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="card mb-4">
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
                                                $statusClass = 'status-to-pay'; break;
                                            case 'to ship':
                                                $statusClass = 'status-to-ship'; break;
                                            case 'to receive':
                                                $statusClass = 'status-to-receive'; break;
                                            case 'completed':
                                                $statusClass = 'status-completed'; break;
                                            case 'return-refund':
                                                $statusClass = 'status-return'; break;
                                            case 'cancelled':
                                                $statusClass = 'status-cancelled'; break;
                                            default:
                                                $statusClass = 'status-to-pay';
                                        }
                                    ?>
                                    <span class="order-status <?php echo $statusClass; ?>">
                                        <?php echo htmlspecialchars($order['status']); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="order-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Customer Information</h6>
                                        <p><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                                        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Order Details</h6>
                                        <p><strong>Total Amount:</strong> ₱<?php echo number_format($order['total_amount'], 2); ?></p>
                                        <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
                                        <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
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
                                <div class="mt-4">
                                    <h6>Order Items</h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Size</th>
                                                    <th>Color</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($order_items as $item): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($item['size']); ?></td>
                                                        <td><?php echo htmlspecialchars($item['color']); ?></td>
                                                        <td>₱<?php echo number_format($item['item_price'], 2); ?></td>
                                                        <td><?php echo $item['quantity']; ?></td>
                                                        <td>₱<?php echo number_format($item['price'], 2); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Order Status Update Form -->
                                <div class="mt-4">
                                    <h6>Update Order Status</h6>
                                    <form method="POST" action="admin-orders.php">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="new_status" class="form-select" required>
                                                    <option value="">Select Status</option>
                                                    <?php foreach ($statuses as $status_key => $status_name): ?>
                                                        <option value="<?php echo $status_key; ?>" <?php echo ($order['status'] === $status_key) ? 'selected' : ''; ?>>
                                                            <?php echo $status_name; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
</body>
</html>