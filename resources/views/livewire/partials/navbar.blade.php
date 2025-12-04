    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>
            @if(request()->routeIs('admin.dashboard'))
                Dashboard
            @elseif(request()->routeIs('admin.user.dashboard'))
                User Management
            @elseif(request()->routeIs('admin.member.dashboard'))
                Data Member
            @elseif(request()->routeIs('admin.category.dashboard'))
                Category
            @elseif(request()->routeIs('admin.book.dashboard'))
                Book Management
            @elseif(request()->routeIs('admin.borrowing.dashboard'))
                Borrowing Data
            @elseif(request()->routeIs('admin.fines.dashboard'))
                Fines Data
            @else
                Admin Panel
            @endif
        </h3>
    </div>
