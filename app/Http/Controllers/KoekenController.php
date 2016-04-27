<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;
use App\Classes\Trello;

use App\Http\Requests;
use App\Jobs\Koeken;

class KoekenController extends Controller
{
    private $GuzzleClient;
    private $TrelloClient;

    public function __construct()
    {
        $this->GuzzleClient = new GuzzleClient();
        $this->TrelloClient = new Trello();
    }

    /**
     * @return string
     */
    public function index()
    {
        $name = $this->TrelloClient->getFirst();
        echo $name;
        $fields = [
            'text' => $name . ' koeken!'
        ];

        $this->send(config('slack.webhook'), $fields);
    }

    public function slackCommand()
    {
        $this->dispatch(new Koeken());
    }

    /**
     * test function
     *
     * @param $name
     * @return string
     */
    public function who($name)
    {
        echo $name;

        $url = 'https://hooks.slack.com/services/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';
        $fields = [
            'text' => $name . ' koeken!'
        ];

        $this->send($url, $fields);

        return json_encode(true);
    }

    /**
     * send the request to slack
     *
     * @param $url
     * @param $fields
     * @return bool
     */
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
