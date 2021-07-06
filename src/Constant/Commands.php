<?php
declare(strict_types=1);

namespace App\Constant;

class Commands
{
    const LEFT = 'L';
    const RIGHT = 'R';
    const MOVE = 'M';

    public static array $commands = [
        self::LEFT,
        self::RIGHT,
        self::MOVE,
    ];
}
