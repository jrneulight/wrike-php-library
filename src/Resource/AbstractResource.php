<?php

/*
 * This file is part of the zibios/wrike-php-library package.
 *
 * (c) Zbigniew Ślązak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zibios\WrikePhpLibrary\Resource;

use Zibios\WrikePhpLibrary\Client\ClientInterface;
use Zibios\WrikePhpLibrary\Enum\Api\RequestMethodEnum;
use Zibios\WrikePhpLibrary\Enum\Api\ResourceMethodEnum;
use Zibios\WrikePhpLibrary\Transformer\ResponseTransformerInterface;

/**
 * Resource Abstract.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class AbstractResource implements ResourceInterface
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var ResponseTransformerInterface
     */
    protected $responseTransformer;

    /**
     * @param ClientInterface              $client
     * @param ResponseTransformerInterface $responseTransformer
     */
    public function __construct(
        ClientInterface $client,
        ResponseTransformerInterface $responseTransformer
    ) {
        $this->client = $client;
        $this->responseTransformer = $responseTransformer;
    }

    /**
     * @return array
     */
    abstract protected function getResourceMethodConfiguration();

    /**
     * @param string            $requestMethod
     * @param string            $resourceMethod
     * @param array             $params
     * @param string|array|null $id
     *
     * @throws \RuntimeException
     * @throws \LogicException
     * @throws \Exception
     * @throws \InvalidArgumentException
     * @throws \Zibios\WrikePhpLibrary\Exception\Api\ApiException
     * @throws \Zibios\WrikePhpLibrary\Exception\Api\AccessForbiddenException
     * @throws \Zibios\WrikePhpLibrary\Exception\Api\InvalidParameterException
     * @throws \Zibios\WrikePhpLibrary\Exception\Api\InvalidRequestException
     * @throws \Zibios\WrikePhpLibrary\Exception\Api\NotAllowedException
     * @throws \Zibios\WrikePhpLibrary\Exception\Api\NotAuthorizedException
     * @throws \Zibios\WrikePhpLibrary\Exception\Api\ParameterRequiredException
     * @throws \Zibios\WrikePhpLibrary\Exception\Api\ResourceNotFoundException
     * @throws \Zibios\WrikePhpLibrary\Exception\Api\ServerErrorException
     *
     * @return mixed
     */
    protected function executeRequest($requestMethod, $resourceMethod, array $params, $id)
    {
        RequestMethodEnum::assertIsValidValue($requestMethod);
        ResourceMethodEnum::assertIsValidValue($resourceMethod);

        try {
            $response = $this->client->executeRequestForParams(
                $requestMethod,
                $this->prepareRequestPathForResourceMethod($resourceMethod, $id),
                $params
            );
        } catch (\Exception $e) {
            throw $this->client->transformApiException($e);
        }

        return $this->responseTransformer->transform($response, static::class);
    }

    /**
     * @param string            $resourceMethod
     * @param string|array|null $id
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    private function prepareRequestPathForResourceMethod($resourceMethod, $id)
    {
        $requestPathFormat = $this->calculateRequestPathFormat($resourceMethod);

        switch ($resourceMethod) {
            case ResourceMethodEnum::GET_ALL:
                $this->assertIsNull($id);
                $path = sprintf($requestPathFormat, $id);
                break;

            case ResourceMethodEnum::GET_BY_IDS:
                $this->assertIsValidIdArray($id);
                $path = sprintf($requestPathFormat, implode(',', $id));
                break;

            case ResourceMethodEnum::GET_ALL_IN_ACCOUNT:
            case ResourceMethodEnum::CREATE_IN_ACCOUNT:
            case ResourceMethodEnum::GET_BY_ID:
            case ResourceMethodEnum::UPDATE:
            case ResourceMethodEnum::DELETE:
                $this->assertIsValidIdString($id);
                $path = sprintf($requestPathFormat, $id);
                break;

            default:
                throw new \InvalidArgumentException(sprintf('"%s" resource method not yet supported', $resourceMethod));
        }

        return $path;
    }

    /**
     * @param string $resourceMethod
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    private function calculateRequestPathFormat($resourceMethod)
    {
        $resourceMethodConfiguration = $this->getResourceMethodConfiguration();
        if (array_key_exists($resourceMethod, $resourceMethodConfiguration) === false) {
            throw new \InvalidArgumentException();
        }

        return $resourceMethodConfiguration[$resourceMethod];
    }

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    private function assertIsNull($value)
    {
        if ($value !== null) {
            throw new \InvalidArgumentException();
        }
    }

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    private function assertIsValidIdString($value)
    {
        if (is_string($value) === false || trim($value) === '' || strlen($value) > 16) {
            throw new \InvalidArgumentException(sprintf('Invalid Id, should be not empty string!'));
        }
    }

    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     */
    private function assertIsValidIdArray($value)
    {
        if (is_array($value) === false) {
            throw new \InvalidArgumentException();
        }

        /** @var array $value */
        foreach ($value as $id) {
            $this->assertIsValidIdString($id);
        }
    }
}
