<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; //これはpriorityのRule::用に作ってるので消してもよし

class TaskRegisterPostRequest extends FormRequest
{
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => ['required','max:255'],
            
            //買うものリストではいらないので除外
            // 'period' => ['required', 'date', 'after_or_equal:today'],
            // 'detail' => ['max:65535'],
            // 'priority' => ['required', 'numeric', Rule::in([1, 2, 3]) ],
            
        ];
    }
}
