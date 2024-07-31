<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail, // Email default untuk User
            'password' => Hash::make('1'),
            'active' => '0',
        ];
    }

    public function withName($name)
    {
        return $this->state([
            'name' => $name,
        ]);
    }

    public function withEmail($email)
    {
        return $this->state([
            'email' => $email,
        ]);
    }

    public function withRole($role)
    {
        return $this->afterCreating(function (User $user) use ($role) {
            $user->addRole($role); // Pastikan method addRole ada di model User
        });
    }
}
