<?php

declare(strict_types=1);

namespace Krisciunas\OpenAi\Persist;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ImagesPersist
{
    private Client $client;

    private string $pathToImagesDirectory;

    public function __construct(string $pathToImagesDirectory)
    {
        $this->pathToImagesDirectory = $pathToImagesDirectory;
        $this->client = new Client();
    }

    /**
     * @return string[]
     * @throws GuzzleException
     */
    public function persist(array $imagesData, string $filenameFormat = 'file_%s.png'): array
    {
        $counter = 0;
        $savedFiles = [];

        foreach ($imagesData as $imageData) {
            if (isset($imageData['b64_json'])) {
                $savedFiles[] = $this->saveEncodedDataToFile(
                    $imageData['b64_json'],
                   $this->prepareFilename($filenameFormat, $counter++)
                );

                continue;
            }

            if (isset($imageData['url'])) {
                $savedFiles[] = $this->downloadFile(
                    $imageData['url'],
                    $this->prepareFilename($filenameFormat, $counter++)
                );
            }
        }

        return $savedFiles;
    }

    private function prepareFilename(string $filenameFormat, int $imageNumber): string
    {
        return rtrim($this->pathToImagesDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR .
            sprintf($filenameFormat, $imageNumber);
    }

    private function saveEncodedDataToFile(string $encodedData, string $filename): string
    {
        file_put_contents($filename, base64_decode($encodedData));

        return $filename;
    }

    /**
     * @throws GuzzleException
     */
    private function downloadFile(string $url, string $pathToFile): string
    {
        $this->client->request('GET', $url, ['sink' => $pathToFile]);

        return $pathToFile;
    }
}
