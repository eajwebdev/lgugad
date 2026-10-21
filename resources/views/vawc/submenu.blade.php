<div class="col-lg-2">
    <div class="card card-gray card-outline">
        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                    <a href="{{ route('vawcRead') }}" class="nav-link p-2  m-1 submenu {{ request()->is('vawc/vac') ||request()->is('vawc/vac/form') ? 'active1' : '' }}">
                        <i class="fas fa-list"></i> Violence Against Children
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="#" class="nav-link p-2  m-1 submenu {{ request()->is('vawc/assistance*') ? 'active1' : '' }}">
                        <i class="fas fa-hands-helping"></i> Violence Against Women
                    </a>
                </li>
            </ul>                        
        </div>
    </div>
</div>