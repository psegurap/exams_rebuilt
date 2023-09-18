var main = new Vue({
    el: 'main',
    data: {
        examenes : examenes,
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
        examenes : function(val){
            this.dt.clear()
            this.dt.rows.add(val);
            this.dt.draw();
        },
    },
    methods: {
        updateCampo: function(campo, id, estado){
            estado = estado ? 1 : 0;

            axios.post(homepath + '/examenes/update_campo/' + campo + '/' + id + '/' + estado).then(function(response){

            }).catch(function(error){
                console.log(error)
            });
        },
        editTemplate: function(id){
            var _this = this;
            swal({
                title: "¿Estas seguro?",
                text: "¡Todo cambio a los examenes no es recomendado!",
                // icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
                dangerMode: true,
            })
            .then(function(willDelete){
                var _this_ = _this;
                if (willDelete) {
                    window.location.href = homepath + "/examenes/editar/" + id;
                }
            });
        },
        deleteTemplate: function(id){
            var _this = this;
            swal({
                title: "¿Estas seguro?",
                text: "¡Esta acción eliminará toda informacion asociada al examen!",
                // icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
                dangerMode: true,
            })
            .then(function(willDelete){
                var _this_ = _this;
                if (willDelete) {
                    axios.post(homepath + '/examenes/delete/' + id).then(function(response){
                        _this_.examenes = response.data;
                    }).catch(function(error){
                        console.log(error)
                    });
                }
            });
        },
        initDataTable: function(){
            this.dt = $('#table').DataTable({
                data : this.examenes,
                // responsive : true,
                columns: [
                    {data : 'nombre'},
                    {data : 'materia_info.materia'},
                    {data : 'materia_info.facilitador.name'},
                    {
                        // data : 'disponible',
                        render: function(data, type, row){
                            if(row.disponible == 1){
                                return "<div class='custom-control custom-switch'><input type='checkbox' info_input='disponible," + row.id + "' class='custom-control-input' id='disponible"+ row.id +"' checked><label class='custom-control-label' for='disponible"+ row.id +"'></label></div>"
                            }else{
                                return "<div class='custom-control custom-switch'><input type='checkbox' info_input='disponible," + row.id + "' class='custom-control-input' id='disponible"+ row.id +"'><label class='custom-control-label' for='disponible"+ row.id +"'></label></div>"
                            }
                        }
                    },
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
                            return "<div class='d-flex justify-content-around'><div class='text-info' style='font-size: 1.5em;'><i onclick='main.editTemplate("+data+")' style='cursor:pointer' class='fa fa-pencil-square-o' aria-hidden='true'></i></div><div class='text-danger' style='font-size: 1.5em';><i onclick='main.deleteTemplate("+data+")' style='cursor:pointer' class='fa fa-trash' aria-hidden='true'></i></div></div>"
                        }
                    }

                ]
            });
        },
    }
});
