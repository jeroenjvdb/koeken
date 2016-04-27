<?php

namespace App\Console\Commands;

use GuzzleHttp\Client as GuzzleClient;
use App\Classes\Trello;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class koeken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'koeken:first';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check who has to get the koeken';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->GuzzleClient = new GuzzleClient();
        $this->TrelloClient = new Trello();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('started koeken:first');
        $name = $this->TrelloClient->getFirst();
        echo $name;
        $fields = [
            'text' => $name . ' koeken!'
        ];

        $this->send(config('slack.webhook'), $fields);
    }

    private function send($url, $fields)
    {
        $res = $this->GuzzleClient->post($url, [
            'form_params' => [
                'payload' => json_encode($fields)
            ]
        ]);

        return true;
    }
}
