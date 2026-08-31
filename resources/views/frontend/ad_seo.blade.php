<!-- Meta Description -->
@if(!empty($description))
<meta name="description" content="{{ $description }}">
@endif

<!-- Meta Keywords -->
@if(isset($seo['is_tags']) && !empty($seo['meta_tags']))
<meta name="keywords" content="{{ $seo['meta_tags'] }}">
@endif

<!-- Open Graph Tags -->
@if(isset($seo['og_tag']))
<meta property="og:title" content="{{ $seo['og']['title'] ?? $advertise->title ?? '' }}">
<meta property="og:description" content="{{ $seo['og']['description'] ?? $advertise->description ?? '' }}">
<meta property="og:url" content="{{ $seo['og']['url'] ?? url('/categories/' . optional($advertise->category)->slug . '/' . $advertise->slug) ?? '' }}">
<meta property="og:type" content="{{ $seo['og']['type'] ?? 'website' }}">
@if(!empty($seo['og']['image']))
<meta property="og:image" content="{{ $seo['og']['image'] }}">
@endif
<meta property="og:site_name" content="{{ env('Website_Name', 'SLGOO') }}">
@endif

<!-- Twitter Card Tags -->
@if(isset($seo['twitter_tag']))
<meta name="twitter:card" content="{{ $seo['twitter']['card'] ?? 'summary' }}">
<meta name="twitter:title" content="{{ $seo['twitter']['title'] ?? $advertise->title ?? '' }}">
<meta name="twitter:description" content="{{ $seo['twitter']['description'] ?? $advertise->description ?? '' }}">
@if(!empty($seo['twitter']['image']))
<meta name="twitter:image" content="{{ $seo['twitter']['image'] }}">
@endif
<meta name="twitter:url" content="{{ $seo['twitter']['url'] ?? url('/categories/' . optional($advertise->category)->slug . '/' . $advertise->slug) ?? '' }}">
@endif

<!-- Canonical Links -->
@if(isset($seo['is_canonicals']))
@if(isset($seo['canonical']) && is_array($seo['canonical']) && count($seo['canonical']) > 0)
    @foreach($seo['canonical'] as $can)
        @if(!empty($can))
            <link rel="canonical" href="{{ $can }}" />
        @endif
    @endforeach
@else
    <link rel="canonical" href="{{ url('/categories/' . optional($advertise->category)->slug . '/' . $advertise->slug) }}" />
@endif
@endif

<!-- Schema Code -->
@if(isset($seo['is_schema']) && !empty($schema))
{!! $schema !!}
@endif 