<?php

namespace App\Features\UserImport\Interfaces;

use Illuminate\Support\Collection;

interface ImportUserRepositoryInterface
{
    /**
     * @return Collection
     */
    public function get(): Collection;
}
