<?php

namespace Tests\Feature;

use App\Models\DashboardMetric;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardMetricTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test retrieving metric names from the database via GET request.
     *
     * @return void
     */
    public function testRetrieveMetricNamesData()
    {
        $names = ['Sales', 'Taxes'];

        for ($i = 0; $i < 2; $i++) {

            $day = Carbon::now()->addDays($i);

            DashboardMetric::create([
                'name' => $names[$i],
                'value' => rand(1000, 99999),
                'date' => $day->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $response = $this->get('/api/v1/metrics/names');
        $response->assertStatus(200);
        $response->assertSee('Sales');
        $response->assertSee('Taxes');
        $response->assertDontSee('Others');
    }



    /**
     * Test create new metric
     *
     * @return void
     */
    public function testCreateMetricNamesData()
    {
        $response = $this->post('/api/v1/metrics', [
            'name' => 'Sales',
            'value' => rand(1000, 99999),
            'date' => Carbon::now()->format('Y-m-d H:i:s')

        ]);

        $response->assertStatus(201);
        $response->assertSee('New metric added successfully');
    }


    /**
     * Create new metric and send a request to get metrics names
     *
     * @return void
     */
    public function testCreateMetricAndGetNewMetricNamesInListEndpoint()
    {
        $creationResponse = $this->post('/api/v1/metrics', [
            'name' => 'New metrics',
            'value' => rand(1000, 99999),
            'date' => Carbon::now()->format('Y-m-d H:i:s')

        ]);

        $creationResponse->assertStatus(201);
        $creationResponse->assertSee('New metric added successfully');


        $getMetricsNamesresponse = $this->get('/api/v1/metrics/names');
        $getMetricsNamesresponse->assertStatus(200);
        $getMetricsNamesresponse->assertSee('New metrics');
    }




    /**
     * Create new metric and send a request to get metrics names
     *
     * @return void
     */
    public function testCreateMetricsAndGetMetricsDataForDayParams()
    {
        $names = ['Sales', 'Sales', 'Sales', 'Sales'];
        $values = [5000, 5000, 5000, 4000];

        for ($i = 0; $i < count($names); $i++) {

            $day = Carbon::now()->addDays($i);

            DashboardMetric::create([
                'name' => $names[$i],
                'value' => $values[$i],
                'date' => $day->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $startDate = Carbon::now()->format('Y-m-d 00:00:00');
        $endDate = Carbon::now()->addDays(count($names) - 1)->format('Y-m-d 00:00:00');
        
        $url = "/api/v1/metrics?start_date=$startDate&end_date=$endDate&name=Sales&duration=Day";
        $response = $this->get($url);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "status" => true,
            "message" => "Day Metrics for Sales between $startDate and $endDate retireved successfully"
        ]);

        $data = json_decode($response->getContent())->data;

        $this->assertIsObject($data);

        /**
         * Our specified start date is in the returned data
         */
        $this->assertTrue(property_exists($data, $startDate));
        $this->assertTrue(property_exists($data, $endDate));
        
        /**
         * The value for the specified date should be the correct average
         */
        $this->assertTrue(property_exists($data, $endDate) && $data->{$endDate} == 4000);
        $this->assertTrue(property_exists($data, $startDate) && $data->{$startDate} == 5000);
    }


     /**
     * Create new metric and send a request to get metrics names
     *
     * @return void
     */
    public function testCreateMetricsAndGetMetricsDataForHourParams()
    {
        $names = ['Sales', 'Sales', 'Sales', 'Sales'];
        $values = [5000, 5000, 5000, 4000];
        

        for ($i = 0; $i < count($names); $i++) {

            $day = Carbon::now()->addDays($i);

            DashboardMetric::create([
                'name' => $names[$i],
                'value' => $values[$i],
                'date' => $day->format("Y-m-d 0$i:00:00"),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        
        $date1 = Carbon::now()->format('Y-m-d 00:00:00');
        $date2 = Carbon::now()->addDays(1)->format('Y-m-d 01:00:00');
        $date3 = Carbon::now()->addDays(2)->format('Y-m-d 02:00:00');
        $date4 = Carbon::now()->addDays(3)->format('Y-m-d 03:00:00');


        $startDate = $date1;
        $endDate = $date4;

        $date1 = Carbon::now()->format('Y-m-d 00:00:00');
        $url = "/api/v1/metrics?start_date=$startDate&end_date=$endDate&name=Sales&duration=Hour";
        $response = $this->get($url);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "status" => true,
            "message" => "Hour Metrics for Sales between $startDate and $endDate retireved successfully"
        ]);

        $data = json_decode($response->getContent())->data;

        $this->assertIsObject($data);

        /**
         * Our specified start date is in the returned data
         */
        $this->assertTrue(property_exists($data, $startDate));
        $this->assertTrue(property_exists($data, $endDate));
        
        /**
         * The value for the specified date should be the correct average
         */
        $this->assertTrue(property_exists($data, $endDate) && $data->{$endDate} == 4000);
        $this->assertTrue(property_exists($data, $startDate) && $data->{$startDate} == 5000);
    }
    


     /**
     * Create new metric and send a request to get metrics names
     *
     * @return void
     */
    public function testCreateMetricsAndGetMetricsDataForMinuteParams()
    {
        $names = ['Sales', 'Sales', 'Sales', 'Sales'];
        $values = [5000, 5000, 5000, 4000];
        

        for ($i = 0; $i < count($names); $i++) {

            $day = Carbon::now()->addDays($i);

            DashboardMetric::create([
                'name' => $names[$i],
                'value' => $values[$i],
                'date' => $day->format("Y-m-d 0$i:30:00"),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        
        $date1 = Carbon::now()->format('Y-m-d 00:30:00');
        $date2 = Carbon::now()->addDays(1)->format('Y-m-d 01:30:00');
        $date3 = Carbon::now()->addDays(2)->format('Y-m-d 02:30:00');
        $date4 = Carbon::now()->addDays(3)->format('Y-m-d 03:30:00');


        $startDate = $date1;
        $endDate = $date4;

        $date1 = Carbon::now()->format('Y-m-d 00:00:00');
        $url = "/api/v1/metrics?start_date=$startDate&end_date=$endDate&name=Sales&duration=Minute";
        $response = $this->get($url);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            "status" => true,
            "message" => "Minute Metrics for Sales between $startDate and $endDate retireved successfully"
        ]);

        $data = json_decode($response->getContent())->data;

        $this->assertIsObject($data);

        /**
         * Our specified start date is in the returned data
         */
        $this->assertTrue(property_exists($data, $startDate));
        $this->assertTrue(property_exists($data, $endDate));
        
        /**
         * The value for the specified date should be the correct average
         */
        $this->assertTrue(property_exists($data, $endDate) && $data->{$endDate} == 4000);
        $this->assertTrue(property_exists($data, $startDate) && $data->{$startDate} == 5000);
    }
    
}
