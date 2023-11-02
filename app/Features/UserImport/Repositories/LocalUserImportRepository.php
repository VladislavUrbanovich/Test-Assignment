<?php

declare(strict_types=1);

namespace App\Features\UserImport\Repositories;

use App\Features\UserImport\Models\ImportedUser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final readonly class LocalUserImportRepository
{
    /**
     * @param Collection $collection
     * @return int
     */
    public function upsert(Collection $collection): int
    {
        return DB::table('imported_users')->upsert($collection->toArray(), ['first_name', 'last_name'], ['email', 'age']);
    }

    /**
     * @return int
     */
    public function totalCount(): int
    {
        return ImportedUser::query()->count();
    }
}
