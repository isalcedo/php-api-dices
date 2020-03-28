<?php
declare(strict_types=1);

namespace App\Application\Actions\Dice;

use App\Application\Actions\Action;
use App\Domain\Dice\DiceRepository;
use http\Exception\RuntimeException;
use Psr\Http\Message\ResponseInterface as Response;
use Pusher\Pusher;
use Pusher\PusherException;

class RollDiceOptionsAction extends Action
{
    /**
     * {@inheritdoc}
     * @throws PusherException
     */
    protected function action(): Response
    {
        return $this->response
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
    }
}
