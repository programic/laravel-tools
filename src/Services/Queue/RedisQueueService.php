<?php

namespace Programic\Tools\Services\Queue;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Programic\Tools\Contracts\QueueSummary;

class RedisQueueService implements QueueSummary
{
    public function all(): Collection
    {
        return collect();
    }
}
