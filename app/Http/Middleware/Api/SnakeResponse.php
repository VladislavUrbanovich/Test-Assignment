<?php

declare(strict_types=1);

namespace App\Http\Middleware\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final readonly class SnakeResponse
{
    public function handle(Request $request, \Closure $next): Response
    {
        $response = $next($request);
        $content = $response->getContent();

        $json = json_decode($content, true);

        if (is_null($json)) {
            return $response;
        }

        $replaced = [];
        foreach ($json as $key => $value) {
            $replaced[Str::snake($key)] = $value;
        }

        $response->setContent(json_encode($replaced));

        return $response;
    }
}
