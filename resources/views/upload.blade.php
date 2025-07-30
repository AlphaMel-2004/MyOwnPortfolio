@extends('layouts.app')

@section('title', 'Upload Files')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-light bg-dark text-light">
                <div class="card-header bg-dark border-light">
                    <h4 class="mb-0">Upload Files</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Current Profile Picture -->
                    <div class="mb-4">
                        <h5 class="text-info">Current Profile Picture</h5>
                        @if($profileImage)
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $profileImage->path) }}" 
                                     alt="Profile Picture" 
                                     class="rounded-circle shadow-lg border border-3 border-light" 
                                     style="width: 200px; height: 200px; object-fit: cover;">
                            </div>
                        @else
                            <p class="text-muted">No profile picture uploaded yet.</p>
                        @endif
                    </div>

                    <!-- Current Certificates -->
                    <div class="mb-4">
                        <h5 class="text-info">Current Certificates</h5>
                        @if($certificates->count() > 0)
                            <div class="row">
                                @foreach($certificates as $certificate)
                                    <div class="col-md-4 mb-3">
                                        <div class="card bg-dark border-light">
                                            <div class="card-body text-center">
                                                @if(pathinfo($certificate->filename, PATHINFO_EXTENSION) === 'pdf')
                                                    <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                                @else
                                                    <img src="{{ asset('storage/' . $certificate->path) }}" 
                                                         alt="{{ $certificate->filename }}" 
                                                         class="img-fluid rounded">
                                                @endif
                                                <p class="mt-2 mb-0 text-truncate">{{ $certificate->filename }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No certificates uploaded yet.</p>
                        @endif
                    </div>

                    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Profile Picture Upload -->
                        <div class="mb-4">
                            <label for="profile_picture" class="form-label text-info">
                                <i class="fas fa-user-circle me-2"></i>Profile Picture
                            </label>
                            <input type="file" 
                                   class="form-control bg-dark text-light border-light @error('profile_picture') is-invalid @enderror" 
                                   id="profile_picture" 
                                   name="profile_picture" 
                                   accept="image/jpeg,image/png">
                            <div class="form-text text-light">Max size: 2MB. Allowed formats: JPEG, PNG</div>
                            @error('profile_picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Certificates Upload -->
                        <div class="mb-4">
                            <label for="certificates" class="form-label text-info">
                                <i class="fas fa-certificate me-2"></i>Certificates
                            </label>
                            <input type="file" 
                                   class="form-control bg-dark text-light border-light @error('certificates.*') is-invalid @enderror" 
                                   id="certificates" 
                                   name="certificates[]" 
                                   multiple 
                                   accept="image/jpeg,image/png,image/jpg,application/pdf">
                            <div class="form-text text-light">Max size per file: 4MB. Allowed formats: JPEG, PNG, JPG, PDF</div>
                            @error('certificates.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-upload me-2"></i>Upload Files
                            </button>
                        </div>
                    </form>
                </div>
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
</style>
@endpush

@push('scripts')
<script>
    // Form validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endpush
@endsection
