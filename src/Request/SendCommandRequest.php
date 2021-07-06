<?php
declare(strict_types=1);

namespace App\Request;

use JetBrains\PhpStorm\ArrayShape;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\RequestBody(
 *     request="SendCommandRequest",
 *     description="Send command request",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/SendCommandRequest")
 * )
 * @OA\Schema(@OA\Xml(name="SendCommandRequest"))
 */
class SendCommandRequest implements RequestInterface
{
    /**
     * @OA\Property(type="string")
     * @Assert\Regex(pattern= "/^[LRM]+$/i", message="Lütfen gerçerli komut giriniz.")
     */
    private string $commands;

    /**
     * @return string
     */
    public function getCommands(): string
    {
        return $this->commands;
    }

    /**
     * @param string $commands
     */
    public function setCommands(string $commands): void
    {
        $this->commands = $commands;
    }

    public function fill(?array $data = null): void
    {
        $this->commands = $data['commands'] ?? '';
    }

    #[ArrayShape(['commands' => "string"])]
    public function toArray(): array
    {
        return ['commands' => $this->commands];
    }
}
