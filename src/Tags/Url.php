<?php

namespace Aldamr01\Sitemap\Tags;

use Carbon\Carbon;
use DateTimeInterface;
use DateTime;

class Url extends Tag
{
    const CHANGE_FREQUENCY_ALWAYS = 'always';
    const CHANGE_FREQUENCY_HOURLY = 'hourly';
    const CHANGE_FREQUENCY_DAILY = 'daily';
    const CHANGE_FREQUENCY_WEEKLY = 'weekly';
    const CHANGE_FREQUENCY_MONTHLY = 'monthly';
    const CHANGE_FREQUENCY_YEARLY = 'yearly';
    const CHANGE_FREQUENCY_NEVER = 'never';

    public string $url;

    public mixed $lastModificationDate = null;

    public mixed $changeFrequency = null;

    public mixed $priority = null;

    public bool $cData = false;

    /** @var \Spatie\Sitemap\Tags\Alternate[] */
    public array $alternates = [];

    /** @var \Spatie\Sitemap\Tags\Image[] */
    public array $images = [];

    /** @var \Spatie\Sitemap\Tags\Video[] */
    public array $videos = [];

    /** @var \Spatie\Sitemap\Tags\Video[] */
    public array $news = [];

    public static function create(string $url): static
    {
        return new static($url);
    }

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function setUrl(string $url = ''): static
    {
        $this->url = $url;

        return $this;
    }

    public function setLastModificationDate(DateTimeInterface $lastModificationDate): static
    {
        $this->lastModificationDate = Carbon::instance($lastModificationDate);

        return $this;
    }

    public function setChangeFrequency(string $changeFrequency): static
    {
        $this->changeFrequency = $changeFrequency;

        return $this;
    }

    public function setPriority(float $priority = 0.8): static
    {
        $this->priority = max(0, min($priority, 1));

        return $this;
    }

    public function setCdata(bool $cData = false): static
    {
        $this->cData = $cData;

        return $this;
    }


    public function addAlternate(string $url, string $locale = ''): static
    {
        $this->alternates[] = new Alternate($url, $locale);

        return $this;
    }

    public function addImage(string $url, string $caption = '', string $geo_location = '', string $title = '', string $license = ''): static
    {
        $this->images[] = new Image($url, $caption, $geo_location, $title, $license);

        return $this;
    }

    public function addNews(string $title, DateTimeInterface $publication_date): static
    {
        $publication_date = Carbon::parse($publication_date);
        $this->news[] = new News($title, $publication_date->format(DateTime::ATOM));

        return $this;
    }

    public function addVideo(string $thumbnailLoc, string $title, string $description, $contentLoc = null, $playerLoc = null, array $options = [], array $allow = [], array $deny = []): static
    {
        $this->videos[] = new Video($thumbnailLoc, $title, $description, $contentLoc, $playerLoc, $options, $allow, $deny);

        return $this;
    }

    public function path(): string
    {
        return parse_url($this->url, PHP_URL_PATH) ?? '';
    }

    public function segments(?int $index = null): array | string | null
    {
        $segments = collect(explode('/', $this->path()))
            ->filter(function ($value) {
                return $value !== '';
            })
            ->values()
            ->toArray();

        if (! is_null($index)) {
            return $this->segment($index);
        }

        return $segments;
    }

    public function segment(int $index): ?string
    {
        return $this->segments()[$index - 1] ?? null;
    }
}
