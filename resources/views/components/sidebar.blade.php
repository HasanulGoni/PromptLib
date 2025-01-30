<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>PromptLib</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ Auth::user()->name
                    }}</h6>
                <span>{{ Auth::user()->role }}</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('dashboard')}}" class="nav-item nav-link {{ request()->is('dashboard') ? 'active':'' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.categories.index') }}" class="nav-item nav-link {{ request()->is('admin/categories*') ? 'active':'' }}"><i class="fa fa-table me-2"></i>Category</a>
                <a href="{{ route('admin.tags.index') }}" class="nav-item nav-link {{ request()->is('admin/tags*') ? 'active':'' }}"><i class="fa fa-tags me-2"></i>Tag</a>
                <a href="{{ route('admin.users.index') }}" class="nav-item nav-link {{ request()->is('admin/users*') ? 'active':'' }}"><i class="fa fa-id-card me-2"></i>User</a>
                <a href="{{ route('admin.prompts.index') }}" class="nav-item nav-link {{ request()->is('admin/prompts*') ? 'active':'' }}"><i class="fa fa-edit me-2"></i>Prompts</a>
            @endif

            <a href="{{ route('prompts.search') }}" class="nav-item nav-link {{ request()->is('prompts/search*') ? 'active':'' }}"><i class="fa fa-search me-2"></i>Prompt Search</a>
            <a href="{{ route('prompts.savedPrompt') }}" class="nav-item nav-link {{ request()->is('prompts/savedPrompt*') ? 'active':'' }}"><i class="fa fa-heart me-2"></i>Saved Prompt</a>
            <a href="{{ route('prompts.reportedPrompt') }}" class="nav-item nav-link {{ request()->is('prompts/reportedPrompt*') ? 'active':'' }}"><i class="fa fa-flag me-2"></i>Reported Prompt</a>

           
        </div>
    </nav>
</div>
