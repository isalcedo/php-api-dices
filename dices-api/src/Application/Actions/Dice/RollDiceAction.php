<?php
declare(strict_types=1);

namespace App\Application\Actions\Dice;

use App\Application\Actions\Action;
use App\Domain\Dice\DiceRepository;
use http\Exception\RuntimeException;
use Psr\Http\Message\ResponseInterface as Response;
use Pusher\Pusher;
use Pusher\PusherException;

class RollDiceAction extends Action
{
    /**
     * {@inheritdoc}
     * @throws PusherException
     */
    protected function action(): Response
    {
        global $app;

        $settings     = $app->getContainer()->get('settings');
        $rolls        = 0;
        $rollsResults = [];
        $requestData  = $this->request->getParsedBody();
        [$dicesQuantity, $diceSize] = explode('x', $requestData['rollType']);

        while ($rolls < (int)$dicesQuantity) {
            try {
                $rollsResults[] = random_int(1, (int)$diceSize);

                $rolls++;
            } catch (\Exception $e) {
                throw new RuntimeException('The roll result calculation has failed.');
            }
        }

        $rollData   = array_merge($requestData, [
            'rollResults' => $rollsResults
        ]);
        $repository = new DiceRepository();
        $roll       = $repository->storeRoll($rollData)->jsonSerialize();
        $pusher     = new Pusher(
            $settings['pusher']['key'],
            $settings['pusher']['secret'],
            $settings['pusher']['app_id'],
            [
                'cluster' => $settings['pusher']['cluster'],
                'useTLS'  => true
            ]
        );

        $pusher->trigger($settings['pusher']['channel'], 'new-roll', $roll);

        return $this->respondWithData($roll)
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
    }
}
