<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'      => 'required|string|max:255',
            'description'   => 'required|string',
            'assigned_to'   => 'required',
            'file'         => 'nullable|max:20480',
        ];
    }
}