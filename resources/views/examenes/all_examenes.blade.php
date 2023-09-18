<x-app-layout>
    @section('title')
        Exámenes
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exámenes') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="text-right border-bottom pb-3">
                            <a :href="homepath + '/examenes/create'">
                                <button class="btn btn-info">Crear Examen</button>
                            </a>
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
                                    <th>{{ __('Examen') }}</th>
                                    <th>{{ __('Materia') }}</th>
                                    <th>{{ __('Facilitador') }}</th>
                                    <th>{{ __('Disponible') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th>{{ __('Opciones') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-light"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            var examenes = {!! json_encode($examenes) !!}
        </script>
        <script type="text/javascript" src="{{ asset('/js/custom/examenes/examenes.js') }}"></script>
    @endsection
</x-app-layout>
