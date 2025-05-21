<?php include_once "role-validation.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro District Designs - Chat Dashboard</title>
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
            overflow-x: hidden;
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
            z-index: 100;
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
            transition: all 0.3s;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Chat container styles */
        .chat-container {
            display: flex;
            height: calc(100vh);
        }

        /* Contact list styles */
        .contact-list {
            width: 300px;
            border-right: 1px solid #ddd;
            background-color: white;
            overflow-y: auto;
        }

        .contact-search {
            padding: 15px;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 10;
        }

        .contact-search input {
            border-radius: 20px;
            padding-left: 35px;
        }

        .contact-search i {
            position: absolute;
            left: 25px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        .contact-filter {
            padding: 0 15px 10px;
            display: flex;
            gap: 10px;
            overflow-x: auto;
            white-space: nowrap;
            border-bottom: 1px solid #eee;
            background-color: white;
        }

        .filter-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            cursor: pointer;
            background-color: #f1f1f1;
            transition: all 0.2s;
        }

        .filter-badge.active {
            background-color: #0d6efd;
            color: white;
        }

        .contact-item {
            display: flex;
            padding: 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .contact-item:hover {
            background-color: #f8f9fa;
        }

        .contact-item.active {
            background-color: #e9f0fd;
            border-left: 3px solid #0d6efd;
        }

        .contact-item.unread::after {
            content: '';
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #0d6efd;
        }

        .contact-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e9f0fd;
            color: #0d6efd;
            font-weight: bold;
            font-size: 20px;
        }

        .contact-info {
            flex-grow: 1;
            overflow: hidden;
        }

        .contact-name {
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: capitalize;
        }

        .contact-preview {
            color: #777;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.85rem;
        }

        .contact-meta {
            text-align: right;
            min-width: 50px;
        }

        .contact-time {
            font-size: 0.75rem;
            color: #777;
            margin-bottom: 5px;
        }

        .contact-badge {
            display: inline-block;
            min-width: 20px;
            height: 20px;
            background-color: #0d6efd;
            color: white;
            border-radius: 10px;
            text-align: center;
            font-size: 0.75rem;
            line-height: 20px;
        }

        /* Chat area styles */
        .chat-area {
            /* flex-grow: 1; */
            display: flex;
            width: 60%;
            flex-direction: column;
            background-color: #f5f7fb;
        }

        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chat-user {
            display: flex;
            align-items: center;
        }

        .chat-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e9f0fd;
            color: #0d6efd;
            font-weight: bold;
            font-size: 18px;
        }

        .chat-user-info h5 {
            margin: 0;
            font-size: 1rem;
            text-transform: capitalize;
        }

        .chat-user-info span {
            font-size: 0.8rem;
            color: #777;
        }

        .chat-actions {
            display: flex;
            gap: 15px;
        }

        .chat-action-btn {
            background: none;
            border: none;
            color: #777;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .message {
            max-width: 70%;
            margin-bottom: 15px;
            clear: both;
        }

        .message-admin {
            align-self: flex-end;
        }

        .message-customer {
            align-self: flex-start;
        }

        .message-content {
            padding: 10px 15px;
            border-radius: 18px;
            position: relative;
            word-wrap: break-word;
        }

        .message-admin .message-content {
            background-color: #0d6efd;
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message-customer .message-content {
            background-color: white;
            border-bottom-left-radius: 5px;
        }

        .message-time {
            font-size: 0.7rem;
            margin-top: 5px;
            opacity: 0.7;
        }

        .message-admin .message-time {
            text-align: right;
            color: #666;
        }

        .message-customer .message-time {
            text-align: left;
            color: #666;
        }

        .message-image {
            max-width: 200px;
            height: auto;
            border-radius: 10px;
            margin-top: 5px;
            cursor: pointer;
        }

        .chat-input {
            padding: 15px;
            background-color: white;
            border-top: 1px solid #ddd;
        }

        .input-container {
            display: flex;
            align-items: center;
            background-color: #f1f1f1;
            border-radius: 25px;
            padding: 5px;
        }

        .input-container textarea {
            flex-grow: 1;
            border: none;
            background: none;
            padding: 10px 15px;
            max-height: 100px;
            resize: none;
        }

        .input-container textarea:focus {
            outline: none;
        }

        .input-actions {
            display: flex;
            gap: 10px;
            padding-right: 10px;
        }

        .input-action-btn {
            background: none;
            border: none;
            color: #777;
            cursor: pointer;
            font-size: 1.1rem;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .input-action-btn:hover {
            background-color: #e0e0e0;
        }

        .send-btn {
            background-color: #0d6efd;
            color: white;
        }

        .send-btn:hover {
            background-color: #0b5ed7;
        }

        /* Order info panel styles */
        .order-info {
            width: 350px;
            border-left: 1px solid #ddd;
            background-color: white;
            overflow-y: auto;
            padding: 20px;
        }

        .order-section {
            margin-bottom: 20px;
        }

        .order-section-title {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .order-section-title button {
            background: none;
            border: none;
            color: #777;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .order-detail {
            margin-bottom: 10px;
        }

        .order-detail-label {
            font-size: 0.8rem;
            color: #777;
            margin-bottom: 5px;
        }

        .order-detail-value {
            font-size: 0.9rem;
            color: #333;
        }

        .order-status {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .status-option {
            padding: 8px 12px;
            border-radius: 5px;
            background-color: #f1f1f1;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .status-new .status-indicator { background-color: #0d6efd; }
        .status-in-progress .status-indicator { background-color: #ffc107; }
        .status-pending-approval .status-indicator { background-color: #6c757d; }
        .status-completed .status-indicator { background-color: #198754; }
        .status-rejected .status-indicator { background-color: #dc3545; }

        .status-option.active {
            background-color: #e9f0fd;
            font-weight: bold;
        }

        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .gallery-image {
            width: calc(50% - 5px);
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Modal styles for image preview */
        .modal-image {
            width: 100%;
            height: auto;
            max-height: 80vh;
            object-fit: contain;
        }

        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #777;
            padding: 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 20px;
            color: #ddd;
        }

        .empty-state h4 {
            margin-bottom: 10px;
            color: #555;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }

            .chat-container {
                flex-direction: column;
            }

            .contact-list {
                width: 100%;
                height: auto;
                max-height: 40vh;
            }

            .order-info {
                display: none;
                width: 100%;
            }
            
            .order-info.show {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .chat-container {
                height: calc(100vh);
            }
            
            .contact-list {
                max-height: 30vh;
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
                        <img src="images/TSHIRTS/LOGO.jpg" class="logo" alt="Logo">
                        <h5 class="brand-name">Metro District Designs</h5>
                    </div>
                    <a href="dashboard.php" class="sidebar-link">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="admin-orders.php" class="sidebar-link">
                        <i class="fas fa-shopping-cart"></i> Orders
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
                <!-- Chat Container -->
                <div class="chat-container">
                    <!-- Contact List -->
                    <div class="contact-list">
                        <div class="contact-search">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" id="contactSearch" placeholder="Search messages...">
                        </div>
                        <div class="contact-filter">
                            <div class="filter-badge active" data-filter="all">All</div>
                            <div class="filter-badge" data-filter="unread">Unread</div>
                            <div class="filter-badge" data-filter="new">New</div>
                            <div class="filter-badge" data-filter="in-progress">In Progress</div>
                            <div class="filter-badge" data-filter="pending-approval">Pending Approval</div>
                            <div class="filter-badge" data-filter="completed">Completed</div>
                        </div>
                        <div id="contactsList">
                            <!-- Contacts will be loaded dynamically -->
                        </div>
                    </div>

                    <!-- Chat Area -->
                    <div class="chat-area" id="chatArea">
                        <div class="empty-state">
                            <i class="far fa-comments"></i>
                            <h4>Select a conversation</h4>
                            <p>Choose a customer from the list to start chatting</p>
                        </div>
                    </div>

                    <!-- Order Info Panel -->
                    <div class="order-info" id="orderInfo">
                        <!-- Order details will be loaded dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" id="previewImage" class="modal-image">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let ws = null;
            let currentUserId = null;
            let users = []; // All users who have chatted
            let latestChatMap = {}; // user_id => { text, time, sender }
            let inquiriesMap = {}; // user_id => latest inquiry
            let allUsers = [];
            let currentFilter = 'all';

            // Fetch all users who have chat messages
            function fetchSidebarUsers() {
                fetch('api/latest_chat_previews.php')
                    .then(res => res.json())
                    .then(chatData => {
                        latestChatMap = chatData;
                        allUsers = Object.keys(chatData).map(user_id => ({
                            user_id: user_id,
                            customer_name: chatData[user_id].customer_name || "User " + user_id,
                            status: chatData[user_id].status || '', // Add status if available
                            unread: chatData[user_id].unread || false // Add unread if available
                        }));
                        allUsers.sort((a, b) => {
                            const timeA = latestChatMap[a.user_id]?.time || '';
                            const timeB = latestChatMap[b.user_id]?.time || '';
                            return new Date(timeB) - new Date(timeA);
                        });
                        filterAndRenderContacts();
                    });
            }
            fetchSidebarUsers();

            function filterAndRenderContacts() {
                let filtered = allUsers;

                // Apply filter badge
                if (currentFilter === 'unread') {
                    filtered = filtered.filter(u => u.unread);
                } else if (currentFilter !== 'all') {
                    filtered = filtered.filter(u => (u.status || '').toLowerCase() === currentFilter.replace('-', ' '));
                }

                // Apply search
                const searchTerm = document.getElementById('contactSearch').value.toLowerCase();
                if (searchTerm) {
                    filtered = filtered.filter(user =>
                        (user.customer_name || '').toLowerCase().includes(searchTerm)
                    );
                }

                renderContactList(filtered);
            }

            // Fetch latest inquiry for a user
            function fetchUserInquiry(userId, cb) {
                fetch('api/get_inquiries.php?user_id=' + encodeURIComponent(userId))
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.data && data.data.length > 0) {
                            inquiriesMap[userId] = data.data[0];
                            cb(data.data[0]);
                        } else {
                            inquiriesMap[userId] = null;
                            cb(null);
                        }
                    });
            }

            // Fetch chat messages for a user
            function fetchChatMessages(userId) {
                fetch('api/chat_messages.php?admin=1&user_id=' + encodeURIComponent(userId))
                    .then(res => res.json())
                    .then(messages => {
                        renderChatArea(userId, messages);
                        fetchUserInquiry(userId, renderOrderInfo);
                    });
            }

            function formatTime(timestamp) {
                const date = new Date(timestamp);
                const now = new Date();
                const diffDays = Math.floor((now - date) / (1000 * 60 * 60 * 24));
                if (diffDays === 0) {
                    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                } else if (diffDays === 1) {
                    return 'Yesterday';
                } else if (diffDays < 7) {
                    return ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][date.getDay()];
                } else {
                    return date.toLocaleDateString();
                }
            }

            function getInitials(name) {
                return name.split(' ').map(n => n.charAt(0).toUpperCase()).join('');
            }

            function renderContactList(contacts) {
                const contactsList = document.getElementById('contactsList');
                contactsList.innerHTML = '';
                contacts.forEach(contact => {
                    const chat = latestChatMap[contact.user_id];
                    const preview = chat && chat.text ? chat.text.substring(0, 40) : '';
                    const time = chat && chat.time ? formatTime(chat.time) : '';
                    const contactItem = document.createElement('div');
                    contactItem.className = 'contact-item';
                    contactItem.setAttribute('data-id', contact.user_id);
                    contactItem.innerHTML = `
                        <div class="contact-avatar">${getInitials(contact.customer_name)}</div>
                        <div class="contact-info">
                            <div class="contact-name">${contact.customer_name}</div>
                            <div class="contact-preview">${preview}</div>
                        </div>
                        <div class="contact-meta">
                            <div class="contact-time">${time}</div>
                        </div>
                    `;
                    contactItem.addEventListener('click', () => {
                        currentUserId = contact.user_id;
                        fetchChatMessages(currentUserId);
                        document.querySelectorAll('.contact-item').forEach(item => item.classList.remove('active'));
                        contactItem.classList.add('active');
                    });
                    contactsList.appendChild(contactItem);
                });
            }

            function getContactName(userId) {
                const contact = users.find(c => c.user_id == userId);
                return contact ? contact.customer_name : '';
            }

            function renderChatArea(userId, messages) {
                const chatArea = document.getElementById('chatArea');
                chatArea.innerHTML = `
                    <div class="chat-header">
                        <div class="chat-user">
                            <div class="chat-avatar">${getInitials(getContactName(userId))}</div>
                            <div class="chat-user-info">
                                <h5>${getContactName(userId)}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="chat-messages" id="chatMessages"></div>
                    <div class="chat-input">
                        <div class="input-container">
                            <textarea class="form-control" id="messageInput" placeholder="Type a message..."></textarea>
                            <div class="input-actions">
                                <button class="input-action-btn send-btn" id="sendMessage">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                const chatMessages = document.getElementById('chatMessages');
                chatMessages.innerHTML = '';
                messages.forEach(msg => {
                    const msgDiv = document.createElement('div');
                    msgDiv.className = `message message-${msg.sender === 'admin' ? 'admin' : 'customer'}`;
                    msgDiv.innerHTML = `
                        <div class="message-content">${msg.text}</div>
                        <div class="message-time">${formatTime(msg.time)}</div>
                    `;
                    chatMessages.appendChild(msgDiv);
                });
                chatMessages.scrollTop = chatMessages.scrollHeight;

                // Send message
                document.getElementById('sendMessage').onclick = function() {
                    sendMessage();
                };
                document.getElementById('messageInput').onkeydown = function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        sendMessage();
                    }
                };
            }

            // Update sidebar after sending a message as admin
            function sendMessage() {
                const input = document.getElementById('messageInput');
                const text = input.value.trim();
                if (!text || !currentUserId) return;

                // Save to backend
                fetch('api/chat_messages.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({text: text, sender: 'admin', user_id: currentUserId})
                }).then(() => {
                    // After saving, update sidebar to reflect new message order/preview
                    fetchSidebarUsers();
                });

                // Send via WebSocket (optional, for real-time)
                if (ws && ws.readyState === WebSocket.OPEN) {
                    ws.send(JSON.stringify({
                        to: currentUserId,
                        message: text,
                        sender: 'admin'
                    }));
                }

                appendMessage({
                    sender: 'admin',
                    message: text,
                    sent_at: new Date().toISOString()
                });

                input.value = '';
            }

            function renderOrderInfo(inquiry) {
                const orderInfo = document.getElementById('orderInfo');
                if (!inquiry) {
                    orderInfo.innerHTML = '';
                    return;
                }
                orderInfo.innerHTML = `
                    <div class="order-section">
                        <div class="order-section-title">Inquiry Details</div>
                        <div class="order-detail">
                            <div class="order-detail-label">Created</div>
                            <div class="order-detail-value">${new Date(inquiry.created_at).toLocaleString()}</div>
                        </div>
                        <div class="order-detail">
                            <div class="order-detail-label">Timeline</div>
                            <div class="order-detail-value">${inquiry.timeline}</div>
                        </div>
                        <div class="order-detail">
                            <div class="order-detail-label">Description</div>
                            <div class="order-detail-value">${inquiry.description}</div>
                        </div>
                        <div class="order-detail">
                            <div class="order-detail-label">Color</div>
                            <div class="order-detail-value">${inquiry.color}</div>
                        </div>
                        <div class="order-detail">
                            <div class="order-detail-label">Size</div>
                            <div class="order-detail-value">${inquiry.size}</div>
                        </div>
                        <div class="order-detail">
                            <div class="order-detail-label">Quantity</div>
                            <div class="order-detail-value">${inquiry.quantity}</div>
                        </div>
                        <div class="order-detail">
                            <div class="order-detail-label">Status</div>
                            <div class="order-detail-value">${inquiry.status}</div>
                        </div>
                        ${inquiry.image_path ? `
                        <div class="order-detail">
                            <div class="order-detail-label">Image</div>
                            <img src="${inquiry.image_path}" class="gallery-image" style="max-width:100%;">
                        </div>
                        ` : ''}
                    </div>
                `;
            }

            // WebSocket connection
            function connectWebSocket() {
                ws = new WebSocket('ws://localhost:8080');
                ws.onopen = function() {
                    ws.send(JSON.stringify({type: "init", is_admin: true}));
                };
                ws.onmessage = function(event) {
                    const data = JSON.parse(event.data);
                    // Log for debugging
                    console.log('WebSocket message:', data);

                    // Determine the user_id for this message
                    let messageUserId = data.user_id || data.from || data.to;

                    // If this message belongs to the currently open chat, append it
                    if (messageUserId == currentUserId) {
                        appendMessage({
                            sender: data.sender,
                            text: data.text !== undefined ? data.text : data.message,
                            time: data.time !== undefined ? data.time : data.sent_at
                        });
                    }
                    // Always update sidebar for new messages
                    fetchSidebarUsers();
                };
                ws.onclose = function() {
                    setTimeout(connectWebSocket, 2000);
                };
            }
            connectWebSocket();

            function appendMessage(msg) {
                const chatMessages = document.getElementById('chatMessages');
                if (!chatMessages) return;
                const messageText = msg.text !== undefined ? msg.text : msg.message;
                let messageTime = msg.time !== undefined ? msg.time : msg.sent_at;
                if(!messageTime) messageTime = new Date().toISOString();
                const msgDiv = document.createElement('div');
                msgDiv.className = `message message-${msg.sender === 'admin' ? 'admin' : 'customer'}`;
                msgDiv.innerHTML = `
                    <div class="message-content">${messageText}</div>
                    <div class="message-time">${formatTime(messageTime)}</div>
                `;
                chatMessages.appendChild(msgDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Filter contacts based on search input
            document.getElementById('contactSearch').addEventListener('input', filterAndRenderContacts);
            document.querySelectorAll('.filter-badge').forEach(badge => {
                badge.addEventListener('click', function() {
                    document.querySelectorAll('.filter-badge').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentFilter = this.getAttribute('data-filter');
                    filterAndRenderContacts();
                });
            });

            // Responsive sidebar toggle
            const toggleSidebar = () => {
                document.querySelector('.sidebar').classList.toggle('show');
            };
            
            // Add sidebar toggle button for mobile if it doesn't exist
            if (!document.getElementById('sidebarToggle')) {
                const toggleBtn = document.createElement('button');
                toggleBtn.id = 'sidebarToggle';
                toggleBtn.className = 'btn btn-sm btn-primary position-fixed';
                toggleBtn.style.top = '10px';
                toggleBtn.style.left = '10px';
                toggleBtn.style.zIndex = '1000';
                toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
                toggleBtn.addEventListener('click', toggleSidebar);
                
                document.body.appendChild(toggleBtn);
                
                // Show button only on mobile
                const checkWidth = () => {
                    if (window.innerWidth <= 992) {
                        toggleBtn.style.display = 'block';
                    } else {
                        toggleBtn.style.display = 'none';
                    }
                };
                
                window.addEventListener('resize', checkWidth);
                checkWidth(); // Initial check
            }
        });
    </script>
</body>
</html>