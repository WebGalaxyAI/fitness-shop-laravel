<?php

namespace App\Helpers;


use Illuminate\Support\Collection;

class Breadcrumbs
{
    public function __construct(private Collection $crumbs)
    {
    }

    public function add(string $title, ?string $url = 'javascript:void(0);'): static
    {
        $this->crumbs->push([
            'title' => $title,
            'url' => $url,
        ]);
        return $this;
    }

    public function crumbs(): Collection
    {
        return $this->crumbs;
    }
}
