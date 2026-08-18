<?php
namespace App\Modules\Menus\Controllers;

use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Menus\Models\Menus;
use App\Modules\Categories\Models\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenusController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Menus";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Menus::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Menus::menus', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_categories = Categories::all()->pluck('name','id');
		
		$data['forms'] = array(
			'category_id' => ['label' => 'Category Id', 'type' => 'select', 'value' => old("category_id"), 'required' => true, 'options' => $ref_categories->all(), 'class' => 'select2'],
			'name' => ['label' => 'Name', 'type' => 'text', 'value' => old("name"), 'required' => true],
			'description' => ['label' => 'Description', 'type' => 'textarea', 'value' => old("description"), 'required' => true],
			'image' => ['label' => 'Image', 'type' => 'file', 'value' => old("image"), 'required' => false, 'accept' => 'image/*'],
			'price' => ['label' => 'Price', 'type' => 'text', 'value' => old("price"), 'required' => true],
			'stock' => ['label' => 'Stock', 'type' => 'text', 'value' => old("stock"), 'required' => true],
			'is_active' => ['label' => 'Is Active', 'type' => 'select', 'value' => old("is_active"), 'required' => true, 'options' => ['1' => 'Ya', '0' => 'Tidak']],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Menus::menus_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'category_id' => 'required',
			'name' => 'required',
			'description' => 'required',
			'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
			'price' => 'required',
			'stock' => 'required',
			'is_active' => 'required',
			
		]);

		$menus = new Menus();
		$menus->category_id = $request->input("category_id");
		$menus->name = $request->input("name");
		$menus->description = $request->input("description");
		$menus->image = $this->simpanGambar($request);
		$menus->price = $request->input("price");
		$menus->stock = $request->input("stock");
		$menus->is_active = $request->input("is_active");
		
		$menus->created_by = Auth::id();
		$menus->save();

		$text = 'membuat '.$this->title; //' baru '.$menus->what;
		$this->log($request, $text, ['menus.id' => $menus->id]);
		return redirect()->route('menus.index')->with('message_success', 'Menus berhasil ditambahkan!');
	}

	public function show(Request $request, Menus $menus)
	{
		$data['menus'] = $menus;

		$text = 'melihat detail '.$this->title;//.' '.$menus->what;
		$this->log($request, $text, ['menus.id' => $menus->id]);
		return view('Menus::menus_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Menus $menus)
	{
		$data['menus'] = $menus;

		$ref_categories = Categories::all()->pluck('name','id');
		
		$data['forms'] = array(
			'category_id' => ['label' => 'Category Id', 'type' => 'select', 'value' => $menus->category_id, 'required' => true, 'options' => $ref_categories->all(), 'class' => 'select2', 'id' => 'category_id'],
			'name' => ['label' => 'Name', 'type' => 'text', 'value' => $menus->name, 'required' => true, 'id' => 'name'],
			'description' => ['label' => 'Description', 'type' => 'textarea', 'value' => $menus->description, 'required' => true, 'id' => 'description'],
			'image' => ['label' => 'Image', 'type' => 'file', 'value' => $menus->image, 'required' => false, 'accept' => 'image/*', 'id' => 'image'],
			'price' => ['label' => 'Price', 'type' => 'text', 'value' => $menus->price, 'required' => true, 'id' => 'price'],
			'stock' => ['label' => 'Stock', 'type' => 'text', 'value' => $menus->stock, 'required' => true, 'id' => 'stock'],
			'is_active' => ['label' => 'Is Active', 'type' => 'select', 'value' => $menus->is_active, 'required' => true, 'options' => ['1' => 'Ya', '0' => 'Tidak'], 'id' => 'is_active'],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$menus->what;
		$this->log($request, $text, ['menus.id' => $menus->id]);
		return view('Menus::menus_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'category_id' => 'required',
			'name' => 'required',
			'description' => 'required',
			'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
			'price' => 'required',
			'stock' => 'required',
			'is_active' => 'required',
			
		]);

		$menus = Menus::find($id);
		$gambarBaru = $this->simpanGambar($request, $menus);
		$menus->category_id = $request->input("category_id");
		$menus->name = $request->input("name");
		$menus->description = $request->input("description");
		$menus->image = $gambarBaru ?? $menus->image;
		$menus->price = $request->input("price");
		$menus->stock = $request->input("stock");
		$menus->is_active = $request->input("is_active");
		
		$menus->updated_by = Auth::id();
		$menus->save();


		$text = 'mengedit '.$this->title;//.' '.$menus->what;
		$this->log($request, $text, ['menus.id' => $menus->id]);
		return redirect()->route('menus.index')->with('message_success', 'Menus berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$menus = Menus::find($id);
		if ($menus->image && Storage::disk('public')->exists($menus->image)) {
			Storage::disk('public')->delete($menus->image);
		}
		$menus->deleted_by = Auth::id();
		$menus->save();
		$menus->delete();

		$text = 'menghapus '.$this->title;//.' '.$menus->what;
		$this->log($request, $text, ['menus.id' => $menus->id]);
		return back()->with('message_success', 'Menus berhasil dihapus!');
	}

	private function simpanGambar(Request $request, $menus = null)
	{
		if (! $request->hasFile('image')) {
			return null;
		}

		if ($menus && $menus->image && Storage::disk('public')->exists($menus->image)) {
			Storage::disk('public')->delete($menus->image);
		}

		$file = $request->file('image');
		$nama = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

		return $file->storeAs('menus', $nama, 'public');
	}

}