@php
    $seo_default = setting('seo_default');
    $seo_type = @$type ?: 'website';
    $seo_title = config('app.name').' '.@$subtitle;
    $seo_cover = @$cover_path ?: @$seo_default['cover_path'] ?: '';
    $seo_authr = @$author ?: @$seo_default['author'] ?: '';
    $seo_descr = @$description ?: @$seo_default['description'] ?: '';
    $seo_keywr = @$keywords ?: @$seo_default['keywords'] ?: '';
    $seo_keywr = is_array($seo_keywr) ? implode(', ', $seo_keywr) : $seo_keywr;
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $seo_title }}</title>
    <link rel="shortcut icon" href="{{ asset('favicox.ico') }}" />

    <meta name="robots" content="index, follow">
    <meta name="author" content="{{ $seo_authr }}">
    <meta name="title" content="{{ $seo_title }}">
    <meta name="description" content="{{ $seo_descr }}">
    <meta name="keywords" content="{{ $seo_keywr }}">

    <meta property="og:author" content="{{ $seo_authr }}">
    <meta property="og:title" content="{{ $seo_title }}">
    <meta property="og:description" content="{{ $seo_descr }}">
    <meta property="og:url" content="{{ \URL::current() }}">
    <meta property="og:image" content="{{ storage_url($seo_cover) }}">
    <meta property="og:type" content="{{ $seo_type }}" />

    <meta name="twitter:author" content="{{ $seo_authr }}">
    <meta name="twitter:title" content="{{ $seo_title }}">
    <meta name="twitter:description" content="{{ $seo_descr }}">
    <meta name="twitter:image" content="{{ storage_url($seo_cover) }}">
    <meta name="twitter:card" content="summary">

    <meta name="developer" content="Decodes Media">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- CSS Vendors -->
    <!-- --Put any global css here -->

    @vite('resources/sass/app.scss')
    @stack('pageStyles')
    @livewireStyles
</head>

<body>
    <div id="app">
        @unless(@$noheader)
          <x-section.navbar />
        @endunless
        {{ $slot }}
        @unless(@$nofooter)
          <x-section.footer />
        @endunless
    </div>

    <!-- JS Vendors -->
    <!-- --Put any global js here -->

    @vite('resources/js/app.js')
    @stack('pageScripts')
    @livewireScripts
</body>

</html>
