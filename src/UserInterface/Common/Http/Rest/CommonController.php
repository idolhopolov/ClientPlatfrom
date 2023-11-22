<?php

declare(strict_types=1);

namespace App\UserInterface\Common\Http\Rest;

use App\Application\Common\Command\Bus\CommandBusInterface;
use App\Application\Common\DTO\Response as ApiResponse;
use App\Application\Common\Query\Bus\DTO\ObjectResponse;
use App\Application\Common\Query\Bus\QueryBusInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CommonController extends AbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        /** @var array<string, int>*/
        private readonly array $exceptionToStatus,
        protected readonly QueryBusInterface $queryBus,
        protected readonly CommandBusInterface $commandBus,
        protected readonly SerializerInterface $serializer
    )
    {
    }

    final protected function getResponse(string|ObjectResponse $content, array $groups = [], int $code = Response::HTTP_OK): JsonResponse
    {

        $response = new ApiResponse(
            $code,
            '',
            ''
        );

        if (is_string($content)) {
            $response->message = $content;
        }
        else if ($content instanceof ObjectResponse) {
            $response->data = $content;
        } else {
            throw new \UnexpectedValueException('Invalid content value');
        }

        return new JsonResponse(
           data: $this->serializer->serialize($response,'json', SerializationContext::create()->setGroups(array_merge(['default'], $groups))),
           status: $code,
           json: true
        );
    }

    protected function getErrorResponse(\Throwable $exception): JsonResponse
    {
        return $this->getResponse(
            $this->determineExceptionMessage($exception) ?? 'application_crashes_with_an_error',
            [],
            $this->determineStatusCode($exception)
        );
    }

    /**
     * @throws \JsonException
     */
    final protected function getPayloadInputAsObject(Request $request, string $objectType, array $groups = []): mixed
    {
        $content = $request->getContent();

        if (!$content) {
            throw new BadRequestHttpException('Empty body', code: 400);
        }

        try {
            $result = $this->serializer->deserialize($content, $objectType, 'json');
            $this->validate($result, $groups);

            return $result;
        } catch (\InvalidArgumentException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }
    }

    /**
     * @throws \JsonException
     */
    private function validate($payload, array $groups = []): void
    {
        $errors = $this->validator->validate($payload, null, $groups);

        if ($errors->count()) {
            $result = [];
            /** @var ConstraintViolationInterface $error */
            foreach ($errors as $error) {
                $result['errors'][] = [
                    'message' => $error->getMessage(),
                    'path' => $error->getPropertyPath(),
                ];
            }

            throw new BadRequestHttpException(\json_encode($result, JSON_THROW_ON_ERROR), code: 400);
        }
    }

    private function determineExceptionMessage(\Throwable $exception): string|null
    {
        $exceptionClass = \get_class($exception);

        foreach ($this->exceptionToStatus as $class => $status) {
            if (\is_a($exceptionClass, $class, true)) {
                return $exception->getMessage();
            }
        }

        return null;
    }

    private function determineStatusCode(\Throwable $exception): int
    {
        $exceptionClass = \get_class($exception);

        foreach ($this->exceptionToStatus as $class => $status) {
            if (\is_a($exceptionClass, $class, true)) {
                return $status;
            }
        }

        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}