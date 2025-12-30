<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
    /* Floating Button */
    #chat-fab {
        width: 60px;
        height: 60px;
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 9999;
    }

    /* Chat Window */
    #chat-window {
        width: 360px;
        height: 500px;
        position: fixed;
        bottom: 100px;
        right: 25px;
        display: none;
        z-index: 9999;
    }

    /* Bubble Chat */
    .chat-bubble {
        max-width: 80%;
        padding: 12px 16px;
        border-radius: 16px;
    }
    .chat-bubble-user {
        background: #0d6efd;
        color: white;
        border-bottom-right-radius: 0;
    }
    .chat-bubble-bot {
        background: #e9ecef;
        color: #000;
        border-bottom-left-radius: 0;
    }

    /* Scroll area */
    #chat-messages {
        height: 350px;
        overflow-y: auto;
    }
</style>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app" class="d-flex flex-row min-vh-100">
        @if(auth()->check())
            @include('layouts.sidebar')
        @endif

        <main class="py-4 text-gray-900 w-100">
            @yield('content')
        </main>
        
    </div>
<div id="chatbot-widget-container">
    <!-- CHAT WINDOW -->
    <div id="chat-window" class="bg-white rounded-3 shadow-lg d-flex flex-column">

        <!-- Header -->
        <div class="bg-primary text-white p-3 rounded-top-3 d-flex justify-content-between align-items-center">
            <strong>Apotek Bot</strong>
            <button onclick="toggleChat()" class="btn btn-sm btn-light text-primary rounded-circle">
                <i class="bi bi-dash"></i>
            </button>
        </div>

        <!-- Chat Messages -->
        <div id="chat-messages" class="p-3 bg-light">

            <!-- Welcome Chat -->
            <div class="d-flex mb-3">
                <div class="chat-bubble chat-bubble-bot shadow-sm">
                    Selamat datang! Saya bot Apotek. Tanyakan tentang <b>stok</b> atau <b>harga</b> obat.
                    <br>Contoh: <i>"berapa stok panadol"</i>
                </div>
            </div>

        </div>

        <!-- Input -->
        <div class="p-3 bg-white border-top">
            <div class="input-group">
                <input type="text" id="user-input" class="form-control" placeholder="Ketik pesan..."
                    onkeypress="if(event.key === 'Enter') sendMessage()">
                <button id="send-btn" class="btn btn-primary" onclick="sendMessage()">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>

    </div>

    <!-- FLOATING BUTTON -->
    <button id="chat-fab" class="btn btn-primary rounded-circle shadow" onclick="toggleChat()">
        <i class="bi bi-chat-dots fs-3"></i>
    </button>
</div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Dinamis SweetAlert untuk semua halaman -->
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            })
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            })
        @endif

        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: "{{ session('warning') }}",
            })
        @endif

        @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: "{{ session('info') }}",
            })
        @endif
        // const API_ENDPOINT = 'http://localhost:5678/webhook/chatbot-obat';
        const API_ENDPOINT = 'http://localhost:5678/webhook/chat-ai-klinik';
        // const API_ENDPOINT = 'http://0.0.0.0:5678/webhook/chat-ai-klinik';
        const chatWindow = document.getElementById('chat-window');
        const chatMessages = document.getElementById('chat-messages');
        const userInput = document.getElementById('user-input');
        const sendBtn = document.getElementById('send-btn');
        const fabBtn = document.getElementById('chat-fab');
        let isChatOpen = false;

        // Fungsi untuk mengganti status jendela chat
        function toggleChat() {
            isChatOpen = !isChatOpen;
            if (isChatOpen) {
                chatWindow.classList.remove('scale-0', 'opacity-0');
                chatWindow.classList.add('scale-100', 'opacity-100');
                fabBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>';
                userInput.focus();
            } else {
                chatWindow.classList.remove('scale-100', 'opacity-100');
                chatWindow.classList.add('scale-0', 'opacity-0');
                fabBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>';
            }
        }

        // Fungsi untuk menambahkan pesan ke UI
        function appendMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('flex', 'max-w-[80%]', 'shadow-sm');
            
            const contentDiv = document.createElement('div');
            contentDiv.classList.add('p-3', 'rounded-lg');
            contentDiv.innerText = text;

            if (sender === 'user') {
                messageDiv.classList.add('justify-end');
                contentDiv.classList.add('bg-primary', 'text-white', 'rounded-br-none');
            } else { // bot
                messageDiv.classList.add('justify-start');
                contentDiv.classList.add('bg-indigo-100', 'text-gray-800', 'rounded-tl-none');
            }
            
            messageDiv.appendChild(contentDiv);
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll ke bawah
        }

        // Fungsi untuk menampilkan indikator loading
        function showLoading() {
            const loadingDiv = document.createElement('div');
            loadingDiv.id = 'loading-indicator';
            loadingDiv.classList.add('flex', 'justify-start');
            loadingDiv.innerHTML = `
                <div class="bg-gray-200 text-gray-800 p-3 rounded-lg rounded-tl-none animate-pulse">
                    <span>Bot sedang mengetik...</span>
                </div>
            `;
            chatMessages.appendChild(loadingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            sendBtn.disabled = true;
            userInput.disabled = true;
        }

        // Fungsi untuk menghilangkan indikator loading
        function hideLoading() {
            const loadingDiv = document.getElementById('loading-indicator');
            if (loadingDiv) {
                loadingDiv.remove();
            }
            sendBtn.disabled = false;
            userInput.disabled = false;
        }

        // Fungsi utama untuk mengirim pesan
        async function sendMessage() {
            const message = userInput.value.trim();
            if (!message) return;

            // 1. Tampilkan pesan user
            appendMessage(message, 'user');
            userInput.value = '';

            // 2. Tampilkan loading
            showLoading();

            try {
                const responseText = await fetchWithRetry(API_ENDPOINT, { message });
                
                // 4. Tampilkan respons dari bot
                appendMessage(responseText, 'bot');

            } catch (error) {
                console.error('API Chatbot Gagal:', error);
                appendMessage('Maaf, Bot tidak dapat terhubung ke server n8n. Pastikan n8n berjalan di ' + API_ENDPOINT, 'bot');
            } finally {
                // 5. Hilangkan loading
                hideLoading();
            }
        }

        // Fungsi Fetch dengan Retry (Exponential Backoff)
        async function fetchWithRetry(url, data, maxRetries = 3) {
            const payload = JSON.stringify(data);

            for (let i = 0; i < maxRetries; i++) {
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: payload
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const result = await response.json();
                    
                    // Pastikan struktur respons dari n8n adalah Array[0]
                    const responseData = Array.isArray(result) ? result[0] : result;
                    
                    // Kembalikan pesan dari bot
                    if (responseData && responseData.output) {
                        return responseData.output;
                    } else {
                        return "Bot merespons dengan format yang tidak dikenal.";
                    }

                } catch (error) {
                    if (i === maxRetries - 1) {
                        // Jika ini adalah percobaan terakhir, lemparkan error
                        throw error;
                    }
                    // Tunggu sebelum retry: 1s, 2s, 4s
                    const delay = Math.pow(2, i) * 1000;
                    await new Promise(resolve => setTimeout(resolve, delay));
                }
            }
            throw new Error("Gagal terhubung ke API setelah beberapa kali percobaan.");
        }

        // Event listener untuk memastikan FAB muncul saat JS dimuat
        document.addEventListener('DOMContentLoaded', () => {
            // Inicialisasi: Sembunyikan jendela chat, tampilkan FAB
            chatWindow.classList.add('scale-0', 'opacity-0');
            fabBtn.style.display = 'flex';
        });

        // Menghindari duplikasi fungsi jika kode ini disalin ke Blade file
        window.toggleChat = toggleChat;
        window.sendMessage = sendMessage;
    
    </script>

    @stack('scripts')
</body>
</html>
