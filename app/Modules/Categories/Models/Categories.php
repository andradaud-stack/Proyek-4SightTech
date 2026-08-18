<?php

namespace App\Modules\Categories\Models;

use App\Helpers\UsesUuid;
use App\Modules\Menus\Models\Menus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Categories extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'categories';
	protected $fillable   = ['*'];

	public function menus()
	{
		return $this->hasMany(Menus::class, 'category_id');
	}
}