<x-app-layout>
    @section('title')
        {{ $examen_completado->examen->materia_info->materia }}
    @endsection
    @section('styles')
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $examen_completado->examen->materia_info->materia }}{{ __('Inicio') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="row">
                    <div class="col-12">
                        <div class="header-pages rounded-top text-white">
                            <span class="text-uppercase">Información General</span>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="test-records">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="mb-0" for="">Materia:</label>
                                        <input disabled type="text"
                                            :value="examen_completado.examen.materia_info.materia"
                                            class="form-control single-input-form">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="mb-0" for="">Estudiante:</label>
                                        <input disabled type="text" :value="examen_completado.user.name"
                                            class="form-control single-input-form"
                                            placeholder="Coloca el nombre del examen...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="mb-0" for="">Facilitador:</label>
                                        <input disabled type="text"
                                            :value="examen_completado.examen.materia_info.facilitador.name"
                                            class="form-control single-input-form"
                                            placeholder="Coloca el nombre del examen...">
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="mb-0" for="">Fecha:</label>
                                        <input disabled type="text" :value="examen_completado.created_at" class="form-control single-input-form" placeholder="Coloca el nombre del examen...">
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="mb-0" for="">Calificacion:</label>
                                        <input type="text" v-model="examen.calificacion"
                                            class="form-control single-input-form" id="calificacion"
                                            placeholder="Coloca la calificación...">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label class="mb-0">Notas:</label>
                                        <textarea name="" id="" v-model="examen.notas" cols="30" rows="4"
                                            class="form-control single-area-form" placeholder="Colocar alguna una nota adicional..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="width: 100%;" class="mb-4">
                        <div v-for="tema in examen_completado.examen.temas" class="col-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="header-pages" style="background-color: #17a2b8;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="mb-0 text-white">@{{ tema.nombre }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="test-records">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="test-records">
                                                    <div class="row">
                                                        <div v-for="(_pregunta,index) in tema.preguntas"
                                                            class="col-12 mb-2">
                                                            <div class="question-container rounded border">
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <p style="word-wrap: break-word;"
                                                                            class="mb-1">@{{ index + 1 }}.
                                                                            @{{ _pregunta.pregunta }}</p>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <div
                                                                                class="custom-control custom-radio custom-control-inline">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    :pregunta_info="[tema.id, _pregunta.id, 1]"
                                                                                    :id="'defaultInline1' + _pregunta.id"
                                                                                    :checked="_pregunta.calificacion == 1"
                                                                                    :name="_pregunta.id">
                                                                                <label class="custom-control-label"
                                                                                    :for="'defaultInline1' + _pregunta.id">Correcto</label>
                                                                            </div>
                                                                            <div
                                                                                class="custom-control custom-radio custom-control-inline">
                                                                                <input type="radio"
                                                                                    class="custom-control-input custom-control-input-incorrect"
                                                                                    :pregunta_info="[tema.id, _pregunta.id, '0']"
                                                                                    :checked="_pregunta.calificacion == 0"
                                                                                    :id="'defaultInline2' + _pregunta.id"
                                                                                    :name="_pregunta.id">
                                                                                <label class="custom-control-label"
                                                                                    :for="'defaultInline2' + _pregunta.id">Incorrecto</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <p class="mb-1">
                                                                            {{-- <span :class="[tema.tipo_pregunta == 'text_libre' ? 'white-space: pre-line' : '']" class="bg-success text-white py-1 px-2 rounded d-inline-block"> --}}
                                                                            <span style="background: #000f2b"
                                                                                :class="[tema.tipo_pregunta == 'texto_libre' ?
                                                                                    'texto_libre px-3 pb-3 rounded' :
                                                                                    'px-2 rounded-0'
                                                                                ]"
                                                                                class="btn text-white btn-section btn-sm text-left">
                                                                                @{{ _pregunta.respuesta }}
                                                                            </span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="text-right">
                            <div class="cancel_saving_button d-inline-block">
                                <button :disabled="examen.calificacion == '' || examen.calificacion == null"
                                    @click="validarCalificadas()" class="btn btn-success rounded-0 ml-2">Guardar
                                    Calificación</button>
                                <a :href="homepath">
                                    <button class="btn btn-danger rounded-0 ml-2">Salir</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            Vue.use(VeeValidate);
            var examen_completado = {!! json_encode($examen_completado) !!}
        </script>

        <script type="text/javascript" src="{{ asset('/js/custom/examenes/calificar.js') }}"></script>
    @endsection
</x-app-layout>
