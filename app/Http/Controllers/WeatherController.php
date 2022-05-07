<?php

namespace App\Http\Controllers;

use App\Http\Resources\WeatherResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;


class WeatherController extends Controller
{
    public function index(): JsonResponse
    {
        $cities = City::all();
        if ($cities->count() > 0) {
            $weather = WeatherResource::collection($cities);
            return response()->json(data: $weather,status: HttpResponse::HTTP_OK);
        }

        return response()->json(status: HttpResponse::HTTP_NO_CONTENT);
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
