<?php

declare(strict_types=1);

namespace Krisciunas\OpenAi\Api;

use RuntimeException;

class ImagePrompt implements PayloadInterface
{
    public const SIZE_256x256 = '256x256';
    public const SIZE_512x512 = '512x512';
    public const SIZE_1024x1024 = '1024x1024';

    public const FORMAT_URL = 'url';
    public const FORMAT_BASE_64 = 'b64_json';

    public string $description = '';

    public int $numberOfImages = 1;

    public string $size = '';

    public string $responseFormat = '';

    public function __construct(
        string $description,
        int $numberOfImages = 1,
        string $size = self::SIZE_1024x1024,
        string $responseFormat = 'url'
    ) {
        if (
            strlen($description) > 1000 ||
            $numberOfImages > 10 ||
            $numberOfImages < 1 ||
            !in_array($size, [self::SIZE_256x256, self::SIZE_512x512, self::SIZE_1024x1024]) ||
            !in_array($responseFormat, [self::FORMAT_URL, self::FORMAT_BASE_64])
        ) {
            throw new RuntimeException('Given image parameters are not supported.');
        }

        $this->description = $description;
        $this->numberOfImages = $numberOfImages;
        $this->size = $size;
        $this->responseFormat = $responseFormat;
    }

    public function getAsString(): string
    {
        return json_encode(
            [
                'prompt' => $this->description,
                'n' => $this->numberOfImages,
                'size' => $this->size,
                'response_format' => $this->responseFormat,
            ]
        );
    }
}
