<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDashboardMetricRequest;
use App\Http\Requests\GetDashboardMetricRequest;
use App\Http\Response;
use App\Repositories\DashboardMetricRepository;
use App\Services\DashboardMetricService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;


class DashboardMetricsController extends Controller
{

  /**
   * Create a dashboard metric record
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function create(CreateDashboardMetricRequest $request, DashboardMetricService $dashboardMetricService): JsonResponse
  {
    $data = $dashboardMetricService->create($request->validated());

    return Response::send(
      true,
      HttpResponse::HTTP_CREATED,
      "New metric added successfully",
      $data
    );
  }


  /**
   * Get dashboard metrics for an entity
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(GetDashboardMetricRequest $request, DashboardMetricRepository $dashboardMetricRepository): JsonResponse
  {
    $filters = $request->safe()->collect();
    $data = $dashboardMetricRepository->getMetricForAPeriod($filters);

    return Response::send(
      true,
      HttpResponse::HTTP_OK,
      "{$request->validated()['duration']} Metrics for {$request->validated()['name']} between {$request->validated()['start_date']} and {$request->validated()['end_date']} retireved successfully",
      $data
    );
  }


  /**
   * Get the names of the metrics currently saved
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getMetricsNames(Request $request, DashboardMetricRepository $dashboardMetricRepository): JsonResponse
  {
    $names = $dashboardMetricRepository->getMetricNames();

    return Response::send(
      true,
      HttpResponse::HTTP_OK,
      "Metric names retireved successfully",
      $names
    );
  }
}
