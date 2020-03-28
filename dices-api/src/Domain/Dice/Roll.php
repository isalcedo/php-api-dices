<?php
declare(strict_types=1);

namespace App\Domain\Dice;

use JsonSerializable;

class Roll implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $playerName;

    /**
     * @var string
     */
    private $rollType;

    /**
     * @var array
     */
    private $rollResult;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @param int|null     $id
     * @param string       $player_name
     * @param string       $roll_type
     * @param array|string $roll_result
     */
    public function __construct(?int $id, string $player_name, string $roll_type, $roll_result, string $created_at)
    {
        $this->id         = $id;
        $this->playerName = $player_name;
        $this->rollType   = $roll_type;
        $this->rollResult = is_string($roll_result) ? json_decode($roll_result, true) : $roll_result;
        $this->createdAt  = $created_at;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    /**
     * @return string
     */
    public function getRollType(): string
    {
        return $this->rollType;
    }

    /**
     * @return array
     */
    public function getRollResult(): array
    {
        return $this->rollResult;
    }

    /**
     * @return array
     */
    public function getCreatedAt(): array
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id'         => $this->id,
            'playerName' => $this->playerName,
            'rollType'   => $this->rollType,
            'rollResult' => $this->rollResult,
            'createdAt'  => $this->createdAt
        ];
    }
}
