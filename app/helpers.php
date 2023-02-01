<?php

function slug($string)
{
//    return preg_replace('/[^A-Za-z0-9ก-๙เ\-]/', '', str_replace(' ', '-', strtolower($string)));
    return preg_replace('/[^A-Za-z0-9ก-๛เ\-]/', '', str_replace(' ', '-', strtolower($string)));
}

function moneyIsDecimal($value)
{
    $price_array = explode('.', "".$value);
    if (count($price_array) > 1 && $price_array[1] != '00') {
        return true;
    } else {
        return false;
    }
}
function money($amount, $dec = false)
{
    if ($dec == 'auto') {
        $dec = moneyIsDecimal($amount);
    }

    if ($dec) {
        return number_format($amount, 2, ".", ",");
    } else {
        return number_format($amount, 0, ".", ",");
    }
}

function numberComma($number)
{
    return number_format($number, 0, ".", ",");
}

function dashboardUrl()
{
    return route('dashboard.index');
}

function isActiveRoute($route)
{
    return Route::currentRouteName() == $route;
}
function isActiveRouteClass($route, $output = "active")
{
    if (isActiveRoute($route)) {
        return $output;
    }
}
function areActiveRoutes(array $routes)
{
    foreach ($routes as $route) {
        if (isActiveRoute($route)) {
            return true;
        }
    }
}
function areActiveRoutesClass(array $routes, $output = "active")
{
    foreach ($routes as $route) {
        if (Route::currentRouteName() == $route) {
            return $output;
        }
    }
//    if (areActiveRoutesClass($routes)) return $output;
}
function isRouteGroup($route)
{
    return \Illuminate\Support\Str::startsWith(Route::currentRouteName(), $route);
}
function isRouteGroupClass($route, $output = 'active')
{
    if (isRouteGroup($route)) {
        return $output;
    }
}
function isAnyRouteGroup(array $routes, $except = [])
{
    foreach ($routes as $route) {
        if (areActiveRoutes($except)) {
            return false;
        }
        if (isRouteGroup($route)) {
            return true;
        }
    }
}
function isAnyRouteGroupClass(array $routes, $output = 'active', $except = [])
{
    if (isAnyRouteGroup($routes, $except)) {
        return $output;
    }
}

function navLinkClass($routes, $activeClass, $inactiveClass)
{
    if (!is_array($routes)) {
        $routes = [$routes];
    }
    return isAnyRouteGroup($routes) ? $activeClass : $inactiveClass;
}

function generateRandomString(
    $length = 10,
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
) {
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandomStringUpper($length = 10)
{
    return generateRandomString($length, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
}

function startWith($haystack, $needles)
{
    return \Illuminate\Support\Str::startsWith($haystack, $needles);
}

function snakeCaseToText($text)
{
    return implode(' ', explode('_', $text));
}

function isEnv($env)
{
    return config('app.env') == $env;
}
function isProduction()
{
    return isEnv('production');
}
function isAssociativeArray($arr)
{
    if (! is_array($arr)) {
        return false;
    }
    if ([] === $arr) {
        return false;
    }
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function maxBidPrice() {
    $priceLimit = (App\Models\SiteSetting::priceLimit())->setting;
    if ($priceLimit['max_bid_price']) {
        return $priceLimit['max_bid_price']/100;
    }
    return null;
}
function maxAskPrice() {
    $priceLimit = (App\Models\SiteSetting::priceLimit())->setting;
    if ($priceLimit['max_ask_price']) {
        return $priceLimit['max_ask_price']/100;
    }
    return null;
}
