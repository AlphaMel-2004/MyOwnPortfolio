// Utility functions
const debounce = (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

const throttle = (func, limit) => {
    let inThrottle;
    return function executedFunction(...args) {
        if (!inThrottle) {
            func(...args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
};

// Initialize admin functionality when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    initializeAdmin();
});

function initializeAdmin() {
    initializeSidebar();
    initializeStats();
    initializeTables();
    initializeForms();
    initializeModals();
    initializeToast();
    enhanceButtons();
    addTooltips();
}

// Sidebar functionality
function initializeSidebar() {
    const sidebar = document.querySelector('.admin-sidebar');
    const toggleBtn = document.querySelector('.sidebar-toggle');
    const navItems = document.querySelectorAll('.nav-item');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 1024 && 
            !sidebar.contains(e.target) && 
            !toggleBtn.contains(e.target) && 
            sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });

    // Handle active nav items
    navItems.forEach(item => {
        item.addEventListener('click', () => {
            navItems.forEach(nav => nav.classList.remove('active'));
            item.classList.add('active');
        });
    });
}

// Stats animations
function initializeStats() {
    const stats = document.querySelectorAll('.stat-value');
    
    stats.forEach(stat => {
        const target = parseInt(stat.dataset.value);
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += step;
            if (current < target) {
                stat.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                stat.textContent = target.toLocaleString();
            }
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(stat);
    });
}

// Table functionality
function initializeTables() {
    const tables = document.querySelectorAll('.admin-table');
    
    tables.forEach(table => {
        const headers = table.querySelectorAll('th');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        headers.forEach((header, index) => {
            if (header.dataset.sortable !== 'false') {
                header.style.cursor = 'pointer';
                header.addEventListener('click', () => {
                    const direction = header.dataset.direction === 'asc' ? -1 : 1;
                    header.dataset.direction = direction === 1 ? 'asc' : 'desc';

                    // Update sort indicators
                    headers.forEach(h => h.classList.remove('asc', 'desc'));
                    header.classList.add(direction === 1 ? 'asc' : 'desc');

                    // Sort rows
                    const sortedRows = rows.sort((a, b) => {
                        const aValue = a.children[index].textContent;
                        const bValue = b.children[index].textContent;
                        return direction * aValue.localeCompare(bValue, undefined, { numeric: true });
                    });

                    // Reorder rows in the table
                    const fragment = document.createDocumentFragment();
                    sortedRows.forEach(row => fragment.appendChild(row));
                    tbody.appendChild(fragment);
                });
            }
        });

        // Add row hover effect
        rows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.style.transform = 'scale(1.01)';
                row.style.transition = 'transform 0.2s ease';
            });

            row.addEventListener('mouseleave', () => {
                row.style.transform = 'scale(1)';
            });
        });
    });
}

// Form functionality
function initializeForms() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Add floating label effect
            if (input.value) {
                input.parentElement.classList.add('has-value');
            }

            input.addEventListener('focus', () => {
                input.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', () => {
                input.parentElement.classList.remove('focused');
                if (input.value) {
                    input.parentElement.classList.add('has-value');
                } else {
                    input.parentElement.classList.remove('has-value');
                }
            });

            // Add validation
            input.addEventListener('input', debounce(() => {
                validateInput(input);
            }, 300));
        });

        // Form submission
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (validateForm(form)) {
                const submitBtn = form.querySelector('[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');

                try {
                    const formData = new FormData(form);
                    const response = await fetch(form.action, {
                        method: form.method,
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) throw new Error('Network response was not ok');
                    
                    const data = await response.json();
                    showToast(data.message, 'success');
                    
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('An error occurred. Please try again.', 'error');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('loading');
                }
            }
        });
    });
}

// Form validation
function validateInput(input) {
    const value = input.value.trim();
    const errorElement = input.parentElement.querySelector('.error-message');
    
    if (input.required && !value) {
        showError(input, errorElement, 'This field is required');
        return false;
    }

    if (input.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            showError(input, errorElement, 'Please enter a valid email address');
            return false;
        }
    }

    if (input.minLength && value.length < input.minLength) {
        showError(input, errorElement, `Minimum length is ${input.minLength} characters`);
        return false;
    }

    if (input.maxLength && value.length > input.maxLength) {
        showError(input, errorElement, `Maximum length is ${input.maxLength} characters`);
        return false;
    }

    hideError(input, errorElement);
    return true;
}

function validateForm(form) {
    const inputs = form.querySelectorAll('input, textarea, select');
    let isValid = true;

    inputs.forEach(input => {
        if (!validateInput(input)) {
            isValid = false;
        }
    });

    return isValid;
}

function showError(input, errorElement, message) {
    input.classList.add('error');
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
}

function hideError(input, errorElement) {
    input.classList.remove('error');
    if (errorElement) {
        errorElement.style.display = 'none';
    }
}

// Modal functionality
function initializeModals() {
    const modals = document.querySelectorAll('.modal');
    
    modals.forEach(modal => {
        const closeBtn = modal.querySelector('.close-btn');
        const content = modal.querySelector('.modal-content');

        // Close modal
        const closeModal = () => {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        };

        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        // Close on outside click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeModal();
            }
        });

        // Prevent content click from closing modal
        content.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    });
}

// Toast notifications
function initializeToast() {
    window.showToast = function(message, type = 'info') {
        const container = document.querySelector('.toast-container') || createToastContainer();
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <span class="toast-icon">
                <i class="fas fa-${getToastIcon(type)}"></i>
            </span>
            <span>${message}</span>
            <button class="toast-close" aria-label="Close">&times;</button>
        `;

        container.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('show'));

        // Close button
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => removeToast(toast));

        // Auto remove
        setTimeout(() => {
            removeToast(toast);
        }, 5000);
    };
}

function createToastContainer() {
    const container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
    return container;
}

function removeToast(toast) {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
}

function getToastIcon(type) {
    const icons = {
        success: 'check-circle',
        error: 'times-circle',
        warning: 'exclamation-circle',
        info: 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Button enhancements
function enhanceButtons() {
    document.querySelectorAll('button, .btn').forEach(btn => {
        // Add ripple effect
        btn.addEventListener('click', (e) => {
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            ripple.style.left = `${e.offsetX}px`;
            ripple.style.top = `${e.offsetY}px`;
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });

        // Add loading state
        if (btn.dataset.loading) {
            btn.addEventListener('click', () => {
                btn.disabled = true;
                btn.classList.add('loading');
                const originalText = btn.textContent;
                btn.innerHTML = `
                    <span class="spinner"></span>
                    ${btn.dataset.loadingText || 'Loading...'}
                `;
            });
        }
    });
}

// Tooltips
function addTooltips() {
    document.querySelectorAll('[title]').forEach(el => {
        el.setAttribute('tabindex', '0');
        const showTooltip = (e) => {
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.textContent = el.getAttribute('title');
            document.body.appendChild(tooltip);
            const rect = el.getBoundingClientRect();
            tooltip.style.left = `${rect.left + window.scrollX + rect.width/2}px`;
            tooltip.style.top = `${rect.top + window.scrollY - 30}px`;
            el._tooltip = tooltip;
        };
        const hideTooltip = () => {
            if (el._tooltip) el._tooltip.remove();
        };
        el.addEventListener('focus', showTooltip);
        el.addEventListener('blur', hideTooltip);
        el.addEventListener('mouseenter', showTooltip);
        el.addEventListener('mouseleave', hideTooltip);
    });
} 