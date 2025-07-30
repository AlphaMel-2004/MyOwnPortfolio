import 'bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Intersection Observer for fade-in and glassmorphism
function animateOnScroll() {
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, i * 120);
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.animate-fade-in, .glass').forEach(el => observer.observe(el));
}

// Animated counters
function animateCounters() {
    document.querySelectorAll('.experience-value, .stat-value').forEach(counter => {
        const target = parseInt(counter.textContent.replace(/\D/g, ''));
        let current = 0;
        const step = Math.ceil(target / 60);
        const update = () => {
            current += step;
            if (current < target) {
                counter.textContent = current + '+';
                requestAnimationFrame(update);
            } else {
                counter.textContent = target + '+';
            }
        };
        if (target > 0) update();
    });
}

// Navbar section highlight
function highlightNavOnScroll() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 80;
            if (pageYOffset >= sectionTop) current = section.getAttribute('id');
        });
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) link.classList.add('active');
        });
    });
}

// Button ripple/glow effect
function addButtonEffects() {
    document.querySelectorAll('.glowing-btn').forEach(btn => {
        btn.addEventListener('mouseenter', () => btn.classList.add('glow-hover'));
        btn.addEventListener('mouseleave', () => btn.classList.remove('glow-hover'));
    });
}

// Parallax/animated geometric backgrounds
function parallaxBackgrounds() {
    const shapes = document.querySelectorAll('.hero-shapes .shape');
    window.addEventListener('mousemove', e => {
        shapes.forEach((shape, i) => {
            const speed = (i + 1) * 0.03;
            shape.style.transform = `translate(${e.clientX * speed}px, ${e.clientY * speed}px)`;
        });
    });
}

// ARIA improvements for modals and buttons
function improveAccessibility() {
    document.querySelectorAll('.modal').forEach(modal => {
        modal.setAttribute('role', 'dialog');
        modal.setAttribute('aria-modal', 'true');
    });
    document.querySelectorAll('button, a').forEach(el => {
        if (!el.hasAttribute('aria-label') && el.textContent.trim() !== '') {
            el.setAttribute('aria-label', el.textContent.trim());
        }
    });
}

// Testimonials carousel
function testimonialsCarousel() {
    const container = document.querySelector('.testimonials-section .row');
    if (!container) return;
    let idx = 0;
    const cards = container.querySelectorAll('.col-md-4');
    if (cards.length <= 1) return;
    setInterval(() => {
        cards.forEach((card, i) => {
            card.style.opacity = i === idx ? '1' : '0.2';
            card.style.transform = i === idx ? 'scale(1.05)' : 'scale(0.95)';
        });
        idx = (idx + 1) % cards.length;
    }, 3500);
}

// AI Chatbot logic
(function() {
    const btn = document.querySelector('#ai-chatbot-btn button');
    const windowEl = document.getElementById('ai-chatbot-window');
    const closeBtn = document.getElementById('ai-chatbot-close');
    const form = document.getElementById('ai-chatbot-form');
    const input = document.getElementById('ai-chatbot-input');
    const messages = document.getElementById('ai-chatbot-messages');
    let isOpen = false;

    if (!btn || !windowEl || !closeBtn || !form || !input || !messages) return;

    function scrollToBottom() {
        messages.scrollTop = messages.scrollHeight;
    }
    function addMessage(text, sender = 'user') {
        const div = document.createElement('div');
        div.className = `mb-2 d-flex ${sender === 'user' ? 'justify-content-end' : 'justify-content-start'}`;
        div.innerHTML = `<span class="px-3 py-2 rounded-3 ${sender === 'user' ? 'bg-primary text-light' : 'bg-info text-dark'}" style="max-width: 80%; display: inline-block; box-shadow: 0 0 12px #00f2fe55;">${text}</span>`;
        messages.appendChild(div);
        scrollToBottom();
    }
    function addLoading() {
        const div = document.createElement('div');
        div.className = 'mb-2 d-flex justify-content-start ai-loading';
        div.innerHTML = `<span class="px-3 py-2 rounded-3 bg-info text-dark" style="max-width: 80%; display: inline-block; box-shadow: 0 0 12px #00f2fe55;"><span class="spinner-border spinner-border-sm me-2"></span>Thinking...</span>`;
        messages.appendChild(div);
        scrollToBottom();
    }
    function removeLoading() {
        const loading = messages.querySelector('.ai-loading');
        if (loading) loading.remove();
    }
    btn.addEventListener('click', () => {
        windowEl.style.display = isOpen ? 'none' : 'block';
        isOpen = !isOpen;
        if (isOpen) setTimeout(() => input.focus(), 200);
    });
    closeBtn.addEventListener('click', () => {
        windowEl.style.display = 'none';
        isOpen = false;
    });
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const text = input.value.trim();
        if (!text) return;
        addMessage(text, 'user');
        input.value = '';
        addLoading();
        fetch('/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message: text })
        })
        .then(res => res.json())
        .then(data => {
            removeLoading();
            addMessage(data.reply, 'ai');
        })
        .catch(() => {
            removeLoading();
            addMessage('Sorry, the AI service is currently unavailable.', 'ai');
        });
    });
})();

document.addEventListener('DOMContentLoaded', () => {
    animateOnScroll();
    animateCounters();
    highlightNavOnScroll();
    addButtonEffects();
    parallaxBackgrounds();
    improveAccessibility();
    testimonialsCarousel();
});
