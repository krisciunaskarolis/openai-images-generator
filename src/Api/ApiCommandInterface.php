<?php

declare(strict_types=1);

namespace Krisciunas\OpenAi\Api;

interface ApiCommandInterface
{
    public const BASE_URI = 'https://api.openai.com/v1/';
    public const DEFAULT_TIMEOUT = 360;

    public function execute(string $authorizationToken, PayloadInterface $payload): array;
}