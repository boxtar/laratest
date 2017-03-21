<?php

/**
 * Helper for quick session flashing
 *
 * @param null $message
 * @param null $title
 * @return \Illuminate\Foundation\Application|mixed
 */
function flash($message=null, $title=null){
    $flash = app('App\Http\Flash');

    if(func_num_args()==0)
        return $flash;


    return $flash->message($message, $title);
}

/**
 * Return profile link string for a given user
 *
 * @param \App\User $user
 * @return string
 */
function userProfileLink(\App\User $user){
    return config('boxtar.usersPrefix') . '/' . $user->profile_link;
}

/**
 * Return string path for a given users storage area
 *
 * @param \App\User $user
 * @return string
 */
function userStoragePath(\App\User $user){
    return config('boxtar.userStoragePath') . '/' . $user->profile_link;
}

function userImagePath(\App\User $user){
    return userStoragePath($user) . '/' . config('boxtar.userImagePath');
}

function userMusicPath(\App\User $user){
    return userStoragePath($user) . '/' . config('boxtar.userMusicPath');
}

function userVideoPath(\App\User $user){
    return userStoragePath($user) . '/' . config('boxtar.userVideoPath');
}

/**
 * Return profile link string for a given Group
 *
 * @param \App\Group $group
 * @return string
 */
function groupProfileLink(\App\Group $group){
    return config('boxtar.groupsPrefix') . '/' . $group->profile_link;
}

/**
 * Return string path for a given groups storage area
 *
 * @param \App\Group $group
 * @return string
 */
function groupStoragePath(\App\Group $group){
    return config('boxtar.groupStoragePath') . '/' . $group->profile_link;
}

function groupImagePath(\App\Group $group){
    return groupStoragePath($group) . '/' . config('boxtar.groupImagePath');
}
