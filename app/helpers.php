<?php

function flash($message=null, $title=null){
    $flash = app('App\Http\Flash');

    if(func_num_args()==0)
        return $flash;


    return $flash->message($message, $title);
}

