<x-app-layout>
    @section('title')
        {{ $examen->materia_info->materia }}
    @endsection
    @section('styles')
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $examen->materia_info->materia }}
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
                                        <input disabled type="text" :value="examen.materia_info.materia"
                                            class="form-control single-input-form">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="mb-0" for="">Estudiante:</label>
                                        <input disabled type="text" :value="examen.estudiante"
                                            class="form-control single-input-form"
                                            placeholder="Coloca el nombre del examen...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="mb-0" for="">Facilitador:</label>
                                        <input disabled type="text" :value="examen.materia_info.facilitador.name"
                                            class="form-control single-input-form"
                                            placeholder="Coloca el nombre del examen...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="mb-0" for="">Fecha:</label>
                                        <input disabled type="text" :value="date"
                                            class="form-control single-input-form"
                                            placeholder="Coloca el nombre del examen...">
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group mb-1">
                                        <label class="mb-0" for="">Descripción:</label>
                                        <textarea disabled :value="examen.descripcion" name="" id="" cols="30" rows="4"
                                            class="form-control single-area-form" placeholder="Coloca la descripcion del examen..."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-2 align-items-end d-flex">
                                    <div>
                                        <p style="font-size: 4em;" class="font-weight-bold mb-0" id="timer">00:00
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="width: 100%;">
                        <div v-for="tema in current_examen" class="col-12">
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
                                                                    <div class="col-md-11">
                                                                        <p style="word-wrap: break-word;"
                                                                            class="mb-1">@{{ index + 1 }}.
                                                                            @{{ _pregunta.pregunta }}</p>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group"
                                                                            v-if="tema.tipo == 'completa'">
                                                                            <input type="text"
                                                                                class="form-control single-input-form"
                                                                                :pregunta_info="[tema.id, _pregunta.id]"
                                                                                placeholder="Escribe tu respuesta aqui">
                                                                        </div>
                                                                        <div class="form-group"
                                                                            v-if="tema.tipo == 'falsoVerdadero'">
                                                                            <div
                                                                                class="custom-control custom-radio custom-control-inline">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    :pregunta_info="[tema.id, _pregunta.id, 'Verdadero']"
                                                                                    :id="'defaultInline1' + _pregunta.id"
                                                                                    :name="_pregunta.id">
                                                                                <label class="custom-control-label"
                                                                                    :for="'defaultInline1' + _pregunta.id">Verdadero</label>
                                                                            </div>
                                                                            <div
                                                                                class="custom-control custom-radio custom-control-inline">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    :pregunta_info="[tema.id, _pregunta.id, 'Falso']"
                                                                                    :id="'defaultInline2' + _pregunta.id"
                                                                                    :name="_pregunta.id">
                                                                                <label class="custom-control-label"
                                                                                    :for="'defaultInline2' + _pregunta.id">Falso</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group"
                                                                            v-if="tema.tipo == 'selectMultiple'">
                                                                            <div v-for="(opcion, ind) in _pregunta.opciones"
                                                                                class="custom-control custom-radio custom-control-inline">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    :pregunta_info="[tema.id, _pregunta.id, opcion]"
                                                                                    :id="'SelecMultiple' + index + ind +
                                                                                        _pregunta.id"
                                                                                    :name="'SelecMultiple' + index + _pregunta
                                                                                        .id">
                                                                                <label class="custom-control-label"
                                                                                    :for="'SelecMultiple' + index + ind +
                                                                                        _pregunta.id">@{{ opcion }}</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group"
                                                                            v-if="tema.tipo == 'texto_libre'">
                                                                            <textarea name="" id="" cols="30" rows="10" class="form-control single-area-form"
                                                                                :pregunta_info="[tema.id, _pregunta.id]" placeholder="Coloca la respuesta aqui..."></textarea>
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
                    </div>
                    <div class="col-12 mb-2">
                        <div class="text-right">
                            <div class="cancel_saving_button d-inline-block">
                                <button @click="validarCompletadas()" class="btn btn-success rounded-0 ml-2">Enviar
                                    Respuestas</button>
                                <a :href="homepath">
                                    <button class="btn btn-danger rounded-0 ml-2">Salir</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Pregunta-->
                <div class="modal fade" data-keyboard="false" data-backdrop="static" id="AlertModal" tabindex="-1"
                    role="dialog" aria-labelledby="AlertModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content border-0">
                            <div class="modal-header py-2 bg-info">
                            </div>
                            <div class="modal-body py-1">
                                <section class="row">
                                    <aside class="col-md-12">
                                        <div class="align-items-center d-flex justify-content-between">
                                            <span v-if="alert_type == 'completado'" class="font-weight-bold">Ya has
                                                completado esta prueba anteriormente.</span>
                                            <span v-if="alert_type == 'disponible'" class="font-weight-bold">Esta
                                                prueba no se encuentra disponible.</span>
                                            <span v-if="alert_type == 'unavailable'" class="font-weight-bold">Esta
                                                prueba ya se encuentra cerrada.</span>
                                            <div class="border d-inline-block m-1 ">
                                                <a :href="homepath">
                                                    <button
                                                        class="btn btn-sm btn-danger btn-section rounded-0">Regresar</button>
                                                </a>
                                            </div>
                                        </div>
                                    </aside>
                                </section>
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

            var examen = {!! json_encode($examen) !!}
            var completado = {!! json_encode($completado) !!}
        </script>
        <script type="text/javascript" src="{{ asset('/js/custom/examenes/llenar.js') }}"></script>
    @endsection
</x-app-layout>
