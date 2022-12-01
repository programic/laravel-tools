<?php

namespace Programic\Tools\Contracts;

use Illuminate\Support\Collection;

interface AnalyticsClient
{
    public function __construct($auth);

    public function send(Collection $data): array;
}
