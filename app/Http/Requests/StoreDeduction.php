<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeduction extends FormRequest
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
            'code'          => 'alpha_num|max:15|required',
            'name'          => 'required|min:3',
            'percentage'    => 'required|min:0.1|max:25|numeric',
            'type'          => 'required|numeric',
            'description'   => 'max:500',
        ];
    }
}
