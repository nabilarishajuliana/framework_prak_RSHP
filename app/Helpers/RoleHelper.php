<?php

function isRole($roleName)
{
    return strtolower(session('user_role_name')) === strtolower($roleName);
}
?>