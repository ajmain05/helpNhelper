@php
    $pendingCounts = App\Models\User::selectRaw('type, COUNT(*) as total')
        ->where('status', 'pending')
        ->whereIn('type', ['donor', 'corporate-donor', 'volunteer', 'seeker', 'organization'])
        ->groupBy('type')
        ->pluck('total', 'type');

    $pendingDonor = ($pendingCounts['donor'] ?? 0) + ($pendingCounts['corporate-donor'] ?? 0);
    $pendingVolunteer = $pendingCounts['volunteer'] ?? 0;
    $pendingSeeker = $pendingCounts['seeker'] ?? 0;
    $pendingOrganization = $pendingCounts['organization'] ?? 0;
@endphp
<aside class="admin-sidebar main-sidebar sidebar-light-olive elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link bg-olive d-flex justify-content-center">
        <img src="{{ asset('web-assets/css/logo.png') }}" alt="Logo" class="" style="width: 70%;">
        {{--    <span class="brand-text font-weight-light">Admin Panel</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('admin-assets/dist/img/avatar5.png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.user.edit', Auth::id()) }}" class="d-block">
                    {{ Auth::user()->name }}
                    <br>
                    <small>{{ Auth::user()->email }}</small>
                </a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                @can('admin-dashboard')
                    <li class="nav-item">
                        <a href="{{ route('admin.home') }}"
                            class="nav-link @if (str_contains(URL::current(), route('admin.home'))) active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endcan
                @can('all-donor')
                    <li class="nav-item @if (str_contains(URL::current(), 'admin/donors') || str_contains(URL::current(), 'admin/corporate-donors') || str_contains(URL::current(), 'admin/user-requests/donors')) menu-open @endif">
                        <a href="#" class="nav-link @if (str_contains(URL::current(), 'admin/donors') || str_contains(URL::current(), 'admin/corporate-donors') || str_contains(URL::current(), 'admin/user-requests/donors')) active @endif">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                Donor Information
                                <span class="badge badge-pill badge-danger">{{ $pendingDonor ?? 0 }}</span>
                            </p>
                            <i class="right fas fa-angle-left "></i>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('all-user-request')
                                <li class="nav-item">
                                    <a href="{{ route('admin.user-requests.index', 'donors') }}"
                                        class="nav-link @if (str_contains(URL::current(), 'admin/user-requests/donors')) active @endif">
                                        @if (str_contains(URL::current(), 'admin/user-requests/donors'))
                                            <i class="far fa-dot-circle nav-icon"></i>
                                        @else
                                            <i class="far fa-circle nav-icon"></i>
                                        @endif
                                        <p>Donor Requests</p>
                                    </a>
                                </li>
                            @endcan
                            {{-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Donor Categories</p>
                            </a>
                        </li> --}}
                            <li class="nav-item">
                                <a href="{{ route('admin.donors.index') }}"
                                    class="nav-link @if (str_contains(URL::current(), 'admin/donors') && !str_contains(URL::current(), 'admin/corporate-donors')) active @endif">
                                    @if (str_contains(URL::current(), 'admin/donors') && !str_contains(URL::current(), 'admin/corporate-donors'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Donor List</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.corporate-donors.index') }}"
                                    class="nav-link @if (str_contains(URL::current(), 'admin/corporate-donors')) active @endif">
                                    @if (str_contains(URL::current(), 'admin/corporate-donors'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Corporate Donors</p>
                                </a>
                            </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Donations</p>
                            </a>
                        </li> --}}
                        </ul>
                    </li>
                @endcan
                @can('all-volunteer')
                    <li class="nav-item @if (str_contains(URL::current(), 'admin/volunteers') || str_contains(URL::current(), 'admin/user-requests/volunteers')) menu-open @endif">
                        <a href="#" class="nav-link @if (str_contains(URL::current(), 'admin/volunteers') || str_contains(URL::current(), 'admin/user-requests/volunteers')) active @endif">
                            <i class="nav-icon fas fa-user-nurse"></i>
                            <p>Volunteer Information
                                <span class="badge badge-pill badge-danger">{{ $pendingVolunteer ?? 0 }}</span>
                            </p>
                            <i class="right fas fa-angle-left "></i>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('all-user-request')
                                <li class="nav-item">
                                    <a href="{{ route('admin.user-requests.index', 'volunteers') }}"
                                        class="nav-link @if (str_contains(URL::current(), 'admin/user-requests/volunteers')) active @endif">
                                        @if (str_contains(URL::current(), 'admin/user-requests/volunteers'))
                                            <i class="far fa-dot-circle nav-icon"></i>
                                        @else
                                            <i class="far fa-circle nav-icon"></i>
                                        @endif
                                        <p>Volunteers Requests</p>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('admin.volunteers.index') }}"
                                    class="nav-link @if (str_contains(URL::current(), 'admin/volunteers')) active @endif">
                                    @if (str_contains(URL::current(), 'admin/volunteers'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Volunteers List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('all-seeker')
                    <li class="nav-item @if (str_contains(URL::current(), 'admin/seekers') ||
                            str_contains(URL::current(), 'admin/user-requests/seekers') ||
                            str_contains(URL::current(), 'admin/seeker-application')) menu-open @endif">
                        <a href="#" class="nav-link @if (str_contains(URL::current(), 'admin/seekers') ||
                                str_contains(URL::current(), 'admin/seeker-application') ||
                                str_contains(URL::current(), 'admin/user-requests/seekers')) active @endif">
                            <i class="nav-icon fas fa-hand-holding-heart"></i>
                            <p>
                                Seeker Information
                                <span class="badge badge-pill badge-danger">{{ $pendingSeeker ?? 0 }}</span>
                            </p>
                            <i class="right fas fa-angle-left "></i>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('all-user-request')
                                <li class="nav-item">
                                    <a href="{{ route('admin.user-requests.index', 'seekers') }}"
                                        class="nav-link @if (str_contains(URL::current(), 'admin/user-requests/seekers')) active @endif">
                                        @if (str_contains(URL::current(), 'admin/user-requests/seekers'))
                                            <i class="far fa-dot-circle nav-icon"></i>
                                        @else
                                            <i class="far fa-circle nav-icon"></i>
                                        @endif
                                        <p>Seekers Requests</p>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('admin.seekers.index') }}"
                                    class="nav-link @if (str_contains(URL::current(), 'admin/seekers')) active @endif">
                                    @if (str_contains(URL::current(), 'admin/seekers'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Seekers List</p>
                                </a>
                            </li>
                            @can('all-seeker-application')
                                <li class="nav-item">
                                    <a href="{{ route('admin.seeker-applications.index') }}"
                                        class="nav-link @if (str_contains(URL::current(), 'admin/seeker-application')) active @endif">
                                        @if (str_contains(URL::current(), 'admin/seeker-application'))
                                            <i class="far fa-dot-circle nav-icon"></i>
                                        @else
                                            <i class="far fa-circle nav-icon"></i>
                                        @endif
                                        <p>Seeker Applications</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('all-organization')
                    <li class="nav-item @if (str_contains(URL::current(), 'admin/organizations') ||
                            str_contains(URL::current(), 'admin/user-requests/organizations') ||
                            str_contains(URL::current(), 'admin/organization-application')) menu-open @endif">
                        <a href="#" class="nav-link @if (str_contains(URL::current(), 'admin/organizations') ||
                                str_contains(URL::current(), 'admin/organization-application') ||
                                str_contains(URL::current(), 'admin/user-requests/organizations')) active @endif">
                            <i class="nav-icon fas fa-hand-holding-heart"></i>
                            <p>
                                Organization Info
                                <span class="badge badge-pill badge-danger">{{ $pendingOrganization ?? 0 }}</span>
                            </p>
                            <i class="right fas fa-angle-left "></i>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('all-user-request')
                                <li class="nav-item">
                                    <a href="{{ route('admin.user-requests.index', 'organizations') }}"
                                        class="nav-link @if (str_contains(URL::current(), 'admin/user-requests/organizations')) active @endif">
                                        @if (str_contains(URL::current(), 'admin/user-requests/organizations'))
                                            <i class="far fa-dot-circle nav-icon"></i>
                                        @else
                                            <i class="far fa-circle nav-icon"></i>
                                        @endif
                                        <p>Organizations Requests</p>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('admin.organizations.index') }}"
                                    class="nav-link @if (str_contains(URL::current(), 'admin/organizations')) active @endif">
                                    @if (str_contains(URL::current(), 'admin/organizations'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Organizations List</p>
                                </a>
                            </li>
                            @can('all-organization-application')
                                <li class="nav-item">
                                    <a href="{{ route('admin.organization-applications.index') }}"
                                        class="nav-link @if (str_contains(URL::current(), 'admin/organization-application')) active @endif">
                                        @if (str_contains(URL::current(), 'admin/organization-application'))
                                            <i class="far fa-dot-circle nav-icon"></i>
                                        @else
                                            <i class="far fa-circle nav-icon"></i>
                                        @endif
                                        <p>Organization Applications</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @if (Gate::check('all-campaign') || Gate::check('all-campaign-category'))
                    <li class="nav-item @if (str_contains(URL::current(), 'admin/campaign')) menu-open @endif">
                        <a href="#" class="nav-link @if (str_contains(URL::current(), 'admin/campaign')) active @endif">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>
                                Campaign Information
                            </p>
                            <i class="right fas fa-angle-left "></i>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('all-campaign-category')
                                <li class="nav-item">
                                    <a href="{{ route('admin.campaign-categories.index') }}"
                                        class="nav-link @if (str_contains(URL::current(), 'admin/campaign-categories')) active @endif">
                                        @if (str_contains(URL::current(), 'admin/campaign-categories'))
                                            <i class="far fa-dot-circle nav-icon"></i>
                                        @else
                                            <i class="far fa-circle nav-icon"></i>
                                        @endif
                                        <p>Campaign Categories</p>
                                    </a>
                                </li>
                            @endcan

                            @can('all-campaign')
                                <li class="nav-item">
                                    <a href="{{ route('admin.campaigns.index') }}"
                                        class="nav-link @if (str_contains(URL::current(), 'admin/campaigns')) active @endif">
                                        @if (str_contains(URL::current(), 'admin/campaigns'))
                                            <i class="far fa-dot-circle nav-icon"></i>
                                        @else
                                            <i class="far fa-circle nav-icon"></i>
                                        @endif
                                        <p>Campaign List</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('admin.success') }}"
                        class="nav-link @if (str_contains(URL::current(), route('admin.success'))) active @endif">
                        <i class=" nav-icon fas fa-check-square"></i>
                        <p>Success Story</p>
                    </a>
                </li>
                @can('all-account')
                    <li class="nav-item @if (str_contains(URL::current(), 'admin/bank') ||
                            str_contains(URL::current(), 'admin/bank-account') ||
                            str_contains(URL::current(), 'admin/transaction-mode') ||
                            str_contains(URL::current(), 'admin/transaction-category') ||
                            str_contains(URL::current(), 'admin/invoice/income') ||
                            str_contains(URL::current(), 'admin/invoice/expense')) menu-open @endif">
                        <a href="#" class="nav-link @if (str_contains(URL::current(), 'admin/bank') ||
                                str_contains(URL::current(), 'admin/bank-account') ||
                                str_contains(URL::current(), 'admin/transaction-mode') ||
                                str_contains(URL::current(), 'admin/transaction-category') ||
                                str_contains(URL::current(), 'admin/invoice/income') ||
                                str_contains(URL::current(), 'admin/invoice/expense')) active @endif">
                            <i class="nav-icon fas fa-user-nurse"></i>
                            <p>Finance</p>
                            <i class="right fas fa-angle-left "></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.bank') }}"
                                    class="nav-link {{ URL::current() }} @if (URL::current() === route('admin.bank')) active @endif">
                                    @if (URL::current() === route('admin.bank'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Banks</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.bank-account') }}"
                                    class="nav-link {{ URL::current() }}  @if (URL::current() === route('admin.bank-account')) active @endif">
                                    @if (URL::current() === route('admin.bank-account'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Bank Accounts</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.transaction-mode') }}"
                                    class="nav-link {{ URL::current() }}  @if (str_contains(URL::current(), 'admin/transaction-mode')) active @endif">
                                    @if (str_contains(URL::current(), 'admin/transaction-mode'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Transaction Mode</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.transaction-category') }}"
                                    class="nav-link {{ URL::current() }}  @if (str_contains(URL::current(), 'admin/transaction-category')) active @endif">
                                    @if (str_contains(URL::current(), 'admin/transaction-category'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Transaction Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.invoice-status') }}"
                                    class="nav-link {{ URL::current() }}  @if (str_contains(URL::current(), 'admin/invoice-status')) active @endif">
                                    @if (str_contains(URL::current(), 'admin/invoice-status'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Status</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.invoice.income') }}"
                                    class="nav-link @if (str_contains(URL::current(), 'admin/invoice/income')) active @endif">
                                    @if (str_contains(URL::current(), 'admin/income'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Income</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.invoice.expense') }}"
                                    class="nav-link @if (str_contains(URL::current(), 'admin/invoice/expense')) active @endif">
                                    @if (str_contains(URL::current(), 'admin/expense'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Expense</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.statement') }}"
                            class="nav-link @if (str_contains(URL::current(), 'admin/statement')) active @endif">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                            <p>Statement</p>
                        </a>
                    </li>
                @endcan
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.transaction-index') }}"
                        class="nav-link @if (str_contains(URL::current(), route('admin.transaction-index'))) active @endif">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>Transactions</p>
                    </a>
                </li> --}}
                
                <li class="nav-item @if (str_contains(URL::current(), 'admin/languages') || str_contains(URL::current(), 'admin/translations')) menu-open @endif">
                    <a href="#" class="nav-link @if (str_contains(URL::current(), 'admin/languages') || str_contains(URL::current(), 'admin/translations')) active @endif">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>
                            Localization
                        </p>
                        <i class="right fas fa-angle-left "></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.language.index') }}"
                                class="nav-link @if (str_contains(URL::current(), 'admin/languages')) active @endif">
                                @if (str_contains(URL::current(), 'admin/languages'))
                                    <i class="far fa-dot-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Languages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.translation.index') }}"
                                class="nav-link @if (str_contains(URL::current(), 'admin/translations')) active @endif">
                                @if (str_contains(URL::current(), 'admin/translations'))
                                    <i class="far fa-dot-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Translations</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item @if (str_contains(URL::current(), 'admin/contents/home') ||
                        str_contains(URL::current(), 'admin/faq') ||
                        str_contains(URL::current(), 'admin/contents/about-us')) menu-open @endif">
                    <a href="#" class="nav-link @if (str_contains(URL::current(), 'admin/contents/home') ||
                            str_contains(URL::current(), 'admin/faq') ||
                            str_contains(URL::current(), 'admin/contents/about-us')) active @endif">
                        <i class="nav-icon fas fa-window-restore"></i>
                        <p>
                            Website Contents
                        </p>
                        <i class="right fas fa-angle-left "></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/contents/home') }}"
                                class="nav-link @if (str_contains(URL::current(), 'admin/contents/home')) active @endif">
                                @if (str_contains(URL::current(), 'admin/contents/home'))
                                    <i class="far fa-dot-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Home</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/faq') }}"
                                class="nav-link @if (str_contains(URL::current(), 'admin/faq')) active @endif">
                                @if (str_contains(URL::current(), 'admin/faq'))
                                    <i class="far fa-dot-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>FAQ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/contents/about-us') }}"
                                class="nav-link @if (str_contains(URL::current(), 'admin/contents/about-us')) active @endif">
                                @if (str_contains(URL::current(), 'admin/contents/about-us'))
                                    <i class="far fa-dot-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>About Us</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contents.page-content.index', 'terms') }}"
                                class="nav-link @if (str_contains(URL::current(), 'admin/contents/page-content/terms')) active @endif">
                                @if (str_contains(URL::current(), 'admin/contents/page-content/terms'))
                                    <i class="far fa-dot-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Terms & Conditions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contents.page-content.index', 'cookies') }}"
                                class="nav-link @if (str_contains(URL::current(), 'admin/contents/page-content/cookies')) active @endif">
                                @if (str_contains(URL::current(), 'admin/contents/page-content/cookies'))
                                    <i class="far fa-dot-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Cookie Preferences</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contents.signup-tutorials.index') }}"
                                class="nav-link @if (str_contains(URL::current(), 'admin/contents/signup-tutorials')) active @endif">
                                @if (str_contains(URL::current(), 'admin/contents/signup-tutorials'))
                                    <i class="far fa-dot-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Signup Tutorials</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @can('all-user')
                    <li class="nav-item @if (str_contains(URL::current(), 'admin/user') && !str_contains(URL::current(), 'admin/user-requests')) menu-open @endif">
                        <a href="#" class="nav-link @if (str_contains(URL::current(), 'admin/user') && !str_contains(URL::current(), 'admin/user-requests')) active @endif">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                User Details
                            </p>
                            <i class="right fas fa-angle-left "></i>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('all-role')
                                <li class="nav-item">
                                    <a href="{{ route('admin.roles.index') }}"
                                        class="nav-link @if (str_contains(URL::current(), 'admin/user-roles')) active @endif">
                                        @if (str_contains(URL::current(), 'admin/user-roles'))
                                            <i class="far fa-dot-circle nav-icon"></i>
                                        @else
                                            <i class="far fa-circle nav-icon"></i>
                                        @endif
                                        <p>Roles</p>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link @if (str_contains(URL::current(), 'admin/users')) active @endif">
                                    @if (str_contains(URL::current(), 'admin/users'))
                                        <i class="far fa-dot-circle nav-icon"></i>
                                    @else
                                        <i class="far fa-circle nav-icon"></i>
                                    @endif
                                    <p>Users</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route('admin.rating-types') }}"
                        class="nav-link @if (str_contains(URL::current(), route('admin.rating-types'))) active @endif">
                        <i class="nav-icon fas fa-star"></i>
                        <p>Ratings</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
