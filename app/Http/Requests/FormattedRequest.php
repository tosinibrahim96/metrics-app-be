<?php


namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class FormattedRequest extends FormRequest
{
  /**
   * Handle a failed validation attempt.
   *
   * @param Validator $validator
   * @return void
   * @throws HttpResponseException
   */
  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(
      response()->json(
        [
          'status' => false,
          'errors' => $validator->errors()->all(),
          'message' => $validator->errors()->all()[0] ?? 'The given data was invalid'
        ],
        Response::HTTP_UNPROCESSABLE_ENTITY
      )
    );
  }
}
