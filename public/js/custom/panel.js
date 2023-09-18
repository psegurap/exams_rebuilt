var main = new Vue({
    el: 'main',
    data: {
        users: users,
        materias: materias,
        estudiante: {
            nombre: '',
            materia: '',
        },
        current_id: null,
        dt: null,
    },
    mounted: function() {
        var _this = this;
        this.initDataTable();
        setTimeout(function() {
            $('.custom-control-input').on('change', function() {
                var _this_ = _this;
                var coming_values = $(this).attr('info_input').split(',');
                var activo = $(this).prop("checked");

                _this_.updateRole(coming_values[0], coming_values[1], activo)
            });
        }, 1000);
    },
    watch: {
        users: function(val) {
            var _this = this;
            this.dt.clear()
            this.dt.rows.add(val);
            this.dt.draw();

            setTimeout(function() {
                $('.custom-control-input').on('change', function() {
                    var _this_ = _this;
                    var coming_values = $(this).attr('info_input').split(',');
                    var activo = $(this).prop("checked");

                    _this_.updateRole(coming_values[0], coming_values[1], activo)
                });
            }, 100);
        },
        'CurrentEstudiante': function(val) {
            let estudiante = val[0];
            if (estudiante) {
                this.estudiante.nombre = estudiante.name;
                this.estudiante.materia = estudiante.estudiante_materia[0].id;
                // this.materia.facilitador = materia.facilitador_id;
            }
        }
    },
    computed: {
        CurrentEstudiante: function() {
            var _this = this;
            return this.users.filter(function(user) {
                return user.id == _this.current_id;
            })
        }
    },
    methods: {
        closeModal: function() {
            var _this = this
            this.estudiante.nombre = '';
            this.estudiante.materia = '';
            setTimeout(function() {
                _this.errors.clear();
            }, 100);
        },
        updateRole: function(role, id, estado) {
            var _this = this;
            estado = estado ? 1 : 0;
            axios.post(homepath + '/usuarios/update_rol/' + role + '/' + id + '/' + estado).then(
                function(response) {
                    _this.users = response.data;
                }).catch(function(error) {
                console.log(error)
            });
        },
        agregarMateria: function(id) {
            this.current_id = id;
            $('#EstudianteModal').modal('show');
        },
        updateEstudiante: function() {
            var _this = this;
            axios.post(homepath + '/usuarios/update_estudiante/' + this.CurrentEstudiante[0].id + '/' +
                this.estudiante.materia).then(function(response) {
                _this.users = response.data;
                $('#EstudianteModal').modal('hide');
                _this.closeModal();
            }).catch(function(error) {
                console.log(error)
            });
        },
        initDataTable: function() {
            this.dt = $('#table').DataTable({
                data: this.users,
                paging: false,
                // responsive : true,
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        // data : 'status',
                        render: function(data, type, row) {
                            if (row.status == 1) {
                                return "<div class='custom-control custom-switch'><input type='checkbox' info_input='status," +
                                    row.id +
                                    "' class='custom-control-input' id='status" + row
                                    .id +
                                    "' checked><label class='custom-control-label' for='status" +
                                    row.id + "'></label></div>"
                                // return "<div class='d-flex justify-content-around'><div class='text-warning' title='Agregar Materia'><i onclick='main.agregarMateria("+row.id+")' style='cursor:pointer' class='fa fa-plus-circle fa-lg' aria-hidden='true'></i></div><div class='custom-control custom-switch'><input type='checkbox' info_input='status," + row.id + "' class='custom-control-input' id='estado"+ row.id +"' checked><label class='custom-control-label' for='estado"+ row.id +"'></label></div></div>"
                            } else {
                                return "<div class='custom-control custom-switch'><input type='checkbox' info_input='status," +
                                    row.id +
                                    "' class='custom-control-input' id='status" + row
                                    .id +
                                    "'><label class='custom-control-label' for='status" +
                                    row.id + "'></label></div>"
                                // return "<div class='d-flex justify-content-around'><div class='text-light'><i class='fa fa-plus-circle fa-lg' aria-hidden='true'></i></div><div class='custom-control custom-switch'><input type='checkbox' info_input='status," + row.id + "' class='custom-control-input' id='estado"+ row.id +"'><label class='custom-control-label' for='estado"+ row.id +"'></label></div></div>"
                                // return "<div class='custom-control custom-switch'><input type='checkbox' info_input='status," + row.id + "' class='custom-control-input' id='estado"+ row.id +"'><label class='custom-control-label' for='estado"+ row.id +"'></label></div>"
                            }
                        }
                    },
                    {
                        // data : 'estudiante',
                        render: function(data, type, row) {
                            if (row.estudiante == 1) {
                                return "<div class='d-flex justify-content-center'><div class='custom-control custom-switch'><input type='checkbox' info_input='estudiante," +
                                    row.id +
                                    "' class='custom-control-input' id='estudiante" +
                                    row.id +
                                    "' checked><label class='custom-control-label' for='estudiante" +
                                    row.id +
                                    "'></label></div><div class='text-warning' title='Agregar Materia'><i onclick='main.agregarMateria(" +
                                    row.id +
                                    ")' style='cursor:pointer' class='fa fa-plus-circle fa-lg' aria-hidden='true'></i></div></div>"
                            } else {
                                return "<div class='d-flex justify-content-center'><div class='custom-control custom-switch'><input type='checkbox' info_input='estudiante," +
                                    row.id +
                                    "' class='custom-control-input' id='estudiante" +
                                    row.id +
                                    "'><label class='custom-control-label' for='estudiante" +
                                    row.id +
                                    "'></label></div><div class='text-light'><i class='fa fa-plus-circle fa-lg' aria-hidden='true'></i></div></div>"
                            }
                        }
                    },
                    {
                        // data : 'facilitador',
                        render: function(data, type, row) {
                            if (row.facilitador == 1) {
                                return "<div class='custom-control custom-switch'><input type='checkbox' info_input='facilitador," +
                                    row.id +
                                    "' class='custom-control-input' id='facilitador" +
                                    row.id +
                                    "' checked><label class='custom-control-label' for='facilitador" +
                                    row.id + "'></label></div>"
                            } else {
                                return "<div class='custom-control custom-switch'><input type='checkbox' info_input='facilitador," +
                                    row.id +
                                    "' class='custom-control-input' id='facilitador" +
                                    row.id +
                                    "'><label class='custom-control-label' for='facilitador" +
                                    row.id + "'></label></div>"
                            }
                        }
                    },
                    {
                        // data : 'administrador',
                        render: function(data, type, row) {
                            if (row.administrador == 1) {
                                return "<div class='custom-control custom-switch'><input type='checkbox' info_input='administrador," +
                                    row.id +
                                    "' class='custom-control-input' id='administrador" +
                                    row.id +
                                    "' checked><label class='custom-control-label' for='administrador" +
                                    row.id + "'></label></div>"
                            } else {
                                return "<div class='custom-control custom-switch'><input type='checkbox' info_input='administrador," +
                                    row.id +
                                    "' class='custom-control-input' id='administrador" +
                                    row.id +
                                    "'><label class='custom-control-label' for='administrador" +
                                    row.id + "'></label></div>"
                            }
                        }
                    },
                ]
            });
        },
        validate: function(callback) {
            var _this = this;
            this.$validator.validateAll().then(function(result) {
                if (result) {
                    callback();
                } else {
                    $.toast({
                        heading: 'Error',
                        text: "{{ __('Necesitas corregir los errores') }}",
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right'
                    })
                }
            })
        }
    }
});
