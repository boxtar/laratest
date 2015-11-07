<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (\Auth::id() === $this->route('users')->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'name' 			=> 'required|min:5|max:30',
			'email' 		=> 'required|email|unique:users,email,'.$this->route('users')->id,
			'password'		=> 'required|min:5',
			'profile_link'	=> 'required|unique:users,profile_link,'.$this->route('users')->id.'|min:5|max:30'
        ];
    }
}
