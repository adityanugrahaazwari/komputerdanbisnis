<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
