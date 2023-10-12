<?= '<'.'?'.'xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" @if($mode == 'web') xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1" @endif @if($mode == 'news') xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" @elseif($mode == 'video') xmlns:video="http://www.google.com/schemas/sitemap-video/1.1" @elseif($mode == 'image' ) xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"  @endif >
@foreach($tags as $tag)
    @include('sitemap::' . $tag->getType())
@endforeach
</urlset>
