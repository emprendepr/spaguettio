<?php
/**
 * Spaguettio Chat Styles
 * LatinChat-inspired design
 */
?>
/* Main Chat Container */
.spaguettio-chat-container {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
    margin: 20px 0;
    max-width: 1200px;
    margin: 20px auto;
}

.spaguettio-chat-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 20px;
    text-align: center;
}

.spaguettio-chat-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: bold;
}

/* Main Chat Area */
.spaguettio-chat-main {
    display: flex;
    height: 600px;
}

.spaguettio-chat-messages-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
    border-right: 1px solid #e0e0e0;
}

/* Messages Area */
.spaguettio-chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    background: #f5f5f5;
}

.spaguettio-chat-welcome {
    text-align: center;
    color: #999;
    padding: 40px 20px;
}

.spaguettio-chat-message {
    margin-bottom: 15px;
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.chat-message-bubble {
    background: #fff;
    border-radius: 18px;
    padding: 12px 16px;
    display: inline-block;
    max-width: 70%;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.chat-message-header {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}

.chat-message-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 8px;
}

.chat-message-username {
    font-weight: bold;
    color: #667eea;
    font-size: 14px;
}

.chat-message-time {
    font-size: 11px;
    color: #999;
    margin-left: 8px;
}

.chat-message-text {
    color: #333;
    word-wrap: break-word;
    line-height: 1.4;
}

.chat-message-system {
    text-align: center;
    color: #999;
    font-size: 13px;
    font-style: italic;
    margin: 10px 0;
}

/* Input Area */
.spaguettio-chat-input-wrapper {
    padding: 15px;
    background: #fff;
    border-top: 1px solid #e0e0e0;
}

.spaguettio-chat-form {
    display: flex;
    gap: 10px;
}

.spaguettio-chat-input {
    flex: 1;
    padding: 12px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 25px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.3s;
}

.spaguettio-chat-input:focus {
    border-color: #667eea;
}

.spaguettio-chat-send-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    border-radius: 25px;
    padding: 12px 25px;
    cursor: pointer;
    font-weight: bold;
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.spaguettio-chat-send-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.spaguettio-chat-send-btn:active {
    transform: translateY(0);
}

/* Users Sidebar */
.spaguettio-chat-users-sidebar {
    width: 280px;
    background: #fafafa;
    display: flex;
    flex-direction: column;
}

.spaguettio-chat-users-header {
    padding: 15px;
    background: #f0f0f0;
    border-bottom: 1px solid #e0e0e0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.spaguettio-chat-users-header h3 {
    margin: 0;
    font-size: 16px;
    color: #333;
}

.users-count {
    background: #667eea;
    color: #fff;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
}

.spaguettio-chat-users-list {
    flex: 1;
    overflow-y: auto;
    padding: 10px;
}

.chat-user-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 5px;
    cursor: pointer;
    transition: background 0.2s;
}

.chat-user-item:hover {
    background: #e8e8e8;
}

.chat-user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    margin-right: 10px;
}

.chat-user-info {
    flex: 1;
}

.chat-user-name {
    font-weight: 500;
    color: #333;
    font-size: 14px;
}

.chat-user-status {
    width: 8px;
    height: 8px;
    background: #4caf50;
    border-radius: 50%;
    display: inline-block;
    margin-left: 5px;
}

/* Admin Styles */
.spaguettio-chat-admin-container {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    margin: 20px 0;
}

.spaguettio-chat-admin-header h1 {
    color: #333;
    margin-bottom: 30px;
}

.spaguettio-chat-admin-layout {
    display: flex;
    gap: 30px;
}

.spaguettio-chat-admin-main {
    flex: 1;
}

.spaguettio-chat-admin-sidebar {
    width: 350px;
    background: #f9f9f9;
    border-radius: 8px;
    padding: 20px;
}

.admin-sidebar-section h2 {
    color: #667eea;
    margin-bottom: 20px;
    font-size: 18px;
}

.admin-section {
    margin-bottom: 40px;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
}

.admin-section h2 {
    color: #667eea;
    margin-bottom: 20px;
    font-size: 20px;
}

.admin-stats {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.stat-box {
    flex: 1;
    min-width: 200px;
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stat-icon {
    font-size: 36px;
    color: #667eea;
}

.stat-info h3 {
    margin: 0;
    font-size: 28px;
    color: #333;
}

.stat-info p {
    margin: 5px 0 0 0;
    color: #666;
    font-size: 13px;
}

.admin-settings .form-group {
    margin-bottom: 20px;
}

.admin-settings label {
    display: block;
    margin-bottom: 5px;
    color: #333;
    font-weight: 500;
}

.admin-settings .form-control {
    width: 100%;
    max-width: 400px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.admin-settings .btn {
    margin-top: 10px;
}

.moderation-actions {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 500;
    transition: background 0.2s;
}

.btn-primary {
    background: #667eea;
    color: #fff;
}

.btn-primary:hover {
    background: #5568d3;
}

.btn-warning {
    background: #ff9800;
    color: #fff;
}

.btn-warning:hover {
    background: #e68900;
}

.btn-info {
    background: #2196f3;
    color: #fff;
}

.btn-info:hover {
    background: #0c7cd5;
}

.btn-success {
    background: #4caf50;
    color: #fff;
}

.btn-success:hover {
    background: #45a049;
}

.recent-activity, .rooms-list {
    margin-top: 20px;
    background: #fff;
    padding: 15px;
    border-radius: 4px;
}

/* Create Room Panel */
.create-room-panel {
    margin-bottom: 20px;
}

.btn-block {
    width: 100%;
}

.create-room-form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    margin-top: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.create-room-form h3 {
    margin-top: 0;
    margin-bottom: 20px;
    color: #333;
    font-size: 18px;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.btn-secondary {
    background: #999;
    color: #fff;
}

.btn-secondary:hover {
    background: #777;
}

.room-item {
    background: #fff;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.room-item h4 {
    margin: 0 0 5px 0;
    color: #333;
}

.room-item p {
    margin: 0;
    color: #666;
    font-size: 13px;
}

.room-info {
    margin-bottom: 10px;
}

.room-actions {
    display: flex;
    gap: 8px;
}

.room-actions .btn {
    padding: 6px 12px;
    font-size: 13px;
}

.btn-danger {
    background: #f44336;
    color: #fff;
}

.btn-danger:hover {
    background: #d32f2f;
}

/* Responsive Design */
@media (max-width: 768px) {
    .spaguettio-chat-main {
        flex-direction: column;
        height: auto;
    }
    
    .spaguettio-chat-messages-wrapper {
        border-right: none;
        border-bottom: 1px solid #e0e0e0;
        min-height: 400px;
    }
    
    .spaguettio-chat-users-sidebar {
        width: 100%;
        max-height: 200px;
    }
    
    .spaguettio-chat-admin-layout {
        flex-direction: column;
    }
    
    .spaguettio-chat-admin-sidebar {
        width: 100%;
    }
    
    .admin-stats {
        flex-direction: column;
    }
    
    .stat-box {
        min-width: 100%;
    }
}
