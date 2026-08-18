<?php
require __DIR__ . '/vendor/autoload.php';
use App\Modules\Pengguna\Models\Pengguna;
$u = Pengguna::where('email', 'superadmin@mail.com')->first();
if ($u) {
    echo "FOUND\n";
    echo "email=" . $u->email . "\n";
    echo "password=" . $u->password . "\n";
    echo "hashed? " . (password_get_info($u->password)['algo'] ? 'yes' : 'no') . "\n";
} else {
    echo "NOT_FOUND\n";
}
