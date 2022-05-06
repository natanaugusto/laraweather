<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;


class WeatherController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(status: HttpResponse::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json(status: HttpResponse::HTTP_CREATED);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        return response()->json(status: HttpResponse::HTTP_OK);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        return response()->json(status: HttpResponse::HTTP_ACCEPTED);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        return response()->json(status: HttpResponse::HTTP_ACCEPTED);
    }
}
