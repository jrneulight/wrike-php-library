<?php

/*
 * This file is part of the zibios/wrike-php-library package.
 *
 * (c) Zbigniew Ślązak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zibios\WrikePhpLibrary\Tests\Transformer\Exception\Api;

use Zibios\WrikePhpLibrary\Tests\Transformer\ApiExceptionTransformerTestCase;
use Zibios\WrikePhpLibrary\Transformer\Exception\Api\RawTransformer;

/**
 * Raw Transformer Test.
 */
class RawTransformerTest extends ApiExceptionTransformerTestCase
{
    public function test_transform()
    {
        $exception = new \Exception();
        $transformer = new RawTransformer();
        self::assertSame($exception, $transformer->transform($exception));
    }
}
