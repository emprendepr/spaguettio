# Spaguettio Chat Component

A LatinChat-style real-time chat room component for OSSN (Open Source Social Network).

## Features

- **Real-time Chat Room**: Public chat room where users can communicate in real-time
- **User Registration**: Automatic user registration using their OSSN username when entering chat
- **Online Users List**: Live sidebar showing all users currently in the chat room
- **Multiple Rooms**: Support for creating and managing multiple chat rooms
- **Admin Panel**: Complete administration interface accessible from the topbar
- **Database Storage**: All messages and user activity stored in database tables
- **LatinChat-Style Interface**: Familiar and user-friendly chat interface

## Installation

1. Copy the `SpaguettioChat` folder to your OSSN `components` directory
2. Log in to your OSSN admin panel
3. Navigate to Components section
4. Find "Spaguettio Chat" and click "Enable"
5. The component will automatically create the necessary database tables

## Database Tables

The component creates four tables:

- `ossn_spaguettio_chat_messages`: Stores all chat messages
- `ossn_spaguettio_chat_rooms`: Stores chat room information
- `ossn_spaguettio_chat_users`: Tracks active users in chat rooms
- `ossn_spaguettio_chat_settings`: Stores chat configuration settings

## Usage

### For Users

1. Once enabled, a "Chat Room" link appears in the sidebar menu
2. Click the link to enter the chat room
3. Your username is automatically registered when you enter
4. Type messages in the input box and click "Send" or press Enter
5. See other online users in the right sidebar
6. System messages show when users join or leave the chat

### For Administrators

1. A "Chat Admin" link appears in the admin topbar
2. Click to access the administration panel
3. View real-time statistics (online users, messages, averages)
4. Manage chat rooms from the sidebar:
   - Create new chat rooms with custom settings
   - Edit existing rooms
   - Delete rooms (except the main room)
5. Configure chat settings (max users, rate limits, moderation)
6. Clear chat history
7. View banned users (feature in development)

## Technical Details

### Component Structure

```
SpaguettioChat/
├── ossn_com.php          # Main component initialization
├── ossn_com.xml          # Component metadata
├── schema.php            # Database schema and installation
├── locale/               # Language files
│   ├── ossn.en.php      # English translations
│   └── ossn.es.php      # Spanish translations
├── views/                # View templates
│   └── default/
│       └── chat/
│           ├── room.php  # Chat room interface
│           └── admin.php # Admin panel interface
├── css/                  # Stylesheets
│   └── spaguettio_chat.php
├── js/                   # JavaScript
│   └── spaguettio_chat.php
└── actions/              # Backend actions
    ├── send.php
    ├── get_messages.php
    ├── get_users.php
    ├── register_user.php
    ├── unregister_user.php
    ├── get_rooms.php
    ├── create_room.php
    ├── edit_room.php
    ├── delete_room.php
    ├── get_statistics.php
    ├── clear_history.php
    └── save_settings.php
```

### Key Features Implementation

- **Auto-refresh**: Messages and user list refresh every 3 seconds
- **User Tracking**: Users inactive for 5+ minutes are automatically removed
- **System Messages**: Join/leave notifications are automatically posted
- **Security**: Messages are sanitized before storage
- **Responsive Design**: Works on desktop and mobile devices

## Configuration

Default settings can be modified in the admin panel:

- **Max Users**: Maximum users allowed per room (default: 100)
- **Rate Limit**: Messages per minute limit (default: 10)
- **Moderation**: Enable/disable automatic moderation (default: enabled)

## Requirements

- OSSN version 5.0 or higher
- PHP with MySQLi support
- Modern web browser with JavaScript enabled

## License

GPL License

## Author

Spaguettio Team
https://github.com/emprendepr/spaguettio

## Support

For issues and feature requests, please visit:
https://github.com/emprendepr/spaguettio/issues
