// Frontend JavaScript for ECE Chatbot
class ChatbotFrontend {
    constructor() {
        this.currentLanguage = 'en';
        this.isTyping = false;

        this.initializeElements();
        this.bindEvents();
        this.setInitialTime();
        this.loadTranslations();
    }

    initializeElements() {
        // Main elements
        this.messagesContainer = document.getElementById('messagesContainer');
        this.messageInput = document.getElementById('messageInput');
        this.sendButton = document.getElementById('sendButton');
        this.langToggle = document.getElementById('langToggle');
        this.currentLangSpan = document.getElementById('currentLang');
        this.chatTitle = document.getElementById('chatTitle');
        this.chatSubtitle = document.getElementById('chatSubtitle');
        this.inputHint = document.getElementById('inputHint');
        this.sidebar = document.getElementById('sidebar');
        this.mobileMenuBtn = document.getElementById('mobileMenuBtn');
        this.closeSidebar = document.getElementById('closeSidebar');

        // Quick action buttons
        this.quickButtons = document.querySelectorAll('.quick-btn');
        this.topicButtons = document.querySelectorAll('.topic-btn');
    }

    bindEvents() {
        // Send message events
        this.sendButton.addEventListener('click', () => this.sendMessage());
        this.messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });

        // Language toggle
        this.langToggle.addEventListener('click', () => this.toggleLanguage());

        // Quick action buttons
        this.quickButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const query = e.target.dataset.query;
                this.sendQuickMessage(query);
            });
        });

        // Topic buttons
        this.topicButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const query = e.target.dataset.query;
                this.sendQuickMessage(query);
                this.closeSidebar();
            });
        });

        // Sidebar controls
        this.mobileMenuBtn.addEventListener('click', () => this.toggleSidebar());
        this.closeSidebar.addEventListener('click', () => this.closeSidebar());

        // Close sidebar when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.sidebar.contains(e.target) &&
                !this.mobileMenuBtn.contains(e.target) &&
                this.sidebar.classList.contains('open')) {
                this.closeSidebar();
            }
        });

        // Focus input on load
        this.messageInput.focus();
    }

    setInitialTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const welcomeTime = document.getElementById('welcomeTime');
        if (welcomeTime) {
            welcomeTime.textContent = timeString;
        }
    }

    loadTranslations() {
        this.translations = {
            en: {
                title: "Electrical & Computer Engineering Assistant",
                subtitle: "Ask me anything about the ECE program at Menoufia University",
                inputPlaceholder: "Type your question here...",
                inputHint: "Press Enter to send or use quick action buttons above",
                welcome: "🎓 Welcome to the Electrical and Computer Engineering Program Assistant!",
                canHelp: "I can help you with:",
                programInfo: "📚 Program information and requirements",
                courseDetails: "📖 Course details and prerequisites",
                registration: "📝 Registration policies and GPA requirements",
                policies: "📋 Academic policies and grading system",
                services: "👨‍🏫 Student services and advising",
                fees: "💰 Fees and payment information",
                tryAsking: "Try asking about:",
                orType: "or type a course code like"
            },
            ar: {
                title: "مساعد برنامج الهندسة الكهربية والحاسبات",
                subtitle: "اسألني أي شيء عن برنامج الهندسة الكهربية والحاسبات في جامعة المنوفية",
                inputPlaceholder: "اكتب سؤالك هنا...",
                inputHint: "اضغط Enter للإرسال أو استخدم الأزرار السريعة أعلاه",
                welcome: "🎓 مرحباً بك في المساعد الآلي لبرنامج الهندسة الكهربية والحاسبات!",
                canHelp: "يمكنني مساعدتك في:",
                programInfo: "📚 معلومات البرنامج والمتطلبات",
                courseDetails: "📖 تفاصيل المقررات والمتطلبات السابقة",
                registration: "📝 سياسات التسجيل ومتطلبات المعدل التراكمي",
                policies: "📋 السياسات الأكاديمية ونظام التقييم",
                services: "👨‍🏫 الخدمات الطلابية والإرشاد",
                fees: "💰 معلومات الرسوم والدفع",
                tryAsking: "جرب السؤال عن:",
                orType: "أو اكتب كود مقرر مثل"
            }
        };
    }

    toggleLanguage() {
        this.currentLanguage = this.currentLanguage === 'en' ? 'ar' : 'en';
        this.updateLanguageUI();
        this.updateTranslations();
    }

    updateLanguageUI() {
        this.currentLangSpan.textContent = this.currentLanguage === 'en' ? 'English' : 'العربية';
        document.body.setAttribute('dir', this.currentLanguage === 'ar' ? 'rtl' : 'ltr');
    }

    updateTranslations() {
        const t = this.translations[this.currentLanguage];

        this.chatTitle.textContent = t.title;
        this.chatSubtitle.textContent = t.subtitle;
        this.messageInput.placeholder = t.inputPlaceholder;
        this.inputHint.textContent = t.inputHint;

        // Update welcome message
        const welcomeMessage = this.messagesContainer.querySelector('.bot-message .message-text');
        if (welcomeMessage) {
            welcomeMessage.innerHTML = `
                <p>${t.welcome}</p>
                <p>${t.canHelp}</p>
                <ul>
                    <li>${t.programInfo}</li>
                    <li>${t.courseDetails}</li>
                    <li>${t.registration}</li>
                    <li>${t.policies}</li>
                    <li>${t.services}</li>
                    <li>${t.fees}</li>
                </ul>
                <p>${t.tryAsking} <strong>program</strong>, <strong>courses</strong>, <strong>registration</strong>, ${t.orType} <strong>ECE-C101</strong></p>
            `;
        }
    }

    async sendMessage() {
        const message = this.messageInput.value.trim();
        if (!message || this.isTyping) return;

        // Add user message
        this.addMessage(message, 'user');
        this.messageInput.value = '';

        // Show typing indicator
        this.showTypingIndicator();

        // Get bot response
        try {
            const response = await fetch('http://localhost:3001/api/chat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message })
            })
            .then(res => res.json())
            .then(data => data.response);
            this.hideTypingIndicator();
            this.addMessage(response, 'bot');
        } catch (error) {
            this.hideTypingIndicator();
            this.addMessage('Sorry, I encountered an error. Please try again.', 'bot');
            console.error('Chatbot error:', error);
        }
    }

    sendQuickMessage(query) {
        this.messageInput.value = query;
        this.sendMessage();
    }

    addMessage(content, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;

        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = sender === 'bot' ? '<i class="fas fa-robot"></i>' : '<i class="fas fa-user"></i>';

        const messageContent = document.createElement('div');
        messageContent.className = 'message-content';

        const messageText = document.createElement('div');
        messageText.className = 'message-text';
        messageText.innerHTML = this.formatMessage(content);

        const messageTime = document.createElement('div');
        messageTime.className = 'message-time';
        messageTime.textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        messageContent.appendChild(messageText);
        messageContent.appendChild(messageTime);
        messageDiv.appendChild(avatar);
        messageDiv.appendChild(messageContent);

        this.messagesContainer.appendChild(messageDiv);
        this.scrollToBottom();
    }

    formatMessage(content) {
        // Convert line breaks to <br> tags and preserve formatting
        return content
            .replace(/\n/g, '<br>')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>');
    }

    showTypingIndicator() {
        this.isTyping = true;
        this.sendButton.disabled = true;

        const typingDiv = document.createElement('div');
        typingDiv.className = 'message bot-message typing-indicator';
        typingDiv.id = 'typingIndicator';

        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = '<i class="fas fa-robot"></i>';

        const messageContent = document.createElement('div');
        messageContent.className = 'message-content';

        const typingDots = document.createElement('div');
        typingDots.className = 'typing-indicator';
        typingDots.innerHTML = `
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        `;

        messageContent.appendChild(typingDots);
        typingDiv.appendChild(avatar);
        typingDiv.appendChild(messageContent);

        this.messagesContainer.appendChild(typingDiv);
        this.scrollToBottom();
    }

    hideTypingIndicator() {
        this.isTyping = false;
        this.sendButton.disabled = false;

        const typingIndicator = document.getElementById('typingIndicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    scrollToBottom() {
        setTimeout(() => {
            this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
        }, 100);
    }

    toggleSidebar() {
        this.sidebar.classList.toggle('open');
    }

    closeSidebar() {
        this.sidebar.classList.remove('open');
    }

    // Utility method to detect if text is Arabic
    isArabicText(text) {
        const arabicRegex = /[\u0600-\u06FF]/;
        return arabicRegex.test(text);
    }

    // Auto-detect language from user input
    detectLanguageFromInput(text) {
        if (this.isArabicText(text)) {
            if (this.currentLanguage !== 'ar') {
                this.currentLanguage = 'ar';
                this.updateLanguageUI();
                this.updateTranslations();
            }
        } else {
            if (this.currentLanguage !== 'en') {
                this.currentLanguage = 'en';
                this.updateLanguageUI();
                this.updateTranslations();
            }
        }
    }
}

// Initialize the frontend when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const frontend = new ChatbotFrontend();

    // Make frontend globally accessible for debugging
    window.chatbotFrontend = frontend;

    // Auto-detect language from user input
    const messageInput = document.getElementById('messageInput');
    messageInput.addEventListener('input', (e) => {
        const text = e.target.value;
        if (text.length > 0) {
            frontend.detectLanguageFromInput(text);
        }
    });

    // Add some helpful console messages
    console.log('🎓 ECE Program Assistant loaded successfully!');
    console.log('💡 Try asking about: program, courses, registration, or type a course code like ECE-C101');
});

// Add some CSS for better mobile experience
const mobileStyles = `
    @media (max-width: 768px) {
        .container {
            padding: 5px;
        }

        .header {
            margin-bottom: 10px;
        }

        .chat-container {
            height: calc(100vh - 120px);
        }
    }
`;

// Inject mobile styles
const styleSheet = document.createElement('style');
styleSheet.textContent = mobileStyles;
document.head.appendChild(styleSheet);
