<?php

require '../vendor/autoload.php';

use Krisciunas\OpenAi\Api\GenerateImageCommand;
use Krisciunas\OpenAi\Api\ImagePrompt;
use Krisciunas\OpenAi\Persist\ImagesPersist;

$authorizationToken = 'YOUR-OPENAI-API-KEY';

$imagesGenerationCommand = new GenerateImageCommand();
$imagesPersistor = new ImagesPersist('/PATH/TO/IMAGES/DIRECTORY/');

$imagesData = $imagesGenerationCommand->execute(
    $authorizationToken,
    new ImagePrompt(
        'small kitty playing with red fish',
        4,
        ImagePrompt::SIZE_256x256,
        ImagePrompt::FORMAT_BASE_64
    ),
);

$imagesPersistor->persist($imagesData, 'kitty_%s.png');