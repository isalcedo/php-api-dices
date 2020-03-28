<?php
declare(strict_types=1);

use App\Application\Actions\Dice\{GetRollsAction, RollDiceAction, RollDiceOptionsAction};
use App\Application\Middleware\JsonBodyParserMiddleware;
use Slim\App;

return function (App $app) {
    $app->options('/api/new-roll', RollDiceOptionsAction::class)->add(JsonBodyParserMiddleware::class);
    $app->post('/api/new-roll', RollDiceAction::class)->add(JsonBodyParserMiddleware::class);
    $app->get('/api/get-rolls', GetRollsAction::class)->add(JsonBodyParserMiddleware::class);
};
