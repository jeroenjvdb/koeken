<?php

namespace App\Classes;

use Stevenmaguire\Services\Trello\Client as TrelloClient;

class Trello
{
    /**
     * @var TrelloClient
     */
    private $client;

    /**
     * Trello constructor.
     */
    public function __construct()
    {
        $this->client = new TrelloClient([
                                         'key' => config('trello.key'),
                                         'secret' => config('trello.secret'),
                                     ]);

        //TODO: place OAuthSettings in config
        $OAuthSettings = [
            'name' => 'koffiekoeken',
            'callbackUrl' => 'test',//route('api.authenticate'),
            'expiration' => 'never',
            'scope' => 'read,write',
            'token' => config('trello.token'),
        ];

        $this->client->addConfig($OAuthSettings);
    }


    public function getFirst()
    {
        $boardLists = $this->client->getBoardLists(config('trello.board'));
        $listId = $boardLists[0]->id;
        $cards = $this->client->getListCards($listId);

        return $cards[0]->name;

    }
}