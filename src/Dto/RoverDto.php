<?php
declare(strict_types=1);

namespace App\Dto;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(@OA\Xml(name="RoverDto"))
 */
class RoverDto
{
    /**
     * @OA\Property(type="integer")
     */
    private int $id;

    /**
     * @OA\Property(type="string")
     */
    private string $name;

    /**
     * @OA\Property(type="integer")
     */
    private int $status;

    /**
     * @OA\Property(type="integer")
     */
    private int $plateau;

    /**
     * @OA\Property(type="integer")
     */
    private int $xCoordinate;

    /**
     * @OA\Property(type="integer")
     */
    private int $yCoordinate;

    /**
     * @OA\Property(type="string")
     */
    private string $direction;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
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
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getPlateau(): int
    {
        return $this->plateau;
    }

    /**
     * @param int $plateau
     */
    public function setPlateau(int $plateau): void
    {
        $this->plateau = $plateau;
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

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection(string $direction): void
    {
        $this->direction = $direction;
    }

    public function getState(): string
    {
        return $this->xCoordinate . ','. $this->yCoordinate . ',' . $this->direction;
    }
}
