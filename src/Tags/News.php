<?php

namespace Spatie\Sitemap\Tags;

class News
{
    public string $title;

    public string $publication_date;

    public static function create(string $title, string $publication_date): static
    {
        return new static($title, $publication_date);
    }

    public function __construct(string $title, string $pub)
    {
        $this->setTitle($title);

        $this->setPublicationDate($publication_date);
    }

    public function setTitle(string $title = ''): static
    {
        $this->title = $title;

        return $this;
    }

    public function setPublicationDate(string $publication_date = ''): static
    {
        $this->publication$publication_date = $publication_date;

        return $this;
    }
}
