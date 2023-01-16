<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'author' => ['required','string','max:100','regex:/^[\pL\s\-]+$/u'], 
            'name_book' => ['required','string','max:250','regex:/^[\pL\s\-]+$/u'],
            'isbn' => ['required','string','max:100'],
            'year_publish' => ['string','max:4','min:2','required'],
            'number_pages' => ['integer'],
            'sku' => ['string','max:100'],
            'editorial' => ['string','max:255'],
            'category_id' =>  ['required','exists:categories,id']
        ];
    }
}
