<?php
declare(strict_types=1);

namespace App\Dto;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(@OA\Xml(name="PlateauDto"))
 */
class PlateauDto
{
    /**
     * @OA\Property(type="string")
     */
    private string $id;

    /**
     * @OA\Property(type="string")
     */
    private string $name;

    /**
     * @OA\Property(type="string")
     */
    private string $status;

    /**
     * @OA\Property(type="integer")
     */
    private int $xCoordinate;

    /**
     * @OA\Property(type="integer")
     */
    private int $yCoordinate;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getXCoordinate(): int
    {
        return $this->xCoordinate;
    }

    /**
     * @param int $xCoordinate
     */
    public function setXCoordinate(int $xCoordinate): void
    {
        $this->xCoordinate = $xCoordinate;
    }

    /**
     * @return int
     */
    public function getYCoordinate(): int
    {
        return $this->yCoordinate;
    }

    /**
     * @param int $yCoordinate
     */
    public function setYCoordinate(int $yCoordinate): void
    {
        $this->yCoordinate = $yCoordinate;
    }
}
