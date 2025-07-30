/**
 * AI Chatbot for Portfolio Website
 * Handles real-time conversations with AI assistant
 */
class Chatbot {
    constructor() {
        // DOM elements
        this.elements = {
            btn: document.getElementById('ai-chatbot-btn'),
            window: document.getElementById('ai-chatbot-window'),
            form: document.getElementById('ai-chatbot-form'),
            input: document.getElementById('ai-chatbot-input'),
            messages: document.getElementById('ai-chatbot-messages'),
            clear: document.getElementById('ai-chatbot-clear'),
            close: document.getElementById('ai-chatbot-close')
        };
        
        // State management
        this.state = {
            isOpen: false,
            isTyping: false,
            messageCount: 0
        };
        
        // Configuration
        this.config = {
            maxMessages: 50,
            typingDuration: 1000,
            scrollDelay: 100
        };
        
        this.init();
    }
    
    init() {
        if (!this.validateElements()) {
            console.warn('Chatbot: Some elements not found, chatbot disabled');
            return;
        }
        
        this.bindEvents();
        this.addWelcomeMessage();
        this.setupAccessibility();
    }
    
    validateElements() {
        return Object.values(this.elements).every(el => el !== null);
    }
    
    bindEvents() {
        // Core interactions
        this.elements.btn?.addEventListener('click', () => this.toggle());
        this.elements.close?.addEventListener('click', () => this.closeWindow());
        this.elements.clear?.addEventListener('click', () => this.clearChat());
        this.elements.form?.addEventListener('submit', (e) => this.handleSubmit(e));
        
        // Keyboard shortcuts
        this.elements.input?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.elements.form?.dispatchEvent(new Event('submit'));
            }
        });
        
        // Global keyboard events
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.state.isOpen) {
                this.closeWindow();
            }
        });
        
        // Prevent form submission on Enter if typing
        this.elements.input?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && this.state.isTyping) {
                e.preventDefault();
            }
        });
    }
    
    setupAccessibility() {
        // Add ARIA labels and roles
        this.elements.btn?.setAttribute('aria-expanded', 'false');
        this.elements.window?.setAttribute('role', 'dialog');
        this.elements.window?.setAttribute('aria-label', 'AI Assistant Chat');
    }
    
    toggle() {
        this.state.isOpen = !this.state.isOpen;
        this.elements.window.style.display = this.state.isOpen ? 'block' : 'none';
        this.elements.btn?.setAttribute('aria-expanded', this.state.isOpen.toString());
        
        if (this.state.isOpen) {
            this.elements.input?.focus();
            this.scrollToBottom();
            this.addEntryAnimation();
        }
    }
    
    closeWindow() {
        this.state.isOpen = false;
        this.elements.window.style.display = 'none';
        this.elements.btn?.setAttribute('aria-expanded', 'false');
    }
    
    clearChat() {
        if (this.elements.messages) {
            this.elements.messages.innerHTML = '';
            this.state.messageCount = 0;
            this.addWelcomeMessage();
        }
    }
    
    addWelcomeMessage() {
        const welcomeDiv = document.createElement('div');
        welcomeDiv.className = 'text-secondary text-center small';
        welcomeDiv.textContent = 'How can I help you today?';
        welcomeDiv.setAttribute('data-message-type', 'welcome');
        this.elements.messages?.appendChild(welcomeDiv);
    }
    
    async handleSubmit(e) {
        e.preventDefault();
        
        const message = this.elements.input?.value.trim();
        if (!message || this.state.isTyping || this.state.messageCount >= this.config.maxMessages) {
            return;
        }
        
        // Add user message
        this.addMessage('user', message);
        this.elements.input.value = '';
        
        // Show typing indicator
        const typingDiv = this.addTypingIndicator();
        
        try {
            const response = await this.sendMessage(message);
            typingDiv?.remove();
            this.addMessage('ai', response);
        } catch (error) {
            console.error('Chatbot error:', error);
            typingDiv?.remove();
            this.addMessage('ai', 'Sorry, I encountered an error. Please try again.');
        }
    }
    
    async sendMessage(message) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (!csrfToken) {
            throw new Error('CSRF token not found');
        }
        
        const response = await fetch('/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: message })
        });
        
        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`HTTP ${response.status}: ${errorText}`);
        }
        
        const data = await response.json();
        return data.reply || 'I apologize, but I couldn\'t generate a response.';
    }
    
    addMessage(type, content) {
        if (!this.elements.messages) return null;
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `mb-3 ${type === 'user' ? 'text-end' : 'text-start'}`;
        messageDiv.setAttribute('data-message-type', type);
        
        const messageBubble = document.createElement('div');
        messageBubble.className = `d-inline-block p-2 rounded-3 ${type === 'user' ? 'bg-primary text-white' : 'bg-secondary text-light'}`;
        messageBubble.style.maxWidth = '80%';
        messageBubble.innerHTML = this.sanitizeContent(content);
        
        messageDiv.appendChild(messageBubble);
        this.elements.messages.appendChild(messageDiv);
        this.scrollToBottom();
        
        this.state.messageCount++;
        
        return messageDiv;
    }
    
    sanitizeContent(content) {
        // Basic XSS protection
        const div = document.createElement('div');
        div.textContent = content;
        return div.innerHTML;
    }
    
    addTypingIndicator() {
        this.state.isTyping = true;
        const typingDiv = document.createElement('div');
        typingDiv.className = 'mb-3 text-start';
        typingDiv.setAttribute('data-message-type', 'typing');
        
        const typingBubble = document.createElement('div');
        typingBubble.className = 'd-inline-block p-2 rounded-3 bg-secondary text-light';
        typingBubble.style.maxWidth = '80%';
        typingBubble.innerHTML = '<div class="typing-indicator"><span></span><span></span><span></span></div>';
        
        typingDiv.appendChild(typingBubble);
        this.elements.messages?.appendChild(typingDiv);
        this.scrollToBottom();
        
        return typingDiv;
    }
    
    scrollToBottom() {
        setTimeout(() => {
            if (this.elements.messages) {
                this.elements.messages.scrollTop = this.elements.messages.scrollHeight;
            }
        }, this.config.scrollDelay);
    }
    
    addEntryAnimation() {
        // Add subtle animation when opening
        this.elements.window?.classList.add('chatbot-enter');
        setTimeout(() => {
            this.elements.window?.classList.remove('chatbot-enter');
        }, 300);
    }
}

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    try {
        new Chatbot();
    } catch (error) {
        console.error('Failed to initialize chatbot:', error);
    }
}); 