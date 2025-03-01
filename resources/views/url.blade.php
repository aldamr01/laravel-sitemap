<url>
    @if (! empty($tag->url))
    @if($tag->cData)
<loc> <![CDATA[ {{ url($tag->url) }} ]]> </loc>
    @else
    <loc>{{ url($tag->url) }}</loc>
    @endif
    @endif
    @if (count($tag->alternates))
        @foreach ($tag->alternates as $alternate)
            <xhtml:link rel="alternate" hreflang="{{ $alternate->locale }}" href="{{ url($alternate->url) }}" />
        @endforeach
    @endif
    @if (! empty($tag->lastModificationDate))
        <lastmod>{{ $tag->lastModificationDate->format(DateTime::ATOM) }}</lastmod>
    @endif
    @if (! empty($tag->changeFrequency))
<changefreq>{{ $tag->changeFrequency }}</changefreq>
    @endif
    @if (! empty($tag->priority))
        <priority>{{ number_format($tag->priority,1) }}</priority>
    @endif
    @each('sitemap::image', $tag->images, 'image')
    @each('sitemap::news', $tag->news, 'news')
    @each('sitemap::video', $tag->videos, 'video')
</url>
