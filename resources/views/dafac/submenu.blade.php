<aside class="col-lg-2 dafac-side" aria-label="FACED navigation">
    <div class="dafac-side__panel">
        <p class="dafac-side__eyebrow">FACED workspace</p>
        <h2 class="dafac-side__title">Family assistance</h2>
        <nav class="dafac-side__links" aria-label="Family assistance sections">
            <a href="{{ route('dafacRead') }}" class="dafac-side__link {{ request()->is('faced') || request()->is('faced/') || request()->is('faced/edit/*') || request()->is('faced/form') ? 'is-active' : '' }}" @if(request()->is('faced') || request()->is('faced/') || request()->is('faced/edit/*') || request()->is('faced/form')) aria-current="page" @endif>
                <i class="fas fa-folder-open" aria-hidden="true"></i><span>Family records</span>
            </a>
            <a href="{{ route('assRead') }}" class="dafac-side__link {{ request()->is('faced/assistance*') ? 'is-active' : '' }}" @if(request()->is('faced/assistance*')) aria-current="page" @endif>
                <i class="fas fa-hand-holding-heart" aria-hidden="true"></i><span>Assistance</span>
            </a>
        </nav>
    </div>
</aside>
