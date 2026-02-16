<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('web-assets/icons/favicon.svg') }}" type="image/svg+xml">
    @if (isset($campaign->title) && isset($setCampaign))
        <meta property="og:title" content="{{ $campaign->title }}" />
        <meta property="twitter:title" content="{{ $campaign->title }}" />
    @else
        <meta property="og:title" content="Help N Helper" />
        <meta name="twitter:title" content="Help N Helper" />
    @endif
    @if (isset($campaign->photo) && isset($setCampaign))
        <meta property="og:image" content="{{ asset($campaign->photo) }}" />
        <meta property="twitter:image" content="{{ asset($campaign->photo) }}" />
    @else
        <meta property="og:image" content="{{ asset('web-assets/logo.jpeg') }}" />
        <meta name="twitter:image" content="{{ asset('web-assets/logo.jpeg') }}" />
    @endif
    @if (isset($campaign->short_description) && isset($setCampaign))
        <meta property="og:description" content="{{ $campaign->short_description }}" />
        <meta property="twitter:description" content="{{ $campaign->short_description }}" />
    @else
        <meta name="og:description"
            content="A simple platform for Help Seekers, Donors and Volunteers from any part of the world. You can request for fund stating a particular need regardless of race, ethnicity, nationality, caste, religion, belief, gender or other status." />
        <meta name="twitter:description"
            content="A simple platform for Help Seekers, Donors and Volunteers from any part of the world. You can request for fund stating a particular need regardless of race, ethnicity, nationality, caste, religion, belief, gender or other status." />
    @endif
    <meta property="og:site_name" content="Help N Helper" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <title>{{ $title ?? 'HelpNHelper' }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    {{-- CSS --}}
    {{ $styles ?? '' }}

    {{-- Vite --}}
    @vite(['resources/css/app.css'])
</head>

<body>
    <main>
        <x-header></x-header>
        {{ $slot }}
        @if (Route::currentRouteName() != 'web.login' && Route::currentRouteName() != 'web.signup')
            <x-footer></x-footer>
        @endif
    </main>

    {{-- JS --}}
    {{ $scripts ?? '' }}

    @vite(['resources/js/app.js'])
</body>

</html>
