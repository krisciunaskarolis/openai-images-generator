# OpenAI Image generation

PHP client for OpenAI [image generation API](https://beta.openai.com/docs/guides/images/introduction) (beta). 

Client allows:
* to generate images based on text prompts.
* to download and save generated images.

## Getting Started
### Installation

```shell
composer require krisciunaskarolis/openai-images-generator
```

### Authentication

The OpenAI API uses API keys for authentication. Visit your [API Keys page](https://beta.openai.com/account/api-keys) to retrieve the API key you'll use in your requests.

### Image generation
To generate images based on text prompts:

```php
use Krisciunas\OpenAi\Api\GenerateImageCommand;
use Krisciunas\OpenAi\Api\ImagePrompt;

$authorizationToken = 'YOUR-OPENAI-API-KEY';
$imagesGenerationCommand = new GenerateImageCommand();

$imagesData = $imagesGenerationCommand->execute(
    $authorizationToken,
    new ImagePrompt(
        'small kitty playing with red fish', //A text description of the desired images. The maximum length is 1000 characters.
        4, //Number of images to generate. Must be between 1 and 10
        ImagePrompt::SIZE_256x256, // The size of generated images
        ImagePrompt::FORMAT_URL //The format in which images are returned
    ),
);
```

### Saving images

To save generated images:

```php
$imagesPersistor = new ImagesPersist('/PATH/TO/IMAGES/DIRECTORY/');
$imagesPersistor->persist($imagesData, 'FILENAME_FORMAT_%s.png');
```
Both images response formats (urls and base_64 encoded images data) are supported.

When saving images, placeholder in filename format will be replaced by images counter value, starting from 0.

## Supported response formats

```php
\Krisciunas\OpenAi\Api\ImagePrompt::FORMAT_URL;
\Krisciunas\OpenAi\Api\ImagePrompt::FORMAT_BASE_64;
```

## Supported image sizes

```php
\Krisciunas\OpenAi\Api\ImagePrompt::SIZE_256x256;
\Krisciunas\OpenAi\Api\ImagePrompt::SIZE_512x512;
\Krisciunas\OpenAi\Api\ImagePrompt::SIZE_1024x1024;
```

## Limitations

According to OpenAI, The Images API is in beta. During this time the API and models will evolve. To ensure all users can prototype comfortably, the default rate limit is 20 images per minute, 50 per 5 minutes.

## Authors
- [Karolis Kriščiūnas](mailto:karolis.krisciunas@gmail.com)