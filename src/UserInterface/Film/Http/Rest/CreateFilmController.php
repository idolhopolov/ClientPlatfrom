<?php

declare(strict_types=1);

namespace App\UserInterface\Film\Http\Rest;

use App\Application\Common\DTO\Response as ApiResponse;
use App\Application\Film\Command\CreateFilm\CreateFilmCommand;
use App\Application\Film\Command\Input\DTO\FilmPayload;
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
class CreateFilmController extends CommonController
{
    #[OA\Response(
        response: Response::HTTP_CREATED,
        description: 'Create film',
        content: new Model(type: ApiResponse::class)
    )]
    #[OA\RequestBody(content: new Model(type: FilmPayload::class))]
    #[Route('/create', methods: [Request::METHOD_POST])]
    #[Security(name: 'Bearer')]
    public function __invoke(Request $request): JsonResponse
    {
        try{
            /** @var FilmPayload $payload*/
            $payload = $this->getPayloadInputAsObject($request, FilmPayload::class);

            $this->commandBus->handle(new CreateFilmCommand($payload));

            return $this->getResponse(content: Response::$statusTexts[Response::HTTP_CREATED], code: Response::HTTP_CREATED);

        } catch (\Throwable $exception) {

            return $this->getErrorResponse($exception);
        }
    }
}