<?php

declare(strict_types=1);

namespace Krisciunas\OpenAi\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use RuntimeException;

use function json_decode;

class GenerateImageCommand implements ApiCommandInterface
{
    private const ACTION = 'images/generations';

    private ClientInterface $client;

    public function __construct(?ClientInterface $client = null)
    {
        $this->client = $client ?? new Client(['base_uri' => self::BASE_URI, 'timeout' => self::DEFAULT_TIMEOUT]);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function execute(string $authorizationToken, PayloadInterface $payload): array
    {
        $response = $this->client->sendRequest($this->buildRequest($authorizationToken, $payload));
        $parsedResponse = json_decode($response->getBody()->getContents(), true);

        if (!is_array($parsedResponse) || !isset($parsedResponse['data'])) {
            $error = $parsedResponse['error']['message'] ?? 'Response format unsupported.';
            throw new RuntimeException($error);
        }

        return $parsedResponse['data'];
    }

    private function buildRequest(string $authorizationToken, PayloadInterface $payload): RequestInterface
    {
        return new Request(
            'POST',
            self::ACTION,
            [
                'Authorization' => 'Bearer ' . $authorizationToken,
                'Content-Type' => 'application/json',
            ],
            $payload->getAsString(),
        );
    }
}
