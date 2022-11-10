<?php

namespace Programic\Tools\Services\Queue;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Programic\Tools\Contracts\QueueSummary;

class RedisQueueService extends QueueService implements QueueSummary
{
    public function all(): Collection
    {
        return collect();
    }
}
