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

    public function fetch(Request $request, string $city): JsonResponse
    {
        try {
            $weather = WeatherResource::fetch(data: ['city' => $city]);
            return response()->json(
                data: $weather,
                status: $weather->wasCreated() ? HttpResponse::HTTP_CREATED : HttpResponse::HTTP_OK
            );
        } catch (\Throwable $e) {
            return response()->json(data: [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], status: HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Request $request, string $city): JsonResponse
    {
        $city = City::where(
            column: 'name',
            operator: '=',
            value: $city
        )->first();
        if (!is_null($city) && $city->delete()) {
            return response()->json(status: HttpResponse::HTTP_ACCEPTED);
        }
        return response()->json(status: HttpResponse::HTTP_NOT_FOUND);
    }
}
