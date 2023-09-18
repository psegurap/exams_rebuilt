<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Examen;
use App\Models\Materia;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function inicio()
    {
        $user = Auth::user()->with(['estudiante_materia' => function($materia){
            $materia->with('facilitador')->get();
        }])->find(Auth::user()->id);

        $estudiantes = [];
        if(Auth::user()->facilitador == 1){
            $estudiantes = Materia::with(['estudiante_materia' => function($estudiante){
                $estudiante->with('examen_completado')->where('estudiante', 1)->orderBy('name', 'asc')->get();
            }])->where('facilitador_id', Auth::user()->id)->get();
        }
        $materia_id = null;
        if(count($user->estudiante_materia)){
            $materia_id = $user->estudiante_materia[0]['id'];
        }
        $exams = Examen::with(['examenes_completados' => function($examen){
            $examen->where('user_id', Auth::user()->id);
        }, 'materia_info' => function($materia){
            $materia->with(['facilitador', 'estudiante_materia' => function($estudiante){
                $estudiante->where('estudiante_id', Auth::user()->id)->get();
            }])->get();
        }])->where('status', 1)->where('materia', $materia_id)->get();

        return view('index', compact('exams', 'user', 'estudiantes'));
    }


    public function home()
    {
        return view('home');
    }

    public function panel_usuarios()
    {
        $users = User::with('estudiante_materia')->get();
        $materias = Materia::where('status', 1)->get();
        return view('panel', compact('users', 'materias'));
    }

    public function update_estudiante($id, $materia)
    {
        $user = User::find($id);
        $user->estudiante_materia()->detach();
        $user->estudiante_materia()->attach($materia);
        $users = User::with('estudiante_materia')->get();
        return response()->json($users, 200);
    }

    public function update_rol($campo, $id, $status)
    {
        User::find($id)->update([$campo => $status ]);
        $users = User::with('estudiante_materia')->get();
        return response()->json($users, 200);
    }
}
