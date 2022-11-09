<?php

namespace Programic\Tools\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Programic\Tools\Contracts\QueueSummary;

class ToolsController extends Controller
{
    public function ohdear(QueueSummary $queueSummary): JsonResponse
    {
        return response()->json([
            'finishedAt' => now()->timestamp,
            'checkResults' => $queueSummary->all()->map(function ($queue) {
                $name = $queue[0]->queue;
                $count = $queue->sum('count');
                $status = $count > 100 ? 'warning' : 'ok';

                return [
                    'name' => "Queue $name",
                    'label' => "queue",
                    'status' => $status,
                    'notificationMessage' => "Queue ($name) seems to be filling up",
                    'shortSummary' => $count,
                    'meta' => $queue->map(function ($event) {
                        $eventName = str_replace('\\\\', '\\', (trim($event->event, '"')));

                        return [
                            'event' => $eventName,
                            'count' => $event->count,
                        ];
                    })
                ];
            }),
        ]);
    }
}
