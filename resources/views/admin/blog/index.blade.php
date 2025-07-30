@extends('layouts.app')

@section('title', 'Manage Blog Posts')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-light bg-dark text-light">
                <div class="card-header bg-dark border-light d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Manage Blog Posts</h4>
                    <div class="header-actions d-flex gap-2">
                        <a href="{{ route('admin.blog.create') }}" class="btn btn-info">
                            <i class="fas fa-plus-circle me-2"></i>New Post
                        </a>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                            <i class="fas fa-plus-circle me-2"></i> Add New Project
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="admin-table table-dark table-hover align-middle mx-auto" style="max-width:900px;">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td>{{ $post->title }}</td>
                                        <td>
                                            @if($post->is_published)
                                                <span class="status-badge status-active">Published</span>
                                            @else
                                                <span class="status-badge status-pending">Draft</span>
                                            @endif
                                        </td>
                                        <td>{{ $post->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('blog.show', $post->slug) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   target="_blank" title="View Post">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.blog.edit', $post) }}" 
                                                   class="btn btn-warning btn-sm" title="Edit Post">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.blog.destroy', $post) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete Post">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Add Project Modal (moved outside container for stacking context) -->
<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content glass">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title neon-text" id="addProjectModalLabel">Add New Project</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="projectTitle" class="form-label text-light">Project Title</label>
                        <input type="text" class="form-control" id="projectTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="projectDescription" class="form-label text-light">Description</label>
                        <textarea class="form-control" id="projectDescription" name="description" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="projectTechStack" class="form-label text-light">Technologies Used (comma separated)</label>
                        <input type="text" class="form-control" id="projectTechStack" name="tech_stack">
                    </div>
                    <div class="mb-3">
                        <label for="projectImage" class="form-label text-light">Project Image</label>
                        <input type="file" class="form-control" id="projectImage" name="image" accept="image/*" required>
                    </div>
                    <div class="modal-footer border-top border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Add Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .form-control:focus {
        background-color: #2c3034;
        border-color: #0dcaf0;
        color: #fff;
        box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.25);
    }
    .form-control::file-selector-button {
        background-color: #0dcaf0;
        color: #000;
        border: none;
        padding: 0.375rem 0.75rem;
        margin-right: 0.5rem;
        border-radius: 0.25rem;
        cursor: pointer;
    }
    .form-control::file-selector-button:hover {
        background-color: #0bb2d9;
    }
    .modal-backdrop {
        z-index: 1040 !important;
        background: rgba(10, 10, 20, 0.7) !important;
        backdrop-filter: blur(6px);
    }
    .modal {
        z-index: 1050 !important;
    }
    .modal-content {
        z-index: 1060 !important;
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
    }
    .modal-header, .modal-footer {
        border-color: var(--glass-border) !important;
    }
    .neon-text {
        text-shadow: 0 0 8px var(--primary-color), 0 0 16px var(--primary-color);
        color: var(--primary-color) !important;
        font-weight: 700;
        letter-spacing: 1.5px;
    }
    .admin-table th, .admin-table td {
        background: transparent;
        color: var(--text-primary);
        border-color: var(--glass-border);
    }
    .admin-table th {
        font-weight: 700;
        letter-spacing: 1px;
    }
    .status-badge {
        padding: 0.3em 0.8em;
        border-radius: 1em;
        font-size: 0.95em;
        font-weight: 600;
        color: #fff;
        background: var(--primary-color);
        box-shadow: 0 0 8px var(--primary-color);
    }
    .status-pending {
        background: #ff9800;
        box-shadow: 0 0 8px #ff9800;
    }
</style>
@endpush 