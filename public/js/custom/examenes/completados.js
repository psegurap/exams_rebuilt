var main = new Vue({
    el: 'main',
    data: {
        examenes: examenes,
    },
    mounted: function() {
        var _this = this;
        this.initDataTable();
        setTimeout(function() {
            $('.custom-control-input').on('change', function() {
                var _this_ = _this;
                var coming_values = $(this).attr('info_input').split(',');
                var activo = $(this).prop("checked");

                _this_.updateCampo(coming_values[0], coming_values[1], activo)
            });
        }, 1000);
    },
    methods: {
        updateCampo: function(campo, id, estado) {
            estado = estado ? 1 : 0;

            axios.post(homepath + '/examenes/completados/update_campo/' + campo + '/' + id + '/' +
                estado).then(function(response) {}).catch(function(error) {
                console.log(error)
            });
        },
        readExam: function(id) {
            window.open(homepath + '/examenes/completado/' + id, '_blank');
        },
        calificarExam: function(id) {
            window.location.href = homepath + "/examenes/completado/calificar/" + id;
            console.log(id);
        },
        initDataTable: function() {
            this.dt = $('#table').DataTable({
                data: this.examenes,
                // responsive : true,
                columns: [{
                        data: 'examen.materia_info.materia'
                    },
                    {
                        data: 'examen.materia_info.facilitador.name'
                    },
                    {
                        data: 'user.name'
                    },
                    {
                        data: 'calificacion_final',
                        render: function(data, row) {
                            if (data == null) {
                                return '<p class="bg-danger btn btn-sm text-white btn-section d-inline-block mb-1 px-2 text-center">No Calificado</p>';
                            } else {
                                return "<p class='bg-success btn btn-sm text-white btn-section d-inline-block mb-1 px-2 text-center'>" +
                                    data + "</p>";
                            }
                        }
                    },
                    {
                        // data: 'status',
                        render: function(data, type, row) {
                            if (row.status == 1) {
                                return "<div class='custom-control custom-switch'><input type='checkbox' info_input='status," +
                                    row.id +
                                    "' class='custom-control-input' id='estado" + row
                                    .id +
                                    "' checked><label class='custom-control-label' for='estado" +
                                    row.id + "'></label></div>"
                            } else {
                                return "<div class='custom-control custom-switch'><input type='checkbox' info_input='status," +
                                    row.id +
                                    "' class='custom-control-input' id='estado" + row
                                    .id +
                                    "'><label class='custom-control-label' for='estado" +
                                    row.id + "'></label></div>"
                            }
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, row) {
                            return "<div class='d-flex justify-content-around'><div class='text-warning' title='Calificar Examen' style='font-size: 1.5em';><i onclick='main.calificarExam(" +
                                data +
                                ")' style='cursor:pointer' class='fa fa-pencil' aria-hidden='true'></i></div><div class='text-info' title='Ver Respuestas' style='font-size: 1.5em;'><i onclick='main.readExam(" +
                                data +
                                ")' style='cursor:pointer' class='fa fa-eye' aria-hidden='true'></i></div></div>"
                        }
                    }

                ]
            });
        },
    }
});
