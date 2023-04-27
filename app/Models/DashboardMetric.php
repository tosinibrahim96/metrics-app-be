<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardMetric extends Model
{
  /**
   * The attributes that aren't mass assignable.
   *
   * @var string[]|bool
   */
  protected $guarded = [];


  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'dashboard_metrics';
}
