<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstimate extends FormRequest
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
            'number'        => 'required|numeric',
            'contract'      => 'required|numeric',

            'start'         => 'required|date',
            'finish'        => 'required|date',
            'release'       => 'required|date',

            'retention'     => 'numeric',

            'type'          => 'required|numeric',
        ];
    }
}
