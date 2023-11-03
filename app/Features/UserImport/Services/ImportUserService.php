<?php

declare(strict_types=1);

namespace App\Features\UserImport\Services;

use App\Features\UserImport\DTO\ImportResultDTO;
use App\Features\UserImport\Interfaces\ImportUserRepositoryInterface;
use App\Features\UserImport\Repositories\LocalUserImportRepository;

final readonly class ImportUserService
{
    /**
     * Разные чанки до и включая 5к показывают примерно одинаковые результаты по скорости на upsert
     */
    const UPSERT_CHUNK_SIZE = 1000;

    /**
     * @param LocalUserImportRepository $localUserImportRepository
     * @param ImportUserRepositoryInterface $importUserRepository
     */
    public function __construct(
        private LocalUserImportRepository $localUserImportRepository,
        private ImportUserRepositoryInterface $importUserRepository
    ) {
    }

    /**
     * @return ImportResultDTO
     */
    public function import(): ImportResultDTO
    {
        $recordsCountBeforeTransaction = $this->localUserImportRepository->totalCount();
        $usersToImport = $this->importUserRepository->get();

        if ($usersToImport->isEmpty()) {
            return new ImportResultDTO(
                totalCount: $recordsCountBeforeTransaction
            );
        }

        /**
         * Изначально полагал, что upsert вернет нам отдельно количество затронутых строк по вставке и обновлению
         * Но он возвращает сумму чисел за каждую строку, где 0 - пропуск, 1 - инсерт, 2 - апдейт
         * Ввиду этого пришлось узнать количество вставленных строк как дельту между двумя COUNT(*),
         * EXPLAIN показал что primary индекс используется, по идее должно отрабатывать быстро
         */
        $upsertCount = 0;
        foreach ($usersToImport->chunk(self::UPSERT_CHUNK_SIZE) as $chunk) {
            $upsertCount += $this->localUserImportRepository->upsert($chunk);
        }

        $recordsCountAfterTransaction = $this->localUserImportRepository->totalCount();
        $recordsInserted = $recordsCountAfterTransaction - $recordsCountBeforeTransaction;
        $recordsUpdated = ($upsertCount - $recordsInserted) / 2;

        return new ImportResultDTO(
            totalCount: $recordsCountAfterTransaction,
            importedCount: $recordsInserted,
            updatedCount: $recordsUpdated
        );
    }
}
