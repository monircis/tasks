<?php
// app/Http/Requests/StoreProductRequest.php
namespace App\Http\Requests;

use Inertia\Inertia;
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
        $productId = $this->route('product')->id;
        return [
            'name' => 'required|string',
            'sku' => "required|string|unique:products,sku,{$productId}",
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'description' => 'nullable|string'
        ];
    }



    protected function failedValidation(Validator $validator)
    {
        if ($this->header('X-Inertia')) {
        throw new HttpResponseException(
            Inertia::render('Edit', [
                'errors' => $validator->errors()->messages(),
                'product' => $this->route('products'), // send product back
            ])->toResponse($this->container->make('request'))->setStatusCode(422)
        );
    }

    parent::failedValidation($validator);
    }

}

