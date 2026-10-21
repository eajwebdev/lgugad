<div class="col-lg-2">
    <div class="card card-gray card-outline">
        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                    <a href="{{ route('pwdRead') }}" class="nav-link p-2  m-1 submenu {{ request()->is('pwd/*') ? 'active1' : '' }}">
                        <i class="fas fa-list"></i> PWD Record
                    </a>
                </li>
            </ul>                        
        </div>
    </div>
</div>