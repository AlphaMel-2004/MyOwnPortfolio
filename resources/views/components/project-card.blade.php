<div class="project-card ai-home-card" 
     data-category="{{ $project->category }}" 
     data-date="{{ $project->created_at }}"
     data-aos="fade-up"
     role="article" aria-labelledby="project-title-{{ $project->id }}">
    <div class="project-image">
        @if(isset($project->images[0]))
            <img src="{{ Storage::url($project->images[0]) }}" 
                 alt="{{ $project->title }}"
                 loading="lazy">
        @else
            <div class="project-placeholder" role="img" aria-label="No image available for {{ $project->title }}">
                <i class="fas fa-code" aria-hidden="true"></i>
                <span>{{ $project->title }}</span>
            </div>
        @endif
        <div class="project-overlay">
            <div class="project-actions">
                <button class="action-btn view-btn" data-project="{{ $project->id }}" title="View Details" aria-label="View details for {{ $project->title }}">
                    <i class="fas fa-eye" aria-hidden="true"></i>
                </button>
                @if($project->demo_url)
                    <a href="{{ $project->demo_url }}" class="action-btn" target="_blank" title="Live Demo" aria-label="View live demo for {{ $project->title }}">
                        <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                    </a>
                @endif
                @if($project->source_url)
                    <a href="{{ $project->source_url }}" class="action-btn" target="_blank" title="Source Code" aria-label="View source code for {{ $project->title }}">
                        <i class="fab fa-github" aria-hidden="true"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="project-content">
        <div class="project-header d-flex justify-content-between align-items-center mb-2">
            <h3 id="project-title-{{ $project->id }}" class="project-title ai-title mb-0">{{ $project->title }}</h3>
            <span class="project-category" aria-label="Project category: {{ $project->category }}">
                <i class="fas fa-tag" aria-hidden="true"></i>
                {{ ucfirst($project->category) }}
            </span>
        </div>
        <p class="project-description ai-desc mb-2">{{ Str::limit($project->description, 100) }}</p>
        <div class="project-tech d-flex flex-wrap gap-2 mb-2" role="list" aria-label="Technologies used">
            @foreach($project->technologies as $tech)
                <span class="tech-badge" title="{{ $tech }}" role="listitem" aria-label="Technology: {{ $tech }}">
                    <i class="fab fa-{{ strtolower($tech) }}" aria-hidden="true"></i>
                    {{ $tech }}
                </span>
            @endforeach
        </div>
        <div class="project-footer d-flex justify-content-between align-items-center mt-2">
            <span class="project-date" aria-label="Created: {{ $project->created_at->diffForHumans() }}">
                <i class="fas fa-clock" aria-hidden="true"></i>
                {{ $project->created_at->diffForHumans() }}
            </span>
            <div class="project-actions d-flex gap-2">
                <button class="edit-btn" data-project="{{ $project->id }}" title="Edit Project" aria-label="Edit project {{ $project->title }}">
                    <i class="fas fa-edit" aria-hidden="true"></i>
                </button>
                <button class="delete-btn" data-project="{{ $project->id }}" title="Delete Project" aria-label="Delete project {{ $project->title }}">
                    <i class="fas fa-trash" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@push('styles')
<style>
.project-card.ai-home-card {
    background: rgba(30, 40, 60, 0.92);
    border: 1.5px solid rgba(0,242,254,0.10);
    box-shadow: 0 2px 16px 0 rgba(0,0,0,0.18);
    color: #eaf6fb;
    transition: box-shadow 0.3s, border-color 0.3s, background 0.3s;
    margin-bottom: 1.5rem;
    border-radius: 16px;
    overflow: hidden;
}
.project-card.ai-home-card:hover {
    border-color: #00f2fe;
    box-shadow: 0 0 24px 2px #00f2fe, 0 2px 16px 0 rgba(0,0,0,0.22);
    background: rgba(30, 40, 60, 0.98);
}
.project-title.ai-title {
    color: #eaf6fb;
    font-size: 1.25rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-shadow: 0 1px 4px rgba(0,0,0,0.18);
}
.project-description.ai-desc {
    color: #cbe8f7;
    font-size: 1.02rem;
    line-height: 1.5;
    font-weight: 500;
    text-shadow: 0 1px 2px rgba(0,0,0,0.12);
}
.tech-badge {
    background: rgba(0,242,254,0.08);
    color: #00f2fe;
    border-radius: 8px;
    padding: 0.2rem 0.7rem;
    font-size: 0.95rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}
.project-category {
    color: #00f2fe;
    font-size: 0.98rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}
.project-date {
    color: #b0eaff;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}
.project-actions .edit-btn, .project-actions .delete-btn, .action-btn {
    background: transparent;
    border: none;
    color: #00f2fe;
    font-size: 1.1rem;
    padding: 0.2rem 0.5rem;
    border-radius: 6px;
    transition: background 0.2s, color 0.2s;
}
.project-actions .edit-btn:hover, .project-actions .delete-btn:hover, .action-btn:hover {
    background: rgba(0,242,254,0.12);
    color: #fff;
}
</style>
@endpush 