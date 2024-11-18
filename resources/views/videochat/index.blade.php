<!-- resources/views/videochat/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RandomMeet - Video Chat</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 min-h-screen font-[Inter]">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="w-full py-4 px-4 bg-white/90 shadow-sm">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="h-8 w-8 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-indigo-500 to-purple-500 text-transparent bg-clip-text">RandomMeet</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div id="connectionStatus" class="text-sm text-gray-600">
                        Status: <span class="font-medium">Initializing...</span>
                    </div>
                    <button id="nextBtn" class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-lg hover:opacity-90 transition-opacity" disabled>
                        Next Person
                    </button>
                    <button id="endCallBtn" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:opacity-90 transition-opacity">
                        End Call
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow flex p-4">
            <div class="max-w-7xl w-full mx-auto grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Video Container -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Remote Video -->
                    <div class="relative bg-gray-900 rounded-xl overflow-hidden aspect-video">
                        <video id="remoteVideo" class="w-full h-full object-cover" autoplay playsinline></video>
                        <div id="waitingScreen" class="absolute inset-0 flex items-center justify-center bg-gray-900">
                            <div class="text-center">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-white mx-auto"></div>
                                <p class="text-white mt-4">Looking for someone interesting...</p>
                                <p class="text-gray-400 text-sm mt-2" id="searchStatus">Initializing connection...</p>
                            </div>
                        </div>
                    </div>
                    <!-- Local Video -->
                    <div class="absolute bottom-4 right-4 w-48 aspect-video bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <video id="localVideo" class="w-full h-full object-cover" autoplay playsinline muted></video>
                    </div>
                </div>

                <!-- Chat Section -->
                <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-sm p-4 flex flex-col h-[600px]">
                    <div class="flex-grow overflow-y-auto space-y-4 p-4" id="chatMessages">
                        <!-- Messages will be inserted here -->
                        <div class="text-center text-gray-500 text-sm">
                            Chat will be available once connected
                        </div>
                    </div>
                    <div class="border-t pt-4">
                        <form id="messageForm" class="flex space-x-2">
                            <input type="text" id="messageInput" 
                                class="flex-grow rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Type your message..."
                                disabled>
                            <button type="submit" 
                                class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                                Send
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Update these constants at the top of your script
const ROUTES = {
    CREATE_SESSION: '/session/create',
    FIND_MATCH: '/session/find-match',
    END_SESSION: '/session/end'
};

let currentConnection = null;
let localStream = null;
let isSearching = false;

// Store the session ID from PHP
const sessionId = '{{ $session_id }}';

document.addEventListener('DOMContentLoaded', function() {
    initializeChat();
});

function updateStatus(message) {
    document.querySelector('#connectionStatus span').textContent = message;
    document.getElementById('searchStatus').textContent = message;
}

async function initializeChat() {
    try {
        updateStatus('Requesting camera access...');
        
        // Get user media
        localStream = await navigator.mediaDevices.getUserMedia({ 
            video: true, 
            audio: true 
        });
        
        document.getElementById('localVideo').srcObject = localStream;
        updateStatus('Camera access granted');

        // Create initial session
        updateStatus('Creating session...');
        const response = await fetch(ROUTES.CREATE_SESSION, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'same-origin'
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        if (data.session_id) {
            document.getElementById('nextBtn').disabled = false;
            updateStatus('Ready to connect');
            findMatch();
        } else {
            throw new Error('Invalid session response');
        }
    } catch (error) {
        console.error('Error initializing chat:', error);
        updateStatus('Error: ' + error.message);
        
        if (error.name === 'NotAllowedError') {
            updateStatus('Camera access denied. Please allow camera access and reload.');
        }
    }
}

async function findMatch() {
    if (isSearching) return;
    
    try {
        isSearching = true;
        updateStatus('Looking for a match...');
        document.getElementById('nextBtn').disabled = true;
        document.getElementById('waitingScreen').style.display = 'flex';
        
        const response = await fetch(ROUTES.FIND_MATCH, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'same-origin'
        });

        const data = await response.json();

        if (response.ok && data.matched_session_id) {
            document.getElementById('waitingScreen').style.display = 'none';
            document.getElementById('nextBtn').disabled = false;
            updateStatus('Connected');
            
            // Enable chat
            document.getElementById('messageInput').disabled = false;
            document.getElementById('messageForm').querySelector('button').disabled = false;
            
            console.log('Matched with session:', data.matched_session_id);
        } else if (response.status === 404) {
            updateStatus('No matches found. Retrying...');
            setTimeout(findMatch, 5000);
        } else {
            throw new Error('Failed to find match');
        }
    } catch (error) {
        console.error('Error finding match:', error);
        updateStatus('Connection error. Retrying...');
        setTimeout(findMatch, 5000);
    } finally {
        isSearching = false;
    }
}

// Handle end call button
document.getElementById('endCallBtn').addEventListener('click', async function() {
    try {
        if (currentConnection) {
            currentConnection.close();
        }
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
        }
        
        await fetch(ROUTES.END_SESSION, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'same-origin'
        });
        
        window.location.href = '/';
    } catch (error) {
        console.error('Error ending session:', error);
        window.location.href = '/';
    }
});


        // Handle chat messages
        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();
            
            if (message) {
                // Add message to chat
                const chatMessages = document.getElementById('chatMessages');
                const messageElement = document.createElement('div');
                messageElement.className = 'flex justify-end';
                messageElement.innerHTML = `
                    <div class="bg-indigo-500 text-white rounded-lg px-4 py-2 max-w-[80%]">
                        ${message}
                    </div>
                `;
                chatMessages.appendChild(messageElement);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                
                // Clear input
                messageInput.value = '';
                
                // Here you would implement your WebRTC data channel to send the message
            }
        });
    </script>

    @vite('resources/js/app.js')
</body>
</html>