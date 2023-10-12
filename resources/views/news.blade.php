<news:news>
            <news:publication>
                <news:name>{{ config('sitemap.site_name', 'Aldion Tamfan Media') }}</news:name>
                <news:language>{{ config('sitemap.language', 'id') }}</news:language>
            </news:publication>
    @if (! empty($news->publication_date))
        <news:publication_date>{{ $news->publication_date }}</news:publication_date>
    @endif
@if (! empty($news->title))
        <news:title><![CDATA[ {{ $news->title }} ]]></news:title>
@endif
        </news:news>
