<?php
namespace App\Modules\Categories\Controllers;

use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Categories\Models\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Categories";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Categories::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Categories::categories', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'name' => ['label' => 'Name', 'type' => 'text', 'value' => old("name"), 'required' => true],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Categories::categories_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			
		]);

		$categories = new Categories();
		$categories->name = $request->input("name");
		
		$categories->created_by = Auth::id();
		$categories->save();

		$text = 'membuat '.$this->title; //' baru '.$categories->what;
		$this->log($request, $text, ['categories.id' => $categories->id]);
		return redirect()->route('categories.index')->with('message_success', 'Categories berhasil ditambahkan!');
	}

	public function show(Request $request, Categories $categories)
	{
		$data['categories'] = $categories;

		$text = 'melihat detail '.$this->title;//.' '.$categories->what;
		$this->log($request, $text, ['categories.id' => $categories->id]);
		return view('Categories::categories_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Categories $categories)
	{
		$data['categories'] = $categories;

		
		$data['forms'] = array(
			'name' => ['label' => 'Name', 'type' => 'text', 'value' => $categories->name, 'required' => true, 'id' => 'name'],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$categories->what;
		$this->log($request, $text, ['categories.id' => $categories->id]);
		return view('Categories::categories_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required',
			
		]);

		$categories = Categories::find($id);
		$categories->name = $request->input("name");
		
		$categories->updated_by = Auth::id();
		$categories->save();


		$text = 'mengedit '.$this->title;//.' '.$categories->what;
		$this->log($request, $text, ['categories.id' => $categories->id]);
		return redirect()->route('categories.index')->with('message_success', 'Categories berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$categories = Categories::find($id);
		$categories->deleted_by = Auth::id();
		$categories->save();
		$categories->delete();

		$text = 'menghapus '.$this->title;//.' '.$categories->what;
		$this->log($request, $text, ['categories.id' => $categories->id]);
		return back()->with('message_success', 'Categories berhasil dihapus!');
	}

}
