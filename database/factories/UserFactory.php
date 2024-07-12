<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'status' => 'user',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function admin()
    {
        return $this->state([
            'username' => 'admin',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'status' => 'admin',
            'password' => Hash::make('admin'), // Password is 'admin'
        ]);
    }

    public function user()
    {
        return $this->state([
            'username' => 'user',
            'name' => 'user',
            'email' => 'user@gmail.com',
            'status' => 'user',
            'password' => Hash::make('user'), // Password is 'user'
        ]);
    }
}
