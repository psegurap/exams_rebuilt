<x-app-layout>
    @section('title')
        Crear Examen
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Examen') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4">
            <div class="">
                <div class="row">
                    <div class="col-12 mb-2">
                        <div class="header-pages rounded-top text-white">
                            <span class="text-uppercase">Crear Examen</span>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="test-records">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="">Nombre Del Examen:</label>
                                        <input type="text" v-model="template_info.nombre"
                                            class="form-control single-input-form"
                                            placeholder="Coloca el nombre del examen...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Materia Correspondiente:</label>
                                        <select v-model="template_info.materia" name="" id=""
                                            class="form-control single-input-form">
                                            <option disabled value="">Selecciona materia</option>
                                            <option v-for="materia in materias" :value="materia.id">
                                                @{{ materia.materia }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Descripción Del Examen:</label>
                                        <textarea v-model="template_info.descripcion" name="" id="" cols="30" rows="4"
                                            class="form-control single-area-form" placeholder="Coloca la descripcion del examen..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="text-right pb-2 border-bottom">
                            <button class="btn btn-info rounded-0"
                                :disabled="template_info.name == '' || template_info.materia == '' || template_info.descripcion ==
                                    ''"
                                @click="openModal('TemaModal', 'create', 'tema')">Agregar Tema</button>
                        </div>
                    </div>
                    <div class="col-12 mb-4" v-if="template_info.temas.length > 0">
                        <div class="pb-1 border-bottom">
                            <div v-for="tema in template_info.temas" class="border d-inline-block m-1 ">
                                <button @click="chooseTema(tema.id)"
                                    :class="[tema.id == current_tema ? 'active-section' : '']"
                                    class="btn btn-sm btn-light btn-section rounded-0 text-left">@{{ tema.nombre }}</button>
                            </div>
                        </div>
                    </div>
                    <div v-if="CurrentTema.length > 0" style="width: 100%;">
                        <div class="col-12 mb-2">
                            <div class="header-pages rounded-top" style="background-color: #17a2b8;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-9">
                                                <span class="text-uppercase font-weight-bold text-white">Tema
                                                    Actual:</span>
                                            </div>
                                            <div class="col-3">
                                                <div class='d-flex justify-content-end'>
                                                    <div class='text-white mr-2' style='font-size: 1.5em;'>
                                                        <i style='cursor:pointer'
                                                            @click="openModal('PreguntaModal', 'create', 'pregunta')"
                                                            title="Agregar Pregunta" class='fa fa-plus'
                                                            aria-hidden='true'></i>
                                                    </div>
                                                    <div class='text-white mr-2' style='font-size: 1.5em;'>
                                                        <i style='cursor:pointer' @click="editTema()"
                                                            title="Editar Tema" class='fa fa-pencil-square-o'
                                                            aria-hidden='true'></i>
                                                    </div>
                                                    <div class='text-white mr-2' style='font-size: 1.5em;'>
                                                        <i style='cursor:pointer' @click="deleteTema()"
                                                            title="Eliminar Tema" class='fa fa-trash'
                                                            aria-hidden='true'></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mb-0 text-white">@{{ CurrentTema[0].nombre }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="test-records">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="test-records">
                                            <div class="row">
                                                <div v-for="(_pregunta,index) in CurrentTema[0].preguntas"
                                                    class="col-12 mb-2">
                                                    <div class="question-container rounded border">
                                                        <div class="row">
                                                            <div class="col-9">
                                                                <label for="" class="mb-0 h6"><strong>Pregunta
                                                                        #@{{ (index + 1) }}:</strong></label>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class='d-flex justify-content-end'>
                                                                    <div class='text-info mr-2 fa-lg'
                                                                        style='font-size: 1.5em;'>
                                                                        <i style='cursor:pointer'
                                                                            title="Editar Pregunta"
                                                                            @click="editarPregunta(_pregunta.id)"
                                                                            class='fa fa-pencil-square-o'
                                                                            aria-hidden='true'></i>
                                                                    </div>
                                                                    <div class='text-danger mr-2 fa-lg'
                                                                        style='font-size: 1.5em;'>
                                                                        <i style='cursor:pointer'
                                                                            title="Eliminar Pregunta"
                                                                            @click="eliminarPregunta(_pregunta.id)"
                                                                            class='fa fa-trash'
                                                                            aria-hidden='true'></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-11">
                                                                <p>@{{ _pregunta.pregunta }}</p>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group"
                                                                    v-if="CurrentTema[0].tipo == 'completa'">
                                                                    <input type="text"
                                                                        class="form-control single-input-form"
                                                                        placeholder="Escribe tu respuesta aqui">
                                                                </div>
                                                                <div class="form-group"
                                                                    v-if="CurrentTema[0].tipo == 'falsoVerdadero'">
                                                                    <div
                                                                        class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio"
                                                                            class="custom-control-input"
                                                                            :id="'defaultInline1' + index"
                                                                            :name="'VerdaderoFalso' + index">
                                                                        <label class="custom-control-label"
                                                                            :for="'defaultInline1' + index">Verdadero</label>
                                                                    </div>
                                                                    <div
                                                                        class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio"
                                                                            class="custom-control-input"
                                                                            :id="'defaultInline2' + index"
                                                                            :name="'VerdaderoFalso' + index">
                                                                        <label class="custom-control-label"
                                                                            :for="'defaultInline2' + index">Falso</label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group"
                                                                    v-if="CurrentTema[0].tipo == 'selectMultiple'">
                                                                    <div v-for="(opcion, ind) in _pregunta.opciones"
                                                                        class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio"
                                                                            class="custom-control-input"
                                                                            :id="'SelecMultiple' + index + ind"
                                                                            :name="'SelecMultiple' + index">
                                                                        <label class="custom-control-label"
                                                                            :for="'SelecMultiple' + index + ind">@{{ opcion }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group"
                                                                    v-if="CurrentTema[0].tipo == 'texto_libre'">
                                                                    <textarea name="" id="" cols="30" rows="6" class="form-control single-area-form"
                                                                        placeholder="Coloca la respuesta aqui..."></textarea>
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
                    <div v-if="CurrentTema.length > 0 && CurrentTema[0].preguntas.length > 0" class="col-12 mb-2">
                        <div class="text-right">
                            <div class="cancel_saving_button d-inline-block">
                                <button class="btn btn-success rounded-0 ml-2" @click="guardarExamen()"
                                    :disabled="template_info.name == '' || template_info.materia == '' || template_info
                                        .descripcion == ''">Guardar
                                    Examen</button>
                                <button class="btn btn-danger rounded-0 ml-2">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tema -->
    <div v-if="current_modal == 'tema'" class="modal fade" id="TemaModal" tabindex="-1" role="dialog"
        aria-labelledby="TemaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p v-if="tema_view == 'create'" class="modal-title mb-0 h6">{{ __('Agregar Tema') }}</p>
                    <p v-if="tema_view == 'edit'" class="modal-title mb-0 h6">{{ __('Editar Tema') }}</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section class="row">
                        <aside class="col-md-12">
                            <div class="form-group">
                                <label class="" for="">Titulo del tema:</label>
                                <input v-validate="'required'" type="text" v-model="tema.nombre" name="title"
                                    class="form-control single-input-form" placeholder="Coloca el nombre del tema...">
                                <span class="text-danger" style="font-size: 12px;" v-show="errors.has('title')">*
                                    @{{ errors.first('title') }}</span>
                            </div>
                        </aside>
                        <aside class="col-md-12">
                            <div class="form-group">
                                <label for="">Tipo de preguntas:</label>
                                <select v-validate="'required'" v-model="tema.tipo" name="type" id=""
                                    class="form-control single-input-form">
                                    <option disabled value="">Selecciona tipo</option>
                                    <option value="falsoVerdadero">Falso y Verdadero</option>
                                    <option value="completa">Completa</option>
                                    <option value="selectMultiple">Seleccion Multiple</option>
                                    <option value="texto_libre">Texto Libre</option>
                                </select>
                                <span class="text-danger" style="font-size: 12px;" v-show="errors.has('type')">*
                                    @{{ errors.first('type') }}</span>
                            </div>
                        </aside>
                    </section>
                </div>
                <div class="modal-footer">
                    <button v-if="tema_view == 'create'" type="button" @click="validate(agregarTema)"
                        class="btn btn-info btn-sm rounded-0">{{ __('Agregar') }}</button>
                    <button v-if="tema_view == 'edit'" type="button" @click="validate(updateTema)"
                        class="btn btn-warning btn-sm rounded-0">{{ __('Actualizar') }}</button>
                    <button type="button" class="btn btn-danger btn-sm rounded-0" @click="closeModal()"
                        data-dismiss="modal">{{ __('Cerrar') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pregunta-->
    <div class="modal fade" id="PreguntaModal" tabindex="-1" role="dialog" aria-labelledby="PreguntaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p v-if="pregunta_view == 'create'" class="modal-title mb-0 h6">{{ __('Agregar Pregunta') }}</p>
                    <p v-if="pregunta_view == 'edit'" class="modal-title mb-0 h6">{{ __('Editar Pregunta') }}</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" v-if="current_modal == 'pregunta'">
                    <section class="row">
                        <aside class="col-md-12">
                            <div class="form-group">
                                <label class="" for="">Pregunta:</label>
                                <input v-validate="'required'" type="text" v-model="pregunta.pregunta"
                                    name="question" class="form-control single-input-form"
                                    placeholder="Coloque la pregunta...">
                                <span class="text-danger" style="font-size: 12px;" v-show="errors.has('question')">*
                                    @{{ errors.first('question') }}</span>
                            </div>
                        </aside>
                        <aside class="col-md-12"
                            v-if="CurrentTema.length > 0 && CurrentTema[0].tipo == 'selectMultiple'">
                            <div class="input-group mb-3">
                                <input type="text" v-model="adding_option" class="form-control single-input-form"
                                    placeholder="Escriba una opción..." aria-label="Recipient's username"
                                    aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button :disabled="adding_option == ''"
                                        class="btn btn-info btn-sm waves-effect waves-light" @click="agregarOpcion()"
                                        type="button">Agregar Opción</button>
                                </div>
                            </div>
                        </aside>
                        <aside class="col-md-12"
                            v-if="CurrentTema.length > 0 && CurrentTema[0].tipo == 'selectMultiple'">
                            <div>
                                <div>
                                    <label for="">Opciones:</label>
                                </div>
                                <div v-for="opcion in pregunta.opciones" class="d-inline-block m-1">
                                    <span class="btn btn-sm btn-info btn-section rounded-0 text-left">
                                        @{{ opcion }}
                                        <span type="button" @click="removerOpcion(opcion)"
                                            class="btn btn-danger btn-sm ml-1 px-1 py-0 waves-effect waves-light">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </aside>
                    </section>
                </div>
                <div class="modal-footer">
                    <button v-if="pregunta_view == 'create'" type="button" @click="validate(agregarPregunta)"
                        class="btn btn-info btn-sm rounded-0">{{ __('Agregar') }}</button>
                    <button v-if="pregunta_view == 'edit'" type="button" @click="validate(updatePregunta)"
                        class="btn btn-warning btn-sm rounded-0">{{ __('Actualizar') }}</button>
                    <button type="button" class="btn btn-danger btn-sm rounded-0" @click="closeModal()"
                        data-dismiss="modal">{{ __('Cerrar') }}</button>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            Vue.use(VeeValidate);
            var materias = {!! json_encode($materias) !!};
        </script>
        <script type="text/javascript" src="{{ asset('/js/custom/examenes/create.js') }}"></script>
    @endsection
</x-app-layout>
