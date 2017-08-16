<?php namespace App\Http\Controllers;

use App\CaptacionesExitosa;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;


class OperacionesController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$dias = CaptacionesExitosa::all();
		$teos = User::where('perfil', '=', 2)->get();
		$datos = CaptacionesExitosa::all();
		return view('operac/agendamiento', compact('datos', 'teos'));

	}

	public function show($id)
	{

		$datos = CaptacionesExitosa::all();
		return view('operac/detalleAgendamiento', compact('datos'));
	}

	public function create()
	{

		return 'accion create';
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function showDay(Request $request)
	{

		$option = Input::get('dia');
		$hoy = Carbon::now()->format('d/m/Y');
		$last_week = Carbon::now()->startOfWeek()->format('d/m/Y');
		$last_month = Carbon::now()->startOfMonth()->format('d/m/Y');
		if ($option == 1) {

			$today = DB::table('captaciones_exitosas')->where('fecha_captacion', '=', $hoy)->get();
			return Response::json($today);

		} elseif ($option == 2) {

			$dias = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_week, $hoy])->get();
			return Response::json($dias);
		} elseif ($option == 3) {
			$captacion = DB::table('captaciones_exitosas')->whereBetween('fecha_captacion', [$last_month, $hoy])->get();

			return Response::json($captacion);

		} else {
		}
	}


}

