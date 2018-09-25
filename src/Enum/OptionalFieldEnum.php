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

namespace Zibios\WrikePhpLibrary\Enum;

/**
 * Optional Field Enum.
 */
class OptionalFieldEnum extends AbstractEnum
{
    /**
     * Metadata.
     */
    public const METADATA = 'metadata';

    /**
     * Subscription.
     */
    public const SUBSCRIPTION = 'subscription';

    /**
     * Custom Fields.
     */
    public const CUSTOM_FIELDS = 'customFields';

    /**
     * Brief Description.
     */
    public const BRIEF_DESCRIPTION = 'briefDescription';

    /**
     * Custom Column Ids.
     */
    public const CUSTOM_COLUMN_IDS = 'customColumnIds';

    /**
     * Attachment Count.
     */
    public const ATTACHMENT_COUNT = 'attachmentCount';
}
