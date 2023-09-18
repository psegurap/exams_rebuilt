var main = new Vue({
    el: 'main',
    data: {
        materias : materias,
        facilitadores : facilitadores,
        materia: {
            nombre : '',
            facilitador : '',
        },
        materia_view: 'create',
        current_materia : null,
    },
    mounted: function(){
        var _this = this;
        this.initDataTable();
        setTimeout(function(){
            $('.custom-control-input').on('change', function(){
                var _this_ = _this;
                var coming_values = $(this).attr('info_input').split(',');
                var activo = $(this).prop("checked");

                _this_.updateCampo(coming_values[0], coming_values[1], activo)
            });
        }, 1000);
    },
    watch: {
        materias : function(val){
            this.dt.clear()
            this.dt.rows.add(val);
            this.dt.draw();
        },
        'CurrentMateria': function(val){
            let materia = val[0];
            if(materia){
                this.materia.nombre = materia.materia;
                this.materia.facilitador = materia.facilitador_id;
            }
        }
    },
    computed: {
        CurrentMateria: function(){
            var _this = this;
            return this.materias.filter(function(materia){
                return materia.id == _this.current_materia;
            })
        }
    },
    methods: {
        openModal: function(modal, type){
            this.materia_view = type;
            this.pregunta_view = type;
            setTimeout(function(){
                $("#" + modal).modal('show');
            }, 100);
        },
        closeModal: function(){
            var _this = this
            this.materia.nombre = '';
            this.materia.facilitador = '';
            setTimeout(function() {
                _this.errors.clear();
            }, 100);
        },
        updateCampo: function(campo, id, estado){
            estado = estado ? 1 : 0;

            axios.post(homepath + '/materias/update_campo/' + campo + '/' + id + '/' + estado).then(function(response){

            }).catch(function(error){
                console.log(error)
            });
        },
        agregarMateria: function(){
            $(".modal-content").LoadingOverlay("show");
            var _this = this;
            axios.post(homepath + '/materias/store', {materia : this.materia}).then(function(response){
                _this.materias = response.data;
                _this.materia.nombre = '';
                _this.materia.facilitador = '';
                setTimeout(function() {
                    _this.errors.clear();
                }, 100);
                $(".modal-content").LoadingOverlay("hide");
                $('#MateriaModal').modal('hide');
            }).catch(function(error){
                console.log(error)
            });
        },
        editMateria: function(id){
            this.current_materia = id;
            this.openModal('MateriaModal', 'edit');
        },
        updateMateria: function(){
            $(".modal-content").LoadingOverlay("show");
            var _this = this;
            axios.post(homepath + '/materias/update/' + this.current_materia, {materia : this.materia}).then(function(response){
                _this.materias = response.data;
                _this.materia.nombre = '';
                _this.materia.facilitador = '';
                setTimeout(function() {
                    _this.errors.clear();
                }, 100);
                $(".modal-content").LoadingOverlay("hide");
                $('#MateriaModal').modal('hide');
            }).catch(function(error){
                console.log(error)
            });
        },
        deleteMateria: function(id){
            var _this = this;
            swal({
                title: "¿Estas seguro?",
                text: "¡Esta materia va a ser eliminada!",
                // icon: "warning",
                cancelButtonText : 'Cancelar',
                buttons: ["Cancelar", "Aceptar"],
                dangerMode: true,
            })
            .then(function(willDelete){
                var _this_ = _this;
                if (willDelete) {
                    axios.post(homepath + '/materias/delete/' + id).then(function(response){
                        _this_.materias = response.data;
                    }).catch(function(error){
                        console.log(error)
                    });
                }
            });
        },
        initDataTable: function(){
            this.dt = $('#table').DataTable({
                data : this.materias,
                // responsive : true,
                columns: [
                    {data : 'id'},
                    {data : 'materia'},
                    {data : 'facilitador.name'},
                    {
                        // data: 'status',
                        render: function(data, type, row){
                            if(row.status == 1){
                                return "<div class='custom-control custom-switch'><input type='checkbox' info_input='status," + row.id + "' class='custom-control-input' id='estado"+ row.id +"' checked><label class='custom-control-label' for='estado"+ row.id +"'></label></div>"
                            }else{
                                return "<div class='custom-control custom-switch'><input type='checkbox' info_input='status," + row.id + "' class='custom-control-input' id='estado"+ row.id +"'><label class='custom-control-label' for='estado"+ row.id +"'></label></div>"
                            }
                        }
                    },
                    {
                        data : 'id',
                        render: function(data, row){
                            return "<div class='d-flex justify-content-around'><div class='text-info' style='font-size: 1.5em;'><i onclick='main.editMateria("+data+")' style='cursor:pointer' class='fa fa-pencil-square-o' aria-hidden='true'></i></div><div class='text-danger' style='font-size: 1.5em';><i onclick='main.deleteMateria("+data+")' style='cursor:pointer' class='fa fa-trash' aria-hidden='true'></i></div></div>"
                        }
                    }

                ]
            });
        },
        validate: function(callback){
            var _this = this;
            this.$validator.validateAll().then(function(result){
                if(result){
                    callback();
                }else{
                    $.toast({
                    heading: 'Error',
                    text: "Necesitas corregir los errores",
                    showHideTransition: 'fade',
                    icon: 'error',
                    position : 'top-right'
                    })
                }
            })
        }
    }
});

