<?php



namespace App\Modules\Tables\Models;



use App\Modules\Orders\Models\Orders;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;





class Tables extends Model

{

use SoftDeletes;



protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

protected $table      = 'tables';

protected $fillable   = ['*'];



public function orders()

{

	return $this->hasMany(Orders::class, 'table_id');

}

}
