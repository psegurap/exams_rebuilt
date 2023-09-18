<x-app-layout>
    @section('title')
        Inicio
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inicio') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="row">
                    <div v-if="exams.length > 0 && user.facilitador != 1" v-for="(exam, index) in exams"
                        class="col-md-6 mt-2">
                        <div class="test-records rounded-sm">
                            <div class="row">
                                <div class="col-lg-7 text-info">
                                    <p class="mb-1 text-capitalize">@{{ exam.materia_info.materia }}</p>
                                    <p class="mb-1 text-dark"><span class="text-info">Facilitador:</span>
                                        @{{ exam.materia_info.facilitador.name }}
                                    </p>
                                </div>
                                <div class="col-lg-5 text-right">
                                    <p v-if="exam.disponible == 0"
                                        class="bg-danger btn btn-sm text-white btn-section d-inline-block mb-1 px-2 rounded-0 text-center">
                                        No Disponible</p>
                                    <a v-else-if="exam.disponible == 1 && exam.examenes_completados.length == 0"
                                        :href="homepath + '/examenes/llenar/' + exam.id">
                                        <p
                                            class="bg-success btn btn-sm text-white btn-section d-inline-block mb-1 px-2 rounded-0 text-center">
                                            <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> Disponible
                                        </p>
                                    </a>
                                    <a v-else-if="exam.examenes_completados.length > 0 && exam.examenes_completados[0].calificacion_final == null"
                                        target="_blank"
                                        :href="homepath + '/examenes/completado/' + exam.examenes_completados[0].id">
                                        <p
                                            class="bg-warning btn btn-sm text-white btn-section d-inline-block mb-1 px-2 rounded-0 text-center">
                                            <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> Completado
                                        </p>
                                    </a>
                                    <a v-else-if="exam.examenes_completados.length > 0 && exam.examenes_completados[0].calificacion_final != null"
                                        target="_blank"
                                        :href="homepath + '/examenes/completado/' + exam.examenes_completados[0].id">
                                        <p
                                            class="bg-info btn btn-sm text-white btn-section d-inline-block mb-1 px-2 rounded-0 text-center">
                                            <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> Calificado
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="exams.length == 0 && user.estudiante_materia.length > 0" class="col-md-6 mt-2">
                        <div class="test-records rounded-sm">
                            <div class="row">
                                <div class="col-lg-7 text-info">
                                    <p class="mb-1 text-capitalize">@{{ user.estudiante_materia[0].materia }}</p>
                                    <p class="mb-1 text-dark"><span class="text-info">Facilitador:</span>
                                        @{{ user.estudiante_materia[0].facilitador.name }}
                                    </p>
                                </div>
                                <div class="col-lg-5 text-right">
                                    <p
                                        class="bg-danger btn btn-sm text-white btn-section d-inline-block mb-1 px-2 rounded-0 text-center">
                                        No Disponible</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4">
            <div class="overflow-hidden">
                <div v-if="user.facilitador == 1 && estudiantes.length > 0" class="row">
                    <div class="col-md-12 mb-2">
                        <div class="header-pages text-white text-uppercase rounded-top">Estudiantes</div>
                    </div>
                    <div v-for="estudiante in estudiantes[0].estudiante_materia" class="col-md-6 mt-2">
                        <div class="test-records rounded">
                            <div class="row">
                                <div class="col-lg-12 text-info">
                                    <div class="d-flex flex-column flex-md-row justify-content-between">
                                        <div>
                                            <p
                                                class="bg-info btn btn-section rounded-0 text-white waves-effect waves-light mb-1 mr-1">
                                                Estudiante:</p> <span
                                                class="bg-dark btn btn-section rounded-0 text-white waves-effect waves-light mb-1">@{{ estudiante.name }}</span>
                                        </div>
                                        <div v-if="estudiante.examen_completado != null">
                                            <a title="CALIFICAR" class="btn btn-outline-warning btn-section"
                                                :href="homepath + '/examenes/completado/calificar/' + estudiante
                                                    .examen_completado.id">
                                                <i class='fa fa-pencil fa-lg'></i>
                                            </a>
                                            <a title="VISUALIZAR" class="btn btn-outline-primary btn-section"
                                                :href="homepath + '/examenes/completado/' + estudiante.examen_completado.id">
                                                <i class='fa fa-eye fa-lg'></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="text-right mt-2">
                                        <p
                                            class="bg-info btn btn-section rounded-0 text-white waves-effect waves-light mb-1">
                                            Estado Exanen:</p>
                                        <span
                                            v-if="estudiante.examen_completado != null && estudiante.examen_completado.calificacion_final != null"
                                            class="ml-1 bg-warning btn btn-section rounded-0 text-white waves-effect waves-light mb-1">Calificado</span>
                                        <span v-else-if="estudiante.examen_completado != null"
                                            class="ml-1 bg-success btn btn-section rounded-0 text-white waves-effect waves-light mb-1">Completado</span>
                                        <span v-else
                                            class="ml-1 bg-danger btn btn-section rounded-0 text-white waves-effect waves-light mb-1">No
                                            Completado</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script type="text/javascript">
            var exams = {!! json_encode($exams) !!}
            var user = {!! json_encode($user) !!}
            var estudiantes = {!! json_encode($estudiantes) !!}
        </script>
        <script type="text/javascript" src="{{asset('/js/custom/index.js')}}"></script>
    @endsection
</x-app-layout>
