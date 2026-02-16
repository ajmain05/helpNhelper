<nav class="header navbar navbar-expand-lg  navbar-light justify-content-between">
    <a class="nav-link text-white" href="{{route('fund-request')}}">{{ __('Post A Fund Request') }}</a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link text-white text dropdown-toggle" data-toggle="dropdown" href="#">
                @php
                    $currentLocale = session('locale', config('app.locale'));
                    $currentLanguage = \App\Models\Language::where('code', $currentLocale)->first();
                    echo $currentLanguage ? $currentLanguage->name : __('Select Language');
                @endphp
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @php
                    $languages = \App\Models\Language::where('status', true)->get();
                @endphp
                @foreach($languages as $language)
                    <a href="{{ request()->fullUrlWithQuery(['lang' => $language->code]) }}" class="dropdown-item">
                        {{ $language->name }}
                    </a>
                @endforeach
            </div>
        </li>
    </ul>
</nav>
