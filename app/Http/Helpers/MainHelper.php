<?php

use Illuminate\Support\Str;

function storage_url($urlOrArray)
{
    $image = asset('default_img/no_img.jpg');
    if (is_array($urlOrArray) || is_object($urlOrArray)) {
        $result = '';
        $count = 0;
        $itemCount = count($urlOrArray);
        foreach ($urlOrArray as $index => $url) {

            $result .= $url ? asset('storage/' . $url) : $image;

            if ($count === $itemCount - 1) {
                $result .= '';
            } else {
                $result .= ', ';
            }
            $count++;
        }
        return $result;
    } else {
        return $urlOrArray ? asset('storage/' . $urlOrArray) : $image;
    }
}

function auth_storage_url($url, $gender)
{
    $image = asset('default_img/other.png');
    if ($gender == 1) {
        $image = asset('default_img/male.png');
    } elseif ($gender == 2) {
        $image = asset('default_img/female.png');
    }
    return $url ? asset('storage/' . $url) : $image;
}



function timeFormat($time)
{
    return date('d-M-Y H:i A', strtotime($time));
}

function user()
{
    return auth()->guard('web')->user();
}
function admin()
{
    return auth()->guard('admin')->user();
}
function str_limit($data, $limit = 20, $end = '...')
{
    return Str::limit($data, $limit, $end);
}
function otp()
{
    $otp =  mt_rand(100000, 999999);
    return $otp;
}
function creater_name($creater)
{
    return $creater->name ?? 'System';
}
function updater_name($updater)
{
    return $updater->name ?? 'Null';
}
function deleter_name($deleter)
{
    return $deleter->name ?? 'Null';
}
