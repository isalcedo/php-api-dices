<?php
declare(strict_types=1);

namespace App\Application\Actions\Dice;

use App\Application\Actions\Action;
use App\Domain\Dice\DiceRepository;
use http\Exception\RuntimeException;
use Psr\Http\Message\ResponseInterface as Response;
use Pusher\Pusher;
use Pusher\PusherException;

class GetRollsAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $repository = new DiceRepository();
        $rolls      = $repository->getRolls();

        foreach ($rolls as $key => $roll) {
            $roll['roll_result'] = json_decode($roll['roll_result'], true);
            $rolls[$key]         = $roll;
        }

        return $this->respondWithData($rolls);
    }
}
