@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
<a href="/" class="visually-hidden-focusable skip-link">Skip to main content</a>
<div class="portfolio-container">
    <div class="text-center mb-4">
        <a href="/" class="btn btn-lg glowing-btn" style="border-radius: 2rem; font-size: 1.1rem;" aria-label="Back to Home"><i class="fas fa-home me-2"></i>Back to Home</a>
    </div>
    <!-- Hero Section -->
    <section class="hero-section py-5 position-relative" style="min-height: 350px;" aria-label="Portfolio Hero">
        <div class="container position-relative z-2">
            <div class="row align-items-center">
                <div class="col-lg-7 animate-fade-in">
                    <h1 class="display-3 fw-bold mb-3 neon-text">My Portfolio</h1>
                    <p class="lead mb-4">Explore a curated selection of my best work in UI/UX design and web development. Each project reflects my passion for creating beautiful and functional digital experiences.</p>
                    <div class="d-flex gap-3">
                        <button class="btn btn-primary btn-lg glowing-btn" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                            <i class="fas fa-plus me-2"></i>Add New Project
                        </button>
                        <a href="#projects" class="btn btn-outline btn-lg">View Projects</a>
                    </div>
                </div>
                <div class="col-lg-5 text-center animate-fade-in" style="animation-delay: 0.2s;">
                    <img src="{{ asset('storage/uploads/newprofile.png') }}" alt="Portfolio Hero" class="img-fluid floating-image" style="max-height: 250px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-4" aria-label="Portfolio Stats">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-4 col-lg-2 text-center">
                    <div class="stats-card animate-fade-in">
                        <span class="stats-number" data-count="{{ $projects->count() }}">0</span>
                        <span class="stats-label">Projects</span>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 text-center">
                    <div class="stats-card animate-fade-in" style="animation-delay: 0.1s;">
                        <span class="stats-number" data-count="{{ $projects->unique('category')->count() }}">0</span>
                        <span class="stats-label">Categories</span>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 text-center">
                    <div class="stats-card animate-fade-in" style="animation-delay: 0.2s;">
                        <span class="stats-number" data-count="{{ $projects->sum(function($project) { return is_array($project->tech_stack) ? count($project->tech_stack) : 0; }) }}">0</span>
                        <span class="stats-label">Technologies</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Grid Section -->
    <section id="projects" class="projects-section py-5" aria-label="Projects">
        <div class="container">
            <h2 class="mb-4 fw-bold neon-text">Featured Projects</h2>
            <div class="row g-4">
                @forelse($projects as $project)
                    <div class="col-md-6 col-lg-4 animate-fade-in">
                        <div class="glass h-100 d-flex flex-column">
                            <div class="project-image position-relative">
                                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="img-fluid rounded-top project-img" style="width: 100%; height: 200px; object-fit: cover;">
                                <div class="project-overlay d-flex align-items-center justify-content-center">
                                    <div class="project-links">
                                        @if($project->demo_url)
                                            <a href="{{ $project->demo_url }}" target="_blank" class="btn btn-primary btn-sm me-2" title="Live Demo">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                        @if($project->github_url)
                                            <a href="{{ $project->github_url }}" target="_blank" class="btn btn-primary btn-sm" title="GitHub">
                                                <i class="fab fa-github"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="project-info p-4 flex-grow-1 d-flex flex-column">
                                <h3 class="h5 mb-2 fw-bold">{{ $project->title }}</h3>
                                <p class="mb-3 text-secondary flex-grow-1">{{ Str::limit($project->description, 100) }}</p>
                                <div class="tech-stack mb-3">
                                    @if(is_array($project->tech_stack))
                                        @foreach($project->tech_stack as $tech)
                                            <span class="badge" style="background: var(--primary-color); color: white;">{{ $tech }}</span>
                                        @endforeach
                                    @elseif(is_string($project->tech_stack) && !empty($project->tech_stack))
                                        @foreach(explode(',', $project->tech_stack) as $tech)
                                            <span class="badge" style="background: var(--primary-color); color: white;">{{ trim($tech) }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex gap-2 mt-auto">
                                    <a href="#" class="btn btn-outline btn-sm" data-bs-toggle="modal" data-bs-target="#editProjectModal-{{ $project->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline btn-sm" onclick="return confirm('Are you sure you want to delete this project?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="glass p-5 text-center">
                            <i class="fas fa-folder-open fa-3x mb-3" style="color: var(--primary-color);"></i>
                            <h3>No Projects Yet</h3>
                            <p class="mb-0">Projects will be displayed here once added.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>

<!-- Add Project Modal -->
<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content glass">
            <div class="modal-header">
                <h5 class="modal-title neon-text" id="addProjectModalLabel">Add New Project</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Project Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" required>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="demo_url" class="form-label">Demo URL</label>
                            <input type="url" class="form-control" id="demo_url" name="demo_url">
                        </div>
                        <div class="col-md-6">
                            <label for="github_url" class="form-label">GitHub URL</label>
                            <input type="url" class="form-control" id="github_url" name="github_url">
                        </div>
                        <div class="col-12">
                            <label for="tech_stack" class="form-label">Technologies (comma-separated)</label>
                            <input type="text" class="form-control" id="tech_stack" name="tech_stack" placeholder="HTML, CSS, JavaScript, React">
                        </div>
                        <div class="col-12">
                            <label for="image" class="form-label">Project Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary glowing-btn">Add Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Project Modals -->
@foreach($projects as $project)
<div class="modal fade" id="editProjectModal-{{ $project->id }}" tabindex="-1" aria-labelledby="editProjectModalLabel-{{ $project->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content glass">
            <div class="modal-header">
                <h5 class="modal-title neon-text" id="editProjectModalLabel-{{ $project->id }}">Edit Project</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="title-{{ $project->id }}" class="form-label">Project Title</label>
                            <input type="text" class="form-control" id="title-{{ $project->id }}" name="title" value="{{ $project->title }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category-{{ $project->id }}" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category-{{ $project->id }}" name="category" value="{{ $project->category }}" required>
                        </div>
                        <div class="col-12">
                            <label for="description-{{ $project->id }}" class="form-label">Description</label>
                            <textarea class="form-control" id="description-{{ $project->id }}" name="description" rows="3" required>{{ $project->description }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="demo_url-{{ $project->id }}" class="form-label">Demo URL</label>
                            <input type="url" class="form-control" id="demo_url-{{ $project->id }}" name="demo_url" value="{{ $project->demo_url }}">
                        </div>
                        <div class="col-md-6">
                            <label for="github_url-{{ $project->id }}" class="form-label">GitHub URL</label>
                            <input type="url" class="form-control" id="github_url-{{ $project->id }}" name="github_url" value="{{ $project->github_url }}">
                        </div>
                        <div class="col-12">
                            <label for="tech_stack-{{ $project->id }}" class="form-label">Technologies (comma-separated)</label>
                            <input type="text" class="form-control" id="tech_stack-{{ $project->id }}" name="tech_stack" value="{{ is_array($project->tech_stack) ? implode(', ', $project->tech_stack) : $project->tech_stack }}">
                        </div>
                        <div class="col-12">
                            <label for="image-{{ $project->id }}" class="form-label">Project Image</label>
                            <input type="file" class="form-control" id="image-{{ $project->id }}" name="image" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary glowing-btn">Update Project</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
// Animate counters
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-count'));
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;
    
    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current);
    }, 16);
}

// Trigger counter animation when stats are visible
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counter = entry.target.querySelector('[data-count]');
            if (counter && !counter.classList.contains('animated')) {
                counter.classList.add('animated');
                animateCounter(counter);
            }
        }
    });
});

document.querySelectorAll('.stats-card').forEach(card => {
    observer.observe(card);
});
</script>
@endpush
@endsection
