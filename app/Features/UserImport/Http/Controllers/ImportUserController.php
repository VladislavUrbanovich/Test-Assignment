<?php

declare(strict_types=1);

namespace App\Features\UserImport\Http\Controllers;

use App\Features\UserImport\Services\ImportUserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ImportUserController extends Controller
{
    /**
     * @param Request $request
     * @param ImportUserService $importUserService
     * @return JsonResponse
     */
    public function __invoke(Request $request, ImportUserService $importUserService): JsonResponse
    {
        return new JsonResponse($importUserService->import());
    }
}

