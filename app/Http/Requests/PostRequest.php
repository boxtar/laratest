<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // User Model:
        $user = $this->route('users');

        // Post Model:
        $post = $this->route('posts');

        // Ensure Authenticated User is trying to create/edit their own post
        if($user->id === \Auth::id())
        {
            // If a Post exists it means User is trying to edit a Post
            if($post)
            {
                // Is the Authenticated User the owner of the Post they are trying to edit?
                // NB: $user and Auth::user() are the same thing as per the initial 'if' check
                return ( $post->owner->id === $user->id );
            }
            else{
                // Authenticated User is creating a New Post
                return true;
            }
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message'		=> 'required|max:150'
        ];
    }
}
