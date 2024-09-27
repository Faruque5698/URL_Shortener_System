<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;


class ShortUrlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
       return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'long_url' => 'required|string|url'
        ];
    }

    public function messages()
    {
        return [
            'long_url.required' => 'The URL field is required.',
            'long_url.string' => 'The URL must be a valid string.',
            'long_url.url' => 'The URL must be a valid URL format.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'success' => false,
                'message' => 'validation error',
                'data' => [],
                'errors' => $validator->errors()->toArray(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
