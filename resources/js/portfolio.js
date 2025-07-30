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

// Initialize the portfolio functionality when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    initializePortfolio();
});

function initializePortfolio() {
    initializeViewToggle();
    initializeFiltering();
    initializeSorting();
    initializeSearch();
    initializeProjectDetails();
    initializeAnimations();
    initializeCounters();
    enhanceButtons();
    addTooltips();
    enhanceModalAccessibility();
}

// View toggle functionality
function initializeViewToggle() {
    const viewBtns = document.querySelectorAll('.view-btn[data-view]');
    const projectsGrid = document.getElementById('projectsContainer');

    viewBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const view = btn.dataset.view;
            viewBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            projectsGrid.className = view === 'list' ? 'projects-grid list-view' : 'projects-grid';
        });
    });
}

// Filtering functionality
function initializeFiltering() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('projectSearch');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.dataset.filter;
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterProjects(searchInput.value.toLowerCase(), filter);
        });
    });
}

// Sorting functionality
function initializeSorting() {
    const sortOptions = document.querySelectorAll('.sort-option');

    sortOptions.forEach(option => {
        option.addEventListener('click', () => {
            const sortBy = option.dataset.sort;
            sortProjects(sortBy);
        });
    });
}

// Search functionality with debouncing
function initializeSearch() {
    const searchInput = document.getElementById('projectSearch');
    const suggestionsContainer = searchInput.nextElementSibling;

    const debouncedSearch = debounce((query) => {
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
        filterProjects(query, activeFilter);
        updateSearchSuggestions(query);
    }, 300);

    searchInput.addEventListener('input', (e) => {
        debouncedSearch(e.target.value.toLowerCase());
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
            suggestionsContainer.style.display = 'none';
        }
    });
}

// Project details modal handling
function initializeProjectDetails() {
    const viewBtns = document.querySelectorAll('.view-btn[data-project]');
    const modal = document.getElementById('projectDetailsModal');
    let currentImageIndex = 0;

    viewBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const projectId = btn.dataset.project;
            try {
                const response = await fetch(`/projects/${projectId}`);
                if (!response.ok) throw new Error('Network response was not ok');
                const project = await response.json();
                updateModalContent(project);
                modal.classList.add('active');
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to load project details. Please try again.', 'error');
            }
        });
    });

    // Gallery navigation with throttle
    const prevBtn = modal.querySelector('.gallery-nav.prev');
    const nextBtn = modal.querySelector('.gallery-nav.next');

    if (prevBtn && nextBtn) {
        const navigateGallery = throttle((direction) => {
            const thumbnails = modal.querySelectorAll('.thumbnail');
            currentImageIndex = (currentImageIndex + direction + thumbnails.length) % thumbnails.length;
            updateMainImage(currentImageIndex);
        }, 300);

        prevBtn.addEventListener('click', () => navigateGallery(-1));
        nextBtn.addEventListener('click', () => navigateGallery(1));
    }

    // Close modal
    modal.querySelector('.close-btn').addEventListener('click', () => {
        modal.classList.remove('active');
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });
}

// Animations using Intersection Observer
function initializeAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '50px'
    });

    document.querySelectorAll('.project-card').forEach(card => {
        observer.observe(card);
    });
}

// Counter animations
function initializeCounters() {
    const counters = document.querySelectorAll('.stat-value');
    
    counters.forEach(counter => {
        const target = parseInt(counter.dataset.count);
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };

        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counterObserver.observe(counter);
    });
}

// Filter projects with performance optimization
function filterProjects(query, filter) {
    const projects = document.querySelectorAll('.project-card');
    const fragment = document.createDocumentFragment();
    
    projects.forEach(project => {
        const title = project.querySelector('.project-title').textContent.toLowerCase();
        const description = project.querySelector('.project-description').textContent.toLowerCase();
        const category = project.dataset.category;

        const matchesSearch = title.includes(query) || description.includes(query);
        const matchesFilter = filter === 'all' || category === filter;

        if (matchesSearch && matchesFilter) {
            project.style.display = '';
            fragment.appendChild(project);
            requestAnimationFrame(() => project.classList.add('visible'));
        } else {
            project.classList.remove('visible');
            requestAnimationFrame(() => project.style.display = 'none');
        }
    });

    document.getElementById('projectsContainer').appendChild(fragment);
}

// Update search suggestions with performance optimization
function updateSearchSuggestions(query) {
    const suggestionsContainer = document.querySelector('.search-suggestions');
    const projects = document.querySelectorAll('.project-card');
    
    if (query.length < 2) {
        suggestionsContainer.style.display = 'none';
        return;
    }

    const suggestions = Array.from(projects)
        .filter(project => {
            const title = project.querySelector('.project-title').textContent.toLowerCase();
            const description = project.querySelector('.project-description').textContent.toLowerCase();
            return title.includes(query) || description.includes(query);
        })
        .slice(0, 5)
        .map(project => {
            const title = project.querySelector('.project-title').textContent;
            const category = project.dataset.category;
            return `
                <div class="search-suggestion-item" data-title="${title}">
                    <i class="fas fa-${getCategoryIcon(category)}"></i>
                    <span>${title}</span>
                </div>
            `;
        });

    if (suggestions.length > 0) {
        suggestionsContainer.innerHTML = suggestions.join('');
        suggestionsContainer.style.display = 'block';

        suggestionsContainer.querySelectorAll('.search-suggestion-item').forEach(item => {
            item.addEventListener('click', () => {
                const searchInput = document.getElementById('projectSearch');
                searchInput.value = item.dataset.title;
                suggestionsContainer.style.display = 'none';
                filterProjects(item.dataset.title.toLowerCase(), 'all');
            });
        });
    } else {
        suggestionsContainer.style.display = 'none';
    }
}

// Get category icon
function getCategoryIcon(category) {
    const icons = {
        web: 'globe',
        mobile: 'mobile-alt',
        design: 'palette',
        desktop: 'desktop',
        game: 'gamepad',
        ai: 'brain'
    };
    return icons[category] || 'code';
}

// Sort projects with performance optimization
function sortProjects(sortBy) {
    const projectsGrid = document.getElementById('projectsContainer');
    const projects = Array.from(projectsGrid.children);
    const fragment = document.createDocumentFragment();

    projects.sort((a, b) => {
        switch (sortBy) {
            case 'date':
                return new Date(b.dataset.date) - new Date(a.dataset.date);
            case 'name':
                return a.querySelector('.project-title').textContent
                    .localeCompare(b.querySelector('.project-title').textContent);
            case 'category':
                return a.dataset.category.localeCompare(b.dataset.category);
            default:
                return 0;
        }
    });

    projects.forEach(project => fragment.appendChild(project));
    projectsGrid.appendChild(fragment);
}

// Update modal content
function updateModalContent(project) {
    const modal = document.getElementById('projectDetailsModal');
    
    modal.querySelector('.modal-title').textContent = project.title;
    modal.querySelector('.project-description').textContent = project.description;
    
    // Update technologies
    modal.querySelector('.tech-stack').innerHTML = project.technologies
        .map(tech => `
            <span class="tech-badge" title="${tech}">
                <i class="fab fa-${tech.toLowerCase()}"></i>
                ${tech}
            </span>
        `)
        .join('');

    // Update features
    modal.querySelector('.features-list').innerHTML = project.features
        .map(feature => `<li>${feature}</li>`)
        .join('');

    // Update images
    const mainImage = modal.querySelector('.main-image img');
    const thumbnailList = modal.querySelector('.thumbnail-list');
    
    if (project.images && project.images.length > 0) {
        mainImage.src = project.images[0];
        mainImage.alt = `Project image for ${project.title}`;
        thumbnailList.innerHTML = project.images
            .map((image, index) => `
                <img src="${image}" 
                     alt="Thumbnail ${index + 1}" 
                     class="thumbnail ${index === 0 ? 'active' : ''}"
                     onclick="updateMainImage(${index})">
            `)
            .join('');
    } else {
        mainImage.src = '';
        mainImage.alt = '';
        thumbnailList.innerHTML = '';
    }

    // Update links
    const demoLink = modal.querySelector('.demo-link');
    const sourceLink = modal.querySelector('.source-link');
    
    if (project.demo_url) {
        demoLink.href = project.demo_url;
        demoLink.style.display = 'inline-flex';
        demoLink.setAttribute('aria-label', `View live demo for ${project.title}`);
    } else {
        demoLink.style.display = 'none';
    }

    if (project.source_url) {
        sourceLink.href = project.source_url;
        sourceLink.style.display = 'inline-flex';
        sourceLink.setAttribute('aria-label', `View source code for ${project.title}`);
    } else {
        sourceLink.style.display = 'none';
    }
}

// Update main image in gallery
function updateMainImage(index) {
    const modal = document.getElementById('projectDetailsModal');
    const mainImage = modal.querySelector('.main-image img');
    const thumbnails = modal.querySelectorAll('.thumbnail');
    
    mainImage.src = thumbnails[index].src;
    thumbnails.forEach(thumb => thumb.classList.remove('active'));
    thumbnails[index].classList.add('active');
}

// Toast Notification System
window.showToast = function(message, type = 'info') {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <span class="toast-icon">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'times-circle' : 'info-circle'}"></i>
        </span>
        <span>${message}</span>
        <button class="toast-close" aria-label="Close">&times;</button>
    `;
    container.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));
    toast.querySelector('.toast-close').onclick = () => toast.remove();
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
};

// Enhance buttons with performance optimization
function enhanceButtons() {
    document.querySelectorAll('button, .btn, .action-btn, .edit-btn, .delete-btn').forEach(btn => {
        btn.tabIndex = 0;
        btn.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                btn.click();
            }
        });
        btn.addEventListener('click', (e) => {
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            ripple.style.left = `${e.offsetX}px`;
            ripple.style.top = `${e.offsetY}px`;
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });
}

// Add tooltips with performance optimization
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

// Modal accessibility with performance optimization
function enhanceModalAccessibility() {
    const modal = document.getElementById('projectDetailsModal');
    if (!modal) return;

    const focusableElements = modal.querySelectorAll('a, button, input, [tabindex]:not([tabindex="-1"])');
    const firstFocusable = focusableElements[0];
    const lastFocusable = focusableElements[focusableElements.length - 1];

    modal.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            modal.classList.remove('active');
        }
        if (e.key === 'Tab') {
            if (e.shiftKey && document.activeElement === firstFocusable) {
                e.preventDefault();
                lastFocusable.focus();
            } else if (!e.shiftKey && document.activeElement === lastFocusable) {
                e.preventDefault();
                firstFocusable.focus();
            }
        }
    });
} 