            <div class="main-menu">
                <!-- Brand Logo -->
                <div class="logo-box">
                    <a class='logo-light' href="{{ route('dashboard') }}">
                        {{ config('app.name') }}
                    </a>

                    <a class='logo-dark' href="{{ route('dashboard') }}">
                        {{ config('app.name') }}
                    </a>
                </div>
                <!--- Menu -->
                <div data-simplebar>
                    <ul class="app-menu">

                        <li class="menu-title">Menu</li>

                        @can('view_dashboard')
                            <li class="menu-item">
                                <a class='menu-link waves-effect' href="{{ route('dashboard') }}">
                                    <span class="menu-icon"><i data-lucide="airplay "></i></span>
                                    <span class="menu-text"> Overview </span>
                                </a>
                            </li>
                        @endcan

                        @canany(['templates.create', 'templates.view', 'templates.update', 'templates.delete'])
                            <li class="menu-item">
                                <a class='menu-link waves-effect' href="{{ route('templates.index') }}">
                                    <span class="menu-icon"><i data-lucide="user"></i></span>
                                    <span class="menu-text"> Templates </span>
                                </a>
                            </li>
                        @endcanany

                        @canany(['users.create', 'users.view', 'users.update', 'users.delete'])
                            <li class="menu-item">
                                <a class='menu-link waves-effect' href="{{ route('users.index') }}">
                                    <span class="menu-icon"><i data-lucide="user "></i></span>
                                    <span class="menu-text"> Users </span>
                                </a>
                            </li>
                        @endcanany

                        <li class="menu-item">
                            <a class='menu-link waves-effect' href="{{ route('notifications') }}">
                                <span class="menu-icon"><i data-lucide="bell"></i></span>
                                <span class="menu-text"> Notifications </span>
                            </a>
                        </li>

                        @canany(['roles.update', 'roles.view', 'roles.delete', 'roles.create', 'work_flow.create',
                            'work_flow.view', 'work_flow.update', 'work_flow.delete', 'validation_rules.create',
                            'validation_rules.view', 'validation_rules.update', 'validation_rules.delete',
                            'view_system_logs'])
                            <li class="menu-item">
                                <a href="#menuExtendedui" data-bs-toggle="collapse" class="menu-link waves-effect">
                                    <span class="menu-icon"><i data-lucide="cog"></i></span>
                                    <span class="menu-text"> Settings </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="menuExtendedui">
                                    <ul class="sub-menu">

                                        @canany(['work_flow.create', 'work_flow.view', 'work_flow.update',
                                            'work_flow.delete'])
                                            <li class="menu-item">
                                                <a class='menu-link' href="{{ route('workflows.index') }}">
                                                    <span class="menu-text">WorkFlows</span>
                                                </a>
                                            </li>
                                        @endcanany
                                        @canany(['validation_rules.create', 'validation_rules.view',
                                            'validation_rules.update', 'validation_rules.delete'])
                                            <li class="menu-item">
                                                <a class='menu-link' href="{{ route('vr.index') }}">
                                                    <span class="menu-text">Validation Rules</span>
                                                </a>
                                            </li>
                                        @endcanany
                                        @can('view_system_logs')
                                            <li class="menu-item">
                                                <a class='menu-link' href="{{ route(name: 'system-logs') }}">
                                                    <span class="menu-text">System Logs</span>
                                                </a>
                                            </li>
                                        @endcan
                                        @canany(['roles.update', 'roles.view', 'roles.delete', 'roles.create'])
                                            <li class="menu-item">
                                                <a class='menu-link' href="{{ route(name: 'roles') }}">
                                                    <span class="menu-text">Roles</span>
                                                </a>
                                            </li>
                                        @endcanany
                                    </ul>
                                </div>
                            </li>
                        @endcanany
                    </ul>
                </div>
            </div>
