<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\captaciones;
use App\fundacion;
use Illuminate\Http\Request;

class InformesController extends Controller {


	public function index()
	{
		$total= captaciones::all()->count();
		$llamados = captaciones::where('estado','!=',0)->count();
		$pendientes = captaciones::where('estado','=',0)->count();
		$cumas = captaciones::where('estado','=','cu+')->count();
		$cumenos = captaciones::where('estado','=','cu-')->count();
		$cnu = captaciones::where('estado','=','cnu')->count();
		$base = captaciones::find(1);
		$contactados = $cumas+$cumenos;
		$name = $base->campana;
		$fundacion = fundacion::find($base->fundacion)->nombre;

		$penetracion = $cumas/$llamados;
		$contactavilidad =$contactados/$llamados;
		$penetracionTotal = $cumas/$total;

		return view('informes.Dashboard',[
			'total'=>$total,
			'llamados'=>$llamados,
			'pendientes'=>$pendientes,
			'cumas'=>$cumas,
			'cumenos'=>$cumenos,
			'cnu'=>$cnu,
			'name'=>$name,
			'fundacion'=>$fundacion,
			'penetracion'=>$penetracion,
			'contactavilidad'=>$contactavilidad,
			'penetracionTotal'=>$penetracionTotal,
		]);
	}

	public function create()
	{
		//
	}


	public function store()
	{
		//
	}


	public function show($id)
	{
		//
	}


	public function edit($id)
	{
		//
	}


	public function update($id)
	{
		//
	}


	public function destroy($id)
	{
		//
	}

}
