<?php
declare(strict_types=1);

namespace App\Controller\v1;

use App\Request\PlateauRequest;
use App\Service\v1\Handler\ValidationHandlerInterface;
use App\Util\v1\RedisHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

final class PlateauController
{
    private RedisHelper $redisHelper;
    private ValidationHandlerInterface $validationHandler;

    public function __construct(RedisHelper $redisHelper, ValidationHandlerInterface $validationHandler)
    {
        $this->redisHelper = $redisHelper;
        $this->validationHandler = $validationHandler;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/plateau",
     *     description="Add a single plateau",
     *     summary="Add Plateau",
     *     tags={"Plateau"},
     *     operationId="addPlateau",
     *     requestBody={"$ref": "#/components/requestBodies/PlateauRequest"},
     *     @OA\Response(response=201, description="Success"),
     *     @OA\Response(response=405, description="Invalid Input"),
     * )
     */
    #[Route("/api/v1/plateau", methods: ["POST"])]
    public function create(Request $request, PlateauRequest $plateauRequest): JsonResponse
    {
        $this->validationHandler->validateRequest($request, $plateauRequest);
        $plateau = json_encode($plateauRequest->toArray());
        $this->redisHelper->hSet('plateaus', $plateauRequest->getId(), $plateau);

        return new JsonResponse($plateau, Response::HTTP_OK, ['Content-Type' => 'application/json;'], true);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/plateau/{id}",
     *     description="List plateau according to id",
     *     summary="List plateau",
     *     tags={"Plateau"},
     *     @OA\Parameter(name="id", required=true, in="path", @OA\Schema(type="string")),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(ref="#/components/schemas/PlateauDto")),
     *     @OA\Response(response="404", description="Plateau Not Found")
     * )
     */
    #[Route("/api/v1/plateau/{id}", methods: ["GET"])]
    public function get(string $id): JsonResponse
    {
        $plateau = $this->redisHelper->hGet('plateaus', $id);
        if (false === $plateau) {
            return new JsonResponse( status: Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($plateau, Response::HTTP_OK, ['Content-Type' => 'application/json;'], true);
    }
}
