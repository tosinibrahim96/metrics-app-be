<?php

namespace Database\Seeders;

use App\Models\DashboardMetric;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DashboardMetricSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    $metricNames = ['Sales', 'Expenses', 'Taxes', 'Extras'];
    $data = [];

    foreach ($metricNames as $key => $name) {

      $numberOfDaysToCreateRecordsFor = 5;
      
      for ($i = 0; $i < $numberOfDaysToCreateRecordsFor; $i++) {

        $day = Carbon::now()->addDays($i);

        $dayInfo = [
          'name' => $name,
          'value' => rand(1000, 99999),
          'date' => $day->format('Y-m-d H:i:s'),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ];

        $hourInfo = [
          'name' => $name,
          'value' => rand(1000, 99999),
          'date' => $day->addHours(rand(1, 20))->format('Y-m-d H:i:s'),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ];

        $minuteInfo = [
          'name' => $name,
          'value' => rand(1000, 99999),
          'date' => $day->addHours(rand(1, 20))->minutes(rand(1, 50))->format('Y-m-d H:i:s'),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ];

        $data[] = $dayInfo;
        $data[] = $hourInfo;
        $data[] = $minuteInfo;
      }
    }

    DashboardMetric::insert($data);
  }
}
