<?php

declare(strict_types=1);

namespace Krisciunas\OpenAi\Api;

interface PayloadInterface
{
    public function getAsString(): string;
}