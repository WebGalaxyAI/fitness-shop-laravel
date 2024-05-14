<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProductRepository
{
    public function search(array $params, int $perPage): LengthAwarePaginator;

    public function getFilters(): Collection;

    public function getPrices(): array;
}
