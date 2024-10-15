<?php

//check user access permission function start
if (! function_exists('can')) {
    function can($permission): bool
    {
        if (auth('web')->check() && auth('web')->user()->can($permission)) {
            return true;
        }
        return false;
    }
}
//check user access permission function end

//unauthorized text start
if (! function_exists('unauthorized')) {
    function unauthorized(): string
    {
        return "You are not authorized for this";
    }
}
//unauthorized text end

