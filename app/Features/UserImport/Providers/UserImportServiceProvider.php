<?php

declare(strict_types=1);

namespace App\Features\UserImport\Providers;

use App\Features\UserImport\Interfaces\ImportUserRepositoryInterface;
use App\Features\UserImport\Repositories\RandomUserImportRepository;
use Illuminate\Support\ServiceProvider;

final class UserImportServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ImportUserRepositoryInterface::class, RandomUserImportRepository::class);
    }
}
