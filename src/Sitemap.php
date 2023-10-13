<?php

namespace Aldamr01\Sitemap;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Aldamr01\Sitemap\Contracts\Sitemapable;
use Aldamr01\Sitemap\Tags\Tag;
use Aldamr01\Sitemap\Tags\Url;

class Sitemap implements Responsable, Renderable
{
    /** @var \Aldamr01\Sitemap\Tags\Url[] */
    protected array $tags = [];

    protected string $mode = 'default';

    public static function create(): static
    {
        return new static();
    }

    public function add(string | Url | Sitemapable | iterable $tag): static
    {
        if (is_object($tag) && array_key_exists(Sitemapable::class, class_implements($tag))) {
            $tag = $tag->toSitemapTag();
        }

        if (is_iterable($tag)) {
            foreach ($tag as $item) {
                $this->add($item);
            }

            return $this;
        }

        if (is_string($tag)) {
            $tag = Url::create($tag);
        }

        if (! in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setMode(string $mode): string
    {
        return $this->mode = $mode;
    }

    public function getUrl(string $url): ?Url
    {
        return collect($this->tags)->first(function (Tag $tag) use ($url) {
            return $tag->getType() === 'url' && $tag->url === $url;
        });
    }

    public function hasUrl(string $url): bool
    {
        return (bool) $this->getUrl($url);
    }

    public function render(): string
    {
        $tags = collect($this->tags)->unique('url')->filter();
        $mode = $this->mode;

        return view('sitemap::sitemap')
            ->with(compact('tags'))
            ->with(compact('mode'))
            ->render();
    }

    public function writeToFile(string $path): static
    {
        file_put_contents($path, $this->render());

        return $this;
    }

    public function writeToDisk(string $disk, string $path): static
    {
        Storage::disk($disk)->put($path, $this->render());

        return $this;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return Response::make($this->render(), 200, [
            'Content-Type' => 'text/xml',
        ]);
    }
}
