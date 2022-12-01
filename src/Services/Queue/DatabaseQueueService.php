<?php

namespace Programic\Tools\Services\Queue;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Programic\Tools\Contracts\QueueSummary;

class DatabaseQueueService extends QueueService implements QueueSummary
{
    public function all(): Collection
    {
        return $this->format(
            DB::table('queue_jobs')
                ->select(DB::raw('COUNT(0) as count, queue, JSON_EXTRACT(payload, "$.displayName") as event'))
//                ->where('available_at', '>', DB::raw('UNIX_TIMESTAMP(NOW())'))
                ->groupByRaw('queue, JSON_EXTRACT(payload, "$.displayName")')
                ->get()
                ->groupBy('queue')
        );
    }
}
