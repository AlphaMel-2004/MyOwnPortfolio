@extends('layouts.app')

@section('title', 'About Me')

@section('content')
<!-- Hero Section -->
<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 animate-fade-in">
                <h1 class="display-4 fw-bold mb-4 neon-text">About Me</h1>
                <p class="lead mb-4">UI/UX Designer & Full-Stack Developer with a passion for creating beautiful and functional digital experiences.</p>
                                    <div class="d-flex gap-3">
                        <a href="{{ route('download.resume') }}" class="btn btn-primary glowing-btn">Download Resume</a>
                        <a href="{{ route('portfolio') }}" class="btn btn-outline">View My Work</a>
                    </div>
            </div>
            <div class="col-lg-6 text-center animate-fade-in" style="animation-delay: 0.2s;">
                <div class="profile-image-container position-relative">
                    <div class="profile-glow"></div>
                    <img src="{{ asset('storage/uploads/newprofile.png') }}" alt="Profile Picture" class="img-fluid floating-image" style="max-height: 250px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 animate-fade-in">
                <div class="glass p-4 h-100">
                    <h2 class="h3 mb-4 neon-text">My Journey</h2>
                    <p class="mb-4">I specialize in UI/UX design and full-stack development, creating intuitive and visually appealing user experiences. With expertise in design thinking, user-centered design principles, and modern web technologies, I transform complex problems into simple, beautiful, and functional digital solutions.</p>
                    <p class="mb-4">My approach combines creative design with technical expertise to deliver engaging digital experiences that users love and businesses value.</p>
                    <div class="d-flex gap-4">
                        <div class="experience-item text-center">
                            <span class="stats-number">5+</span>
                            <span class="stats-label">Years Experience</span>
                        </div>
                        <div class="experience-item text-center">
                            <span class="stats-number">20+</span>
                            <span class="stats-label">Projects Completed</span>
                        </div>
                        <div class="experience-item text-center">
                            <span class="stats-number">80+</span>
                            <span class="stats-label">Happy Clients</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 animate-fade-in" style="animation-delay: 0.2s;">
                <div class="glass p-4 h-100">
                    <h2 class="h3 mb-4 neon-text">Skills & Expertise</h2>
                    <div class="skills-container">
                        <div class="skill-category mb-4">
                            <h3 class="h5 mb-3">Design Tools</h3>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge" style="background: var(--primary-color); color: white;">Figma</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">Adobe XD</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">Sketch</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">InVision</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">Adobe Creative Suite</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">Protopie</span>
                            </div>
                        </div>
                        <div class="skill-category mb-4">
                            <h3 class="h5 mb-3">Development</h3>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge" style="background: var(--primary-color); color: white;">Laravel</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">PHP</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">JavaScript</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">React</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">Vue.js</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">MySQL</span>
                            </div>
                        </div>
                        <div class="skill-category mb-4">
                            <h3 class="h5 mb-3">Design Skills</h3>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge" style="background: var(--primary-color); color: white;">User Research</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">Wireframing</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">Prototyping</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">UI Design</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">UX Design</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">Design Systems</span>
                            </div>
                        </div>
                        <div class="skill-category">
                            <h3 class="h5 mb-3">Other Skills</h3>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge" style="background: var(--primary-color); color: white;">HTML/CSS</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">JavaScript</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">Responsive Design</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">Accessibility</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">Design Thinking</span>
                                <span class="badge" style="background: var(--primary-color); color: white;">Agile</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Experience Section -->
<section class="experience-section py-5">
    <div class="container">
        <h2 class="text-center mb-5 neon-text">Work Experience</h2>
        <div class="row g-4">
            <div class="col-lg-6 animate-fade-in">
                <div class="glass p-4 h-100">
                    <h3 class="h4 mb-3">Senior UI/UX Designer</h3>
                    <p class="text-muted mb-2">Tech Company • 2022 - Present</p>
                    <p class="mb-3">Leading design initiatives for web and mobile applications, creating user-centered designs that improve user experience and drive business growth.</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check me-2" style="color: var(--primary-color);"></i>Designed 15+ mobile and web applications</li>
                        <li><i class="fas fa-check me-2" style="color: var(--primary-color);"></i>Improved user engagement by 40%</li>
                        <li><i class="fas fa-check me-2" style="color: var(--primary-color);"></i>Led design system implementation</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 animate-fade-in" style="animation-delay: 0.2s;">
                <div class="glass p-4 h-100">
                    <h3 class="h4 mb-3">UI/UX Designer</h3>
                    <p class="text-muted mb-2">Design Agency • 2020 - 2022</p>
                    <p class="mb-3">Created user interfaces and experiences for various clients across different industries, focusing on usability and modern design trends.</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check me-2" style="color: var(--primary-color);"></i>Designed 25+ client projects</li>
                        <li><i class="fas fa-check me-2" style="color: var(--primary-color);"></i>Conducted user research and testing</li>
                        <li><i class="fas fa-check me-2" style="color: var(--primary-color);"></i>Collaborated with development teams</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Education Section -->
<section class="education-section py-5">
    <div class="container">
        <h2 class="text-center mb-5 neon-text">Education</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="glass p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="h4 mb-2">Bachelor of Design</h3>
                            <p class="text-muted mb-2">Design University • 2016 - 2020</p>
                            <p class="mb-0">Specialized in User Experience Design and Digital Media</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <span class="badge" style="background: var(--primary-color); color: white; font-size: 0.9rem;">Graduated with Honors</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="glass p-5">
                    <h2 class="mb-4 neon-text">Ready to Work Together?</h2>
                    <p class="lead mb-4">Let's create something amazing together. I'm always excited to take on new challenges and bring your ideas to life.</p>
                                <div class="d-flex gap-3 justify-content-center">
                <a href="{{ route('download.resume') }}" class="btn btn-primary glowing-btn download-btn" data-download="resume">
                    <i class="fas fa-download me-2"></i>Download Resume
                </a>
                <a href="{{ route('portfolio') }}" class="btn btn-outline">View My Work</a>
            </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
