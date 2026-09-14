<?php
namespace App\Modules\Orders\Controllers;

use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Orders\Models\Orders;
use App\Modules\Users\Models\Users;
use App\Modules\Tables\Models\Tables;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Orders";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Orders::with(['user', 'pengguna', 'tabel', 'orderItems.menu.category']);
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Orders::orders', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_users = Users::all()->pluck('name','id');
		$ref_tables = Tables::all()->pluck('table_number','id');
		
		$data['forms'] = array(
			'user_id' => ['label' => 'User Id', 'type' => 'select', 'value' => old("user_id"), 'required' => true, 'options' => $ref_users->all(), 'class' => 'select2'],
			'table_id' => ['label' => 'Table Id', 'type' => 'select', 'value' => old("table_id"), 'required' => true, 'options' => $ref_tables->all(), 'class' => 'select2'],
			'status' => ['label' => 'Status', 'type' => 'text', 'value' => old("status"), 'required' => true],
			'metode_pembayaran' => ['label' => 'Metode Pembayaran', 'type' => 'text', 'value' => old("metode_pembayaran"), 'required' => false],
			'status_pembayaran' => ['label' => 'Status Pembayaran', 'type' => 'text', 'value' => old("status_pembayaran"), 'required' => true],
			'total' => ['label' => 'Total', 'type' => 'text', 'value' => old("total"), 'required' => true],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Orders::orders_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'user_id' => 'required',
			'table_id' => 'required',
			'status' => 'required',
			'metode_pembayaran' => 'required',
			'status_pembayaran' => 'required',
			'total' => 'required',
			
		]);

		$orders = new Orders();
		$orders->user_id = $request->input("user_id");
		$orders->table_id = $request->input("table_id");
		$orders->status = $request->input("status");
		$orders->metode_pembayaran = $request->input("metode_pembayaran");
		$orders->status_pembayaran = $request->input("status_pembayaran");
		$orders->total = $request->input("total");
		
		$orders->created_by = Auth::id();
		$orders->save();

		$text = 'membuat '.$this->title; //' baru '.$orders->what;
		$this->log($request, $text, ['orders.id' => $orders->id]);
		return redirect()->route('orders.index')->with('message_success', 'Orders berhasil ditambahkan!');
	}

	public function show(Request $request, Orders $orders)
	{
		$orders->load(['user', 'pengguna', 'tabel', 'orderItems.menu.category']);
		$data['orders'] = $orders;

		$text = 'melihat detail '.$this->title;//.' '.$orders->what;
		$this->log($request, $text, ['orders.id' => $orders->id]);
		return view('Orders::orders_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Orders $orders)
	{
		$data['orders'] = $orders;

		$ref_users = Users::all()->pluck('name','id');
		$ref_tables = Tables::all()->pluck('table_number','id');
		
		$data['forms'] = array(
			'user_id' => ['label' => 'User Id', 'type' => 'select', 'value' => $orders->user_id, 'required' => false, 'options' => $ref_users->all(), 'class' => 'select2', 'id' => 'user_id'],
			'table_id' => ['label' => 'Table Id', 'type' => 'select', 'value' => $orders->table_id, 'required' => true, 'options' => $ref_tables->all(), 'class' => 'select2', 'id' => 'table_id'],
			'status' => ['label' => 'Status', 'type' => 'select', 'value' => $orders->status, 'required' => true, 'id' => 'status', 'options' => [
				'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
				'diproses' => 'Diproses',
				'siap_disajikan' => 'Siap Disajikan',
				'selesai' => 'Selesai',
				'dibatalkan' => 'Dibatalkan',
			]],
			'metode_pembayaran' => ['label' => 'Metode Pembayaran', 'type' => 'select', 'value' => $orders->metode_pembayaran, 'required' => false, 'id' => 'metode_pembayaran', 'options' => [
				'Tunai' => 'Tunai di Kasir',
				'Qris' => 'QRIS',
				'Transfer Bank' => 'Transfer Bank',
			]],
			'status_pembayaran' => ['label' => 'Status Pembayaran', 'type' => 'select', 'value' => $orders->status_pembayaran, 'required' => true, 'id' => 'status_pembayaran', 'options' => [
				'belum_bayar' => 'Belum Bayar',
				'sudah_bayar' => 'Sudah Dibayar',
				'dibatalkan' => 'Dibatalkan',
			]],
			'total' => ['label' => 'Total', 'type' => 'text', 'value' => $orders->total, 'required' => true, 'id' => 'total'],
		);

		$text = 'membuka form edit '.$this->title;//.' '.$orders->what;
		$this->log($request, $text, ['orders.id' => $orders->id]);
		return view('Orders::orders_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'user_id' => 'nullable',
			'table_id' => 'required',
			'status' => 'required|in:menunggu_konfirmasi,diproses,siap_disajikan,selesai,dibatalkan',
			'metode_pembayaran' => 'required',
			'status_pembayaran' => 'required|in:belum_bayar,sudah_bayar,lunas,dibatalkan',
			'total' => 'required',
		]);

		$orders = Orders::find($id);
		if ($request->filled('user_id')) {
			$orders->user_id = $request->input("user_id");
		}
		$orders->table_id = $request->input("table_id");
		$orders->status = $request->input("status");
		$orders->metode_pembayaran = $request->input("metode_pembayaran");
		$orders->status_pembayaran = $request->input("status_pembayaran");

		// Jika admin memilih status selesai dan pembayaran masih belum_bayar, sinkronkan ke sudah_bayar
		if ($orders->status === 'selesai' && $orders->status_pembayaran === 'belum_bayar') {
			$orders->status_pembayaran = 'sudah_bayar';
		}

		$orders->total = $request->input("total");
		
		$orders->updated_by = Auth::id();
		$orders->save();


		$text = 'mengedit '.$this->title;//.' '.$orders->what;
		$this->log($request, $text, ['orders.id' => $orders->id]);
		return redirect()->route('orders.index')->with('message_success', 'Orders berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$orders = Orders::find($id);
		$orders->deleted_by = Auth::id();
		$orders->save();
		$orders->delete();

		$text = 'menghapus '.$this->title;//.' '.$orders->what;
		$this->log($request, $text, ['orders.id' => $orders->id]);
		return back()->with('message_success', 'Orders berhasil dihapus!');
	}

	public function management(Request $request)
	{
		// Show only customer orders (those with pengguna_id)
		$orders = Orders::with(['user', 'pengguna', 'tabel', 'orderItems.menu.category'])
			->whereNotNull('pengguna_id')
			->whereIn('status', ['menunggu_konfirmasi', 'diproses', 'siap_disajikan'])
			->orderBy('created_at', 'desc')
			->get();

		$this->log($request, 'melihat halaman manajemen status pesanan customer');
		return view('Orders::orders_management', ['orders' => $orders]);
	}

	public function updateStatus(Request $request, Orders $orders)
	{
		$this->validate($request, [
			'status' => 'nullable|in:menunggu_konfirmasi,diproses,siap_disajikan,selesai,dibatalkan',
			'status_pembayaran' => 'nullable|in:belum_bayar,sudah_bayar,lunas,dibatalkan',
		]);

		$changes = [];

		if ($request->filled('status')) {
			$oldStatus = $orders->status;
			$newStatus = $request->input('status');
			$orders->status = $newStatus;
			$changes[] = "status: {$oldStatus} -> {$newStatus}";

			// Logika konsistensi status pembayaran:
			// Jika pesanan diselesaikan (selesai), status pembayaran dipastikan lunas/sudah_bayar
			if ($newStatus === 'selesai' && ! $orders->isPaid()) {
				$orders->status_pembayaran = 'sudah_bayar';
				$changes[] = "status_pembayaran -> sudah_bayar";
			} elseif ($newStatus === 'dibatalkan' && ! $orders->isPaid()) {
				$orders->status_pembayaran = 'dibatalkan';
				$changes[] = "status_pembayaran -> dibatalkan";
			}
		}

		if ($request->filled('status_pembayaran')) {
			$oldPayment = $orders->status_pembayaran;
			$newPayment = $request->input('status_pembayaran');
			$orders->status_pembayaran = $newPayment;
			$changes[] = "status_pembayaran: {$oldPayment} -> {$newPayment}";
		}

		$orders->updated_by = Auth::id();
		$orders->save();

		$this->log($request, "mengubah status pesanan (" . implode(', ', $changes) . ")", ['orders.id' => $orders->id]);
		
		return back()->with('message_success', "Status pesanan berhasil diperbarui!");
	}
}
