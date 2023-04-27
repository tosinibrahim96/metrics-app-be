<?php

use Carbon\Carbon;


if (!function_exists('buildDatesForDashboardMetrics')) {
  /**
   * Build dates data for dashboard metrics
   *
   * @param  mixed $startDate
   * @param  mixed $endDate
   * @param  string $interval
   * @return array
   */
  function buildDatesForDashboardMetrics($startDate, $endDate, $interval)
  {
    $interval = strtolower($interval);
    $dates = [];
    $intervalLokup = [
      'day' => 'P1D',
      'hour' => 'PT1H',
      'minute' => 'PT1M'
    ];

    $interval = new DateInterval($intervalLokup[$interval]);

    $startDate = Carbon::parse($startDate)->startOfDay();
    $endDate = Carbon::parse($endDate)->endOfDay();

    $period = new DatePeriod( $startDate, $interval, $endDate);

    foreach ($period as $date) {
      $dates[$date->format('Y-m-d H:i:s')] = 0;
    }

    return $dates;
  }
}
