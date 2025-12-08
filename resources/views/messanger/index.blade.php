@extends('layouts.master')

@section('content')

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Include Feather Icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- Custom CSS with unique class prefixes for better aesthetics -->
    <style>
        :root {
            --message-app-primary: #0d6efd; /* Primary Blue */
            --message-app-bg-light: #f8f9fa; /* Light background for chat area */
            --message-app-bg-white: #ffffff;
            --message-app-sidebar-width-lg: 380px;
        }

        /* 1. Overall App Container */
        .message-app-container {
            height: 100vh;
            width: 100%;
            display: flex;
            background-color: #e9ecef; /* Slightly darker background for context */
        }

        @media (min-width: 992px) {
            .message-app-container {
                height: 90vh;
                max-width: 1400px;
                border-radius: 1rem;
                overflow: hidden;
                box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175); /* Prominent shadow */
            }
        }

        /* 2. Sidebar Layout */
        .message-app-sidebar {
            width: 100%; /* Mobile full width */
            background-color: var(--message-app-bg-white);
            border-right: 1px solid #e9ecef;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }
        @media (min-width: 992px) {
            .message-app-sidebar {
                width: var(--message-app-sidebar-width-lg);
                display: flex !important;
            }
        }

        /* 3. Chat Area Layout and Responsiveness */
        .message-app-chat-area {
            flex-grow: 1;
            background-color: var(--message-app-bg-light);
            display: none;
            flex-direction: column;
        }
        @media (min-width: 992px) {
            .message-app-chat-area {
                display: flex !important;
            }
        }
        .message-app-chat-area.message-app-active {
            display: flex !important;
        }
        .message-app-sidebar:not(.message-app-active) {
            display: none;
        }
        .message-app-sidebar.message-app-active {
            display: flex;
        }

        /* 4. Chat List Items */
        .message-app-chat-item {
            cursor: pointer;
            transition: background-color 0.2s, border-left 0.2s;
            border-left: 4px solid transparent;
            padding: 0.8rem 1rem; /* Better padding for list items */
        }
        .message-app-chat-item:hover {
            background-color: #f0f0f0;
        }
        .message-app-chat-item.message-app-active {
            background-color: var(--message-app-bg-light) !important;
            border-left-color: var(--message-app-primary);
        }
        .message-app-avatar {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 50%; /* Ensure rounded avatars */
        }

        /* 5. Message Bubbles */
        .message-app-log {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1.5rem;
        }
        /* Custom scrollbar for the message log */
        .message-app-log::-webkit-scrollbar { width: 6px; }
        .message-app-log::-webkit-scrollbar-thumb { background-color: #ced4da; border-radius: 3px; }

        .message-app-bubble-them {
            background-color: var(--message-app-bg-white);
            color: #212529;
            border-radius: 1rem 1rem 1rem 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            max-width: 70%;
        }
        .message-app-bubble-me {
            background-color: var(--message-app-primary);
            color: #fff;
            border-radius: 1rem 1rem 0 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
            max-width: 70%;
        }
        .message-app-check-icon {
             color: #28a745; /* Bootstrap Green */
             font-size: 0.8rem;
        }
    </style>
</head>

<!-- Main Container -->
<div class="message-app-container">

    <!-- 1. Sidebar (User List) -->
    <div id="messageAppSidebar" class="message-app-sidebar message-app-active">
        <!-- Search Header -->
        <div class="p-3 border-bottom bg-white">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 border-0 ps-0"><i data-feather="search" class="text-muted" style="width: 1.25rem;"></i></span>
                <!-- Use rounded-pill for a sleeker search bar look -->
                <input type="text" placeholder="Search chats..." class="form-control rounded-pill shadow-none" style="padding-left: 0.75rem;">
            </div>
        </div>

        <!-- Chat List -->
        <div id="messageAppChatList" class="overflow-auto flex-grow-1">
            <!-- Active Chat Item -->
            <div class="message-app-chat-item d-flex align-items-center message-app-active"
                 onclick="switchChat(this, 'Azunyan U. Wu', 'Active', 'https://placehold.co/45x45/0dcaf0/ffffff?text=AW')">
                <div class="position-relative flex-shrink-0">
                    <img class="message-app-avatar" src="https://placehold.co/45x45/0dcaf0/ffffff?text=AW" alt="Avatar">
                    <div class="position-absolute bottom-0 end-0 rounded-circle border border-2 border-white bg-success" style="width:12px; height:12px;"></div>
                </div>
                <div class="flex-grow-1 ms-3 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0 fw-bold text-truncate small" style="max-width: 75%;">Azunyan U. Wu</p>
                        <small class="text-muted" style="font-size: 0.7rem;">16:45</small>
                    </div>
                    <p class="mb-0 text-muted text-truncate small">I'll send you the report by EOD...</p>
                </div>
                <span class="badge rounded-pill bg-primary ms-2" style="font-size: 0.7rem;">2</span>
            </div>

            <!-- Inactive Chat Item 1 -->
            <div class="message-app-chat-item d-flex align-items-center"
                 onclick="switchChat(this, 'Bob Johnson', 'Offline', 'https://placehold.co/45x45/6c757d/ffffff?text=BJ')">
                <div class="position-relative flex-shrink-0">
                    <img class="message-app-avatar" src="https://placehold.co/45x45/6c757d/ffffff?text=BJ" alt="Avatar">
                    <div class="position-absolute bottom-0 end-0 rounded-circle border border-2 border-white bg-secondary" style="width:12px; height:12px;"></div>
                </div>
                <div class="flex-grow-1 ms-3 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0 fw-bold text-truncate small" style="max-width: 75%;">Bob Johnson</p>
                        <small class="text-muted" style="font-size: 0.7rem;">Yesterday</small>
                    </div>
                    <p class="mb-0 text-muted text-truncate small">Sounds great!</p>
                </div>
            </div>

            <!-- Inactive Chat Item 2 -->
            <div class="message-app-chat-item d-flex align-items-center"
                 onclick="switchChat(this, 'Alice Smith', 'Busy', 'https://placehold.co/45x45/ffc107/ffffff?text=AS')">
                <div class="position-relative flex-shrink-0">
                    <img class="message-app-avatar" src="https://placehold.co/45x45/ffc107/ffffff?text=AS" alt="Avatar">
                    <div class="position-absolute bottom-0 end-0 rounded-circle border border-2 border-white bg-danger" style="width:12px; height:12px;"></div>
                </div>
                <div class="flex-grow-1 ms-3 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0 fw-bold text-truncate small" style="max-width: 75%;">Alice Smith</p>
                        <small class="text-muted" style="font-size: 0.7rem;">5 min ago</small>
                    </div>
                    <p class="mb-0 text-muted text-truncate small">The latest budget draft is attached.</p>
                </div>
                <span class="badge rounded-pill bg-primary ms-2" style="font-size: 0.7rem;">1</span>
            </div>
            <!-- Extra list items for scrolling demo -->
            <div class="message-app-chat-item d-flex align-items-center"
                 onclick="switchChat(this, 'Charlie Brown', 'Offline', 'https://placehold.co/45x45/20c997/ffffff?text=CB')">
                <div class="position-relative flex-shrink-0">
                    <img class="message-app-avatar" src="https://placehold.co/45x45/20c997/ffffff?text=CB" alt="Avatar">
                    <div class="position-absolute bottom-0 end-0 rounded-circle border border-2 border-white bg-secondary" style="width:12px; height:12px;"></div>
                </div>
                <div class="flex-grow-1 ms-3 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0 fw-bold text-truncate small" style="max-width: 75%;">Charlie Brown</p>
                        <small class="text-muted" style="font-size: 0.7rem;">1 day</small>
                    </div>
                    <p class="mb-0 text-muted text-truncate small">See you tomorrow!</p>
                </div>
            </div>
            <div class="message-app-chat-item d-flex align-items-center"
                 onclick="switchChat(this, 'Diana Prince', 'Active', 'https://placehold.co/45x45/6610f2/ffffff?text=DP')">
                <div class="position-relative flex-shrink-0">
                    <img class="message-app-avatar" src="https://placehold.co/45x45/6610f2/ffffff?text=DP" alt="Avatar">
                    <div class="position-absolute bottom-0 end-0 rounded-circle border border-2 border-white bg-success" style="width:12px; height:12px;"></div>
                </div>
                <div class="flex-grow-1 ms-3 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0 fw-bold text-truncate small" style="max-width: 75%;">Diana Prince</p>
                        <small class="text-muted" style="font-size: 0.7rem;">now</small>
                    </div>
                    <p class="mb-0 text-muted text-truncate small">Working on it now.</p>
                </div>
                <span class="badge rounded-pill bg-primary ms-2" style="font-size: 0.7rem;">1</span>
            </div>
        </div>
    </div>

    <!-- 2. Chat Area -->
    <div id="messageAppChatArea" class="message-app-chat-area">

        <!-- Chat Header -->
        <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center shadow-sm">
            <div class="d-flex align-items-center">
                <!-- Back Button (Mobile Only) -->
                <button id="messageAppBackButton" class="btn btn-light d-lg-none me-3" onclick="showSidebar()">
                    <i data-feather="chevron-left" style="width: 1.5rem; height: 1.5rem;"></i>
                </button>

                <div class="position-relative">
                    <img id="headerAvatar" class="message-app-avatar" src="https://placehold.co/45x45/0dcaf0/ffffff?text=AW" alt="Avatar">
                    <div id="headerStatus" class="position-absolute bottom-0 end-0 rounded-circle border border-2 border-white bg-success" style="width:12px; height:12px;"></div>
                </div>
                <div class="ms-3">
                    <h5 id="headerName" class="mb-0 fw-bold">Azunyan U. Wu</h5>
                    <p id="headerDetails" class="mb-0 text-success small">Active</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-light rounded-circle p-2" title="Call"><i data-feather="phone" style="width: 1.25rem; height: 1.25rem;"></i></button>
                <button class="btn btn-light rounded-circle p-2" title="View Profile"><i data-feather="user" style="width: 1.25rem; height: 1.25rem;"></i></button>
            </div>
        </div>

        <!-- Message Log -->
        <div id="messageAppLog" class="message-app-log">

            <!-- Date Separator -->
            <div class="d-flex justify-content-center my-4">
                <span class="badge text-bg-light shadow-sm px-3 py-2 rounded-pill">19 August</span>
            </div>

            <!-- Message from Them (Azunyan) - Text -->
            <div class="d-flex justify-content-start mb-2">
                <div class="message-app-bubble-them p-3">
                    <p class="mb-0 small">Hi team! Just wanted to share the final specs for the Q4 product roadmap. Please review the attached document and leave any feedback in the dedicated channel.</p>
                </div>
            </div>
            <div class="text-start small text-muted ms-1 mb-4" style="font-size: 0.7rem;">16:30</div>

            <!-- Message from Them (Azunyan) - Attachment -->
            <div class="d-flex justify-content-start mb-2">
                <div class="message-app-bubble-them p-3 d-flex align-items-center gap-3">
                    <i data-feather="file-text" class="text-primary" style="width: 2rem; height: 2rem;"></i>
                    <div>
                        <p class="mb-0 fw-medium small">Roadmap_Q4.pdf</p>
                        <p class="mb-0 text-muted" style="font-size: 0.75rem;">2.4 MB</p>
                    </div>
                </div>
            </div>
            <div class="text-start small text-muted ms-1 mb-4" style="font-size: 0.7rem;">16:31</div>

            <!-- Date Separator -->
            <div class="d-flex justify-content-center my-4">
                <span class="badge text-bg-light shadow-sm px-3 py-2 rounded-pill">Today</span>
            </div>

            <!-- Message from Me - Text -->
            <div class="d-flex justify-content-end mb-2">
                <div class="message-app-bubble-me p-3">
                    <p class="mb-0 small">Thanks for sharing! Looks great, I'm reviewing the specs now and will get back to you with comments on the UI flow.</p>
                </div>
            </div>
            <!-- Checkmark for Sent/Read -->
            <div class="text-end small text-muted me-1 mb-4" style="font-size: 0.7rem;">16:45 <span class="message-app-check-icon">✓✓</span></div>

            <!-- Message from Them (Azunyan) - Image -->
            <div class="d-flex justify-content-start mb-2">
                <div class="p-1 bg-white rounded-3 shadow-sm" style="max-width: 250px;">
                    <img class="img-fluid rounded-2" src="https://placehold.co/300x200/adb5bd/ffffff?text=Image+Preview" alt="Image received">
                </div>
            </div>
            <div class="text-start small text-muted ms-1 mb-4" style="font-size: 0.7rem;">16:47</div>

            <!-- Message from Me - Audio -->
            <div class="d-flex justify-content-end mb-2">
                <div class="message-app-bubble-me p-3 d-flex align-items-center gap-2" style="max-width: 200px;">
                    <i data-feather="play-circle" class="flex-shrink-0" style="width: 1.25rem; height: 1.25rem;"></i>
                    <!-- Simple waveform simulation -->
                    <div class="flex-grow-1 bg-white rounded-pill" style="height: 4px; opacity: 0.5;">
                        <div class="bg-light rounded-pill" style="width: 60%; height: 100%;"></div>
                    </div>
                    <span class="small flex-shrink-0" style="font-size: 0.75rem;">0:15</span>
                </div>
            </div>
            <div class="text-end small text-muted me-1 mb-4" style="font-size: 0.7rem;">16:50 <span class="message-app-check-icon">✓✓</span></div>

        </div>

        <!-- Message Input Footer -->
        <div class="p-3 border-top bg-white">
            <form id="messageAppForm" class="d-flex align-items-center gap-3">
                <!-- Attachments Icon -->
                <button type="button" class="btn btn-light rounded-circle p-2 text-muted" title="Attach File">
                    <i data-feather="paperclip" class="d-block" style="width: 1.5rem; height: 1.5rem;"></i>
                </button>

                <!-- Text Input -->
                <input type="text" id="messageAppInput" placeholder="Type your message here..." class="form-control form-control-lg rounded-pill shadow-sm" required style="padding-top: 0.6rem; padding-bottom: 0.6rem;">

                <!-- Emoji Icon -->
                <button type="button" class="btn btn-light rounded-circle p-2 text-muted" title="Emoji">
                    <i data-feather="smile" class="d-block" style="width: 1.5rem; height: 1.5rem;"></i>
                </button>

                <!-- Send Button -->
                <button type="submit" class="btn btn-primary rounded-circle p-3 shadow-lg" style="width: 3.2rem; height: 3.2rem; display: flex; align-items: center; justify-content: center;">
                    <i data-feather="send" class="d-block" style="width: 1.5rem; height: 1.5rem;"></i>
                </button>
            </form>
        </div>
    </div>

</div>

<!-- Custom Modal (Bootstrap component replacement for alert/confirm) -->
<div class="modal fade" id="messageAppModal" tabindex="-1" aria-labelledby="messageAppModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageAppModalLabel">App Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="messageAppModalContent">
                <!-- Content injected by JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Custom Application Logic -->
<script>
    // Initialize Feather Icons
    feather.replace();

    const sidebar = document.getElementById('messageAppSidebar');
    const chatArea = document.getElementById('messageAppChatArea');
    const messageLog = document.getElementById('messageAppLog');
    const messageForm = document.getElementById('messageAppForm');
    const messageInput = document.getElementById('messageAppInput');
    const chatItems = document.querySelectorAll('.message-app-chat-item');
    const modalElement = document.getElementById('messageAppModal');
    const messageModal = new bootstrap.Modal(modalElement);
    const modalContent = document.getElementById('messageAppModalContent');

    // Function to display custom message box (replacement for alert)
    function showMessageBox(message) {
        modalContent.innerHTML = `<p>${message}</p>`;
        messageModal.show();
    }

    // Function to update the header and visual state
    function switchChat(selectedElement, name, status, avatar) {
        // 1. Update Header
        document.getElementById('headerName').textContent = name;
        document.getElementById('headerDetails').textContent = status;
        document.getElementById('headerAvatar').src = avatar;

        // Update status indicator color and text class
        const statusElement = document.getElementById('headerStatus');
        const detailsElement = document.getElementById('headerDetails');
        
        statusElement.className = 'position-absolute bottom-0 end-0 rounded-circle border border-2 border-white';
        detailsElement.className = 'mb-0 small';

        if (status.toLowerCase() === 'active') {
            statusElement.classList.add('bg-success');
            detailsElement.classList.add('text-success');
        } else if (status.toLowerCase() === 'offline') {
            statusElement.classList.add('bg-secondary');
            detailsElement.classList.add('text-secondary');
        } else { // Busy
            statusElement.classList.add('bg-danger');
            detailsElement.classList.add('text-danger');
        }


        // 2. Update Sidebar Active State
        chatItems.forEach(item => {
            item.classList.remove('message-app-active');
        });
        selectedElement.classList.add('message-app-active');

        // 3. Handle Mobile View Toggle
        hideSidebar();

        // Optional: Reset message log content for new chat (omitted for static content demo)
        messageLog.scrollTop = messageLog.scrollHeight;
    }

    // Function to show sidebar (Mobile)
    function showSidebar() {
        if (window.innerWidth < 992) {
            sidebar.classList.add('message-app-active');
            chatArea.classList.remove('message-app-active');
        }
    }

    // Function to hide sidebar (Mobile)
    function hideSidebar() {
         if (window.innerWidth < 992) {
            sidebar.classList.remove('message-app-active');
            chatArea.classList.add('message-app-active');
        }
    }

    // Function to simulate sending a message
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const text = messageInput.value.trim();

        if (text) {
            const time = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false });

            // Create the new message bubble (from 'Me')
            const newMessageHtml = `
                <div class="d-flex justify-content-end mb-2">
                    <div class="message-app-bubble-me p-3">
                        <p class="mb-0 small">${text}</p>
                    </div>
                </div>
                <div class="text-end small text-muted me-1 mb-4" style="font-size: 0.7rem;">
                    ${time} <span class="message-app-check-icon">✓✓</span>
                </div>
            `;

            // Append to log and scroll to bottom
            messageLog.insertAdjacentHTML('beforeend', newMessageHtml);
            messageLog.scrollTop = messageLog.scrollHeight;

            // Clear input
            messageInput.value = '';

            // Show a confirmation message
            showMessageBox('Message sent successfully: "' + text + '"');
        }
    });

    // Initial load and resize logic for responsive layout
    function handleInitialLayout() {
        if (window.innerWidth >= 992) { // Desktop View
            sidebar.classList.add('message-app-active');
            chatArea.classList.add('message-app-active');
        } else { // Mobile View: Default to sidebar
            sidebar.classList.add('message-app-active');
            chatArea.classList.remove('message-app-active');
        }
    }

    window.addEventListener('resize', handleInitialLayout);
    handleInitialLayout(); // Initial call

    // Scroll to the bottom of the message log on load
    window.onload = function() {
        messageLog.scrollTop = messageLog.scrollHeight;
    };

</script>

@endsection