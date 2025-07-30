@extends('layouts.app')

@section('title', 'Home')

@section('content')
<a href="#home" class="visually-hidden-focusable skip-link">Skip to main content</a>
<!-- Hero Section -->
<section id="home" class="hero-section py-5 position-relative" style="min-height: 100vh; display: flex; align-items: center;" aria-label="Home">
    <div class="container position-relative z-2">
        <div class="row align-items-center">
            <!-- Left Content -->
            <div class="col-lg-6 animate-fade-in">
                <p class="text-light mb-2" style="font-size: 1.1rem; opacity: 0.8;">Hi I am</p>
                <h1 class="display-3 fw-bold mb-3 text-light" style="letter-spacing: 1px;">Rumel Eumague Jr.</h1>
                <h2 class="display-4 fw-bold mb-4 neon-text" style="letter-spacing: 2px;">UI/UX Designer & Full-Stack Developer</h2>
                
                <!-- Social Icons -->
                <div class="social-icons mb-4">
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
                
                <!-- Action Buttons -->
                            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('download.resume') }}" class="btn btn-primary glowing-btn download-btn" data-download="resume">
                    <i class="fas fa-download me-2"></i>Download Resume
                </a>
                <a href="{{ route('download.cv') }}" class="btn btn-outline download-btn" data-download="cv">
                    <i class="fas fa-download me-2"></i>Download CV
                </a>
            </div>
            </div>
            
            <!-- Right Content - Profile Image -->
            <div class="col-lg-6 text-center animate-fade-in" style="animation-delay: 0.2s;">
                <div class="profile-image-container position-relative mx-auto">
                    <div class="profile-glow"></div>
                    <img src="{{ asset('storage/uploads/newprofile.png') }}" alt="Mahmood Fazile" class="rounded-circle shadow-lg border border-3 border-light animate-float" style="width: 400px; height: 400px; object-fit: cover; box-shadow: 0 0 60px 10px rgba(255, 107, 53, 0.2);">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5" style="background: var(--darker-bg);">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <span class="stats-number">3+</span>
                    <span class="stats-label">Years Experiences</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <span class="stats-number">5+</span>
                    <span class="stats-label">Project done</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <span class="stats-number">10+</span>
                    <span class="stats-label">Happy Clients</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="about-section py-5" aria-label="About">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 animate-fade-in">
                <h2 class="display-5 fw-bold mb-4 neon-text">About Me</h2>
                <p class="lead mb-4">I specialize in creating intuitive and visually appealing user experiences. With expertise in UI/UX design, I transform complex problems into simple, beautiful, and intuitive designs.</p>
                <p class="mb-4">My approach combines user-centered design principles with modern design trends to create engaging digital experiences that users love.</p>
                <div class="d-flex gap-4">
                    <div class="experience-item text-center">
                        <span class="stats-number">3+</span>
                        <span class="stats-label">Years Experience</span>
                    </div>
                    <div class="experience-item text-center">
                        <span class="stats-number">5+</span>
                        <span class="stats-label">Projects Completed</span>
                    </div>
                    <div class="experience-item text-center">
                        <span class="stats-number">10+</span>
                        <span class="stats-label">Happy Clients</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center animate-fade-in" style="animation-delay: 0.2s;">
                <div class="profile-image-container position-relative mx-auto">
                    <div class="profile-glow"></div>
                    <img src="{{ asset('storage/uploads/newprofile.png') }}" alt="Profile Picture" class="rounded-circle shadow-lg border border-3 border-light animate-float" style="width: 300px; height: 300px; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="services-section py-5" aria-label="Services">
    <div class="container">
        <h2 class="text-center mb-5 neon-text">What I Do</h2>
        <div class="row g-4">
            <div class="col-md-4 animate-fade-in" style="animation-delay: 0.2s;">
                <div class="glass h-100 p-4">
                    <div class="icon-container mb-4">
                        <i class="fas fa-pencil-ruler fa-3x" style="color: var(--primary-color);"></i>
                    </div>
                    <h3 class="h4 mb-3">UI/UX Design</h3>
                    <p class="mb-0">Creating intuitive and visually appealing user interfaces that enhance user experience and drive engagement.</p>
                </div>
            </div>
            <div class="col-md-4 animate-fade-in" style="animation-delay: 0.4s;">
                <div class="glass h-100 p-4">
                    <div class="icon-container mb-4">
                        <i class="fas fa-code fa-3x" style="color: var(--primary-color);"></i>
                    </div>
                    <h3 class="h4 mb-3">Full-Stack Development</h3>
                    <p class="mb-0">Building robust web applications using modern technologies like Laravel, PHP, JavaScript, and React.</p>
                </div>
            </div>
            <div class="col-md-4 animate-fade-in" style="animation-delay: 0.6s;">
                <div class="glass h-100 p-4">
                    <div class="icon-container mb-4">
                        <i class="fas fa-mobile-alt fa-3x" style="color: var(--primary-color);"></i>
                    </div>
                    <h3 class="h4 mb-3">Mobile Development</h3>
                    <p class="mb-0">Creating responsive and cross-platform mobile applications with modern development frameworks.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section id="portfolio" class="portfolio-section py-5" aria-label="Portfolio">
    <div class="container">
        <h2 class="text-center mb-5 neon-text">My Portfolio</h2>
        <div class="row g-4">
            @foreach(\App\Models\Project::latest()->take(6)->get() as $project)
            <div class="col-md-6 col-lg-4 animate-fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                <div class="glass h-100 project-card position-relative overflow-hidden">
                    <div class="project-image-wrapper position-relative" style="background: linear-gradient(120deg, #232323 0%, #181818 100%); min-height: 200px;">
                        <img src="{{ $project->image ? asset('storage/' . $project->image) : asset('images/fallback-project.png') }}"
                             alt="{{ $project->title }} project image"
                             class="img-fluid rounded-top project-image"
                             style="width: 100%; height: 200px; object-fit: cover; background: #222;">
                        <div class="project-image-overlay"></div>
                    </div>
                    <div class="p-4 project-card-content">
                        <h5 class="mb-1 fw-bold text-white">{{ $project->title }}</h5>
                        <p class="mb-2 text-white-50" style="font-size: 0.98rem;">{{ Str::limit($project->description, 100) }}</p>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach(explode(',', $project->technologies) as $tech)
                            <span class="badge" style="background: var(--primary-color); color: white;">{{ trim($tech) }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section py-5" aria-label="Contact">
    <div class="container">
        <h2 class="text-center mb-5 neon-text">Get In Touch</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass p-5">
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="Your Name" required style="background: var(--card-bg); border: 1px solid var(--glass-border); color: var(--text-primary);">
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required style="background: var(--card-bg); border: 1px solid var(--glass-border); color: var(--text-primary);">
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject" required style="background: var(--card-bg); border: 1px solid var(--glass-border); color: var(--text-primary);">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" name="message" rows="5" placeholder="Your Message" required style="background: var(--card-bg); border: 1px solid var(--glass-border); color: var(--text-primary);"></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary glowing-btn">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
