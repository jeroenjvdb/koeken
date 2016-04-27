<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use GuzzleHttp\Client as GuzzleClient;
use App\Classes\Trello;

class Koeken extends Job implements ShouldQueue
{
    use InteractsWithQueue;//, SerializesModels;

    private $GuzzleClient;
    private $TrelloClient;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->GuzzleClient = new GuzzleClient();
        //$this->TrelloClient = new Trello();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $TrelloClient = new Trello();

        $name = $TrelloClient->getFirst();
        echo $name;
        $fields = [
            'text' => $name . ' koeken!'
        ];

        $this->send(config('slack.webhook'), $fields);
    }

    private function send($url, $fields)
    {
        $GuzzleClient = new GuzzleClient();

        $res = $GuzzleClient->post($url, [
            'form_params' => [
                'payload' => json_encode($fields)
            ]
        ]);

        return true;
    }

}
