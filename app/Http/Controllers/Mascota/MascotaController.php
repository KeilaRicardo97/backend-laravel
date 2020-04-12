<?php

namespace App\Http\Controllers\Mascota;

use App\Mascota;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class MascotaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mascotas = Mascota::all();
        return $this->showAll($mascotas);

    }

    public function store(Request $request)
    {
        $rule = [            
			'name' => 'required',
        ];
		$this->validate($request, $rule);
        $MascoraArray = $request->all();
        $MascoraArray['name'] = $request->name;
        $MascoraArray['raza'] = $request->raza;
        $MascoraArray['edad'] = $request->edad;
        $newMascota = Mascota::create($MascoraArray);
        return $this->showOne($newMascota);
    }

    public function show(Mascota $mascota)
    {
        return $this->showOne($mascota);
    }



    public function update(Request $request, Mascota $mascota)
    {
        $role = [ 'name' => 'required'];
        $this->validate($request, $role);
        if($request->has('name')){
			$mascota->name = $request->name;
        }
        if($request->has('edad')){
			$mascota->edad = $request->edad;
        }
        if($request->has('raza')){
			$mascota->raza = $request->raza;
        }
        $mascota->save();
        return $this->showOne($mascota);
    }

 
    public function destroy(Mascota $mascota)
    {
        $mascota->delete();
        return $this->showOne($mascota);
    }
}
