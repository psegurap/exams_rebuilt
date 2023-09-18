<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examen;
use App\Models\Tema;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\ExamenCompletado;
use App\Models\Materia;
use Auth;

class ExamenController extends Controller
{
    public function all()
    {
        $examenes = Examen::with(['materia_info' => function($materia){
            $materia->with('facilitador:id,name')->get();
        }])->get();
        return view('examenes.all_examenes', compact('examenes'));
    }

    public function create()
    {
        $materias = Materia::where('status', 1)->get();
        return view('examenes.create', compact('materias'));
    }

    public function store(Request $request)
    {
        $template_info =  $request->template;
        $temas =  $request->temas;

        $template_data = [
            'nombre' => $template_info['nombre'],
            'materia' => $template_info['materia'],
            'descripcion' => $template_info['descripcion'],
            'facilitador_id' => Auth::user()->id,
            'status' => 1,
        ];
        $examen = Examen::create($template_data);

        foreach ($temas as $tema) {
            $tema_info = [
                'nombre' => $tema['nombre'],
                'tipo_pregunta' => $tema['tipo'],
                'examen_id' => $examen->id,
                'status' => 1,
            ];
            $created_tema = Tema::create($tema_info);

            foreach ($tema['preguntas'] as $pregunta) {
                if(count($pregunta['opciones']) > 0){
                    $opciones = implode('||', $pregunta['opciones']);
                }else{
                    $opciones = null;
                }
                $pregunta_info = [
                    'pregunta' => $pregunta['pregunta'],
                    'select_options' => $opciones,
                    'tema_id' =>$created_tema->id,
                    'status' => 1,
                ];
                Pregunta::create($pregunta_info);
            }
        }
        return response()->json($examen, 200);
    }

    public function delete_examen($id)
    {
        Examen::find($id)->forceDelete();
        $current_temas = Tema::where('examen_id', $id)->get();
        foreach ($current_temas as $tema ) {
            Pregunta::where('tema_id', $tema['id'])->forceDelete();
        }
        Tema::where('examen_id', $id)->forceDelete();

        $completados = ExamenCompletado::where('template_id', $id)->get();
        if($completados){
            foreach ($completados as $completado ) {
                Respuesta::where('examen_completado_id', $completado->id)->forceDelete();
            }
            ExamenCompletado::where('template_id', $id)->forceDelete();
        }

        $examenes = Examen::with(['materia_info' => function($materia){
            $materia->with('facilitador:id,name')->get();
        }])->get();

        return response()->json($examenes, 200);
    }

    public function llenar_examen($id)
    {
        $examen = Examen::with(['materia_info' => function($materia){
            $materia->with('facilitador')->get();
        }, 'temas' => function($query){
            $query->with('preguntas')->where('status', 1)->get();
        }])->find($id);

        $examen->temas = $examen->temas->map(function($tema){
            $tema = $tema->preguntas->map(function($pregunta){
                if($pregunta['select_options'] == null){
                    return $pregunta;
                }else{
                    $pregunta['select_options'] = explode('||', $pregunta['select_options']);
                    return $pregunta;
                }
            });
            return $tema;
        });
        $examen->estudiante = Auth::user()->name;

        $completado = ExamenCompletado::where('template_id', $examen->id)->where('user_id', Auth::user()->id)->get();

        return view('examenes.llenar_examen', compact('examen', 'completado'));
    }

    public function editar_examen($id)
    {
        $materias = Materia::where('status', 1)->get();
        $examen = Examen::with(['materia_info' => function($materia){
            $materia->with('facilitador')->get();
        }, 'temas' => function($query){
            $query->with('preguntas')->where('status', 1)->get();
        }])->find($id);

        $examen->temas = $examen->temas->map(function($tema){
            $tema = $tema->preguntas->map(function($pregunta){
                if($pregunta['select_options'] == null){
                    return $pregunta;
                }else{
                    $pregunta['select_options'] = explode('||', $pregunta['select_options']);
                    return $pregunta;
                }
            });
            return $tema;
        });

        return view('examenes.edit', compact('examen', 'materias'));
    }

    public function save_edit(Request $request, $id)
    {
        $temas = $request->temas;
        Examen::find($id)->update(['nombre' => $request->template['nombre'], 'materia' => $request->template['materia'], 'descripcion' => $request->template['descripcion']]);
        $current_temas = Tema::where('examen_id', $id)->get();
        foreach ($current_temas as $tema ) {
            Pregunta::where('tema_id', $tema['id'])->forceDelete();
        }
        Tema::where('examen_id', $id)->forceDelete();

        $completados = ExamenCompletado::where('template_id', $id)->get();
        if($completados){
            foreach ($completados as $completado ) {
                Respuesta::where('examen_completado_id', $completado->id)->forceDelete();
            }
            ExamenCompletado::where('template_id', $id)->forceDelete();
        }


        foreach ($temas as $tema) {
            $tema_info = [
                'nombre' => $tema['nombre'],
                'tipo_pregunta' => $tema['tipo'],
                'examen_id' => $id,
                'status' => 1,
            ];
            $created_tema = Tema::create($tema_info);

            foreach ($tema['preguntas'] as $pregunta) {
                if(count($pregunta['opciones']) > 0){
                    $opciones = implode('||', $pregunta['opciones']);
                }else{
                    $opciones = null;
                }
                $pregunta_info = [
                    'pregunta' => $pregunta['pregunta'],
                    'select_options' => $opciones,
                    'tema_id' =>$created_tema->id,
                    'status' => 1,
                ];
                Pregunta::create($pregunta_info);
            }
        }

        return $request;
    }

    public function store_respuestas(Request $request)
    {
        // return $request;
        $curren_examen = Examen::find($request->examen_id);
        if($curren_examen->disponible == 0){
            return response()->json('unavailable', 401);
        }else{
            $temas =  $request->temas;

            $examen_data = [
                'template_id' => $request->examen_id,
                'user_id' => Auth::user()->id,
                'status' => 1
            ];
            $examen_completado = ExamenCompletado::create($examen_data);

            foreach ($temas as $tema) {
                foreach ($tema['preguntas'] as $pregunta) {

                    $respuesta_info = [
                        'examen_completado_id' => $examen_completado->id,
                        'question_id' => $pregunta['id'],
                        'respuesta' => $pregunta['respuesta'],

                    ];
                    Respuesta::create($respuesta_info);
                }
            }
            return response()->json($examen_completado->id, 200);
        }
    }

    public function all_completados()
    {
        $examenes = ExamenCompletado::with(['user:id,name', 'examen' => function($examen){
            $examen->with(['materia_info' => function($materia){
                $materia->with('facilitador')->get();
            }])->get();
        }])->get();
        return view('examenes.all_completados', compact('examenes'));
    }

    public function examen_completado($id)
    {
        $examen_completado = ExamenCompletado::with(['user:id,name', 'examen' => function($examen) use ($id){
            $examen->with(['materia_info' => function($materia){
                $materia->with('facilitador:id,name')->get();
            }, 'temas' => function($tema) use ($id){
                $tema->with(['preguntas' => function($pregunta) use ($id){
                    $pregunta->with(['respuesta' => function($respuesta) use ($id){
                        $respuesta->where('examen_completado_id', $id)->get();
                    }])->get();
                }])->get();
            }])->get();
        }])->find($id);

        // $examen_completado->created_at = 'asdasasdd';
        // $examen_completado['created_at'] = date("m-d-Y", strtotime($examen_completado['created_at']));

        return view('examenes.completado', compact('examen_completado'));
    }

    public function calificar_completado($id)
    {
        $examen_completado = ExamenCompletado::with(['user:id,name', 'examen' => function($examen) use ($id){
            $examen->with(['materia_info' => function($materia){
                $materia->with('facilitador:id,name')->get();
            }, 'temas' => function($tema) use ($id){
                $tema->with(['preguntas' => function($pregunta) use ($id){
                    $pregunta->with(['respuesta' => function($respuesta) use ($id){
                        $respuesta->where('examen_completado_id', $id)->get();
                    }])->get();
                }])->get();
            }])->get();
        }])->find($id);

        // $examen_completado->created_at = 'asdasasdd';
        // $examen_completado['created_at'] = date("m-d-Y", strtotime($examen_completado['created_at']));

        return view('examenes.calificar_examen', compact('examen_completado'));
    }

    public function store_calificacion(Request $request)
    {
        ExamenCompletado::find($request->examen['id'])->update(['calificacion_final' => $request->examen['calificacion'], 'notas' => $request->examen['notas']]);
        foreach ($request->temas as $tema) {
            foreach ($tema['preguntas'] as $pregunta) {
                Respuesta::where('examen_completado_id', $request->examen['id'])->where('question_id', $pregunta['id'])->update(['respuesta_calificacion' => $pregunta['calificacion']]);
            }
        }
        return response()->json('Done', 200);
    }

    public function update_campo($campo, $id, $status)
    {
        Examen::find($id)->update([$campo => $status ]);
    }

    public function completados_update_campo($campo, $id, $status)
    {
        ExamenCompletado::find($id)->update([$campo => $status ]);
    }

}
