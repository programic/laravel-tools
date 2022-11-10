<?php

namespace Programic\Tools\Services\Queue;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Programic\Tools\Contracts\QueueSummary;

abstract class QueueService
{
    public function format(Collection $items): Collection
    {
        if ($items->count() > 0) {
            return $items;
        }

        $stdClass = new \StdClass();
        $stdClass->count = 0;
        $stdClass->queue = 'default';

        return collect([
            'queue' => collect([
                $stdClass,
            ]),
        ]);
    }
}
