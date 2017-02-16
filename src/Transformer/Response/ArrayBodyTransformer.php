<?php

/*
 * This file is part of the zibios/wrike-php-library package.
 *
 * (c) Zbigniew Ślązak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zibios\WrikePhpLibrary\Transformer\Response;

use Psr\Http\Message\ResponseInterface;
use Zibios\WrikePhpLibrary\Transformer\AbstractResponseTransformer;

/**
 * Array Body Transformer.
 */
class ArrayBodyTransformer extends AbstractResponseTransformer
{
    /**
     * @param ResponseInterface $response
     * @param string            $resourceClass
     *
     * @throws \RuntimeException
     *
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function transform(ResponseInterface $response, $resourceClass)
    {
        return $this->transformToArrayBody($response);
    }
}
