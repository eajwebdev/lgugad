<div class="workspace-header">
    <div class="workspace-header__top">
        <nav aria-label="Breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @if (!empty($backRoute))
                    <li class="breadcrumb-item"><a href="{{ route($backRoute) }}">{{ $module }} records</a></li>
                @else
                    <li class="breadcrumb-item" aria-current="page">{{ $module }} records</li>
                @endif
                @if (!empty($backRoute))<li class="breadcrumb-item" aria-current="page">{{ $title }}</li>@endif
            </ol>
        </nav>
        <div class="workspace-header__nav">
            @if (!empty($relatedRoute))
                <a href="{{ route($relatedRoute) }}" class="workspace-header__link"><i class="fas {{ $relatedIcon ?? 'fa-list' }}" aria-hidden="true"></i> {{ $relatedLabel }}</a>
            @endif
            <a href="{{ route($backRoute ?? 'dashboard') }}" class="workspace-header__back" aria-label="Back to {{ !empty($backRoute) ? $module . ' records' : 'dashboard' }}" title="Back"><i class="fas fa-arrow-left" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="workspace-header__title">
        <div>
            <span class="workspace-header__eyebrow">{{ $module }} workspace</span>
            <h1>{{ $title }}</h1>
            @if (!empty($description))<p>{{ $description }}</p>@endif
        </div>
        <div class="workspace-header__actions">
            @if (isset($count))<span class="workspace-header__count">{{ number_format($count) }} {{ $countLabel ?? 'records' }}</span>@endif
            @if (!empty($actionRoute))<a href="{{ route($actionRoute) }}" class="btn btn-primary workspace-header__primary"><i class="fas {{ $actionIcon ?? 'fa-plus' }}" aria-hidden="true"></i> {{ $actionLabel ?? 'Add new' }}</a>@endif
            @if (!empty($modalTarget))<button type="button" class="btn btn-primary workspace-header__primary" data-toggle="modal" data-target="{{ $modalTarget }}"><i class="fas {{ $actionIcon ?? 'fa-plus' }}" aria-hidden="true"></i> {{ $actionLabel ?? 'Add new' }}</button>@endif
        </div>
    </div>
</div>
