<?php

namespace App\Services;

use App\Models\DashboardMetric;
use Carbon\Carbon;

class DashboardMetricService
{


  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
  }


  /**
   * Create new dashboard metric
   * data
   *
   * @param  array $newMetricData
   * @return \App\DashboardMetric
   */
  public function create($newMetricData): DashboardMetric
  {
    return DashboardMetric::updateOrCreate(
      [
        'name' => ucfirst(strtolower($newMetricData['name'])),
        'value' => $newMetricData['value'],
        'date' => Carbon::parse($newMetricData['date'])->format('Y-m-d H:i:s')
      ]
    );
  }
}
