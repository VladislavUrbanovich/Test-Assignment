<?php

declare(strict_types=1);

namespace App\Features\UserImport\DTO;

final readonly class ImportResultDTO
{
    public function __construct(
        public int $totalCount,
        public int $importedCount = 0,
        public int $updatedCount = 0
    ) {
    }
}
