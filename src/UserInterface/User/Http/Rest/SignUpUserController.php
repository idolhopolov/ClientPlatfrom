<?php

declare(strict_types=1);

namespace App\UserInterface\User\Http\Rest;

use App\Application\Common\DTO\Response as ApiResponse;
use App\Application\User\Command\SignUp\Input\DTO\SignUpUserPayload;
use App\Application\User\Command\SignUp\SignUpUserCommand;
use App\UserInterface\Common\Http\Rest\CommonController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route(path: '/api/v1', name: 'client_portal_film')]
#[OA\Tag(name: 'Client Portal / User')]
class SignUpUserController extends CommonController
{
    #[OA\Response(
        response: Response::HTTP_CREATED,
        description: 'Create film',
        content: new Model(type: ApiResponse::class)
    )]
    #[OA\RequestBody(content: new Model(type: SignUpUserPayload::class))]
    #[Route('/register', methods: [Request::METHOD_POST])]
    #[Security(name: 'Bearer')]
    public function __invoke(Request $request): JsonResponse
    {
        try{
            /** @var SignUpUserPayload $payload*/
            $payload = $this->getPayloadInputAsObject($request, SignUpUserPayload::class);

            $this->commandBus->handle(new SignUpUserCommand($payload));

            return $this->getResponse(content: Response::$statusTexts[Response::HTTP_CREATED], code: Response::HTTP_CREATED);

        } catch (\Throwable $exception) {

            return $this->getErrorResponse($exception);
        }
    }
}