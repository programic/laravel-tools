<?php

namespace Programic\Tools\Contracts;

use Illuminate\Support\Collection;

interface QueueSummary
{
    public function all(): Collection;
}
