
@php
    use Spatie\Multitenancy\Models\Tenant;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;

    $tenant = Tenant::current();

    // Default empty module set
    $tenantModules = collect();

    // Only Admin should load module-based menus
    if ($tenant && Auth::guard('school')->check() && Auth::guard('school')->user()) {
        $central = config('database.connections.kawacherp') ? 'kawacherp' : 'mysql';

        $tenantModules = DB::connection($central)
            ->table('school_modules')
            ->join('modules', 'modules.id', '=', 'school_modules.module_id')
            ->where('school_modules.school_id', $tenant->id)
            ->get();
    }
@endphp


<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- ========================= ADMIN DASHBOARD ========================= --}}
        @role('Admin', 'school')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('school.dashboard') }}">
                    <i class="typcn typcn-device-desktop menu-icon"></i>
                    <span class="menu-title">Admin Dashboard</span>
                </a>
            </li>
        @endrole


        {{-- ========================= TEACHER DASHBOARD ========================= --}}
        @role('Teacher', 'teacher')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tenant.teacher.teacher-index') }}">
                    <i class="typcn typcn-user-add-outline menu-icon"></i>
                    <span class="menu-title">Teacher Dashboard</span>
                </a>
            </li>
        @endrole


        {{-- ========================= STUDENT DASHBOARD ========================= --}}
        @role('Student', 'student')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tenant.student.student-index') }}">
                    <i class="typcn typcn-group outline menu-icon"></i>
                    <span class="menu-title">Student Dashboard</span>
                </a>
            </li>
        @endrole


        {{-- ========================= ADMIN ONLY – Dynamic Module Menus ========================= --}}
        @role('Admin', 'school')
            @foreach($tenantModules as $module)
                @php
                    $menuFile = base_path("Modules/{$module->name}/module.json");

                    if (!file_exists($menuFile)) continue;

                    $config = json_decode(file_get_contents($menuFile), true);

                    if (!$config || !isset($config['menu'])) continue;
                @endphp

                @foreach($config['menu'] as $menu)
                    @php
                        $collapseId = $menu['collapse_id'] ?? Str::slug($menu['title']);
                        $isActiveMenu = false;
                        $isExpanded = false;

                        foreach($menu['submenus'] as $sub) {
                            if (request()->routeIs($sub['route'])) {
                                $isActiveMenu = true;
                                $isExpanded = true;
                                break;
                            }
                        }
                    @endphp

                    <li class="nav-item {{ $isActiveMenu ? 'active' : '' }}">
                        <a class="nav-link"
                           data-toggle="collapse"
                           href="#{{ $collapseId }}"
                           aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
                           aria-controls="{{ $collapseId }}">
                            <i class="{{ $menu['icon'] ?? 'typcn typcn-folder' }} menu-icon"></i>
                            <span class="menu-title">{{ $menu['title'] }}</span>
                            <i class="menu-arrow"></i>
                        </a>

                        <div class="collapse {{ $isExpanded ? 'show' : '' }}" id="{{ $collapseId }}">
                            <ul class="nav flex-column sub-menu">
                                @foreach($menu['submenus'] as $sub)
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs($sub['route']) ? 'active' : '' }}"
                                           href="{{ route($sub['route']) }}">
                                            {{ $sub['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endforeach
            @endforeach
        @endrole


        {{-- ========================= SETTINGS — ADMIN ONLY ========================= --}}
        @role('Admin', 'school')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#settingsMenu">
                    <i class="typcn typcn-document-text menu-icon"></i>
                    <span class="menu-title">Settings</span>
                    <i class="menu-arrow"></i>
                </a>

                <div class="collapse" id="settingsMenu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('school.modules.index') }}">Install Modules</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Manage Roles</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endrole

    </ul>
</nav>
