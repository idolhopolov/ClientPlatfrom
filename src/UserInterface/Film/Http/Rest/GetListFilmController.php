<?php

declare(strict_types=1);

namespace App\UserInterface\Film\Http\Rest;

use App\Application\Common\DTO\Response as ApiResponse;
use App\Application\Film\Query\GetListFilm\GetListFilmQuery;
use App\Application\Film\Query\Input\Transformer\FilmQueryInputTransformer;
use App\UserInterface\Common\Http\Rest\CommonController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1/film', name: 'client_portal_film')]
#[OA\Tag(name: 'Client Portal / Film')]
class GetListFilmController extends CommonController
{

    #[OA\Parameter(
        name: 'withRandom',
        description: 'Input [x] random entities',
        in: 'query',
        required: false,
        schema: new OA\Schema(
            type: 'integer',
            example: '5'
        )
    )]
    #[OA\Parameter(
        name: 'withMultipleWords',
        description: 'Input entities with multiple words',
        in: 'query',
        required: false,
        schema: new OA\Schema(
            type: 'boolean',
            example: 'true'
        )
    )]
    #[OA\Parameter(
        name: 'withFirstLetter',
        description: 'Input entities by first word',
        in: 'query',
        required: false,
        schema: new OA\Schema(
            type: 'string',
            example: 'W'
        )
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Get product list',
        content: new Model(type: ApiResponse::class)
    )]
    #[Route('/list', methods: [Request::METHOD_GET])]
    #[Security(name: 'Bearer')]
    public function __invoke(Request $request): JsonResponse
    {
        try{
            $filter = FilmQueryInputTransformer::makeFromRequest($request->query);

            $response = $this->queryBus->handle(new GetListFilmQuery($filter));

            return $this->getResponse(content: $response, groups: ['film_list']);

        } catch (\Throwable $exception) {

            return $this->getErrorResponse($exception);
        }
    }
}