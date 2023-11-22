<?php

namespace App\Tests\Api;

use App\Domain\User\Entity\User;
use App\Tests\FixturesFactory\DoctrineModelFactory;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;

abstract class ApiJsonTestCase extends WebTestCase
{
    protected ?KernelBrowser $client = null;
    protected ?DoctrineModelFactory $factory = null;

    public function assertJsonResponse(
        Response $response,
        int $code = Response::HTTP_OK
    ): void {
        $this->assertSame($code, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    public function assertOtherResponse(
        Response $response,
        int $code = Response::HTTP_OK
    ): void {
        $this->assertSame($code, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response);
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->factory = new DoctrineModelFactory(
            $this->service('doctrine.orm.default_entity_manager'), DoctrineModelFactory::DBNAME_TEST);
    }

    protected function tearDown(): void
    {
        /**
         * @var $cache CacheClearerInterface
         */
        $cache = self::getContainer()->get('cache.default_clearer');
        $cache->clear('');
        $this->service('doctrine.orm.default_entity_manager')->clear();
        $this->client = null;
        $this->factory = null;
        parent::tearDown();
    }

    protected function service(string $serviceId): mixed
    {
        return self::getContainer()->get($serviceId);
    }

    protected function post(string $uri, array $params = []): void
    {
        $this->client->request(
            'POST',
            $uri,
            [],
            [],
            $this->headers(),
            (string) json_encode($params)
        );
    }

    protected function put(string $uri, array $params = []): void
    {
        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            $this->headers(),
            (string) json_encode($params)
        );
    }

    protected function get(string $uri, array $parameters = []): void
    {
        $this->client->request(
            'GET',
            $uri,
            $parameters,
            [],
            $this->headers()
        );
    }

    protected function delete(string $uri, array $parameters = []): void
    {
        $this->client->request(
            'DELETE',
            $uri,
            $parameters,
            [],
            $this->headers()
        );
    }

    protected function authClient(): void
    {
        $email = 'test@gmail.com';
        $pass = 'testPassword';

        $this->factory->create(User::class, ['email' => $email, 'pass' => $pass]);

        $this->post('api/v1/login', [
            'email' => $email,
            'password' => $pass
        ]);

        $data = json_decode($this->client->getResponse()->getContent(), true);

        $this->client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['data']['token']));
    }

    private function headers(): array
    {
        return [
            'CONTENT_TYPE' => 'application/json',
        ];
    }
}