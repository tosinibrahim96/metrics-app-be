<?php

namespace App\Http\Requests;

use App\Http\Requests\FormattedRequest;
use Illuminate\Validation\Rule;

class GetDashboardMetricRequest extends FormattedRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'start_date' => 'required|date',
      'end_date' => 'required|date',
      'name' => 'required|string',
      'duration' => ['required', Rule::in('Day','Hour','Minute')],
    ];
  }

  /**
   * Prepare the data for validation.
   *
   * @return void
   */
  protected function prepareForValidation()
  {
    $this->merge([
      'start_date' => $this->start_date ?? null,
      'end_date' => $this->end_date ?? null,
      'name' => $this->name ?? null,
      'duration' => isset($this->duration) ? ucfirst(strtolower($this->duration)) : null,
    ]);
  }
}
