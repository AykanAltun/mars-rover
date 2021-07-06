<?php
declare(strict_types=1);

namespace App\Dto;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(@OA\Xml(name="RoverStateDto"))
 */
class RoverStateDto
{
    /**
     * @OA\Property(type="string")
     */
    private string $state;

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }
}
