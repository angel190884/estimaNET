<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConcept extends FormRequest
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
            'code' => 'required',

            'name' => 'required',
            //'location' => '',
            //'address' => '',
            'contract' => 'numeric|required',
            'measurementUnit' => 'required',
            'type' => 'required|in:N,EXC,EXT',
            'unitPrice'          => 'numeric|required',
            'quantity'     => 'required_if:type,==,N',
        ];
    }
}
