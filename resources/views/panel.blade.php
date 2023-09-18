<x-app-layout>
    @section('title')
        Panel de usuarios
    @endsection
    @section('styles')
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de usuarios') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="text-right border-bottom pb-3">
                            <a href="/register">
                                <button class="btn btn-info">Registrar Usuario</button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="table" class="table table-bordered table-hover table-sm text-center table-responsive-sm"
                            style="width:100%">
                            <thead class="table-header bg-info text-white">
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Nombre') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th>{{ __('Estudiante') }}</th>
                                    <th>{{ __('Facilitador') }}</th>
                                    <th>{{ __('Administrador') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-light"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Materia -->
    <div class="modal fade" id="EstudianteModal" tabindex="-1" role="dialog" aria-labelledby="MateriaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title mb-0 h6">{{ __('Editar Estudiante') }}</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section class="row">
                        <aside class="col-md-12">
                            <div class="form-group">
                                <label class="" for="">Nombre:</label>
                                <input v-validate="'required'" type="text" v-model="estudiante.nombre" name="name"
                                    class="form-control single-input-form"
                                    placeholder="Coloca el nombre de la materia...">
                                <span class="text-danger" style="font-size: 12px;" v-show="errors.has('name')">*
                                    @{{ errors.first('name') }}</span>
                            </div>
                        </aside>
                        <aside class="col-md-12">
                            <div class="form-group">
                                <label for="">Materia:</label>
                                <select v-validate="'required'" v-model="estudiante.materia" name="subject"
                                    id="" class="form-control single-input-form">
                                    <option disabled value="">Selecciona materia</option>
                                    <option v-for="materia in materias" :value="materia.id">@{{ materia.materia }}
                                    </option>
                                </select>
                                <span class="text-danger" style="font-size: 12px;" v-show="errors.has('subject')">*
                                    @{{ errors.first('subject') }}</span>
                            </div>
                        </aside>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="validate(updateEstudiante)"
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
            var users = {!! json_encode($users) !!}
            var materias = {!! json_encode($materias) !!}
        </script>
        <script type="text/javascript" src="{{asset('/js/custom/panel.js')}}"></script>
    @endsection
</x-app-layout>
