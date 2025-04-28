<?php include_once "role-validation.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro District Designs - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E5E4E2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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

        .navbar-brand img {
            height: 30px;
            margin-right: 10px;
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

        .admin-header {
            background-color: #555;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-title {
            margin: 0;
            font-size: 1.2rem;
        }

        .admin-user {
            display: flex;
            align-items: center;
        }

        .admin-user img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 10px;
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

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        .toggle-sidebar {
            cursor: pointer;
            display: none;
        }

        .inquiry-list {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .inquiry-item {
            border-bottom: 1px solid #eee;
            padding: 15px;
            transition: background-color 0.2s;
            cursor: pointer;
        }

        .inquiry-item:hover {
            background-color: #f8f9fa;
        }

        .inquiry-item.unread {
            border-left: 3px solid #007bff;
        }

        .inquiry-item.urgent {
            background-color: rgba(255, 107, 107, 0.1);
        }

        .inquiry-meta {
            display: flex;
            justify-content: space-between;
            color: #777;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        .inquiry-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .inquiry-preview {
            color: #555;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .badge-urgent {
            background-color: #ff6b6b;
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: normal;
        }

        .badge-standard {
            background-color: #4ecdc4;
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: normal;
        }

        .badge-relaxed {
            background-color: #6c757d;
            color: white;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: normal;
        }

        .filter-section {
            margin-bottom: 20px;
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #777;
        }

        .search-box input {
            padding-left: 40px;
        }

        .detail-panel {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
        }

        .detail-header {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .detail-meta {
            display: flex;
            justify-content: space-between;
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .detail-title {
            font-size: 1.5rem;
            margin-bottom: 5px;
            text-transform: capitalize;
        }

        .detail-customer {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .capitalize {
            text-transform: capitalize;
        }

        .detail-customer img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .detail-content {
            margin-bottom: 20px;
        }

        .detail-image-gallery {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .detail-image {
            width: 150px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            cursor: pointer;
        }

        .detail-info {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            border: 1px solid #eee;
            padding: 10px;
            border-radius: 4px;
        }

        .info-label {
            font-weight: bold;
            font-size: 0.8rem;
            margin-bottom: 5px;
            color: #777;
        }

        .info-value {
            font-size: 0.9rem;
        }

        .reply-section {
            margin-top: 20px;
        }

        .reply-box {
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .reply-toolbar {
            background-color: #f8f9fa;
            padding: 10px;
            display: flex;
            gap: 10px;
            border-bottom: 1px solid #ddd;
        }

        .reply-toolbar button {
            background: none;
            border: none;
            color: #555;
            cursor: pointer;
        }

        .reply-toolbar button:hover {
            color: #000;
        }

        .reply-textarea {
            width: 100%;
            border: none;
            padding: 15px;
            min-height: 150px;
            resize: vertical;
        }

        .reply-actions {
            padding: 10px;
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-dropdown {
            width: 200px;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ff6b6b;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .toggle-sidebar {
                display: block;
            }
            
            .sidebar.show {
                transform: translateX(0);
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
                <a href="product-stock.php" class="sidebar-link">
                    <i class="fas fa-box"></i> Product Stock
                </a>
                <a href="admininquiries.php" class="sidebar-link active">
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col">
                    <h2>Design Inquiries</h2>
                    <p class="text-muted">Manage custom design requests from customers</p>
                </div>
            </div>
            
            <div class="row">
                <!-- Left Panel - Inquiry List -->
                <div class="col-lg-4">
                    <div class="filter-section d-flex gap-2">
                        <div class="search-box flex-grow-1">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" id="searchInput" placeholder="Search inquiries...">
                        </div>
                        <button class="btn btn-outline-secondary" data-bs-toggle="dropdown">
                            <i class="fas fa-filter"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item filter-option" href="#" data-filter="all">All Inquiries</a>
                            <a class="dropdown-item filter-option" href="#" data-filter="new">New Inquiries</a>
                            <a class="dropdown-item filter-option" href="#" data-filter="in-progress">In Progress</a>
                            <a class="dropdown-item filter-option" href="#" data-filter="completed">Completed</a>
                        </div>
                    </div>
                    
                    <div class="inquiry-list" id="inquiryList">
                        <!-- Inquiry items will be dynamically loaded from the inquiries data -->
                    </div>
                </div>
                
                <!-- Right Panel - Detail View -->
                <div class="col-lg-8">
                    <div class="detail-panel" id="inquiryDetail">
                        <!-- Inquiry details will be dynamically loaded -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inquiryList = document.getElementById('inquiryList');
            const inquiryDetail = document.getElementById('inquiryDetail');

            // Fetch inquiries from the backend

            let inquiries = [];
            async function fetchInquiries() {
                try {
                    const response = await fetch('api/get_inquiries.php');
                    const result = await response.json();

                    if (result.success) {
                        inquiries = result.data;
                        renderInquiryList(inquiries);
                    } else {
                        alert(result.error || 'Failed to fetch inquiries.');
                    }
                } catch (error) {
                    console.error('Error fetching inquiries:', error);
                }
            }

            // Function to render inquiry list
            function renderInquiryList(inquiriesData) {
                const listContainer = document.getElementById('inquiryList');
                listContainer.innerHTML = '';
                
                inquiriesData.forEach(inquiry => {
                    const item = document.createElement('div');
                    item.className = `inquiry-item${inquiry.unread ? ' unread' : ''}${inquiry.priority === 'urgent' ? ' urgent' : ''}`;
                    item.setAttribute('data-id', inquiry.id);
                    
                    item.innerHTML = `
                        <div class="inquiry-meta">
                            <span class="capitalize">${inquiry.customer_name}</span>
                            <span>${new Date(inquiry.created_at).toLocaleString()}</span>
                        </div>
                        <div class="inquiry-title capitalize">T-Shirt</div>
                        <div class="inquiry-preview">${inquiry.description_preview}</div>
                    `;
                    
                    item.addEventListener('click', () => renderInquiryDetail(inquiry));
                    listContainer.appendChild(item);
                });
                
                // Add click event listeners to inquiry items
                const inquiryItems = document.querySelectorAll('.inquiry-item');
                inquiryItems.forEach(item => {
                    item.addEventListener('click', function() {
                        // Remove active class from all items
                        inquiryItems.forEach(i => i.classList.remove('active', 'bg-light'));
                        
                        // Add active class to clicked item
                        this.classList.add('active', 'bg-light');
                        
                        // Remove unread status
                        this.classList.remove('unread');
                        
                        // Get inquiry ID and load details
                        const inquiryId = parseInt(this.getAttribute('data-id'));
                        const selectedInquiry = inquiries.find(inq => inq.id === inquiryId);
                        
                        if (selectedInquiry) {
                            renderInquiryDetail(selectedInquiry);
                            
                            // Update the data to mark as read
                            selectedInquiry.unread = false;
                        }
                    });
                });
                
                // Make the first inquiry item active by default
                if (inquiryItems.length > 0) {
                    inquiryItems[0].click();
                }
            }
            
            // Function to render inquiry detail
            function renderInquiryDetail(inquiry) {
                const detailContainer = document.getElementById('inquiryDetail');
                
                // Render the detail view
                detailContainer.innerHTML = `
                    <div class="detail-header">
                        <div class="detail-meta">
                            <span><strong>Inquiry ID:</strong> #${inquiry.id}</span>
                            <span>Submitted: ${new Date(inquiry.created_at).toLocaleString()}</span>
                        </div>
                        <h3 class="detail-title">T-Shirt</h3>
                        <div class="detail-customer">
                            <div>
                                <div><strong class="capitalize">${inquiry.customer_name}</strong></div>
                                <div>${inquiry.customer_email} | +63${inquiry.customer_phone}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-content">
                        ${inquiry.description_preview}
                    </div>
                    
                    <div class="detail-image-gallery">
                        <img src="${inquiry.image_path}" class="detail-image" alt="Reference image">
                    </div>
                    
                    <div class="detail-info">
                        <div class="info-item">
                            <div class="info-label">Design Type</div>
                            <div class="info-value capitalize">T-Shirt</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">${inquiry.status.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase())}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Timeline</div>
                            <div class="info-value capitalize">${inquiry.timeline}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Color</div>
                            <div class="info-value capitalize">${inquiry.color}</div>
                        </div>
                        <div class="info-item">
                           <div class="info-label">Size</div>
                            <div class="info-value capitalize">${inquiry.size}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Quantity</div>
                            <div class="info-value capitalize">${inquiry.quantity}</div>
                        </div>
                    </div>
                    
                    <div class="reply-section">
                        <h5>Reply to Customer</h5>
                        <div class="reply-box">
                            <textarea class="reply-textarea" id="replyMessage" placeholder="Type your response here..."></textarea>
                            <div class="reply-actions">
                                <div>
                                    <select class="form-select status-dropdown" id="status-dropdown">
                                        <option value="">Update Status</option>
                                        <option value="new" ${inquiry.status === 'new' ? 'selected' : ''}>New</option>
                                        <option value="in-progress" ${inquiry.status === 'in-progress' ? 'selected' : ''}>In Progress</option>
                                        <option value="pending-approval" ${inquiry.status === 'pending-approval' ? 'selected' : ''}>Pending Approval</option>
                                        <option value="completed" ${inquiry.status === 'completed' ? 'selected' : ''}>Completed</option>
                                        <option value="rejected" ${inquiry.status === 'rejected' ? 'selected' : ''}>Rejected</option>
                                    </select>
                                </div>
                                <div>
                                    <button class="btn btn-primary" id="sendReplyBtn">Send Reply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                const sendReplyBtn = document.getElementById('sendReplyBtn');
                sendReplyBtn.addEventListener('click', async () => {
                    const replyMessage = document.getElementById('replyMessage').value;

                    try {
                        const response = await fetch('api/send_reply.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `inquiry_id=${inquiry.id}&reply_message=${encodeURIComponent(replyMessage)}`,
                        });

                        const result = await response.json();

                        if (result.success) {
                            alert('Reply sent successfully.');
                            document.getElementById('replyMessage').value = '';
                        } else {
                            alert(result.error || 'Failed to send reply.');
                        }
                    } catch (error) {
                        console.error('Error sending reply:', error);
                    }
                });

                // Handle updating status

                const statusDropdown = document.getElementById('status-dropdown');
                statusDropdown.addEventListener('change', async () => {
                    const newStatus = statusDropdown.value;

                    try {
                        const response = await fetch('api/update_inquiry.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `inquiry_id=${inquiry.id}&status=${newStatus}`,
                        });

                        const result = await response.json();

                        if (result.success) {
                            alert('Status updated successfully.');
                            fetchInquiries(); // Refresh the inquiry list
                        } else {
                            alert(result.error || 'Failed to update status.');
                        }
                    } catch (error) {
                        console.error('Error updating status:', error);
                    }
                });
            }
            
            // Handle search functionality
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filteredInquiries = inquiries.filter(inquiry => 
                    inquiry.customer_name.toLowerCase().includes(searchTerm) ||
                    inquiry.description.toLowerCase().includes(searchTerm)
                );
                renderInquiryList(filteredInquiries);
            });
            
            // Handle filter options
            const filterOptions = document.querySelectorAll('.filter-option');
            filterOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    const filterType = this.getAttribute('data-filter');
                    let filteredInquiries = [...inquiries];
                    
                    switch(filterType) {
                        case 'unread':
                            filteredInquiries = inquiries.filter(inq => inq.unread);
                            break;
                        case 'urgent':
                            filteredInquiries = inquiries.filter(inq => inq.priority === 'urgent');
                            break;
                        case 'new':
                            filteredInquiries = inquiries.filter(inq => inq.status === 'new');
                            break;
                        case 'in-progress':
                            filteredInquiries = inquiries.filter(inq => inq.status === 'in-progress');
                            break;
                        case 'completed':
                            filteredInquiries = inquiries.filter(inq => inq.status === 'completed');
                            break;
                        // 'all' and default don't need filtering
                    }
                    
                    renderInquiryList(filteredInquiries);
                });
            });

            fetchInquiries();
        });
    </script>
</body>
</html>