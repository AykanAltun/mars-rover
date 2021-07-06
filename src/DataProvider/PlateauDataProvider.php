<?php
declare(strict_types=1);

namespace App\DataProvider;

class PlateauDataProvider
{
    const TEST_NAME = 'Test';
    const STATUS = '1';

    public function providePlateauRequest(): array
    {
        return [[[
            'id' => uniqid(),
            'name' => self::TEST_NAME,
            'status' => self::STATUS,
            'xCoordinate' => rand(-10, 10),
            'yCoordinate' => rand(-10, 10),
        ]]];
    }
}
