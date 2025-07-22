@extends('layouts.app')
@section('title', 'Car Rental - Home')
@section('content')
<style>
    .faq-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .faq-item {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .faq-item.active {
        border-color: #4f46e5;
        box-shadow: 0 1px 3px rgba(79, 70, 229, 0.1);
    }
    
    .faq-question {
        width: 100%;
        padding: 1.25rem;
        text-align: left;
        
        border: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        font-size: 1.125rem;
        font-weight: 500;
        color: #111827;
        transition: all 0.2s ease;
    }
    
    .faq-question:hover {
        color: #4f46e5;
    }
    
    .faq-question.active {
        color: #4f46e5;
        font-weight: 600;
    }
    
    .faq-icon {
        transition: transform 0.3s ease;
    }
    
    .faq-question.active .faq-icon {
        transform: rotate(180deg);
    }
    
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        padding: 0 1.25rem;
        transition: max-height 0.3s ease, padding 0.3s ease;
        color: #4b5563;
    }
    
    .faq-answer.active {
        max-height: 300px;
        padding-bottom: 1.25rem;
    }
     /* Floating Chat Button */
        .chat-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .chat-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(0,0,0,0.4);
        }

        .chat-button svg {
            width: 30px;
            height: 30px;
            fill: white;
        }

        /* Chat Window */
        .chat-window {
            position: fixed;
            bottom: 90px;
            left: 20px;
            width: 350px;
            height: 450px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            display: none;
            flex-direction: column;
            z-index: 1000;
            overflow: hidden;
        }

        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            position: relative;
        }

        .chat-close {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
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

        .message-bubble {
            max-width: 80%;
            padding: 10px 15px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.4;
        }

        .message.bot .message-bubble {
            background: white;
            color: #333;
            border: 1px solid #e0e0e0;
        }

        .message.user .message-bubble {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .chat-input-container {
            padding: 15px;
            background: white;
            border-top: 1px solid #e0e0e0;
        }

        .chat-input-form {
            display: flex;
            gap: 10px;
        }

        .chat-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            outline: none;
            font-size: 14px;
        }

        .chat-input:focus {
            border-color: #667eea;
        }

        .chat-send-btn {
            padding: 10px 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .chat-send-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .chat-send-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .typing-indicator {
            display: none;
            padding: 10px 15px;
            background: white;
            border-radius: 18px;
            margin-bottom: 15px;
            border: 1px solid #e0e0e0;
            max-width: 80%;
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
            animation: typing 1.4s infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 60%, 100% {
                transform: translateY(0);
            }
            30% {
                transform: translateY(-10px);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .chat-window {
                width: calc(100vw - 40px);
                left: 20px;
                right: 20px;
                height: 70vh;
            }
        }
</style>

<section class="py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-20">
        <div class="mb-12 text-center">
            <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                Frequently Asked Questions
            </h2>
            <p class="mt-4 text-lg text-gray-600">
                Find answers to common questions about our car rental services.
            </p>
        </div>
        
        <div class="faq-container">
            <!-- FAQ Item 1 -->
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-1">
                    What's the minimum age to rent a car in Sri Lanka?
                    <svg class="faq-icon w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="faq-answer-1" class="faq-answer" aria-hidden="true">
                    <p class="mt-2 text-gray-600">
                        To rent a car in Sri Lanka you need to be at least 19 years old with a valid license. Some car categories have a higher minimum rental age, and an underage driver fee may apply.
                    </p>
                </div>
            </div>
            <!-- FAQ Item 1 -->
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-2">
                    What documents do I need to rent a car in Sri Lanka?
                    <svg class="faq-icon w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="faq-answer-2" class="faq-answer" aria-hidden="true">
                    <p class="mt-2 text-gray-600">
                        You will need a full, valid driver's license along with a passport or identity card when picking up your car. More detailed information can be found in our rental information.
                    </p>
                </div>
            </div>
            <!-- FAQ Item 1 -->
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-3">
                    How can I reset my password?
                    <svg class="faq-icon w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="faq-answer-3" class="faq-answer" aria-hidden="true">
                    <p class="mt-2 text-gray-600">
                        To reset your password, go to the login page and click on "Forgot Password". 
                        Enter your email address and we'll send you a link to reset your password. 
                        The link will expire in 24 hours for security reasons.
                    </p>
                </div>
            </div>
            
            <!-- FAQ Item 2 -->
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-4">
                    How do I update my billing information?
                    <svg class="faq-icon w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="faq-answer-4" class="faq-answer" aria-hidden="true">
                    <p class="mt-2 text-gray-600">
                        You can update your billing information by logging into your account and navigating to 
                        the "Billing" section in your profile settings. Here you can add, remove, or update 
                        your payment methods and billing address.
                    </p>
                </div>
            </div>
            
            <!-- FAQ Item 3 -->
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-5">
                    How can I contact customer support?
                    <svg class="faq-icon w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="faq-answer-5" class="faq-answer" aria-hidden="true">
                    <p class="mt-2 text-gray-600">
                        Our customer support team is available 24/7. You can reach us by phone at 
                        1-800-RENT-CAR, via email at support@carrental.com, or through the live chat 
                        feature on our website and mobile app.
                    </p>
                </div>
            </div>
            
            <!-- FAQ Item 4 -->
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-6">
                    How do I delete my account?
                    <svg class="faq-icon w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="faq-answer-6" class="faq-answer" aria-hidden="true">
                    <p class="mt-2 text-gray-600">
                        To delete your account, go to your account settings and select "Delete Account". 
                        Please note that this action is permanent and will erase all your rental history 
                        and personal information from our system.
                    </p>
                </div>
            </div>
            
            <!-- FAQ Item 5 -->
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-7">
                    What is your cancellation policy?
                    <svg class="faq-icon w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="faq-answer-7" class="faq-answer" aria-hidden="true">
                    <p class="mt-2 text-gray-600">
                        You can cancel your reservation free of charge up to 24 hours before your scheduled 
                        pickup time. Cancellations made within 24 hours may incur a fee. Please check your 
                        rental agreement for specific details.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Floating Chat Button -->
    <div class="chat-button" id="chatButton">
        <svg viewBox="0 0 24 24">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4v3c0 .6.4 1 1 1 .2 0 .4-.1.6-.2l4.2-3.8H20c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-3 9h-2v2c0 .6-.4 1-1 1s-1-.4-1-1v-2h-2c-.6 0-1-.4-1-1s.4-1 1-1h2V7c0-.6.4-1 1-1s1 .4 1 1v2h2c.6 0 1 .4 1 1s-.4 1-1 1z"/>
        </svg>
    </div>

    <!-- Chat Window -->
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">
            <span>Venujaya Car Rent Assistant</span>
            <div class="chat-close" id="chatClose">×</div>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <div class="message bot">
                <div class="message-bubble">
                    Hello! I'm here to help you with car rental questions. How can I assist you today?
                </div>
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
                <input type="text" class="chat-input" id="chatInput" placeholder="Type your message..." required>
                <button type="submit" class="chat-send-btn" id="chatSendBtn">Send</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatButton = document.getElementById('chatButton');
            const chatWindow = document.getElementById('chatWindow');
            const chatClose = document.getElementById('chatClose');
            const chatForm = document.getElementById('chatForm');
            const chatInput = document.getElementById('chatInput');
            const chatMessages = document.getElementById('chatMessages');
            const chatSendBtn = document.getElementById('chatSendBtn');
            const typingIndicator = document.getElementById('typingIndicator');

            // Toggle chat window
            chatButton.addEventListener('click', function() {
                chatWindow.style.display = chatWindow.style.display === 'flex' ? 'none' : 'flex';
                if (chatWindow.style.display === 'flex') {
                    chatInput.focus();
                }
            });

            // Close chat window
            chatClose.addEventListener('click', function() {
                chatWindow.style.display = 'none';
            });

            // Handle form submission
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const message = chatInput.value.trim();
                if (!message) return;

                // Add user message
                addMessage(message, 'user');
                chatInput.value = '';
                chatSendBtn.disabled = true;
                
                // Show typing indicator
                showTypingIndicator();

                // Send to server
                fetch('/chatbot/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => response.json())
                .then(data => {
                    hideTypingIndicator();
                    chatSendBtn.disabled = false;
                    
                    if (data.success) {
                        addMessage(data.message, 'bot');
                    } else {
                        addMessage('Sorry, I encountered an error. Please try again.', 'bot');
                    }
                })
                .catch(error => {
                    hideTypingIndicator();
                    chatSendBtn.disabled = false;
                    addMessage('Sorry, I am having trouble connecting. Please try again later.', 'bot');
                });
            });

            function addMessage(message, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${sender}`;
                
                const bubbleDiv = document.createElement('div');
                bubbleDiv.className = 'message-bubble';
                bubbleDiv.textContent = message;
                
                messageDiv.appendChild(bubbleDiv);
                chatMessages.appendChild(messageDiv);
                
                // Scroll to bottom
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function showTypingIndicator() {
                typingIndicator.style.display = 'block';
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function hideTypingIndicator() {
                typingIndicator.style.display = 'none';
            }

            // Auto-resize chat input
            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    chatForm.dispatchEvent(new Event('submit'));
                }
            });
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqQuestions = document.querySelectorAll('.faq-question');
        
        faqQuestions.forEach(question => {
            question.addEventListener('click', function() {
                // Close all other FAQ items
                faqQuestions.forEach(q => {
                    if (q !== question) {
                        q.classList.remove('active');
                        q.setAttribute('aria-expanded', 'false');
                        const answerId = q.getAttribute('aria-controls');
                        document.getElementById(answerId).classList.remove('active');
                        q.parentElement.classList.remove('active');
                    }
                });
                
                // Toggle current FAQ item
                const isExpanded = question.getAttribute('aria-expanded') === 'true';
                question.classList.toggle('active', !isExpanded);
                question.setAttribute('aria-expanded', !isExpanded);
                
                const answerId = question.getAttribute('aria-controls');
                document.getElementById(answerId).classList.toggle('active', !isExpanded);
                question.parentElement.classList.toggle('active', !isExpanded);
            });
        });
    });
</script>
@endsection