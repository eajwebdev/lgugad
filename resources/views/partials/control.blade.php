@php
    $user = auth()->user();

    // [label, route name, URL pattern for the active state, module flag, icon]
    $tabs = [
        ['Dashboard', 'dashboard', 'dashboard*', null, 'fa-table-cells-large'],
        ['FACED', 'dafacRead', 'faced*', 'dafac', 'fa-house-user'],
        ['PWD', 'pwdRead', 'pwd*', 'pwd', 'fa-wheelchair'],
        ['Solo parents', 'soloparentRead', 'soloparent*', 'soloparent', 'fa-people-roof'],
        ['Senior citizens', 'citizenRead', 'senior*', 'senior', 'fa-person-cane'],
        ['VAWC', 'vawcRead', 'vawc*', 'vawc', 'fa-shield-heart'],
    ];

    if ($user->canAccessModule('admin')) {
        $tabs[] = ['Users', 'userRead', 'user*', 'admin', 'fa-user-group'];
    }
@endphp

<nav class="gad-tabs" id="moduleNav" aria-label="Modules">
    @foreach ($tabs as [$label, $routeName, $pattern, $module, $icon])
        @if ($module === null || $user->canAccessModule($module))
            <a href="{{ route($routeName) }}"
               class="gad-tab {{ request()->is($pattern) ? 'is-active' : '' }}"
               @if (request()->is($pattern)) aria-current="page" @endif>
                <i class="fas {{ $icon }} gad-tab__icon" aria-hidden="true"></i><span>{{ $label }}</span>
            </a>
        @else
            <span class="gad-tab is-locked" aria-disabled="true" title="Your account doesn't have access to {{ $label }}">
                <i class="fas {{ $icon }} gad-tab__icon" aria-hidden="true"></i><span>{{ $label }}</span><i class="fas fa-lock gad-tab__lock" aria-hidden="true"></i>
            </span>
        @endif
    @endforeach
</nav>
