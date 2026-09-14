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

    protected $casts    = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    protected $table    = 'orders';
    protected $fillable = [
        'user_id',
        'pengguna_id',
        'table_id',
        'status',
        'metode_pembayaran',
        'status_pembayaran',
        'total',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function getUserIdAttribute($value)
    {
        return $value ?? ($this->pengguna_id ? (string) $this->pengguna_id : null);
    }

    public function getStatusPembayaranLabelAttribute(): string
    {
        return match (strtolower($this->status_pembayaran ?? '')) {
            'sudah_bayar', 'lunas', 'paid' => 'Sudah Dibayar',
            'belum_bayar', 'unpaid' => 'Belum Bayar',
            'dibatalkan', 'cancelled', 'batal' => 'Dibatalkan',
            default => ucfirst(str_replace('_', ' ', $this->status_pembayaran ?? 'Belum Bayar')),
        };
    }

    public function isPaid(): bool
    {
        return in_array(strtolower($this->status_pembayaran ?? ''), ['sudah_bayar', 'lunas', 'paid']);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

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

    public function order_items()
    {
	    return $this->hasMany(Order_items::class, 'order_id');
    }
}