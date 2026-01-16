/* Lounge Styles - Integrado con OSSN */

.lounge-container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.lounge-header-info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
}

.lounge-header-info .current-user {
    font-weight: bold;
    font-size: 16px;
    background: rgba(255, 255, 255, 0.2);
    padding: 6px 15px;
    border-radius: 20px;
}

.lounge-main-area {
    display: flex;
    min-height: 600px;
}

.lounge-users-sidebar {
    width: 250px;
    background: #f8f9fa;
    border-right: 1px solid #e0e0e0;
    padding: 15px;
    overflow-y: auto;
}

.lounge-users-sidebar h4 {
    color: #764ba2;
    margin-bottom: 15px;
    font-size: 16px;
}

#lounge-users-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.lounge-user-item {
    background: white;
    padding: 10px 12px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.lounge-user-item:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

.lounge-user-item .status-indicator {
    width: 10px;
    height: 10px;
    background: #28a745;
    border-radius: 50%;
    animation: lounge-pulse 2s infinite;
}

@keyframes lounge-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.lounge-user-item .username {
    font-weight: bold;
    font-size: 14px;
}

.lounge-content-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: white;
}

.lounge-messages-container {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.lounge-messages-container::-webkit-scrollbar {
    width: 8px;
}

.lounge-messages-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.lounge-messages-container::-webkit-scrollbar-thumb {
    background: #764ba2;
    border-radius: 4px;
}

.lounge-messages-container::-webkit-scrollbar-thumb:hover {
    background: #667eea;
}

.lounge-message {
    display: flex;
    flex-direction: column;
    max-width: 70%;
    animation: lounge-slideIn 0.3s ease-out;
}

@keyframes lounge-slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.lounge-message.own {
    align-self: flex-end;
}

.lounge-message.other {
    align-self: flex-start;
}

.lounge-message.system {
    align-self: center;
    max-width: 90%;
}

.lounge-message-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 5px;
    font-size: 12px;
}

.lounge-message-username {
    font-weight: bold;
}

.lounge-message-time {
    color: #888;
    font-size: 11px;
}

.lounge-message-content {
    padding: 12px 18px;
    border-radius: 8px;
    word-wrap: break-word;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.lounge-message.own .lounge-message-content {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.lounge-message.other .lounge-message-content {
    background: #f8f9fa;
    border: 1px solid #e0e0e0;
    color: #333;
}

.lounge-message.system .lounge-message-content {
    background: #fff9c4;
    color: #333;
    text-align: center;
    font-style: italic;
    border: 1px solid #fdd835;
}

.lounge-emoticons-bar {
    display: flex;
    gap: 10px;
    padding: 12px 20px;
    background: #f8f9fa;
    border-top: 1px solid #e0e0e0;
    justify-content: center;
    flex-wrap: wrap;
}

.lounge-emoticon {
    font-size: 22px;
    cursor: pointer;
    transition: transform 0.2s;
    padding: 4px;
}

.lounge-emoticon:hover {
    transform: scale(1.3);
}

.lounge-input-area {
    display: flex;
    gap: 10px;
    padding: 15px 20px;
    background: #f8f9fa;
    border-top: 1px solid #e0e0e0;
}

#lounge-message-input {
    flex: 1;
    padding: 10px 18px;
    border: 2px solid #e0e0e0;
    border-radius: 25px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.3s;
}

#lounge-message-input:focus {
    border-color: #764ba2;
}

/* Responsive */
@media (max-width: 768px) {
    .lounge-main-area {
        flex-direction: column;
    }
    
    .lounge-users-sidebar {
        width: 100%;
        max-height: 150px;
        border-right: none;
        border-bottom: 1px solid #e0e0e0;
    }
    
    #lounge-users-list {
        flex-direction: row;
        overflow-x: auto;
        flex-wrap: nowrap;
    }
    
    .lounge-user-item {
        flex-shrink: 0;
    }
    
    .lounge-message {
        max-width: 85%;
    }
    
    .lounge-emoticons-bar {
        padding: 10px;
        gap: 8px;
    }
    
    .lounge-emoticon {
        font-size: 20px;
    }
}
