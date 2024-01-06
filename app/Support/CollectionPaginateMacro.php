<?php

namespace App\Support;

use Closure;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Paginate the given collection.
 *
 * @param  int  $perPage
 * @param  int  $total
 * @param  int  $page
 * @param  string  $pageName
 *
 * @mixin \Illuminate\Support\Collection
 *
 * @return \Illuminate\Pagination\LengthAwarePaginator
 *
 * Thanks to spatie.
 *
 * @see https://github.com/spatie/laravel-collection-macros/blob/main/src/Macros/Paginate.php
 */
class CollectionPaginateMacro
{
    public function __invoke(): Closure
    {
        return function (
            int $perPage = 15,
            string $pageName = 'page',
            ?int $page = null,
            ?int $total = null,
            array $options = [],
        ): LengthAwarePaginator {
            //
            /** @var \Illuminate\Support\Collection $this */
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            $results = $this->forPage($page, $perPage)->values();

            $total = $total ?: $this->count();

            $options += [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ];

            return new LengthAwarePaginator($results, $total, $perPage, $page, $options);
        };
    }
}
