<?php

namespace App\Repo\User;

use App\Models\User;

class UserEloquentRepo
{
    public function findById($id)
    {
        return User::find($id);
    }

    public function all()
    {
        return User::all();
    }

}
