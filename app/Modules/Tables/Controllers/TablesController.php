<?php
namespace App\Modules\Tables\Controllers;

use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Tables\Models\Tables;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TablesController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Tables";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Tables::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Tables::tables', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'table_number' => ['label' => 'Table Number', 'type' => 'text', 'value' => old("table_number"), 'required' => true],
			'qr_token' => ['label' => 'Qr Token', 'type' => 'text', 'value' => old("qr_token"), 'required' => true],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Tables::tables_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'table_number' => 'required',
			'qr_token' => 'required',
			
		]);

		$tables = new Tables();
		$tables->table_number = $request->input("table_number");
		$tables->qr_token = $request->input("qr_token");
		
		$tables->created_by = Auth::id();
		$tables->save();

		$text = 'membuat '.$this->title; //' baru '.$tables->what;
		$this->log($request, $text, ['tables.id' => $tables->id]);
		return redirect()->route('tables.index')->with('message_success', 'Tables berhasil ditambahkan!');
	}

	public function show(Request $request, Tables $tables)
	{
		$data['tables'] = $tables;

		$text = 'melihat detail '.$this->title;//.' '.$tables->what;
		$this->log($request, $text, ['tables.id' => $tables->id]);
		return view('Tables::tables_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Tables $tables)
	{
		$data['tables'] = $tables;

		
		$data['forms'] = array(
			'table_number' => ['label' => 'Table Number', 'type' => 'text', 'value' => $tables->table_number, 'required' => true, 'id' => 'table_number'],
			'qr_token' => ['label' => 'Qr Token', 'type' => 'text', 'value' => $tables->qr_token, 'required' => true, 'id' => 'qr_token'],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$tables->what;
		$this->log($request, $text, ['tables.id' => $tables->id]);
		return view('Tables::tables_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'table_number' => 'required',
			'qr_token' => 'required',
			
		]);

		$tables = Tables::find($id);
		$tables->table_number = $request->input("table_number");
		$tables->qr_token = $request->input("qr_token");
		
		$tables->updated_by = Auth::id();
		$tables->save();


		$text = 'mengedit '.$this->title;//.' '.$tables->what;
		$this->log($request, $text, ['tables.id' => $tables->id]);
		return redirect()->route('tables.index')->with('message_success', 'Tables berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$tables = Tables::find($id);
		$tables->deleted_by = Auth::id();
		$tables->save();
		$tables->delete();

		$text = 'menghapus '.$this->title;//.' '.$tables->what;
		$this->log($request, $text, ['tables.id' => $tables->id]);
		return back()->with('message_success', 'Tables berhasil dihapus!');
	}

}
