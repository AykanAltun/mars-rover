<?php
declare(strict_types=1);

namespace App\DataProvider;

class RoverDataProvider
{
    const TEST_NAME = 'Test Rover';
    const DIRECTION = 'N';
    const STATUS = '1';

    public function provideRoverRequest(): array
    {
        return [[[
            'id' => uniqid(),
            'name' => self::TEST_NAME,
            'status' => self::STATUS,
            'plateau' => uniqid(),
            'xCoordinate' => rand(-10, 10),
            'yCoordinate' => rand(-10, 10),
            'direction' => self::DIRECTION,
        ]]];
    }
}
