<?php
declare(strict_types=1);

use App\Application\Actions\Dice\RollDiceAction;
use App\Application\Middleware\JsonBodyParserMiddleware;
use Slim\App;

return function (App $app) {
    $app->post('/', RollDiceAction::class)->add(JsonBodyParserMiddleware::class);
};
