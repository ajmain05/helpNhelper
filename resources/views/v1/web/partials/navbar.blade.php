<nav class="header-menu navbar navbar-expand-xl  navbar-dark">
    <a class="nav-brand nav_logo_link" href="{{ route('home') }}"><img class="nav_logo"
            src="{{ asset('web-assets/logo.jpeg') }}" alt="Logo"></a>
    <button class="navbar-toggler mr-3" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link text-white" href="{{ route('home') }}">Home </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('current-campaigns') }}">Current Campaigns</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('about-us') }}">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('faq') }}">FAQ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('success-stories') }}">Success Stories</a>
            </li>
        </ul>
        @if (!Auth::user())
            <a class="nav-link text-white nav_item_donate" href="{{ url('/current-campaigns') }}">Donate</a>
        @endif
        @if (Auth::user())
            <div class="dropdown ml-3 mr-5">
                <button class="btn bg-transparent dropdown-toggle text-white" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{-- <i class="far fa-user"></i> --}}
                    <img src="{{ asset('web-assets/profile.png') }}" alt="logo" srcset="" height="33px">
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ url('profile') }}">Profile</a>
                    @if ((Auth::user()->type == 'seeker' || Auth::user()->type == 'organization') && Auth::user()->status === 'approved')
                        <a class="dropdown-item" href="{{ url('fund-request') }}">Fund Request</a>
                    @endif
                    <a class="dropdown-item" href="{{ url('history') }}"><span
                            class="text-uppercase">{{ Auth::user()?->type }}</span> History</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </div>
            </div>
            {{-- <a type="button" href="{{ url('profile') }}" class="btn bg-white mr-3 sign-up"><b>Profile</b></a>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-danger mr-3 sign-up"><b>Logout</b></button>
    </form> --}}
        @else
            <button class="btn bg-white ml-3 mr-3 sign-up nav_btn_sign_up" data-toggle="modal"
                data-target="#loginModal"><b>Sign In</b></button>
        @endif
    </div>
</nav>
