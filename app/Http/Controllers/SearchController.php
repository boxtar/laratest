<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Contracts\Search;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{

    /**
     *  Action for submitting a Search Form.
     *
     * @param Search $search
     * @param Request $request
     * @return mixed
     */
    public function search(Search $search, Request $request)
    {
        $result = $search->in($request->t)
            ->inColumn($request->c)
            ->find($request->q)
            ->go();

        if($result->isEmpty()) abort(404);

        $result = $result->first();
        if(is_a($result, \App\User::class))
            return redirect()->action('UsersController@show', ['users' => $result->profile_link]);
        elseif(is_a($result, \App\Group::class))
            return redirect()->action('GroupsController@show', ['groups' => $result->profile_link]);
        else
            abort(404);
    }

    /**
     *  Action used for typeahead hints
     *
     * @param Search $search
     * @param Request $request
     * @return mixed
     */
    public function hintSearch(Search $search, Request $request)
    {

        if(! $request->q) $request->merge(['q' => '%']);

        if(! $request->t) $request->merge(['t' => [\App\User::class, \App\Group::class]]);

        if(! $request->c) $request->merge(['c' => 'name']);

        return $search->in($request->t)
            ->inColumn($request->c)
            ->find($request->q)
            ->usingLike()
            ->go();
    }
}
