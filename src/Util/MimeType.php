<?php

declare(strict_types=1);

namespace Application\Util;

final class MimeType
{
    /* CSV */
    public const TEXT_CSV = 'text/csv';
    public const APPLICATION_CSV = 'application/csv';
    public const ALL_CSV = [self::TEXT_CSV, self::APPLICATION_CSV];
}
