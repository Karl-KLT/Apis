<?php

use Carbon\Carbon;

function getTimeFromNow($time){
    return  Carbon::create($time)->diffForHumans(null,null,true);
};
