<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductFormRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'category' => 'required|numeric',
            'description' => 'required|min:100|max:1000',
            'price' => 'required|numeric|between:1,9999.99',
            'file' => 'required|image|mimes:jpeg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Please provide product name.',
            'name.string' => 'Product name should be string.',
            'name.max' => 'Maximum length of product name should be 100 characters.',
            'category.required' => 'Please select product category.',
            'category.numeric' => 'Please selected product category is not valid.',
            'description.required' => 'Please provide product description.',
            'description.min' => 'Minimum length of product description should be 100 characters.',
            'description.max' => 'Maximum length of product description should be 1000 characters.',
            'price.required' => 'Please enter product price.',
            'price.numeric' => 'Product price should be in numbers or decimals only.',
            'price.between' => 'Product price should range from 1 to 9999.99.',
            'file.required' => 'Please select product image.',
            'file.image' => 'Please select valid product image.',
            'file.mimes' => 'Only JPG or JPEG are allowed.',
            'file.max' => 'Product image can be upto 2MB.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['status' => false ,' message' => $validator->errors()->first()], 422));
        dd(1);
    }
}
