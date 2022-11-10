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
        $results = $queueSummary->all();
        $treshold = 100;

        return response()->json([
            'finishedAt' => now()->timestamp,
            'checkResults' => $results->map(function ($queue) use ($treshold) {
                $name = $queue[0]->queue;
                $count = $queue->sum('count');
                $status = $count > $treshold ? 'warning' : 'ok';
                $notificationMessage = 'Queue is fine';

                if ($status === 'warning') {
                    $notificationMessage = "Queue ($name) seems to be filling up";
                }

                return [
                    'name' => "Queue $name",
                    'label' => $name,
                    'status' => $status,
                    'notificationMessage' => $notificationMessage,
                    'shortSummary' => "$count / $treshold jobs",
                    'meta' => $queue->mapWithKeys(function ($event) {
                        if (isset($event->event)) {
                            $eventName = str_replace('\\\\', '\\', (trim($event->event, '"')));

                            return [
                                $eventName => $event->count,
                            ];
                        }

                        return [];
                    })
                ];
            }),
        ]);
    }
}
