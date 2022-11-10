<?php

namespace Tests\DataGenerators;

use App\Models\User;

trait UserGenerator
{
    public function generateUser($data = [])
    {
        return User::factory()->create($data);
    }
}
