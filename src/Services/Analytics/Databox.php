<?php

namespace Programic\Tools\Services\Analytics;

use Illuminate\Support\Collection;
use Programic\Tools\Contracts\AnalyticsClient;

class Databox implements AnalyticsClient
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;

        if (!$token) {
            throw new \Exception('Databox token must be set');
        }
    }

    public function send(Collection $data): array
    {
        $postData = [];

        $data->each(function ($queue) use (&$postData) {
            $name = $queue[0]->queue;
            $count = $queue->sum('count');

            foreach ($queue as $item) {
                $postData[] = [
                    "\$queue_{$item->queue}" => $item->count,
                    'event' => str_replace('\\\\', '\\', (trim($item->event, '"'))),
                    'date' => now()->format('c'),
                ];
            }
        });

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://push.databox.com');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->token:");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['data' => $postData]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Accept: application/vnd.databox.v2+json',
            'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);

        curl_close($ch);

        return json_decode($server_output, true);
    }
}
