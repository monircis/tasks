<?php
// app/Http/Requests/StoreProductRequest.php
namespace App\Http\Requests;

use Inertia\Inertia;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
 class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // allow all users
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

 

protected function failedValidation(Validator $validator)
{
    if ($this->header('X-Inertia')) {
        // Convert Inertia response to HTTP response
        $response = Inertia::render('Create', [
            'errors' => $validator->errors()
        ])->toResponse($this->container->make('request')); // pass current request

        throw new HttpResponseException($response);
    }

    parent::failedValidation($validator);
}

}

 