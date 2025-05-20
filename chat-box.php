<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    return;
}
?>

<!-- Chat Box Component -->
<button class="chat-toggle" id="chatToggleBtn" style="display: flex;">💬</button>
<div class="chat-container" id="chatContainer" style="display: none;">
    <div class="chat-header">
        <div class="chat-header-logo">
            <div class="logo"></div>
            <span>Metro District Designs</span>
        </div>
        <div class="chat-header-actions">
            <button class="header-button" id="minimizeBtn">-</button>
            <button class="header-button" id="closeBtn">×</button>
        </div>
    </div>
    <div class="chat-messages" id="chatMessages">
        <!-- Messages will be appended here -->
        <div class="message-container">
            <div class="message received">
                Welcome to Metro District Designs! How can we help you today?
            </div>
        </div>
        <!-- <div class="safety-banner">
            <span class="safety-icon">⚠️</span>
            <div>For your safety, please keep all communications within this chat. Don't share personal information.</div>
        </div> -->
    </div>
    <div class="chat-input" id="chatInputSection">
        <?php if(!empty($_SESSION['user_id'])): ?>
            <input type="text" class="input-field" id="chatInput" placeholder="Type a message here">
            <button class="send-button" id="sendBtn">➤</button>
        <?php else: ?>
            <div class="chat-login-prompt" style="width:100%;text-align:center;">
                Please <a href="Login.php">log in</a> or <a href="Signup.php">sign up</a> to start a chat
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* --- chat-box2 styles reused and adapted --- */
.chat-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #333333;
    color: white;
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}
.chat-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 320px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-height: 500px;
    background: #fff;
    z-index: 1001;
}
.chat-header {
    background-color: #1a1a1a;
    color: white;
    padding: 12px 16px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.chat-header-logo {
    display: flex;
    align-items: center;
    gap: 10px;
}
.logo {
    width: 24px;
    height: 24px;
    background-color: #ff4500;
    border-radius: 4px;
}
.chat-header-actions {
    display: flex;
    gap: 10px;
}
.header-button {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    font-size: 16px;
}
.chat-messages {
    background-color: white;
    padding: 10px;
    overflow-y: auto;
    flex-grow: 1;
    max-height: 300px;
    display: flex;
    flex-direction: column;
}
.message {
    margin-bottom: 10px;
    padding: 8px 12px;
    border-radius: 16px;
    max-width: 80%;
    word-wrap: break-word;
}
.received {
    background-color: #f0f0f0;
    align-self: flex-start;
    margin-right: auto;
}
.sent {
    background-color: #333333;
    color: white;
    align-self: flex-end;
    margin-left: auto;
}
.message-container {
    display: flex;
    flex-direction: column;
}
.chat-input {
    display: flex;
    padding: 10px;
    background-color: #f5f5f5;
    border-top: 1px solid #ddd;
}
.input-field {
    flex-grow: 1;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 8px 12px;
    outline: none;
}
.send-button {
    background-color: #333333;
    color: white;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    margin-left: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
.safety-banner {
    background-color: #fff9e6;
    border-left: 4px solid #ffcc00;
    padding: 10px;
    margin: 5px;
    font-size: 12px;
    color: #666;
    display: flex;
    align-items: flex-start;
}
.safety-icon {
    color: #ffcc00;
    margin-right: 8px;
    font-size: 16px;
}
.timestamp {
    font-size: 10px;
    color: #999;
    margin-top: 4px;
    text-align: right;
}
.chat-login-prompt a {
    color: #1a75bb;
    font-weight: bold;
    text-decoration: none;
}
@media (max-width: 576px) {
    .chat-container {
        width: calc(100vw - 40px);
        right: 0;
        max-height: 400px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatToggleBtn = document.getElementById('chatToggleBtn');
    const chatContainer = document.getElementById('chatContainer');
    const closeBtn = document.getElementById('closeBtn');
    const minimizeBtn = document.getElementById('minimizeBtn');
    const chatMessages = document.getElementById('chatMessages');
    const chatInputSection = document.getElementById('chatInputSection');
    const sendBtn = document.getElementById('sendBtn');
    const chatInput = document.getElementById('chatInput');
    const user_id = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>";
    let ws = null;
    let minimized = false;

    // Toggle chat open
    chatToggleBtn.addEventListener('click', function() {
        chatContainer.style.display = 'flex';
        chatToggleBtn.style.display = 'none';
        scrollToBottom();
    });

    // Close chat
    closeBtn.addEventListener('click', function() {
        chatContainer.style.display = 'none';
        chatToggleBtn.style.display = 'flex';
    });

    // Minimize chat
    minimizeBtn.addEventListener('click', function() {
        minimized = !minimized;
        if (minimized) {
            chatMessages.style.display = 'none';
            chatInputSection.style.display = 'none';
        } else {
            chatMessages.style.display = 'flex';
            chatInputSection.style.display = 'flex';
            scrollToBottom();
        }
    });

    // Send message
    if (sendBtn && chatInput) {
        sendBtn.addEventListener('click', sendMessage);
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') sendMessage();
        });
    }

    // WebSocket connection
    function connectWebSocket() {
        ws = new WebSocket('ws://localhost:8080');
        ws.onopen = function() {
            ws.send(JSON.stringify({type: "init", user_id: user_id}));
        };
        ws.onmessage = function(event) {
            const data = JSON.parse(event.data);
            if(data.message) {
                addMessage(data.message, 'received');
            }
        };
        ws.onclose = function() {
            setTimeout(connectWebSocket, 2000);
        };
    }
    if (user_id) connectWebSocket();

    // Load chat history
    function loadChatHistory() {
        fetch('api/chat_messages.php')
            .then(res => res.json())
            .then(messages => {
                messages.forEach(msg => {
                    addMessage(msg.text, msg.sender === 'user' ? 'sent' : 'received', msg.time);
                });
                scrollToBottom();
            });
    }
    loadChatHistory();

    // Add message to chat
    function addMessage(text, type, time=null) {
        const msgContainer = document.createElement('div');
        msgContainer.className = 'message-container';
        const msgDiv = document.createElement('div');
        msgDiv.className = 'message ' + type;
        msgDiv.innerHTML = text;
        msgContainer.appendChild(msgDiv);

        // --- Correct UTC+8 time logic ---
        let now;
        if (time) {
            now = new Date(time);
        } else {
            now = new Date();
        }
        const timestamp = document.createElement('div');
        timestamp.className = 'timestamp';
        timestamp.textContent = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', timeZone: 'Asia/Singapore'});
        msgContainer.appendChild(timestamp);

        chatMessages.appendChild(msgContainer);
        scrollToBottom();

        // Save only new messages (not when loading history)
        if (!time && type === 'sent') {
            saveMessage(text, 'user');
        }
        if (!time && type === 'received') {
            saveMessage(text, 'admin');
        }
    }

    // Save message to backend
    function saveMessage(text, sender) {
        fetch('api/chat_messages.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({text, sender})
        });
    }

    // Send message logic
    function sendMessage() {
        if (!chatInput.value.trim()) return;
        const message = chatInput.value.trim();
        addMessage(message, 'sent');
        if (ws && ws.readyState === WebSocket.OPEN) {
            ws.send(JSON.stringify({user_id: user_id, to: "admin", message: message, sender: "user"}));
        }
        chatInput.value = '';
    }

    // Scroll to bottom helper
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});
</script>