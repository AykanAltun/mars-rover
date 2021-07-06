<?php
declare(strict_types=1);

namespace App\Service\v1;

use App\Constant\Commands;
use App\Constant\Directions;
use App\Util\v1\RedisHelper;
use JetBrains\PhpStorm\Pure;

class RoverService
{
    /**
     * X is current direction
     * Y is new command direction
     * Z is final direction
     * X-Y => Z
     */
    private array $nextDirection = [
        Directions::NORTH . '-' . Commands::LEFT => Directions::WEST,
        Directions::NORTH . '-' . Commands::MOVE => Directions::NORTH,
        Directions::NORTH . '-' . Commands::RIGHT => Directions::EAST,
        Directions::EAST  . '-' . Commands::LEFT => Directions::NORTH,
        Directions::EAST  . '-' . Commands::MOVE => Directions::EAST,
        Directions::EAST  . '-' . Commands::RIGHT => Directions::SOUTH,
        Directions::SOUTH . '-' . Commands::LEFT => Directions::EAST,
        Directions::SOUTH . '-' . Commands::MOVE => Directions::SOUTH,
        Directions::SOUTH . '-' . Commands::RIGHT => Directions::WEST,
        Directions::WEST  . '-' . Commands::LEFT => Directions::SOUTH,
        Directions::WEST  . '-' . Commands::MOVE => Directions::WEST,
        Directions::WEST  . '-' . Commands::RIGHT => Directions::NORTH,
    ];

    private RedisHelper $redisHelper;

    public function __construct(RedisHelper $redisHelper)
    {
        $this->redisHelper = $redisHelper;
    }

    #[Pure]
    public function calculateState(array $rover, string $commands): array
    {
        $commands = str_split($commands);
        foreach ($commands as $command) {
            $rover['direction'] = $this->nextDirection[$rover['direction'].'-'.$command];
            $rover = $this->move($rover, $command);
        }

        return $rover;
    }

    public function updateState(array $rover): void
    {
        $this->redisHelper->hSet('rovers', $rover['id'], json_encode($rover));
    }

    private function move(array $rover, string $command): array
    {
        if ($command !== Commands::MOVE) {
            return $rover;
        }
        if (Directions::EAST === $rover['direction']) {
            $rover['xCoordinate']++;
        } else if (Directions::WEST === $rover['direction']) {
            $rover['xCoordinate']--;
        } else if (Directions::NORTH === $rover['direction']) {
            $rover['yCoordinate']++;
        } else {
            $rover['yCoordinate']--;
        }

        return $rover;
    }
}
