<?php
declare(strict_types=1);

namespace App\Request;

use JetBrains\PhpStorm\ArrayShape;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\RequestBody(
 *     request="PlateauRequest",
 *     description="Plateau request",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/PlateauRequest")
 * )
 * @OA\Schema(@OA\Xml(name="PlateauRequest"))
 */
class PlateauRequest implements RequestInterface
{
    private string $id;

    /**
     * @OA\Property(type="string")
     * @Assert\NotBlank(message="Name boş bırakılamaz.")
     * @Assert\NotNull(message="Name null olamaz.")
     */
    private string $name;

    /**
     * @OA\Property(type="string")
     * @Assert\NotBlank(message="Status boş bırakılamaz.")
     * @Assert\NotNull(message="Status null olamaz.")
     */
    private string $status;

    /**
     * @OA\Property(type="integer")
     * @Assert\NotBlank(message="xCoordinate boş bırakılamaz.")
     * @Assert\NotNull(message="xCoordinate null olamaz.")
     */
    private int $xCoordinate;

    /**
     * @OA\Property(type="integer")
     * @Assert\NotBlank(message="yCoordinate boş bırakılamaz.")
     * @Assert\NotNull(message="yCoordinate null olamaz.")
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

    public function fill(?array $data = null): void
    {
        $this->id = md5(uniqid((string) rand(), true));
        $this->name = $data['name'] ?? '';
        $this->status = $data['status'] ?? '';
        $this->xCoordinate = $data['xCoordinate'] ?? 0;
        $this->yCoordinate = $data['yCoordinate'] ?? 0;
    }


    #[ArrayShape([
        'id' => "string",
        'name' => "string",
        'status' => "string",
        'xCoordinate' => "int",
        'yCoordinate' => "int"
    ])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'xCoordinate' => $this->xCoordinate,
            'yCoordinate' => $this->yCoordinate,
        ];
    }
}
