<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    //role admin
    User::create(attributes: [
      'username' => 'admin',
      'email' => 'admin@mail.com',
      'password' => Hash::make('admin12345'),
      'role' => 'admin',
    ]);

    //role user
    User::create(attributes: [
      'username' => 'user',
      'email' => 'user@mail.com',
      'password' => Hash::make('user12345'),
      'role' => 'user',
    ]);
  }
}