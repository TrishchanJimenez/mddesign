<?php
session_start();
require_once "db_connection.php";
// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);
$user_id = $loggedIn ? $_SESSION['user_id'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro District Designs - Messages</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
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

        .message-container {
            height: calc(100vh - 150px);
            display: flex;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .conversation-list {
            width: 300px;
            border-right: 1px solid #ddd;
            overflow-y: auto;
            background-color: #f8f9fa;
        }

        .conversation-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .conversation-item:hover, .conversation-item.active {
            background-color: #e9ecef;
        }

        .conversation-item.unread {
            border-left: 3px solid #007bff;
            font-weight: bold;
        }

        .conversation-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .message-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .message-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .message-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .message-footer {
            padding: 15px;
            border-top: 1px solid #eee;
        }

        .message-input {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 12px 15px;
            resize: none;
        }

        .message-bubble {
            max-width: 70%;
            padding: 12px 15px;
            border-radius: 18px;
            margin-bottom: 15px;
            position: relative;
        }

        .message-sent {
            background-color: #007bff;
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 5px;
        }

        .message-received {
            background-color: #e9ecef;
            color: #212529;
            border-bottom-left-radius: 5px;
        }

        .message-time {
            font-size: 0.7rem;
            margin-top: 5px;
            color: rgba(255, 255, 255, 0.8);
            text-align: right;
        }

        .message-received .message-time {
            color: #6c757d;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 50px;
            margin-bottom: 15px;
            color: #adb5bd;
        }

        .login-prompt {
            text-align: center;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .message-date-divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .message-date-divider span {
            background-color: #f9f9f9;
            padding: 0 10px;
            position: relative;
            color: #6c757d;
            font-size: 0.8rem;
        }

        .message-date-divider:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #dee2e6;
            z-index: 0;
        }

        .conversation-preview {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .empty-conversations {
            text-align: center;
            padding: 30px 15px;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .conversation-list {
                width: 100%;
                display: block;
            }
            
            .message-content {
                display: none;
            }
            
            .message-container.show-messages .conversation-list {
                display: none;
            }
            
            .message-container.show-messages .message-content {
                display: flex;
            }
            
            .back-to-conversations {
                display: block !important;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar - Updated with new navbar code -->
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

    <!-- Main Content -->
    <div class="container my-4">
        <h2 class="mb-4">Messages</h2>
        
        <?php if($loggedIn): ?>
            <div class="message-container" id="messageContainer">
                <!-- Conversation List -->
                <div class="conversation-list" id="conversationList">
                    <!-- Conversations will be loaded dynamically -->
                    <div class="empty-conversations" id="emptyConversations">
                        <i class="fas fa-comments fa-3x mb-3"></i>
                        <h5>No conversations yet</h5>
                        <p>Your message threads will appear here.</p>
                    </div>
                </div>
                
                <!-- Message Content -->
                <div class="message-content">
                    <!-- Initial empty state -->
                    <div class="empty-state" id="emptyState">
                        <i class="fas fa-comments"></i>
                        <h4>No conversation selected</h4>
                        <p>Choose a conversation from the list or start a new one</p>
                    </div>
                    
                    <!-- Message thread view (initially hidden) -->
                    <div class="message-thread d-none" id="messageThread">
                        <div class="message-header">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm btn-light me-2 back-to-conversations d-none" id="backButton">
                                    <i class="fas fa-arrow-left"></i>
                                </button>
                                <div class="conversation-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0" id="conversationRecipient">Recipient Name</h5>
                                    <small class="text-muted" id="conversationSubject">Subject/Topic</small>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-outline-danger btn-sm" id="deleteConversationBtn">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="message-body" id="messageBody">
                            <!-- Messages will be loaded dynamically -->
                        </div>
                        
                        <div class="message-footer">
                            <div class="input-group">
                                <textarea class="message-input" id="messageInput" placeholder="Type your message here..."></textarea>
                                <button class="btn btn-primary" id="sendMessageBtn">
                                    <i class="fas fa-paper-plane"></i> Send
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="login-prompt">
                <i class="fas fa-lock fa-3x mb-3"></i>
                <h3>Please Log In</h3>
                <p>You need to log in to view and send messages.</p>
                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="register.php" class="btn btn-outline-primary ms-2">Register</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- New Conversation Modal -->
    <div class="modal fade" id="newConversationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newConversationForm">
                        <div class="mb-3">
                            <label for="recipientType" class="form-label">Send to:</label>
                            <select class="form-select" id="recipientType">
                                <option value="admin">Admin/Support</option>
                                <option value="inquiry">About My Inquiry</option>
                                <option value="order">About My Order</option>
                            </select>
                        </div>
                        
                        <div class="mb-3 d-none" id="inquirySelectGroup">
                            <label for="inquirySelect" class="form-label">Select Inquiry:</label>
                            <select class="form-select" id="inquirySelect">
                                <!-- Will be populated dynamically -->
                            </select>
                        </div>
                        
                        <div class="mb-3 d-none" id="orderSelectGroup">
                            <label for="orderSelect" class="form-label">Select Order:</label>
                            <select class="form-select" id="orderSelect">
                                <!-- Will be populated dynamically -->
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="messageSubject" class="form-label">Subject:</label>
                            <input type="text" class="form-control" id="messageSubject" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="messageContent" class="form-label">Message:</label>
                            <textarea class="form-control" id="messageContent" rows="5" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="sendNewMessageBtn">Send Message</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
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
            
            const newConversationBtn = document.createElement('button');
            newConversationBtn.className = 'btn btn-primary mb-3';
            newConversationBtn.innerHTML = '<i class="fas fa-plus"></i> New Message';
            newConversationBtn.setAttribute('data-bs-toggle', 'modal');
            newConversationBtn.setAttribute('data-bs-target', '#newConversationModal');
            
            const conversationList = document.getElementById('conversationList');
            if (conversationList) {
                conversationList.insertAdjacentElement('afterbegin', newConversationBtn);
            }
            
            // Variables to store state
            let currentConversationId = null;
            let conversations = [];
            let userInquiries = [];
            let userOrders = [];
            
            // Initialize back button for mobile view
            const backButton = document.getElementById('backButton');
            if (backButton) {
                backButton.addEventListener('click', function() {
                    document.getElementById('messageContainer').classList.remove('show-messages');
                });
            }
            
            // Load conversations if user is logged in
            <?php if($loggedIn): ?>
                loadConversations();
                loadUserInquiries();
                loadUserOrders();
            <?php endif; ?>
            
            // Set up recipient type change event
            const recipientType = document.getElementById('recipientType');
            if (recipientType) {
                recipientType.addEventListener('change', function() {
                    const inquiryGroup = document.getElementById('inquirySelectGroup');
                    const orderGroup = document.getElementById('orderSelectGroup');
                    
                    inquiryGroup.classList.add('d-none');
                    orderGroup.classList.add('d-none');
                    
                    if (this.value === 'inquiry') {
                        inquiryGroup.classList.remove('d-none');
                    } else if (this.value === 'order') {
                        orderGroup.classList.remove('d-none');
                    }
                });
            }
            
            // Set up new message send button
            const sendNewMessageBtn = document.getElementById('sendNewMessageBtn');
            if (sendNewMessageBtn) {
                sendNewMessageBtn.addEventListener('click', sendNewMessage);
            }
            
            // Set up message send button
            const sendMessageBtn = document.getElementById('sendMessageBtn');
            if (sendMessageBtn) {
                sendMessageBtn.addEventListener('click', sendReplyMessage);
            }
            
            // Set up delete conversation button
            const deleteConversationBtn = document.getElementById('deleteConversationBtn');
            if (deleteConversationBtn) {
                deleteConversationBtn.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this conversation?')) {
                        deleteConversation(currentConversationId);
                    }
                });
            }
            
            // Function to load user conversations
            async function loadConversations() {
                try {
                    const response = await fetch('api/get_conversations.php');
                    const result = await response.json();
                    
                    if (result.success) {
                        conversations = result.data;
                        renderConversationList(conversations);
                    } else {
                        console.error('Error loading conversations:', result.error);
                    }
                } catch (error) {
                    console.error('Error fetching conversations:', error);
                }
            }
            
            // Function to load user inquiries for the dropdown
            async function loadUserInquiries() {
                try {
                    const response = await fetch('api/get_user_inquiries.php');
                    const result = await response.json();
                    
                    if (result.success) {
                        userInquiries = result.data;
                        populateInquiryDropdown(userInquiries);
                    } else {
                        console.error('Error loading inquiries:', result.error);
                    }
                } catch (error) {
                    console.error('Error fetching inquiries:', error);
                }
            }
            
            // Function to load user orders for the dropdown
            async function loadUserOrders() {
                try {
                    const response = await fetch('api/get_user_orders.php');
                    const result = await response.json();
                    
                    if (result.success) {
                        userOrders = result.data;
                        populateOrderDropdown(userOrders);
                    } else {
                        console.error('Error loading orders:', result.error);
                    }
                } catch (error) {
                    console.error('Error fetching orders:', error);
                }
            }
            
            // Function to populate inquiry dropdown
            function populateInquiryDropdown(inquiries) {
                const inquirySelect = document.getElementById('inquirySelect');
                if (!inquirySelect) return;
                
                inquirySelect.innerHTML = '';
                
                if (inquiries.length === 0) {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No inquiries found';
                    inquirySelect.appendChild(option);
                    return;
                }
                
                inquiries.forEach(inquiry => {
                    const option = document.createElement('option');
                    option.value = inquiry.id;
                    option.textContent = `#${inquiry.id} - ${inquiry.design_type} (${formatDate(inquiry.created_at)})`;
                    inquirySelect.appendChild(option);
                });
            }
            
            // Function to populate order dropdown
            function populateOrderDropdown(orders) {
                const orderSelect = document.getElementById('orderSelect');
                if (!orderSelect) return;
                
                orderSelect.innerHTML = '';
                
                if (orders.length === 0) {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No orders found';
                    orderSelect.appendChild(option);
                    return;
                }
                
                orders.forEach(order => {
                    const option = document.createElement('option');
                    option.value = order.id;
                    option.textContent = `Order #${order.id} - ${formatDate(order.order_date)}`;
                    orderSelect.appendChild(option);
                });
            }
            
            // Function to render conversation list
            function renderConversationList(conversationsData) {
                const listContainer = document.getElementById('conversationList');
                const emptyConversations = document.getElementById('emptyConversations');
                
                if (!listContainer) return;
                
                // Keep the new conversation button at the top
                const newButton = listContainer.querySelector('.btn-primary');
                
                // Clear existing conversations
                listContainer.innerHTML = '';
                
                // Add back the new conversation button
                if (newButton) {
                    listContainer.appendChild(newButton);
                }
                
                if (conversationsData.length === 0) {
                    listContainer.appendChild(emptyConversations);
                    return;
                }
                
                conversationsData.forEach(conversation => {
                    const item = document.createElement('div');
                    item.className = `conversation-item ${conversation.unread ? 'unread' : ''}`;
                    item.setAttribute('data-id', conversation.id);
                    
                    const lastMessage = conversation.last_message || 'No messages yet';
                    const lastMessageTime = conversation.last_message_time 
                        ? formatDate(conversation.last_message_time) 
                        : formatDate(conversation.created_at);
                    
                    item.innerHTML = `
                        <div class="d-flex align-items-center">
                            <div class="conversation-avatar">
                                <i class="fas ${conversation.type === 'admin' ? 'fa-headset' : 'fa-user'}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <strong>${conversation.subject}</strong>
                                    <small class="text-muted">${lastMessageTime}</small>
                                </div>
                                <div class="conversation-preview">${lastMessage}</div>
                            </div>
                        </div>
                    `;
                    
                    item.addEventListener('click', () => {
                        // Remove active class from all items
                        document.querySelectorAll('.conversation-item').forEach(i => {
                            i.classList.remove('active');
                        });
                        
                        // Add active class to clicked item
                        item.classList.add('active');
                        
                        // Show message thread on mobile
                        document.getElementById('messageContainer').classList.add('show-messages');
                        
                        // Load this conversation's messages
                        loadConversationMessages(conversation.id);
                        
                        // Update the conversation header
                        document.getElementById('conversationRecipient').textContent = 
                            conversation.type === 'admin' ? 'Admin/Support' : 'Customer Service';
                        document.getElementById('conversationSubject').textContent = conversation.subject;
                    });
                    
                    listContainer.appendChild(item);
                });
                
                // If there's at least one conversation, select the first one
                if (conversationsData.length > 0) {
                    const firstItem = listContainer.querySelector('.conversation-item');
                    if (firstItem) {
                        firstItem.click();
                    }
                }
            }
            
            // Function to load messages for a specific conversation
            async function loadConversationMessages(conversationId) {
                try {
                    currentConversationId = conversationId;
                    
                    const response = await fetch(`api/get_messages.php?conversation_id=${conversationId}`);
                    const result = await response.json();
                    
                    if (result.success) {
                        renderConversationMessages(result.data);
                        
                        // Show the message thread view and hide empty state
                        document.getElementById('emptyState').classList.add('d-none');
                        document.getElementById('messageThread').classList.remove('d-none');
                        
                        // Mark conversation as read
                        markConversationAsRead(conversationId);
                    } else {
                        console.error('Error loading messages:', result.error);
                    }
                } catch (error) {
                    console.error('Error fetching messages:', error);
                }
            }
            
            // Function to render conversation messages
            function renderConversationMessages(messages) {
                const messageBody = document.getElementById('messageBody');
                if (!messageBody) return;
                
                messageBody.innerHTML = '';
                
                if (messages.length === 0) {
                    messageBody.innerHTML = '<div class="text-center text-muted my-5">No messages yet.</div>';
                    return;
                }
                
                let currentDate = '';
                
                messages.forEach(message => {
                    const messageDate = new Date(message.created_at).toLocaleDateString();
                    
                    // Add date divider if this is a new date
                    if (messageDate !== currentDate) {
                        currentDate = messageDate;
                        
                        const dateDivider = document.createElement('div');
                        dateDivider.className = 'message-date-divider';
                        dateDivider.innerHTML = `<span>${messageDate}</span>`;
                        messageBody.appendChild(dateDivider);
                    }
                    
                    const isCurrentUser = message.sender_id == <?php echo $user_id ?? 'null'; ?>;
const messageDiv = document.createElement('div');
                    
messageDiv.className = `message-bubble ${isCurrentUser ? 'message-sent' : 'message-received'}`;
messageDiv.innerHTML = `
    <div>${message.content}</div>
    <div class="message-time">${formatTime(message.created_at)}</div>
`;
                    
messageBody.appendChild(messageDiv);
});

// Scroll to bottom of message container
messageBody.scrollTop = messageBody.scrollHeight;
}

// Function to mark a conversation as read
async function markConversationAsRead(conversationId) {
    try {
        const response = await fetch('api/mark_conversation_read.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ conversation_id: conversationId })
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Update the UI to remove unread indicator
            const conversationItem = document.querySelector(`.conversation-item[data-id="${conversationId}"]`);
            if (conversationItem) {
                conversationItem.classList.remove('unread');
            }
            
            // Update our local data
            conversations = conversations.map(conv => {
                if (conv.id == conversationId) {
                    conv.unread = false;
                }
                return conv;
            });
        } else {
            console.error('Error marking conversation as read:', result.error);
        }
    } catch (error) {
        console.error('Error updating read status:', error);
    }
}

// Function to send a new message (start a new conversation)
async function sendNewMessage() {
    const recipientType = document.getElementById('recipientType').value;
    const subject = document.getElementById('messageSubject').value.trim();
    const content = document.getElementById('messageContent').value.trim();
    
    let referenceId = null;
    
    if (recipientType === 'inquiry') {
        referenceId = document.getElementById('inquirySelect').value;
    } else if (recipientType === 'order') {
        referenceId = document.getElementById('orderSelect').value;
    }
    
    if (!subject || !content) {
        alert('Please fill in all required fields.');
        return;
    }
    
    try {
        const response = await fetch('api/start_conversation.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                type: recipientType,
                subject: subject,
                content: content,
                reference_id: referenceId
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('newConversationModal'));
            if (modal) {
                modal.hide();
            }
            
            // Reset form
            document.getElementById('newConversationForm').reset();
            
            // Reload conversations
            loadConversations();
        } else {
            alert('Error sending message: ' + result.error);
            console.error('Error sending message:', result.error);
        }
    } catch (error) {
        console.error('Error sending message:', error);
        alert('An error occurred while sending your message.');
    }
}

// Function to send a reply in an existing conversation
async function sendReplyMessage() {
    if (!currentConversationId) {
        alert('No conversation selected.');
        return;
    }
    
    const messageInput = document.getElementById('messageInput');
    const content = messageInput.value.trim();
    
    if (!content) {
        alert('Message cannot be empty.');
        return;
    }
    
    try {
        const response = await fetch('api/send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                conversation_id: currentConversationId,
                content: content
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Clear input
            messageInput.value = '';
            
            // Reload messages for this conversation
            loadConversationMessages(currentConversationId);
        } else {
            alert('Error sending message: ' + result.error);
            console.error('Error sending message:', result.error);
        }
    } catch (error) {
        console.error('Error sending message:', error);
        alert('An error occurred while sending your message.');
    }
}

// Function to delete a conversation
async function deleteConversation(conversationId) {
    if (!conversationId) return;
    
    try {
        const response = await fetch('api/delete_conversation.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                conversation_id: conversationId
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Reload conversations
            loadConversations();
            
            // Hide message thread and show empty state
            document.getElementById('messageThread').classList.add('d-none');
            document.getElementById('emptyState').classList.remove('d-none');
            
            // On mobile, go back to conversation list
            document.getElementById('messageContainer').classList.remove('show-messages');
        } else {
            alert('Error deleting conversation: ' + result.error);
            console.error('Error deleting conversation:', result.error);
        }
    } catch (error) {
        console.error('Error deleting conversation:', error);
        alert('An error occurred while deleting the conversation.');
    }
}

// Helper function to format date
function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const yesterday = new Date(now);
    yesterday.setDate(yesterday.getDate() - 1);
    
    // Check if date is today
    if (date.toDateString() === now.toDateString()) {
        return 'Today';
    }
    
    // Check if date is yesterday
    if (date.toDateString() === yesterday.toDateString()) {
        return 'Yesterday';
    }
    
    // Otherwise, return formatted date
    return date.toLocaleDateString();
}

// Helper function to format time
function formatTime(dateString) {
    const date = new Date(dateString);
    let hours = date.getHours();
    let minutes = date.getMinutes();
    const ampm = hours >= 12 ? 'PM' : 'AM';
    
    // Convert to 12-hour format
    hours = hours % 12;
    hours = hours ? hours : 12; // '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    
    return `${hours}:${minutes} ${ampm}`;
}

// Handle Enter key in message input
const messageInput = document.getElementById('messageInput');
if (messageInput) {
    messageInput.addEventListener('keydown', function(e) {
        // Send message on Enter key (without Shift)
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendReplyMessage();
        }
    });
}
}); // Close the DOMContentLoaded event listener
</script>
</body>
</html>