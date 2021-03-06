<?php

function presentPrice($price)
{
    $prices = number_format($price, 2, '.', '');
    return number_format($prices / 100, 2);
}
