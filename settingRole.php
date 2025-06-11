<?php
function group1()
{
    // 6: instructor
    return ['6'];
}
function group2()
{
    // 8: students
    return ['8'];
}
function group3()
{
    // 7: administrator, 1: admin, 5: PIC
    return ['7', '3', '5'];
}

function role_available()
{
    // 4: instructor, 6:students
    return ['6', '8'];
}

// in_array
function canAddModul($role)
{
    if (in_array($role, group1())) {
        return true;
    }
}
