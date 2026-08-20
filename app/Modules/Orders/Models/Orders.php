<?php



namespace App\Modules\Orders\Models;



use App\Modules\Order_items\Models\Order_items;

use App\Modules\Pengguna\Models\Pengguna;

use App\Modules\Tables\Models\Tables;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;





class Orders extends Model

{

use SoftDeletes;



protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

protected $table      = 'orders';

protected $fillable   = ['*'];



public function pengguna()

{

	return $this->belongsTo(Pengguna::class, 'pengguna_id');

}



public function tabel()

{

	return $this->belongsTo(Tables::class, 'table_id');

}



public function orderItems()

{

	return $this->hasMany(Order_items::class, 'order_id');

}

}