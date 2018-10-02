<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/wrike-php-library package.
 *
 * (c) Zbigniew Ślązak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zibios\WrikePhpLibrary\Tests\Enum;

use Zibios\WrikePhpLibrary\Enum\CustomFieldAggregationEnum;

/**
 * Custom Field Aggregation Enum Test.
 */
class CustomFieldAggregationEnumTest extends EnumTestCase
{
    /**
     * @var string
     */
    protected $sourceClass = CustomFieldAggregationEnum::class;

    /**
     * @var int
     */
    protected $enumCount = 3;
}
