// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

// Initialize Application
function initializeApp() {
    hidePreloader();
    initScrollAnimations();
    initNavigation();
    initGallery();
    initModals();
    initPhoneMask();
    initSmoothScroll();
    initScrollEffects();
    initParallax();
}

// Preloader
function hidePreloader() {
    setTimeout(() => {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.classList.add('hidden');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    }, 1000);
}

// Navigation
function initNavigation() {
    const header = document.querySelector('.header');
    const burgerMenu = document.querySelector('.burger-menu');
    const mobileMenu = document.querySelector('.mobile-menu');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    
    // Header scroll effect
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
    
    // Mobile menu toggle
    if (burgerMenu && mobileMenu) {
        burgerMenu.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            mobileMenuOverlay.classList.toggle('active');
            burgerMenu.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : 'auto';
        });
    }
    
    // Close mobile menu on overlay click
    if (mobileMenuOverlay) {
        mobileMenuOverlay.addEventListener('click', closeMobileMenu);
    }
    
    // Close mobile menu on link click
    const mobileNavLinks = document.querySelectorAll('.mobile-menu .nav-link');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });
    
    function closeMobileMenu() {
        mobileMenu.classList.remove('active');
        mobileMenuOverlay.classList.remove('active');
        burgerMenu.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

// Smooth Scroll
function initSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const headerHeight = document.querySelector('.header').offsetHeight;
                const targetPosition = targetSection.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Scroll Animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px 200px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);
    
    // Add animation classes to elements
    const animatedElements = document.querySelectorAll('.service-card, .gallery-item, .contact-item, .about-text, .about-image');
    
    animatedElements.forEach((el, index) => {
        el.classList.add('fade-in');
        el.style.transitionDelay = `${index * 0.05}s`;
        observer.observe(el);
    });
}

// Gallery
function initGallery() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            btn.classList.add('active');
            
            const filter = btn.getAttribute('data-filter');
            
            galleryItems.forEach(item => {
                const category = item.getAttribute('data-category');
                
                if (filter === 'all' || category === filter) {
                    item.classList.remove('hidden');
                    setTimeout(() => {
                        item.style.display = 'block';
                    }, 50);
                } else {
                    item.classList.add('hidden');
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
}

// Modals
function initModals() {
    // Close modal on outside click
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal')) {
            closeAllModals();
        }
    });
    
    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAllModals();
        }
    });
}

function openCallbackModal() {
    const modal = document.getElementById('callbackModal');
    if (modal) {
        modal.classList.add('show');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Focus on first input
        setTimeout(() => {
            const firstInput = modal.querySelector('input');
            if (firstInput) {
                firstInput.focus();
            }
        }, 300);
    }
}

function closeCallbackModal() {
    const modal = document.getElementById('callbackModal');
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        
        // Reset modal content
        resetCallbackModal();
    }
}

function resetCallbackModal() {
    const modalBody = document.querySelector('#callbackModal .modal-body');
    const form = document.querySelector('#callbackForm');
    
    // Show form and hide success/error messages
    form.style.display = 'block';
    
    // Remove any success or error messages
    const messages = modalBody.querySelectorAll('.success-message, .error-message');
    messages.forEach(msg => msg.remove());
    
    // Clear form errors
    form.querySelectorAll('.form-error').forEach(error => error.remove());
    form.querySelectorAll('.error').forEach(error => error.remove());
    form.querySelectorAll('.form-group').forEach(group => group.classList.remove('error'));
    
    // Reset form
    form.reset();
    
    // Reset phone mask
    const phoneInput = form.querySelector('#phone');
    if (phoneInput) {
        phoneInput.value = '';
        setTimeout(() => {
            phoneInput.value = '+375 ';
        }, 10);
    }
}

function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    
    if (modal && modalImage) {
        modalImage.src = imageSrc;
        modal.classList.add('show');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

function closeAllModals() {
    closeCallbackModal();
    closeImageModal();
}

// Phone Mask
function initPhoneMask() {
    const phoneInput = document.getElementById('phone');
    
    if (phoneInput) {
        // Set initial value
        if (phoneInput.value === '') {
            phoneInput.value = '+375 ';
        }
        
        phoneInput.addEventListener('input', function(e) {
            formatPhoneNumber(e.target);
        });
        
        phoneInput.addEventListener('keydown', function(e) {
            // Allow backspace, delete, tab, escape, enter
            if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
                // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (e.keyCode === 65 && e.ctrlKey === true) ||
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true) ||
                // Allow home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                return;
            }
            
            // Prevent deleting +375 prefix
            if (e.keyCode === 8) { // Backspace
                if (e.target.selectionStart <= 5) {
                    e.preventDefault();
                }
            }
            
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        
        phoneInput.addEventListener('focus', function(e) {
            if (e.target.value === '' || e.target.value === '+375') {
                e.target.value = '+375 ';
            }
        });
        
        phoneInput.addEventListener('blur', function(e) {
            if (e.target.value === '+375 ') {
                e.target.value = '';
            }
        });
    }
}

function formatPhoneNumber(input) {
    let value = input.value.replace(/\D/g, '');
    
    // Ensure it starts with 375
    if (!value.startsWith('375')) {
        if (value.startsWith('75')) {
            value = '3' + value;
        } else if (value.startsWith('5')) {
            value = '37' + value;
        } else if (value.length > 0 && !value.startsWith('375')) {
            value = '375' + value;
        }
    }
    
    // Remove extra digits after 375XXXXXXXXX (12 digits total)
    if (value.length > 12) {
        value = value.substring(0, 12);
    }
    
    // Format the number
    if (value.length >= 3) {
        let formatted = '+375';
        const remaining = value.substring(3);
        
        if (remaining.length > 0) {
            formatted += ' ' + remaining.substring(0, 2);
        }
        if (remaining.length > 2) {
            formatted += ' ' + remaining.substring(2, 5);
        }
        if (remaining.length > 5) {
            formatted += '-' + remaining.substring(5, 7);
        }
        if (remaining.length > 7) {
            formatted += '-' + remaining.substring(7, 9);
        }
        
        input.value = formatted;
    } else {
        input.value = '+375 ';
    }
}

// Scroll Effects
function initScrollEffects() {
    const scrollIndicator = document.querySelector('.scroll-indicator');
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        // Hide scroll indicator after scrolling
        if (scrollIndicator) {
            if (scrolled > 100) {
                scrollIndicator.style.opacity = '0';
            } else {
                scrollIndicator.style.opacity = '1';
            }
        }
        
        // Parallax effect for floating elements
        const floatingElements = document.querySelectorAll('.floating-element');
        floatingElements.forEach((element, index) => {
            const speed = 0.5 + (index * 0.2);
            element.style.transform = `translateY(${scrolled * speed}px) rotate(${scrolled * 0.1}deg)`;
        });
    });
}

// Parallax Effect
function initParallax() {
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.hero-image-decoration, .about-decoration');
        
        parallaxElements.forEach(element => {
            const speed = 0.3;
            element.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
}

// Form Validation
function validateForm(form) {
    const phoneInput = form.querySelector('#phone');
    const nameInput = form.querySelector('#name');
    
    let isValid = true;
    
    // Reset previous errors
    form.querySelectorAll('.error').forEach(error => error.remove());
    form.querySelectorAll('.form-group').forEach(group => group.classList.remove('error'));
    
    // Validate phone
    if (!phoneInput) {
        console.error('Phone input not found');
        return false;
    }
    
    const phoneValue = phoneInput.value.trim();
    
    // Проверяем, что номер введен и соответствует белорусскому формату
    if (!phoneValue || phoneValue === '+375 ' || phoneValue.length < 17) {
        showFieldError(phoneInput, 'Пожалуйста, введите корректный номер телефона');
        isValid = false;
    } else {
        // Дополнительная проверка формата
        const cleanPhone = phoneValue.replace(/\s|-/g, '');
        if (!cleanPhone.match(/^\+375\d{9}$/)) {
            showFieldError(phoneInput, 'Некорректный формат номера телефона');
            isValid = false;
        }
    }
    
    return isValid;
}

function showFieldError(field, message) {
    const formGroup = field.closest('.form-group');
    formGroup.classList.add('error');
    
    const errorElement = document.createElement('div');
    errorElement.className = 'error';
    errorElement.textContent = message;
    errorElement.style.color = 'var(--error)';
    errorElement.style.fontSize = '0.9rem';
    errorElement.style.marginTop = '5px';
    
    formGroup.appendChild(errorElement);
}

// Form Submission
document.addEventListener('submit', function(e) {
    if (e.target.id === 'callbackForm') {
        e.preventDefault();
        
        if (!validateForm(e.target)) {
            return false;
        }
        
        submitCallbackForm(e.target);
    }
});

// AJAX Form Submission
function submitCallbackForm(form) {
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Отправка...';
    submitBtn.disabled = true;
    
    // Clear previous errors
    form.querySelectorAll('.error').forEach(error => error.remove());
    form.querySelectorAll('.form-group').forEach(group => group.classList.remove('error'));
    
    // Prepare form data
    const formData = new FormData(form);
    const data = {
        name: formData.get('name') || '',
        phone: formData.get('phone') || ''
    };
    
    // Send AJAX request
    fetch('ajax/callback.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showSuccessMessage(result.message, result.telegram_sent);
            form.reset();
            // Reset phone mask
            const phoneInput = form.querySelector('#phone');
            if (phoneInput) {
                phoneInput.value = '';
                setTimeout(() => {
                    phoneInput.value = '+375 ';
                }, 10);
            }
        } else {
            showErrorMessage(result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorMessage('Произошла ошибка при отправке заявки. Проверьте интернет-соединение и попробуйте еще раз.');
    })
    .finally(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// Show Success Message
function showSuccessMessage(message, telegramSent) {
    const modalBody = document.querySelector('#callbackModal .modal-body');
    const form = document.querySelector('#callbackForm');
    
    form.style.display = 'none';
    
    const successHtml = `
        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <p>${message}</p>
            ${!telegramSent ? '<p style="font-size: 0.9rem; color: #F59E0B;"><i class="fas fa-exclamation-triangle"></i> Уведомление в Telegram не отправлено</p>' : ''}
            <button class="btn btn-primary" onclick="closeCallbackModal()">Закрыть</button>
        </div>
    `;
    
    modalBody.innerHTML = successHtml;
}

// Show Error Message
function showErrorMessage(message) {
    const modalBody = document.querySelector('#callbackModal .modal-body');
    const form = document.querySelector('#callbackForm');
    
    // Show error at the top of the form
    const existingError = form.querySelector('.form-error');
    if (existingError) {
        existingError.remove();
    }
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'form-error';
    errorDiv.innerHTML = `
        <i class="fas fa-exclamation-circle"></i>
        <span>${message}</span>
    `;
    
    form.insertBefore(errorDiv, form.firstChild);
}

// Counter Animation
function animateCounter(element, start, end, duration) {
    let current = start;
    const increment = (end - start) / (duration / 16);
    const timer = setInterval(() => {
        current += increment;
        element.textContent = Math.floor(current);
        
        if (current >= end) {
            element.textContent = end;
            clearInterval(timer);
        }
    }, 16);
}

// Initialize counters when they come into view
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
            const target = parseInt(entry.target.textContent.replace(/\D/g, ''));
            entry.target.textContent = '0';
            animateCounter(entry.target, 0, target, 2000);
            entry.target.classList.add('animated');
        }
    });
}, { threshold: 0.3, rootMargin: '0px 0px 100px 0px' });

// Observe achievement numbers
document.querySelectorAll('.achievement-number').forEach(counter => {
    counterObserver.observe(counter);
});

// Typing Effect for Hero Title
function initTypingEffect() {
    const titleLines = document.querySelectorAll('.title-line');
    
    titleLines.forEach((line, index) => {
        const text = line.textContent;
        line.textContent = '';
        line.style.opacity = '1';
        
        setTimeout(() => {
            let i = 0;
            const typeInterval = setInterval(() => {
                line.textContent += text.charAt(i);
                i++;
                
                if (i >= text.length) {
                    clearInterval(typeInterval);
                }
            }, 50);
        }, index * 1000);
    });
}

// Mouse Parallax Effect
function initMouseParallax() {
    document.addEventListener('mousemove', (e) => {
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        const floatingElements = document.querySelectorAll('.floating-element');
        floatingElements.forEach((element, index) => {
            const speed = (index + 1) * 0.5;
            const x = (mouseX - 0.5) * speed * 20;
            const y = (mouseY - 0.5) * speed * 20;
            
            element.style.transform += ` translate(${x}px, ${y}px)`;
        });
    });
}

// Initialize additional effects after page load
window.addEventListener('load', () => {
    initMouseParallax();
    
    // Add loading complete class to body
    document.body.classList.add('loaded');
});

// Service Card Hover Effects
document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px) scale(1.02)';
    });
    
    card.addEventListener('mouseleave', function() {
        if (!this.classList.contains('featured')) {
            this.style.transform = 'translateY(0) scale(1)';
        } else {
            this.style.transform = 'scale(1.05)';
        }
    });
});

// Gallery Image Lazy Loading
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Initialize lazy loading if needed
// initLazyLoading();

// Utility Functions
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction() {
        const context = this;
        const args = arguments;
        
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        
        if (callNow) func.apply(context, args);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Performance optimized scroll handler
const optimizedScrollHandler = throttle(() => {
    const scrolled = window.pageYOffset;
    
    // Update header
    const header = document.querySelector('.header');
    if (scrolled > 100) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
    
    // Update scroll indicator
    const scrollIndicator = document.querySelector('.scroll-indicator');
    if (scrollIndicator) {
        scrollIndicator.style.opacity = scrolled > 100 ? '0' : '1';
    }
}, 16);

// Replace the existing scroll handler
window.removeEventListener('scroll', initScrollEffects);
window.addEventListener('scroll', optimizedScrollHandler);

// Error Handling
window.addEventListener('error', function(e) {
    console.error('JavaScript error:', e.error);
});

// Console welcome message
console.log('%c🌟 Browistik Website 🌟', 'color: #8B5CF6; font-size: 20px; font-weight: bold;');
console.log('%cСайт разработан с любовью ❤️', 'color: #A855F7; font-size: 14px;');

