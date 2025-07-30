@extends('layouts.app')

@section('title', 'Admin - Projects')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-light bg-dark text-light">
                <div class="card-header bg-dark border-light d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Manage Projects</h4>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                        <i class="fas fa-plus me-2"></i>Add New Project
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mx-auto" style="max-width:900px;">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Technologies</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ Str::limit($project->description, 100) }}</td>
                                    <td>{{ is_array($project->technologies) ? implode(', ', $project->technologies) : $project->technologies }}</td>
                                    <td>{{ $project->category }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info me-2" onclick="editProject({{ $project->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteProject({{ $project->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                <form id="addProjectForm" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label text-light">Project Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label text-light">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="technologies" class="form-label text-light">Technologies Used</label>
                        <input type="text" class="form-control" id="technologies" name="technologies" placeholder="e.g., Laravel, Vue.js, MySQL" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label text-light">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="web">Web Development</option>
                            <option value="mobile">Mobile Development</option>
                            <option value="design">Design</option>
                            <option value="desktop">Desktop Application</option>
                            <option value="game">Game Development</option>
                            <option value="ai">AI/ML</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="project_image" class="form-label text-light">Project Image</label>
                        <input type="file" class="form-control" id="project_image" name="project_image" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="project_url" class="form-label text-light">Project URL</label>
                        <input type="url" class="form-control" id="project_url" name="project_url" placeholder="https://">
                    </div>
                    <div class="mb-3">
                        <label for="github_url" class="form-label text-light">GitHub URL</label>
                        <input type="url" class="form-control" id="github_url" name="github_url" placeholder="https://github.com/">
                    </div>
                    <div class="modal-footer border-top border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Add Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content glass">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title neon-text" id="editProjectModalLabel">Edit Project</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProjectForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_project_id" name="project_id">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label text-light">Project Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label text-light">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_technologies" class="form-label text-light">Technologies Used</label>
                        <input type="text" class="form-control" id="edit_technologies" name="technologies" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category" class="form-label text-light">Category</label>
                        <select class="form-control" id="edit_category" name="category" required>
                            <option value="web">Web Development</option>
                            <option value="mobile">Mobile Development</option>
                            <option value="design">Design</option>
                            <option value="desktop">Desktop Application</option>
                            <option value="game">Game Development</option>
                            <option value="ai">AI/ML</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_project_image" class="form-label text-light">Project Image</label>
                        <input type="file" class="form-control" id="edit_project_image" name="project_image" accept="image/*">
                        <div class="mt-2">
                            <img id="edit_image_preview" src="" alt="Current Project Image" class="img-fluid rounded" style="max-height: 180px; display: none;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_project_url" class="form-label text-light">Project URL</label>
                        <input type="url" class="form-control" id="edit_project_url" name="project_url">
                    </div>
                    <div class="mb-3">
                        <label for="edit_github_url" class="form-label text-light">GitHub URL</label>
                        <input type="url" class="form-control" id="edit_github_url" name="github_url">
                    </div>
                    <div class="modal-footer border-top border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Save Changes</button>
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
    .table th, .table td {
        background: transparent;
        color: var(--text-primary);
        border-color: var(--glass-border);
    }
    .table th {
        font-weight: 700;
        letter-spacing: 1px;
    }
</style>
@endpush

@push('scripts')
<script>
    function editProject(id) {
        // Fetch project data via AJAX and populate the edit form
        fetch(`/admin/projects/${id}`)
            .then(response => response.json())
            .then(project => {
                document.getElementById('edit_project_id').value = project.id;
                document.getElementById('edit_title').value = project.title;
                document.getElementById('edit_description').value = project.description;
                document.getElementById('edit_technologies').value = Array.isArray(project.technologies) ? project.technologies.join(', ') : project.technologies;
                document.getElementById('edit_project_url').value = project.project_url || '';
                document.getElementById('edit_github_url').value = project.github_url || '';
                document.getElementById('edit_category').value = project.category || '';
                if (project.image) {
                    document.getElementById('edit_image_preview').src = `/storage/${project.image}`;
                    document.getElementById('edit_image_preview').style.display = 'block';
                } else {
                    document.getElementById('edit_image_preview').style.display = 'none';
                }
                document.getElementById('editProjectForm').action = `/admin/projects/${id}`;
                var editModal = new bootstrap.Modal(document.getElementById('editProjectModal'));
                editModal.show();
            });
    }
    function deleteProject(id) {
        if (confirm('Are you sure you want to delete this project?')) {
            fetch(`/admin/projects/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    // Remove the row from the table
                    const row = document.querySelector(`button[onclick="deleteProject(${id})"]`).closest('tr');
                    if (row) row.remove();
                } else {
                    showToast('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred while deleting the project.', 'error');
            });
        }
    }
    // Form submission handling
    document.getElementById('addProjectForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('addProjectModal')).hide();
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the project.');
        });
    });
    document.getElementById('edit_project_image').addEventListener('change', function(e) {
        const [file] = this.files;
        if (file) {
            document.getElementById('edit_image_preview').src = URL.createObjectURL(file);
            document.getElementById('edit_image_preview').style.display = 'block';
        }
    });
    document.getElementById('editProjectForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('editProjectModal')).hide();
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the project.');
        });
    });
</script>
@endpush 