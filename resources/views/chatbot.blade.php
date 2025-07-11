<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECE Program Assistant</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset("css/chat-styles.css") }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-graduation-cap"></i>
                    <h1>ECE Program Assistant</h1>
                </div>
                <div class="language-toggle" style="display: flex; gap: 1rem;">
                    <button id="langToggle" class="lang-btn">
                        <span id="currentLang">English</span>
                        <i class="fas fa-globe"></i>
                    </button>
                    <button class="lang-btn">
                        <a href="{{ route('home') }}">home</a>
                    </button>
                </div>
            </div>
        </header>

        <!-- Chat Container -->
        <div class="chat-container">
            <div class="chat-header">
                <div class="chat-title">
                    <i class="fas fa-robot"></i>
                    <span id="chatTitle">Electrical & Computer Engineering Assistant</span>
                </div>
                <div class="chat-subtitle" id="chatSubtitle">
                    Ask me anything about the ECE program at Menoufia University
                </div>
            </div>

            <!-- Messages Area -->
            <div class="messages-container" id="messagesContainer">
                <!-- Welcome Message -->
                <div class="message bot-message">
                    <div class="message-avatar">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="message-content">
                        <div class="message-text">
                            <p>🎓 Welcome to the Electrical and Computer Engineering Program Assistant!</p>
                            <p>I can help you with:</p>
                            <ul>
                                <li>📚 Program information and requirements</li>
                                <li>📖 Course details and prerequisites</li>
                                <li>📝 Registration policies and GPA requirements</li>
                                <li>📋 Academic policies and grading system</li>
                                <li>👨‍🏫 Student services and advising</li>
                                <li>💰 Fees and payment information</li>
                            </ul>
                            <p>Try asking about: <strong>program</strong>, <strong>courses</strong>, <strong>registration</strong>, or type a course code like <strong>ECE-C101</strong></p>
                        </div>
                        <div class="message-time" id="welcomeTime"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions" id="quickActions">
                <button class="quick-btn" data-query="program">Program Info</button>
                <button class="quick-btn" data-query="courses">Courses</button>
                <button class="quick-btn" data-query="registration">Registration</button>
                <button class="quick-btn" data-query="gpa">GPA Info</button>
                <button class="quick-btn" data-query="help">Help</button>
            </div>

            <!-- Input Area -->
            <div class="input-container">
                <div class="input-wrapper">
                    <input type="text" id="messageInput" placeholder="Type your question here..." autocomplete="off">
                    <button id="sendButton" class="send-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <div class="input-hint">
                    <i class="fas fa-lightbulb"></i>
                    <span id="inputHint">Press Enter to send or use quick action buttons above</span>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Quick Topics</h3>
                <button class="close-sidebar" id="closeSidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="sidebar-content">
                <div class="topic-section">
                    <h4>Program Information</h4>
                    <button class="topic-btn" data-query="program">Program Details</button>
                    <button class="topic-btn" data-query="credits">Credit Hours</button>
                    <button class="topic-btn" data-query="duration">Program Duration</button>
                    <button class="topic-btn" data-query="requirements">Admission Requirements</button>
                </div>

                <div class="topic-section">
                    <h4>Academic</h4>
                    <button class="topic-btn" data-query="registration">Registration</button>
                    <button class="topic-btn" data-query="gpa">GPA Information</button>
                    <button class="topic-btn" data-query="semester">Semester Info</button>
                    <button class="topic-btn" data-query="grades">Grading System</button>
                </div>

                <div class="topic-section">
                    <h4>Courses</h4>
                    <button class="topic-btn" data-query="courses">All Courses</button>
                    <button class="topic-btn" data-query="prerequisites">Prerequisites</button>
                    <button class="topic-btn" data-query="ECE-C101">Digital Logic</button>
                    <button class="topic-btn" data-query="ECE-C102">Computer Programming</button>
                </div>

                <div class="topic-section">
                    <h4>Policies</h4>
                    <button class="topic-btn" data-query="attendance">Attendance Policy</button>
                    <button class="topic-btn" data-query="policies">Academic Policies</button>
                    <button class="topic-btn" data-query="withdrawal">Withdrawal Policy</button>
                </div>

                <div class="topic-section">
                    <h4>Services</h4>
                    <button class="topic-btn" data-query="advisor">Academic Advisor</button>
                    <button class="topic-btn" data-query="training">Industrial Training</button>
                    <button class="topic-btn" data-query="project">Graduation Project</button>
                    <button class="topic-btn" data-query="fees">Fees Information</button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    {{-- <script src="/chatbot.js"></script> --}}
    <script src="{{ asset("js/frontend.js") }}"></script>
</body>
</html>
