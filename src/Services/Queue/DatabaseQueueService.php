<?php

namespace Programic\Tools\Services\Queue;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Programic\Tools\Contracts\QueueSummary;

class DatabaseQueueService implements QueueSummary
{
    public function all(): Collection
    {
        return DB::table('queue_jobs')
            ->select(DB::raw('COUNT(0) as count, queue, JSON_EXTRACT(payload, "$.displayName") as event'))
            ->groupByRaw('queue, JSON_EXTRACT(payload, "$.displayName")')
            ->get()
            ->groupBy('queue');
    }
}
