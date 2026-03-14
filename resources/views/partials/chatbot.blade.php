<!-- Chatbot Widget -->
<div id="chatbot-widget" class="fixed bottom-6 right-6 z-50">
    <!-- Chat Toggle Button -->
    <button id="chat-toggle" class="bg-primary hover:bg-primary-dark text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition-all duration-300">
        <svg id="chat-icon-open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <svg id="chat-icon-close" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Chat Window -->
    <div id="chat-window" class="hidden absolute bottom-16 right-0 w-80 sm:w-96 bg-white rounded-md shadow-2xl border border-slate-200 flex flex-col" style="height: 480px;">
        <!-- Header -->
        <div class="bg-primary text-white px-4 py-3 rounded-t-md flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <span class="font-semibold text-sm">QuickTicket Support</span>
            </div>
            <button id="chat-clear" class="text-white/70 hover:text-white text-xs">Clear</button>
        </div>

        <!-- Messages -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-3">
            <!-- Welcome message -->
            <div class="flex justify-start">
                <div class="bg-slate-100 rounded-md px-3 py-2 max-w-[80%] text-sm text-slate-700">
                    Hi! I'm QuickTicket's support assistant. I can help you with booking, payment, cancellation, tracking, and more. Ask me anything!
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="border-t border-slate-200 p-3">
            <form id="chat-form" class="flex space-x-2">
                <input type="text" id="chat-input" placeholder="Type your question..."
                    class="flex-1 border border-slate-200 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"
                    maxlength="500" autocomplete="off">
                <button type="submit" id="chat-send" class="bg-primary hover:bg-primary-dark text-white rounded-md px-3 py-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('chat-toggle');
    const chatWindow = document.getElementById('chat-window');
    const iconOpen = document.getElementById('chat-icon-open');
    const iconClose = document.getElementById('chat-icon-close');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const messagesDiv = document.getElementById('chat-messages');
    const clearBtn = document.getElementById('chat-clear');
    const sendBtn = document.getElementById('chat-send');

    let chatHistory = [];
    let isLoading = false;

    // Toggle chat window
    toggle.addEventListener('click', () => {
        chatWindow.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden')) {
            input.focus();
        }
    });

    // Clear chat
    clearBtn.addEventListener('click', () => {
        chatHistory = [];
        messagesDiv.innerHTML = `
            <div class="flex justify-start">
                <div class="bg-slate-100 rounded-md px-3 py-2 max-w-[80%] text-sm text-slate-700">
                    Hi! I'm QuickTicket's support assistant. I can help you with booking, payment, cancellation, tracking, and more. Ask me anything!
                </div>
            </div>`;
    });

    function addMessage(text, isUser) {
        const wrapper = document.createElement('div');
        wrapper.className = isUser ? 'flex justify-end' : 'flex justify-start';

        const bubble = document.createElement('div');
        bubble.className = isUser
            ? 'bg-primary text-white rounded-md px-3 py-2 max-w-[80%] text-sm'
            : 'bg-slate-100 rounded-md px-3 py-2 max-w-[80%] text-sm text-slate-700';
        bubble.textContent = text;

        wrapper.appendChild(bubble);
        messagesDiv.appendChild(wrapper);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    function addTypingIndicator() {
        const wrapper = document.createElement('div');
        wrapper.className = 'flex justify-start';
        wrapper.id = 'typing-indicator';

        const bubble = document.createElement('div');
        bubble.className = 'bg-slate-100 rounded-md px-3 py-2 text-sm text-slate-500';
        bubble.innerHTML = '<span class="inline-flex space-x-1"><span class="animate-bounce" style="animation-delay:0ms">.</span><span class="animate-bounce" style="animation-delay:150ms">.</span><span class="animate-bounce" style="animation-delay:300ms">.</span></span>';

        wrapper.appendChild(bubble);
        messagesDiv.appendChild(wrapper);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    function removeTypingIndicator() {
        const indicator = document.getElementById('typing-indicator');
        if (indicator) indicator.remove();
    }

    // Send message
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = input.value.trim();
        if (!message || isLoading) return;

        isLoading = true;
        sendBtn.disabled = true;
        input.value = '';

        addMessage(message, true);
        addTypingIndicator();

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            const response = await fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    message: message,
                    history: chatHistory,
                }),
            });

            removeTypingIndicator();

            const data = await response.json();
            const reply = data.reply || 'Sorry, something went wrong. Please try again.';

            addMessage(reply, false);

            // Keep conversation history (max 20 messages)
            chatHistory.push({ role: 'user', content: message });
            chatHistory.push({ role: 'assistant', content: reply });
            if (chatHistory.length > 20) {
                chatHistory = chatHistory.slice(-20);
            }
        } catch (error) {
            removeTypingIndicator();
            addMessage('Sorry, I\'m having trouble connecting. Please try again later.', false);
        }

        isLoading = false;
        sendBtn.disabled = false;
        input.focus();
    });
});
</script>
