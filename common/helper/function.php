<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 13:30
 */

function dd($input, $die = true)
{
    echo '<pre>';
    echo '<hr/>';

    print_r($input);

    echo '<hr/>';
    echo '</pre>';

    $die === true ? die() : print_r('');
}