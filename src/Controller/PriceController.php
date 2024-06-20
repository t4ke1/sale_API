<?php

namespace App\Controller;

use App\DTO\Request\PriceDTO;
use App\Services\PriceServices;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PriceController extends AbstractController
{
    public function __construct(
        private readonly PriceServices $priceServices
    ) {
    }

    #[Route('/api/price', name: 'price', methods: ['POST'])]
    #[OA\RequestBody(
        description: 'User credentials',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: PriceDTO::class))
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Success'
    )]
    #[OA\Response(
        response: 409,
        description: 'Data is not valid'
    )]
    #[OA\Parameter(
        name: 'registration',
        description: 'responses',
        in: 'query',
        schema: new OA\Schema(type: PriceDTO::class),
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: PriceDTO::class))
        )
    )]
    public function index(PriceDTO $DTO): JsonResponse
    {
        $totalPrice = $this->priceServices->priceCalculate(
            $DTO->getPrice(),
            $DTO->getStartDate(),
            $DTO->getBrithDayDate(),
            $DTO->getPayDate()
        );

        return new JsonResponse(['Success' => $totalPrice]);
    }
}
