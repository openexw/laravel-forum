<?php


function create ($class, $attr = []) {
    return factory($class) -> create($attr);
}

function make($class,$attributes = []) {
    return factory($class)->make($attributes);
}

function raw($class,$attributes = []) {
    return factory($class)->raw($attributes);
}