<div class="bug-card">
    <div class="d-flex justify-content-between mb-2">
        <span class="badge badge-{{ strtolower($bug->priority) }}">
            {{ ucfirst($bug->priority) }}
        </span>
        <span class="badge badge-{{ str_replace(' ', '-', strtolower($bug->status)) }}">
            {{ ucfirst($bug->status) }}
        </span>
    </div>
    
    <h3 class="bug-card__title">{{ $bug->title }}</h3>
    
    <div class="bug-card__description">
        {{ Str::limit($bug->description, 100) }}
    </div>
    
    <div class="bug-card__meta">
        <div class="bug-card__meta-item">
            <i data-feather="user" class="feather-sm me-1"></i>
            {{ $bug->user->name }}
        </div>
        
        <div class="bug-card__meta-item">
            <i data-feather="clock" class="feather-sm me-1"></i>
            {{ $bug->created_at->diffForHumans() }}
        </div>
    </div>
    
    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('bugs.edit', $bug->id) }}" class="btn btn-warning btn-sm me-2">
            <i data-feather="edit-2" class="feather-sm"></i> Edit
        </a>
        
        <form action="{{ route('bugs.destroy', $bug->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" 
                    onclick="return confirm('Are you sure you want to delete this bug?')">
                <i data-feather="trash-2" class="feather-sm"></i> Delete
            </button>
        </form>
    </div>
</div>
