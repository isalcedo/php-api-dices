<?php
declare(strict_types=1);

namespace App\Domain\Dice;

use Carbon\Carbon;
use PDO;
use PDOException;
use RuntimeException;

class DiceRepository
{
    /** @var PDO $pdo */
    public $pdo;

    public function __construct()
    {
        $this->pdo = null;
    }

    /**
     * Set and start PDO.
     *
     * @param bool $test
     */
    public function setPdo($test = false): void
    {
        global $app;
        $settings  = $app->getContainer()->get('settings');
        $dbPath    = $test ? $settings['sqliteTestPath'] : $settings['sqlitePath'];
        $this->pdo = new PDO(
            'sqlite:' . $dbPath,
            null,
            null,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    /**
     * @return array
     */
    public function getRolls(): array
    {
        $this->checkPDO();
        $query = 'select id, player_name, roll_type, roll_result, created_at from "rolls" order by created_at';
        $query = $this->pdo->query($query);
        $query->setFetchMode(PDO::FETCH_ASSOC);

        try {
            return $query->fetchAll();
        } catch (PDOException $e) {
            throw new RuntimeException(
                $e
            );
        }
    }

    /**
     * @param array $rollData
     *
     * @return Roll
     */
    public function storeRoll(array $rollData): Roll
    {
        $this->checkPDO();
        $nowTime     = Carbon::now();
        $createdAt   = $nowTime->format('Y-m-d H:i:s');
        $sql         = 'INSERT INTO "rolls" (player_name, roll_type, roll_result, created_at) ' .
                       'VALUES (:player_name, :roll_type, :roll_result, :created_at)';
        $sessionData = [
            'player_name' => $rollData['playerName'],
            'roll_type'   => $rollData['rollType'],
            'roll_result' => json_encode($rollData['rollResults']),
            'created_at'  => $createdAt
        ];
        $query       = $this->pdo->prepare($sql);

        try {
            $query->execute($sessionData);
            $id = (int)$this->pdo->lastInsertId();

            return new Roll($id, $rollData['playerName'], $rollData['rollType'], $rollData['rollResults'], $createdAt);
        } catch (PDOException $e) {
            throw new RuntimeException(
                $e
            );
        }
    }

    private function checkPDO()
    {
        if ($this->pdo === null) {
            $this->setPdo();
        }
    }
}
