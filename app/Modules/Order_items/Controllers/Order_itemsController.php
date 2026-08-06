<?php
namespace App\Modules\Order_items\Controllers;

use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Order_items\Models\Order_items;
use App\Modules\Orders\Models\Orders;
use App\Modules\Menus\Models\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Order_itemsController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Order Items";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Order_items::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Order_items::order_items', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_orders = Orders::all()->pluck('user_id','id');
		$ref_menus = Menus::all()->pluck('category_id','id');
		
		$data['forms'] = array(
			'order_id' => ['label' => 'Order Id', 'type' => 'select', 'value' => old("order_id"), 'required' => true, 'options' => $ref_orders->all(), 'class' => 'select2'],
			'menu_id' => ['label' => 'Menu Id', 'type' => 'select', 'value' => old("menu_id"), 'required' => true, 'options' => $ref_menus->all(), 'class' => 'select2'],
			'menu_name' => ['label' => 'Menu Name', 'type' => 'text', 'value' => old("menu_name"), 'required' => true, 'placeholder' => 'disalin saat order dibuat, tidak ikut berubah kalau menu diedit'],
			'price' => ['label' => 'Price', 'type' => 'text', 'value' => old("price"), 'required' => true, 'placeholder' => 'harga saat transaksi, bukan harga terkini'],
			'qty' => ['label' => 'Qty', 'type' => 'text', 'value' => old("qty"), 'required' => true],
			'subtotal' => ['label' => 'Subtotal', 'type' => 'text', 'value' => old("subtotal"), 'required' => true],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Order_items::order_items_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'order_id' => 'required',
			'menu_id' => 'required',
			'menu_name' => 'required',
			'price' => 'required',
			'qty' => 'required',
			'subtotal' => 'required',
			
		]);

		$order_items = new Order_items();
		$order_items->order_id = $request->input("order_id");
		$order_items->menu_id = $request->input("menu_id");
		$order_items->menu_name = $request->input("menu_name");
		$order_items->price = $request->input("price");
		$order_items->qty = $request->input("qty");
		$order_items->subtotal = $request->input("subtotal");
		
		$order_items->created_by = Auth::id();
		$order_items->save();

		$text = 'membuat '.$this->title; //' baru '.$order_items->what;
		$this->log($request, $text, ['order_items.id' => $order_items->id]);
		return redirect()->route('order_items.index')->with('message_success', 'Order Items berhasil ditambahkan!');
	}

	public function show(Request $request, Order_items $order_items)
	{
		$data['order_items'] = $order_items;

		$text = 'melihat detail '.$this->title;//.' '.$order_items->what;
		$this->log($request, $text, ['order_items.id' => $order_items->id]);
		return view('Order_items::order_items_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Order_items $order_items)
	{
		$data['order_items'] = $order_items;

		$ref_orders = Orders::all()->pluck('user_id','id');
		$ref_menus = Menus::all()->pluck('category_id','id');
		
		$data['forms'] = array(
			'order_id' => ['label' => 'Order Id', 'type' => 'select', 'value' => $order_items->order_id, 'required' => true, 'options' => $ref_orders->all(), 'class' => 'select2', 'id' => 'order_id'],
			'menu_id' => ['label' => 'Menu Id', 'type' => 'select', 'value' => $order_items->menu_id, 'required' => true, 'options' => $ref_menus->all(), 'class' => 'select2', 'id' => 'menu_id'],
			'menu_name' => ['label' => 'Menu Name', 'type' => 'text', 'value' => $order_items->menu_name, 'required' => true, 'placeholder' => 'disalin saat order dibuat, tidak ikut berubah kalau menu diedit', 'id' => 'menu_name'],
			'price' => ['label' => 'Price', 'type' => 'text', 'value' => $order_items->price, 'required' => true, 'placeholder' => 'harga saat transaksi, bukan harga terkini', 'id' => 'price'],
			'qty' => ['label' => 'Qty', 'type' => 'text', 'value' => $order_items->qty, 'required' => true, 'id' => 'qty'],
			'subtotal' => ['label' => 'Subtotal', 'type' => 'text', 'value' => $order_items->subtotal, 'required' => true, 'id' => 'subtotal'],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$order_items->what;
		$this->log($request, $text, ['order_items.id' => $order_items->id]);
		return view('Order_items::order_items_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'order_id' => 'required',
			'menu_id' => 'required',
			'menu_name' => 'required',
			'price' => 'required',
			'qty' => 'required',
			'subtotal' => 'required',
			
		]);

		$order_items = Order_items::find($id);
		$order_items->order_id = $request->input("order_id");
		$order_items->menu_id = $request->input("menu_id");
		$order_items->menu_name = $request->input("menu_name");
		$order_items->price = $request->input("price");
		$order_items->qty = $request->input("qty");
		$order_items->subtotal = $request->input("subtotal");
		
		$order_items->updated_by = Auth::id();
		$order_items->save();


		$text = 'mengedit '.$this->title;//.' '.$order_items->what;
		$this->log($request, $text, ['order_items.id' => $order_items->id]);
		return redirect()->route('order_items.index')->with('message_success', 'Order Items berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$order_items = Order_items::find($id);
		$order_items->deleted_by = Auth::id();
		$order_items->save();
		$order_items->delete();

		$text = 'menghapus '.$this->title;//.' '.$order_items->what;
		$this->log($request, $text, ['order_items.id' => $order_items->id]);
		return back()->with('message_success', 'Order Items berhasil dihapus!');
	}

}
