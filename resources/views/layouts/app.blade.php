<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Mahmood Fazile - UI/UX Designer. Portfolio, blog, and contact information.')">
    <meta name="keywords" content="Mahmood Fazile, UI/UX designer, portfolio, web design, user experience, user interface, design, Figma, creative">
    <meta name="author" content="Mahmood Fazile">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta http-equiv="Content-Language" content="en">
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'Mahmood Fazile') | Portfolio">
    <meta property="og:description" content="@yield('meta_description', 'Mahmood Fazile - UI/UX Designer. Portfolio, blog, and contact information.')">
    <meta property="og:image" content="{{ asset('public/storage/uploads/newprofile.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Mahmood Fazile') | Portfolio">
    <meta name="twitter:description" content="@yield('meta_description', 'Mahmood Fazile - UI/UX Designer. Portfolio, blog, and contact information.')">
    <meta name="twitter:image" content="{{ asset('public/storage/uploads/newprofile.png') }}">
    <title>@yield('title') | Portfolio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-color: #ff6b35;
            --secondary-color: #f7931e;
            --accent-color: #ff8c42;
            --dark-bg: #0a0a0a;
            --darker-bg: #050505;
            --glass-bg: rgba(20, 20, 20, 0.95);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --text-muted: rgba(255, 255, 255, 0.6);
            --transition-speed: 0.3s;
            --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            --gradient-accent: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            --card-bg: rgba(30, 30, 30, 0.8);
        }

        /* Base Styles */
        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            background: var(--dark-bg);
            color: var(--text-primary);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Effects */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: 
                radial-gradient(circle at 20% 20%, rgba(255, 107, 53, 0.08) 0%, transparent 60%),
                radial-gradient(circle at 80% 80%, rgba(247, 147, 30, 0.06) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
            animation: bgfloat 18s linear infinite alternate;
        }

        /* Navigation */
        .navbar {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
            padding: 1rem 0;
            z-index: 100;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 0.5rem 0;
            background: rgba(10, 10, 10, 0.98) !important;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color) !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all var(--transition-speed) ease;
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all var(--transition-speed) ease;
            position: relative;
            margin: 0 0.2rem;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: var(--gradient-primary);
            transition: all var(--transition-speed) ease;
        }

        .nav-link:hover::after, .nav-link.active::after {
            width: 100%;
            left: 0;
        }

        /* Content Area */
        .content {
            flex: 1;
            overflow-y: auto;
            padding-top: 5rem;
            padding-bottom: 2rem;
            z-index: 1;
        }

        /* Cards and Components */
        .glass {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 8px 32px 0 rgba(0,0,0,0.4);
            transition: all 0.3s ease;
            border-radius: 12px;
        }

        .glass:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px 0 rgba(0,0,0,0.5);
            border-color: rgba(255, 107, 53, 0.3);
        }

        .neon-text {
            color: var(--primary-color) !important;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            padding: 0.7rem 2rem;
            font-weight: 600;
            transition: all var(--transition-speed) ease;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: #fff;
        }

        .btn-primary:hover {
            filter: brightness(1.2);
            box-shadow: 0 0 20px var(--primary-color);
            transform: translateY(-2px);
        }

        .btn-outline {
            border: 2px solid var(--text-secondary);
            color: var(--text-secondary);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
        }

        /* Footer */
        .footer {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--glass-border);
            padding: 2rem 0;
            color: var(--text-secondary);
            text-align: center;
            z-index: 10;
            width: 100%;
        }

        .footer .social-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1.2rem;
            margin-bottom: 1rem;
        }

        .footer .social-icons a {
            color: var(--primary-color);
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .footer .social-icons a:hover {
            color: var(--accent-color);
            transform: translateY(-3px);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @keyframes bgfloat {
            0% { transform: translateY(0px) rotate(0deg); }
            100% { transform: translateY(-20px) rotate(1deg); }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Hero Section Styles */
        .hero-section {
            background: var(--dark-bg) !important;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 30% 20%, rgba(255, 107, 53, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, rgba(247, 147, 30, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        .profile-image-container {
            position: relative;
            display: inline-block;
        }

        .profile-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120%;
            height: 120%;
            background: radial-gradient(circle, var(--primary-color) 0%, transparent 70%);
            filter: blur(30px);
            opacity: 0.3;
            animation: float 4s ease-in-out infinite;
        }

        /* Statistics Cards */
        .stats-card {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            display: block;
        }

        .stats-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                padding: 0.5rem 0;
            }
            
            .content {
                padding-top: 4rem;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        .glowing-btn {
            box-shadow: 0 0 20px 4px rgba(255, 107, 53, 0.3);
            background: var(--gradient-primary);
            color: #fff;
            border: none;
            font-weight: 600;
            letter-spacing: 1px;
            transition: box-shadow 0.3s, background 0.3s;
        }
        
        .glowing-btn:hover {
            box-shadow: 0 0 40px 8px rgba(255, 107, 53, 0.5);
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            color: #fff;
        }

        /* Social Icons */
        .social-icons {
            display: flex;
            gap: 1rem;
            margin: 2rem 0;
        }

        .social-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-icon:hover {
            color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <a href="#home" class="visually-hidden-focusable skip-link">Skip to main content</a>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">KnowMel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About me</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact me</a>
                    </li>
                    <li class="nav-item ms-2">
                        <button class="btn btn-primary glowing-btn" data-bs-toggle="modal" data-bs-target="#hireMeModal">Hire Me</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="social-icons">
                <a href="https://www.facebook.com/rumel.eumague" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://www.linkedin.com/in/rumel-eumague-778580310?lipi=urn%3Ali%3Apage%3Ad_flagship3_profile_view_base_contact_details%3B6HJqhyQCQsW%2Ba2mVwAIoVA%3D%3D" target="_blank"><i class="fab fa-linkedin"></i></a>
                <a href="https://github.com/AlphaMel-2004" target="_blank"><i class="fab fa-github"></i></a>
            </div>
            <p class="mb-0">&copy; {{ date('Y') }} KnowMel. All rights reserved.</p>
        </div>
    </footer>

    <!-- Hire Me Modal -->
    <div class="modal fade" id="hireMeModal" tabindex="-1" aria-labelledby="hireMeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glass position-relative p-0" style="overflow: visible; border-radius: 2rem; box-shadow: 0 0 60px 10px rgba(255, 107, 53, 0.3); border: 2px solid var(--primary-color); background: rgba(20, 20, 20, 0.95);">
                <div class="modal-header border-0 justify-content-center position-relative" style="background: linear-gradient(120deg, #0a0a0a 0%, #1a1a1a 100%); border-radius: 2rem 2rem 0 0;">
                    <div class="w-100 text-center">
                        @php
                            $profileImage = \App\Models\Image::where('type', 'profile')->latest()->first();
                        @endphp
                        <div class="profile-image-container position-relative mx-auto mb-3" style="width: 120px; height: 120px;">
                            <div class="profile-glow" style="width: 140px; height: 140px; background: radial-gradient(circle, var(--primary-color) 0%, transparent 100%); filter: blur(30px); opacity: 0.5; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
                            <img src="{{ asset('storage/uploads/newprofile.png') }}" alt="Profile Picture" class="rounded-circle shadow-lg border border-3 border-light animate-float" style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                        <h3 class="fw-bold neon-text mb-1" style="font-size: 2rem;">Rumel Eumague Jr.</h3>
                        <p class="mb-0 text-light">UI/UX Designer & Full-Stack Developer</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="row g-3 justify-content-center mb-4">
                        <div class="col-12 col-md-6">
                            <div class="contact-card glass p-3 mb-2 d-flex align-items-center gap-3 justify-content-start">
                                <i class="fas fa-envelope" style="color: var(--primary-color); font-size: 1.2rem; min-width: 20px;"></i> 
                                <a href="mailto:eumaguerumel4@gmail.com" class="text-info text-decoration-none" style="word-break: break-all;">eumaguerumel4@gmail.com</a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="contact-card glass p-3 mb-2 d-flex align-items-center gap-3 justify-content-start">
                                <i class="fas fa-phone" style="color: var(--primary-color); font-size: 1.2rem; min-width: 20px;"></i> 
                                <a href="tel:+639815864687" class="text-info text-decoration-none">+63 981 586 4687</a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="contact-card glass p-3 mb-2 d-flex align-items-center gap-3 justify-content-start">
                                <i class="fas fa-map-marker-alt" style="color: var(--primary-color); font-size: 1.2rem; min-width: 20px;"></i> 
                                <span class="text-light">Davao City, Philippines</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="contact-card glass p-3 mb-2 d-flex align-items-center gap-3 justify-content-start">
                                <i class="fab fa-linkedin" style="color: var(--primary-color); font-size: 1.2rem; min-width: 20px;"></i> 
                                <a href="https://www.linkedin.com/in/rumel-eumague-778580310?lipi=urn%3Ali%3Apage%3Ad_flagship3_profile_view_base_contact_details%3B6HJqhyQCQsW%2Ba2mVwAIoVA%3D%3D" target="_blank" class="text-info text-decoration-none">linkedin.com/in/rumel-eumague</a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('contact') }}" class="btn btn-lg glowing-btn w-100 mt-3" style="font-size: 1.2rem; padding: 1rem 2rem;">Let's Work Together <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Chatbot -->
    <div id="ai-chatbot-btn" class="position-fixed" style="bottom: 2rem; right: 2rem; z-index: 1200;">
        <button class="btn glowing-btn rounded-circle shadow-lg" style="width: 64px; height: 64px; font-size: 2rem;" aria-label="Open AI Chatbot">
            <i class="fas fa-robot"></i>
        </button>
    </div>
    
    <div id="ai-chatbot-window" class="glass position-fixed" style="bottom: 6.5rem; right: 2rem; width: 350px; max-width: 95vw; border-radius: 1.5rem; box-shadow: 0 0 40px 8px rgba(255, 107, 53, 0.3); display: none; z-index: 1300;">
        <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-secondary" style="border-radius: 1.5rem 1.5rem 0 0; background: linear-gradient(120deg, #0a0a0a 0%, #1a1a1a 100%);">
            <span class="fw-bold neon-text"><i class="fas fa-robot me-2"></i>AI Assistant</span>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-light" id="ai-chatbot-clear" aria-label="Clear Chat"><i class="fas fa-trash"></i></button>
                <button class="btn btn-sm btn-outline-light" id="ai-chatbot-close" aria-label="Close Chatbot"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="px-3 pt-2 pb-0 small text-info" style="background: rgba(20,20,20,0.92); border-radius: 0 0 0 0;">
            <strong>AI Assistant:</strong> Ask me about Rumel's portfolio, projects, skills, or web development topics!
        </div>
        <div id="ai-chatbot-messages" class="p-3" style="height: 320px; overflow-y: auto; background: rgba(20,20,20,0.85);">
            <div class="text-secondary text-center small">How can I help you today?</div>
        </div>
        <form id="ai-chatbot-form" class="d-flex border-top border-secondary p-2 gap-2" autocomplete="off" style="background: rgba(20,20,20,0.92); border-radius: 0 0 1.5rem 1.5rem;">
            <input type="text" id="ai-chatbot-input" class="form-control" placeholder="Type your message..." aria-label="Type your message">
            <button type="submit" class="btn glowing-btn" aria-label="Send"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Active navigation highlighting
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-link');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (window.scrollY >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });


    </script>
    @stack('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/chatbot.js', 'resources/js/downloads.js'])
    <noscript><div class="alert alert-warning text-center">This site works best with JavaScript enabled.</div></noscript>
</body>
</html>
