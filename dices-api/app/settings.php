<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions(
        [
            'settings' => [
                'displayErrorDetails' => true, // Should be set to false in production
                'logger'              => [
                    'name'  => 'slim-app',
                    'path'  => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'sqlitePath'          => __DIR__ . '/../db/storage/dicesdb.db',
                'sqliteTestPath'      => __DIR__ . '/../db/storage/dicesdb_test.db',
                'pusher' => [
                    'app_id'  => '971576',
                    'key'     => '32b5f8b8cdf96e5ef793',
                    'secret'  => 'c49c208d57126c674d3b',
                    'cluster' => 'us2',
                    'channel' => 'dices-rolls'
                ]
            ],
        ]
    );
};
