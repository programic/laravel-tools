<?php

namespace Programic\Tools\Console\Commands;

use Illuminate\Console\Command;
use Programic\Tools\Contracts\AnalyticsClient;
use Programic\Tools\Contracts\QueueSummary;

class SendQueueAnalyticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send queue monitor to 3rd party';

    /**
     * @var QueueSummary
     */
    protected $queueSummary;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $queueSummary = app(QueueSummary::class);
        $analyticsClient = app(AnalyticsClient::class);
        $results = $queueSummary->all();

        $response = $analyticsClient->send($results);


        if ($response['status'] === 'OK') {
            $this->line('<info>' . $response['message'] . '</info>');

            return;
        }

        $this->line('<error>' . $response['message'] . '</error>');
    }
}
