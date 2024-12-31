<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */

  protected $table = 'users';
  protected $fillable = [
    'username',
    'name',
    'email',
    'role',
    'password',
    'status',
    'no_telp',
    'alamat',
    'kecamatan',
    'desa',
    'avatar',
    'first_name',
    'last_name'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }
  // logic simpan profile
  public function updateProfile($request)
  {
    $user = Auth::user();
    // Proses Upload Avatar
    if ($request->hasFile('avatar')) {
      $avatar = $request->file('avatar');
      $avatarName = strtolower($user->username) . '_avatar.' . $avatar->getClientOriginalExtension();
      $avatarPath = public_path('avatars/');

      if (!file_exists($avatarPath)) {
        mkdir($avatarPath, 0777, true);
      }

      // Hapus avatar lama jika ada
      if ($this->avatar && file_exists(public_path($this->avatar))) {
        unlink(public_path($this->avatar));
      }

      $avatar->move($avatarPath, $avatarName);
      $this->avatar = 'avatars/' . $avatarName;
    }

    // Gabungkan alamat lengkap
    $alamatLengkap = $request->address . ', ' . $request->desa . ', ' . $request->kecamatan . ', Karawang';

    // Update Data User
    $this->first_name = $request->firstName;
    $this->last_name = $request->lastName;
    $this->jabatan = $request->jabatan;
    $this->no_telp = $request->phoneNumber;
    $this->alamat = $request->address;
    // $this->alamat = $alamatLengkap;
    $this->kecamatan = $request->kecamatan;
    $this->desa = $request->desa;

    return $this->save();
  }

}