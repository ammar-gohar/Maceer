<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electrical Engineering Chatbot</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .chat-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            height: 600px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }

        .message.user {
            justify-content: flex-end;
        }

        .message-content {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            word-wrap: break-word;
            line-height: 1.4;
        }

        .message.user .message-content {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message.assistant .message-content {
            background: white;
            color: #333;
            border: 1px solid #e0e0e0;
            border-bottom-left-radius: 4px;
        }

        .message-time {
            font-size: 11px;
            color: #999;
            margin-top: 5px;
            text-align: right;
        }

        .chat-input-container {
            padding: 20px;
            background: white;
            border-top: 1px solid #e0e0e0;
        }

        .chat-input-form {
            display: flex;
            gap: 10px;
        }

        .chat-input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .chat-input:focus {
            border-color: #667eea;
        }

        .send-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s;
        }

        .send-button:hover {
            transform: scale(1.05);
        }

        .send-button:active {
            transform: scale(0.95);
        }

        .welcome-message {
            text-align: center;
            color: #666;
            font-style: italic;
            margin-bottom: 20px;
        }

        .typing-indicator {
            display: none;
            padding: 12px 16px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 18px;
            border-bottom-left-radius: 4px;
            max-width: 70%;
            margin-bottom: 15px;
        }

        .typing-dots {
            display: flex;
            gap: 4px;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            background: #999;
            border-radius: 50%;
            animation: typing 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes typing {
            0%, 80%, 100% {
                transform: scale(0.8);
                opacity: 0.5;
            }
            40% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .help-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.3s;
        }

        .help-button:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 768px) {
            .chat-container {
                height: 100vh;
                border-radius: 0;
            }

            .message-content {
                max-width: 85%;
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <button class="help-button" onclick="showHelp()">مساعدة / Help</button>
            مساعد برنامج الهندسة الكهربية والحاسبات
            <br>
            Electrical and Computer Engineering Program Assistant
        </div>

        <div class="chat-messages" id="chatMessages">
            <div class="welcome-message">
                مرحباً! يمكنك سؤالي عن البرنامج، المقررات، المتطلبات، وغيرها...
                <br>
                Hello! You can ask me about the program, courses, requirements, and more...
            </div>
        </div>

        <div class="typing-indicator" id="typingIndicator">
            <div class="typing-dots">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>

        <div class="chat-input-container">
            <form class="chat-input-form" id="chatForm">
                <input
                    type="text"
                    class="chat-input"
                    id="chatInput"
                    placeholder="اكتب رسالتك هنا... / Type your message here..."
                    autocomplete="off"
                >
                <button type="submit" class="send-button">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22,2 15,22 11,13 2,9"></polygon>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset("js/chatbot.js") }}"></script>
    <script>
        // Initialize chatbot
        const chatbot = new StudentChatbot();
        const chatMessages = document.getElementById('chatMessages');
        const chatForm = document.getElementById('chatForm');
        const chatInput = document.getElementById('chatInput');
        const typingIndicator = document.getElementById('typingIndicator');

        // Add initial help message
        setTimeout(() => {
            addMessage(chatbot.getHelpMessage(), 'assistant');
        }, 1000);

        // Handle form submission
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const userInput = chatInput.value.trim();

            if (!userInput) return;

            // Add user message
            addMessage(userInput, 'user');
            chatInput.value = '';

            // Show typing indicator
            showTypingIndicator();

            // Simulate processing delay
            setTimeout(() => {
                hideTypingIndicator();

                // Get chatbot response
                const response = chatbot.getResponse(userInput);
                addMessage(response, 'assistant');

                // Check if user wants to exit
                if (chatbot.keywords.exit.some(keyword => userInput.toLowerCase().includes(keyword))) {
                    setTimeout(() => {
                        alert('Thank you for using the chatbot!');
                        window.close();
                    }, 2000);
                }
            }, 1000 + Math.random() * 1000); // Random delay between 1-2 seconds
        });

        // Add message to chat
        function addMessage(content, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}`;

            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            messageContent.innerHTML = content.replace(/\n/g, '<br>');

            const messageTime = document.createElement('div');
            messageTime.className = 'message-time';
            messageTime.textContent = new Date().toLocaleTimeString();

            messageDiv.appendChild(messageContent);
            messageDiv.appendChild(messageTime);

            chatMessages.appendChild(messageDiv);

            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Show typing indicator
        function showTypingIndicator() {
            typingIndicator.style.display = 'block';
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Hide typing indicator
        function hideTypingIndicator() {
            typingIndicator.style.display = 'none';
        }

        // Show help
        function showHelp() {
            addMessage(chatbot.getHelpMessage(), 'assistant');
        }

        // Handle Enter key
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        });

        // Focus input on load
        window.addEventListener('load', () => {
            chatInput.focus();
        });
    </script>
</body>
</html>
