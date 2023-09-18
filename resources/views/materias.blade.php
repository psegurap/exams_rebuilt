<x-app-layout>
    @section('title')
        Materias
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Materias') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="text-right border-bottom pb-3">
                            <button @click="openModal('MateriaModal', 'create')" class="btn btn-info">Registrar
                                Materia</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="table"
                            class="table table-bordered table-hover table-sm text-center table-responsive-sm"
                            style="width:100%">
                            <thead class="table-header bg-info text-white">
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Materia') }}</th>
                                    <th>{{ __('Facilitador') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th>{{ __('Opciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-light"></tbody>
                        </table>
                    </div>
                </div>
                <!-- Modal Materia -->
                <div class="modal fade" id="MateriaModal" tabindex="-1" role="dialog"
                    aria-labelledby="MateriaModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p v-if="materia_view == 'create'" class="modal-title mb-0 h6">
                                    {{ __('Agregar Materia') }}</p>
                                <p v-if="materia_view == 'edit'" class="modal-title mb-0 h6">
                                    {{ __('Editar Materia') }}</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <section class="row">
                                    <aside class="col-md-12">
                                        <div class="form-group">
                                            <label class="" for="">Nombre:</label>
                                            <input v-validate="'required'" type="text" v-model="materia.nombre"
                                                name="materia" class="form-control single-input-form"
                                                placeholder="Coloca el nombre de la materia...">
                                            <span class="text-danger" style="font-size: 12px;"
                                                v-show="errors.has('materia')">* @{{ errors.first('materia') }}</span>
                                        </div>
                                    </aside>
                                    <aside class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Facilitador:</label>
                                            <select v-validate="'required'" v-model="materia.facilitador"
                                                name="facilitator" id=""
                                                class="form-control single-input-form">
                                                <option disabled value="">Selecciona facilitador</option>
                                                <option v-for="facilitador in facilitadores" :value="facilitador.id">
                                                    @{{ facilitador.name }}</option>
                                            </select>
                                            <span class="text-danger" style="font-size: 12px;"
                                                v-show="errors.has('facilitator')">* @{{ errors.first('facilitator') }}</span>
                                        </div>
                                    </aside>
                                </section>
                            </div>
                            <div class="modal-footer">
                                <button v-if="materia_view == 'create'" type="button"
                                    @click="validate(agregarMateria)"
                                    class="btn btn-info btn-sm rounded-0">{{ __('Agregar') }}</button>
                                <button v-if="materia_view == 'edit'"  @click="validate(updateMateria)"
                                    class="btn btn-warning btn-sm rounded-0">{{ __('Actualizar') }}</button>
                                <button  class="btn btn-danger btn-sm rounded-0" @click="closeModal()"
                                    data-dismiss="modal">{{ __('Cerrar') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @section('scripts')
    <script type="text/javascript">
        Vue.use(VeeValidate);
        var materias = {!! json_encode($materias) !!}
        var facilitadores = {!! json_encode($facilitadores) !!}
    </script>
    <script type="text/javascript" src="{{ asset('/js/custom/materias.js') }}"></script>
@endsection
</x-app-layout>
