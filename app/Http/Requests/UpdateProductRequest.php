<?php
// app/Http/Requests/StoreProductRequest.php
namespace App\Http\Requests;

use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // allow all users
    }

    public function rules()
    {
        $productId = $this->route('product');
        return [
            'name' => 'required|string',
            'sku' => [
                'required',
                'string',
                Rule::unique('products', 'sku')->ignore($productId)
            ],
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }



    protected function failedValidation(Validator $validator)
    {
        if ($this->header('X-Inertia')) {
            throw new HttpResponseException(
                Inertia::render('Edit', [
                    'errors' => $validator->errors()->messages(),
                    'product' => $this->route('products.edit'), // send product back
                ])->toResponse($this->container->make('request'))->setStatusCode(422)
            );
        }

        parent::failedValidation($validator);
    }

}

