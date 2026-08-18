<?php

namespace App\Modules\Menus\Models;

use App\Modules\Categories\Models\Categories;
use App\Modules\Order_items\Models\Order_items;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Menus extends Model
{
	use SoftDeletes;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'menus';
	protected $fillable   = ['*'];

	public function kategori()
	{
		return $this->belongsTo(Categories::class, 'category_id');
	}

	public function orderItems()
	{
		return $this->hasMany(Order_items::class, 'menu_id');
	}

	public function scopeActive($query)
	{
		return $query->where('is_active', true);
	}

	public function scopeTersedia($query)
	{
		return $query->where('stock', '>', 0);
	}

	public function hargaRupiah()
	{
		return 'Rp ' . number_format($this->price, 0, ',', '.');
	}
}