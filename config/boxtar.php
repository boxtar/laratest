<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Boxtar Mail Settings
    |--------------------------------------------------------------------------
    */

    'contactFormMailbox' => 'contactforms@boxtar.uk',

    /*
    |--------------------------------------------------------------------------
    | Group Type Constants
    |--------------------------------------------------------------------------
    */

    'musicGroup'        => 1,
    'danceGroup'        => 2,
    'comedyGroup'       => 3,

    /*
     |--------------------------------------------------------------------------
     | Storage Paths
     |--------------------------------------------------------------------------
     */

    'userStoragePath'  => 'users',
    'userImagePath'    => 'images',
    'userMusicPath'    => 'music',
    'userVideoPath'    => 'videos',
    'userDataPath'     => 'data',

    'groupStoragePath' => 'groups',
    'groupImagePath'   => 'images',
    'groupMusicPath'   => 'music',
    'groupVideoPath'   => 'videos',
    'groupDataPath'    => 'data',

    'defaultAvatar'    => 'images/default.jpg',

    /*
     |--------------------------------------------------------------------------
     | General Pages View Locations
     |--------------------------------------------------------------------------
     */

    'home'          => 'pages.general.welcome',
    'index'         => 'pages.general.welcome',
    'about'         => 'pages.general.about',
    'contact'       => 'pages.general.contact',

    /*
     |--------------------------------------------------------------------------
     | Authentication & Registration Pages View Locations
     |--------------------------------------------------------------------------
     */

    'login'         => 'auth.login',
    'register'      => 'auth.register',

    /*
     |--------------------------------------------------------------------------
     | User Pages View Locations
     |--------------------------------------------------------------------------
     */

    'viewUsers'         => 'pages.users.users',
    'viewUser'          => 'pages.users.user',
    'editUser'          => 'pages.users.edit',
    'viewUsersGroups'   => 'pages.users.groups',

    /*
     |--------------------------------------------------------------------------
     | Group Pages View Locations
     |--------------------------------------------------------------------------
     */

    'createGroup'        => 'pages.groups.create',
    'viewGroups'         => 'pages.groups.groups',
    'viewGroup'          => 'pages.groups.group',
    'editGroup'          => 'pages.groups.edit',
    'manageMembers'      => 'pages.groups.manage-members',

    /*
     |--------------------------------------------------------------------------
     | Posts Pages View Locations
     |--------------------------------------------------------------------------
     */

    'viewPosts'         => 'pages.posts.posts',
    'createPost'        => 'pages.posts.create',
    'editPost'          => 'pages.posts.edit',

];