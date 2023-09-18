<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\User;

class MateriaController extends Controller
{
    public function all()
    {
        $materias = Materia::with('facilitador')->get();
        $facilitadores = User::where('status', 1)->where('facilitador', 1)->get();
        return view('materias', compact('materias', 'facilitadores'));
    }

    public function store(Request $request)
    {

        $materia_info = [
            'materia' => $request->materia['nombre'],
            'facilitador_id' => $request->materia['facilitador'],
            'status' => 1
        ];

        Materia::create($materia_info);
        $materias = Materia::with('facilitador')->get();
        return response()->json($materias, 200);
    }

    public function update(Request $request, $id)
    {
        Materia::find($id)->update(['materia' => $request->materia['nombre'], 'facilitador_id' => $request->materia['facilitador']]);
        $materias = Materia::with('facilitador')->get();
        return response()->json($materias, 200);
    }

    public function delete($id)
    {
        Materia::destroy($id);
        $materias = Materia::with('facilitador')->get();
        return response()->json($materias, 200);
    }

    public function update_campo($campo, $id, $status)
    {
        Materia::find($id)->update([$campo => $status ]);
        // return [$role, $id, $status];
    }
}
