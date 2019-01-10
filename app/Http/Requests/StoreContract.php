<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContract extends FormRequest
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
            'code'          => 'alpha_num|min:15|max:15|required',
            'short_name'     => 'numeric|required',

            'amount_total'        => 'numeric|required',
            'amount_anticipated'   => 'numeric|nullable',
            'amount_extension'     => 'numeric|nullable',
            'amount_adjustment'    => 'numeric|nullable',

            'date_start'                => 'date|required',
            'date_finish'               => 'date|required',
            'date_signature'            => 'date|nullable',
            'date_signature_covenant'   => 'date|nullable',
            'date_finish_modified'      => 'date|nullable',

            'name'          => 'required|min:3',
            'description'   => 'max:500',

            'active'        => 'boolean|required',

            'company'       => 'numeric|nullable',
        ];
    }
}
