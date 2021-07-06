<?php
declare(strict_types=1);

namespace App\Controller\v1;

use App\Request\RoverRequest;
use App\Request\SendCommandRequest;
use App\Service\v1\Handler\ValidationHandlerInterface;
use App\Service\v1\RoverService;
use App\Util\v1\RedisHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

class RoverController
{
    private RedisHelper $redisHelper;
    private ValidationHandlerInterface $validationHandler;
    private RoverService $roverService;

    public function __construct(
        RedisHelper $redisHelper,
        ValidationHandlerInterface $validationHandler,
        RoverService $roverService
    ) {
        $this->redisHelper = $redisHelper;
        $this->validationHandler = $validationHandler;
        $this->roverService = $roverService;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/rover",
     *     description="Add a single rover",
     *     summary="Add Rover",
     *     tags={"Rover"},
     *     operationId="addRover",
     *     requestBody={"$ref": "#/components/requestBodies/RoverRequest"},
     *     @OA\Response(response=201, description="Success"),
     *     @OA\Response(response=405, description="Invalid Input"),
     * )
     */
    #[Route("/api/v1/rover", methods: ["POST"])]
    public function create(Request $request, RoverRequest $roverRequest): JsonResponse
    {
        $this->validationHandler->validateRequest($request, $roverRequest);
        $rover = json_encode($roverRequest->toArray());
        $this->redisHelper->hSet('rovers', $roverRequest->getId(), $rover);

        return new JsonResponse($rover, Response::HTTP_OK, ['Content-Type' => 'application/json;'], true);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/rover/{id}",
     *     description="List rover according to id",
     *     summary="List rover",
     *     tags={"Rover"},
     *     @OA\Parameter(name="id", required=true, in="path", @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(ref="#/components/schemas/RoverDto")),
     *     @OA\Response(response="404", description="Rover Not Found")
     * )
     */
    #[Route("/api/v1/rover/{id}", methods: ["GET"])]
    public function get(string $id): JsonResponse
    {
        $rover = $this->redisHelper->hGet('rovers', $id);
        if (false === $rover) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($rover, Response::HTTP_OK, ['Content-Type' => 'application/json;'], true);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/rover/{id}/state",
     *     description="List rover state according to id",
     *     summary="List rover state",
     *     tags={"Rover"},
     *     @OA\Parameter(name="id", required=true, in="path", @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(ref="#/components/schemas/RoverStateDto")),
     *     @OA\Response(response="404", description="Rover Not Found")
     * )
     */
    #[Route("/api/v1/rover/{id}/state", methods: ["GET"])]
    public function getState(string $id): JsonResponse
    {
        $rover  = $this->redisHelper->hGet('rovers', $id);
        if (false === $rover) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        }

        $rover = json_decode($rover, true);

        return new JsonResponse(
            json_encode(['state' => $rover['xCoordinate'].','.$rover['yCoordinate'].','.$rover['direction']]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json;'],
            true
        );
    }

    /**
     * @OA\Post(
     *     path="/api/v1/rover/{id}/send-commands",
     *     description="Send commands to rover",
     *     summary="Send Command",
     *     tags={"Rover"},
     *     operationId="sendCommand",
     *     requestBody={"$ref": "#/components/requestBodies/SendCommandRequest"},
     *     @OA\Parameter(name="id", required=true, in="path", @OA\Schema(type="string")),
     *     @OA\Response(response=201, description="Success"),
     *     @OA\Response(response=405, description="Invalid Input"),
     * )
     */
    #[Route("/api/v1/rover/{id}/send-commands", methods: ["POST"])]
    public function sendCommands(string $id, Request $request, SendCommandRequest $commandRequest): JsonResponse
    {
        $this->validationHandler->validateRequest($request, $commandRequest);
        $rover = $this->redisHelper->hGet('rovers', $id);
        if (false === $rover) {
            return new JsonResponse(status: Response::HTTP_NOT_FOUND);
        }

        $rover = $this->roverService->calculateState(json_decode($rover, true), $commandRequest->getCommands());
        $this->roverService->updateState($rover);

        return new JsonResponse(
            json_encode(['state' => $rover['xCoordinate'].','.$rover['yCoordinate'].','.$rover['direction']]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json;'],
            true
        );
    }
}
