<?php
function checkPermission($value, $existingPermission)
{
    
    $test = array_search($value, array_column($existingPermission, 'permission_id'));
    dd($test);
}
