<?php

declare(strict_types=1);

namespace App\Features\UserImport\Repositories;

use App\Features\UserImport\Interfaces\ImportUserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final readonly class RandomUserImportRepository implements ImportUserRepositoryInterface
{
    const URL = 'https://randomuser.me/api/?results=20';

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        $result = collect();

        $response = Http::get(self::URL)
            ->onError(function () use ($result) {
                Log::warning('RandomUserService is unavailable');
                return $result;
            });

        $data = $response->collect();

        if ($data->has('error') || !$data->has('results')) {
            Log::warning('RandomUser service return incorrect data');
            return $result;
        }

        return collect($data->get('results'))->map(static fn($user): array => [
            'first_name' => (string)$user['name']['first'],
            'last_name' => (string)$user['name']['last'],
            'email' => (string)$user['email'],
            'age' => (int)$user['registered']['age'],
        ]);
    }
}
