<?php
declare(strict_types=1);

use App\Application\Actions\Dice\{GetRollsAction, RollDiceAction};
use App\Application\Middleware\JsonBodyParserMiddleware;
use Slim\App;

return function (App $app) {
    $app->post('/api/new-roll', RollDiceAction::class)->add(JsonBodyParserMiddleware::class);
    $app->get('/api/get-rolls', GetRollsAction::class)->add(JsonBodyParserMiddleware::class);
};
