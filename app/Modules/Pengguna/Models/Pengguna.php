<?php

namespace App\Modules\Pengguna\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
	use HasFactory, Notifiable, SoftDeletes;

	protected $casts      = [
		'deleted_at' => 'datetime',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'password'   => 'hashed',
	];
	protected $table      = 'pengguna';
	protected $fillable   = ['name', 'email', 'password', 'role'];
}
