<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\comunaRetiro;
use App\captaciones;
use App\estado;
use App\maxCap;

class RegionesController extends Controller {


	public function index()
	{
		//
	}


	public function create()
	{
		return ("funca");
	}


	public function store()
	{
		return("funca");
	}


	public function show($id)
	{//funcion que nos retornara una vista similar a la vista normal de agendamiento, pero dedicada exclusivamente a realizar agendamientos de regiones
		$status = estado::where('modulo', '=', 'llamado')->get();
		$estado = estado::where('modulo','=','agendamiento')->get();
		$f_pago = estado::where('modulo','=','pago')->get();
		$capta = captaciones::findOrFail($id);
		$minmax =maxCap::find(1);

		$comunas = comunaRetiro::where('ciudad', '!=', 'santiago')->get();


		return view('teo/agendamientoRegiones',
		 ['capta'=>$capta,
		 	'comunas'=>$comunas,
			'status'=>$status,
			'estado'=>$estado,
			'f_pago'=>$f_pago,
			'minmax'=>$minmax]);

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
