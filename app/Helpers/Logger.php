<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;

trait Logger{

	public function log(Request $request, $activity, $context = NULL, $data = NULL)
	{
		$user = $request->user() ?? \Illuminate\Support\Facades\Auth::user();
		$route = $request->route() ? ($request->route()->getName() ?? '') : '';
		$elm = explode('.', $route);
		$action = end($elm);

		$log = $this->log;
		$log->id_user = @$user->id ?? '00000000-0000-0000-0000-000000000000';
		$log->name = @$user->name ?? 'Guest';
		$log->aktivitas = $activity;
		$log->route = $route;
		$log->action = $action;
		$log->context = $context == null ? null : json_encode($context);
		$log->data = $data == null ? null : json_encode($data);
		$log->ip_address = $request->ip();
		$log->user_agent = $request->userAgent();
		$log->save();
	}

}
