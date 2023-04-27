<?php

namespace App\Services;

use App\Models\DashboardMetric;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardMetricRepository
{

  protected $metricQueryBuilder;

  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
  }


  /**
   * Get metric data for a time period
   *
   * @param  array $newMetricData
   * @return array
   */
  public function getMetricForAPeriod($filters)
  {
    $startDate = $filters->pull('start_date') ?? null;
    $endDate = $filters->pull('end_date') ?? null;
    $duration = $filters->pull('duration') ?? '';
    $name = $filters->pull('name');

    $duration = strtolower($duration);

    $databaseMetrics = $this->getMetricsFromDatabase($name, $duration, $startDate, $endDate);
    $finalResult = $this->setValuesForCorrespondingGeneratedDates($databaseMetrics->toArray(), $duration, $startDate, $endDate);
    
    return $finalResult;
  }


  
  /**
   * Get metrics from database
   *
   * @param  mixed $name
   * @param  mixed $duration
   * @param  mixed $startDate
   * @param  mixed $endDate
   * @return \illuminate\Support\Collection
   */
  private function getMetricsFromDatabase($name, $duration, $startDate, $endDate)
  {

    $dateFormatLokup = [
      'day' => '%Y-%m-%d 00:00:00',
      'hour' => '%Y-%m-%d %H:00:00',
      'minute' => '%Y-%m-%d %H:%i:00'
    ];

    return DB::table('dashboard_metrics')
      ->where('name', $name)
      ->whereBetween('date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
      ->select(DB::raw("DATE_FORMAT(date, '$dateFormatLokup[$duration]') as $duration"))
      ->groupBy($duration)
      ->selectRaw('AVG(value) as average_value')
      ->get();
  }



    /**
   * Set values for all dates generated between start date and end date
   *
   * @param  \illuminate\Support\Collection $databaseMetrics
   * @param  array $duration
   * @param  mixed $startDate
   * @param  mixed $endDate
   * @return array
   */
  private function setValuesForCorrespondingGeneratedDates($databaseMetrics, $duration, $startDate, $endDate)
  { 
    $datesGenerated = [];

    foreach ($databaseMetrics as $record) {
      $datesGenerated[$record->{$duration}] = $record->average_value;

    }
    
    return $datesGenerated;
  }



  /**
   * Get all metric names from the database
   *
   * @return \illuminate\Support\Collection
   */
  public function getMetricNames()
  {
   return DashboardMetric::select('id','name')->get()->groupBy('name')->keys();
  }
}
