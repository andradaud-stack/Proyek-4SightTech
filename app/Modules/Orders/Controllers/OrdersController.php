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
		$query = Orders::query();
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
			'user_id' => ['label' => 'User Id', 'type' => 'select', 'value' => $orders->user_id, 'required' => true, 'options' => $ref_users->all(), 'class' => 'select2', 'id' => 'user_id'],
			'table_id' => ['label' => 'Table Id', 'type' => 'select', 'value' => $orders->table_id, 'required' => true, 'options' => $ref_tables->all(), 'class' => 'select2', 'id' => 'table_id'],
			'status' => ['label' => 'Status', 'type' => 'text', 'value' => $orders->status, 'required' => true, 'id' => 'status'],
			'metode_pembayaran' => ['label' => 'Metode Pembayaran', 'type' => 'text', 'value' => $orders->metode_pembayaran, 'required' => false, 'id' => 'metode_pembayaran'],
			'status_pembayaran' => ['label' => 'Status Pembayaran', 'type' => 'text', 'value' => $orders->status_pembayaran, 'required' => true, 'id' => 'status_pembayaran'],
			'total' => ['label' => 'Total', 'type' => 'text', 'value' => $orders->total, 'required' => true, 'id' => 'total'],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$orders->what;
		$this->log($request, $text, ['orders.id' => $orders->id]);
		return view('Orders::orders_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'user_id' => 'required',
			'table_id' => 'required',
			'status' => 'required',
			'metode_pembayaran' => 'required',
			'status_pembayaran' => 'required',
			'total' => 'required',
			
		]);

		$orders = Orders::find($id);
		$orders->user_id = $request->input("user_id");
		$orders->table_id = $request->input("table_id");
		$orders->status = $request->input("status");
		$orders->metode_pembayaran = $request->input("metode_pembayaran");
		$orders->status_pembayaran = $request->input("status_pembayaran");
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

}
