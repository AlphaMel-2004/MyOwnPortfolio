@extends('layouts.app')

@section('title', 'Contact Me')

@section('content')
<!-- Hero Section -->
<section class="hero-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center animate-fade-in">
                <h1 class="display-4 fw-bold mb-4 neon-text">Get in Touch</h1>
                <p class="lead mb-5">Have a project in mind? Let's discuss how we can work together to bring your ideas to life.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass p-4 p-md-5">
                    <form action="{{ route('contact.submit') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                                    <label for="name">Your Name</label>
                                    <div class="invalid-feedback">Please enter your name.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                                    <label for="email">Your Email</label>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                                    <label for="subject">Subject</label>
                                    <div class="invalid-feedback">Please enter a subject.</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="message" name="message" placeholder="Your Message" style="height: 150px" required></textarea>
                                    <label for="message">Your Message</label>
                                    <div class="invalid-feedback">Please enter your message.</div>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg glowing-btn">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Section -->
<section class="contact-info-section py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="glass p-4 text-center h-100">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-envelope fa-2x" style="color: var(--primary-color);"></i>
                    </div>
                    <h3 class="h5 mb-2">Email</h3>
                    <p class="mb-0">eumaguerumel4@gmail.com</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass p-4 text-center h-100">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-phone fa-2x" style="color: var(--primary-color);"></i>
                    </div>
                    <h3 class="h5 mb-2">Phone</h3>
                    <p class="mb-0">+63-981-586-4687</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass p-4 text-center h-100">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-map-marker-alt fa-2x" style="color: var(--primary-color);"></i>
                    </div>
                    <h3 class="h5 mb-2">Location</h3>
                    <p class="mb-0">Davao City, Philippines</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Social Media Section -->
<section class="social-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="mb-4 neon-text">Connect With Me</h2>
                <div class="social-icons justify-content-center">
                    <a href="https://www.facebook.com/rumel.eumague" target="_blank" class="social-icon" aria-label="Facebook">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/rumel-eumague-778580310?lipi=urn%3Ali%3Apage%3Ad_flagship3_profile_view_base_contact_details%3B6HJqhyQCQsW%2Ba2mVwAIoVA%3D%3D" target="_blank" class="social-icon" aria-label="LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://github.com/AlphaMel-2004" target="_blank" class="social-icon" aria-label="GitHub">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Form submission feedback
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<span class="loading"></span> Sending...';
    submitBtn.disabled = true;
    
    // Re-enable button after 3 seconds (in case of error)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
});
</script>
@endpush
@endsection 