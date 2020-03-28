<?php
declare(strict_types=1);

namespace App\Application\Actions\Dice;

use App\Application\Actions\Action;
use http\Exception\RuntimeException;
use Psr\Http\Message\ResponseInterface as Response;

class RollDiceAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
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

        $returnData = array_merge($requestData, [
            'rollResults' => $rollsResults
        ]);

        return $this->respondWithData($returnData);
    }
}
