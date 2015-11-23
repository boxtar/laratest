<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GroupRequest extends Request
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
        $rules = [
            'name'          => 'required|min:2|max:30',
            'profile_link'  => 'required|unique:groups|min:4|max:30',
            'group_type_id' => 'required|min:1|max:3',
        ];

        if($this->isMethod('patch'))
        {
            $rules['profile_link'] = 'required|unique:groups,profile_link,'.$this->route('groups')->id.'|min:4|max:30';
        }

        return $rules;
    }
}
