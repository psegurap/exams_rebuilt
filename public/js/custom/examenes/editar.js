function Tema(id, nombre, tipo, table_id){
    this.id = id;
    this.nombre = nombre;
    this.tipo = tipo;
    this.preguntas = [];
    this.table_id = table_id;
}

function Pregunta(id, pregunta, opciones){
    this.id = id;
    this.pregunta = pregunta;
    this.opciones = opciones;
}


var main = new Vue({
    el : 'main',
    data: {
        materias : materias,
        template_info : {
            id : null,
            nombre : '',
            materia : '',
            descripcion : '',
            temas : [],
        },
        tema : {
            nombre : '',
            tipo : '',
        },
        pregunta : {
            pregunta : '',
            opciones : [],
        },
        current_tema : null,
        tema_view : 'create',
        pregunta_view : 'create',
        current_modal: '',
        adding_option : '',
        current_pregunta : null,
        preguntas : [],
    },
    mounted: function(){
        var _this = this;
        this.template_info.id = examen.id;
        this.template_info.nombre = examen.nombre;
        this.template_info.materia = examen.materia;
        this.template_info.descripcion = examen.descripcion;
        this.template_info.temas = examen.temas.map(function(tema){
            preguntas = tema.preguntas;
            tema = new Tema((_this.randomString() + new Date().getTime()), tema.nombre, tema.tipo_pregunta, tema.id);

            var _this_ = _this;

            tema.preguntas = preguntas.map(function(pregunta){
                if(pregunta.select_options == null){
                    pregunta.select_options = [];
                }
                pregunta = new Pregunta((_this_.randomString() + new Date().getTime()), pregunta.pregunta, pregunta.select_options);
                return pregunta;
            })

            return tema;
        })
    },
    computed : {
        CurrentTema: function(){
            var _this = this;
            this.preguntas = [];
            return this.template_info.temas.filter(function(tema){
                _this_ = _this;
                tema.preguntas.forEach(function(pregunta){
                    _this.preguntas.push(pregunta)
                });
                return tema.id == _this.current_tema;
            });
        },
        CurrentPregunta: function(){
            var _this = this;
            return this.preguntas.filter(function(pregunta){
                return pregunta.id == _this.current_pregunta;
            });
        },
    },
    watch : {

    },
    methods: {
        randomString: function(){
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < 10; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        },
        openModal: function(modal, type, current_modal){
            this.tema_view = type;
            this.pregunta_view = type;
            this.current_modal = current_modal;
            setTimeout(function(){
                $("#" + modal).modal('show');
            }, 100);
        },
        closeModal: function(){
            var _this = this
            this.tema.nombre = '';
            this.tema.tipo = '';
            this.pregunta.pregunta = '';
            this.pregunta.opciones = [];
            setTimeout(function() {
                _this.errors.clear();
            }, 100);
        },
        agregarTema: function(){
            var _this = this;
            let tema = new Tema((this.randomString() + new Date().getTime()), this.tema.nombre, this.tema.tipo);
            this.template_info.temas.push(tema);
            $('#TemaModal').modal('hide');
            this.tema.nombre = '';
            this.tema.tipo = '';
            setTimeout(function() {
                _this.errors.clear();
            }, 100);
        },
        chooseTema: function(id){
            this.current_tema = id;
        },
        editTema: function(){
            this.tema.nombre = this.CurrentTema[0].nombre;
            this.tema.tipo = this.CurrentTema[0].tipo;
            this.openModal('TemaModal', 'edit', 'tema');
        },
        deleteTema: function(){
            for (let index = 0; index < this.template_info.temas.length; index++) {
                if (this.template_info.temas[index].id == this.CurrentTema[0].id) {
                    this.template_info.temas.splice(index, 1);
                    this.CurrentTema = [];
                    break;
                }
            }
        },
        updateTema: function(){
            var _this = this;
            for (let index = 0; index < this.template_info.temas.length; index++) {
                if (this.template_info.temas[index].id == this.CurrentTema[0].id) {
                    this.template_info.temas[index].nombre = this.tema.nombre;
                    this.template_info.temas[index].tipo = this.tema.tipo;
                }
            }

            $('#TemaModal').modal('hide');
            this.tema.nombre = '';
            this.tema.tipo = '';
            setTimeout(function() {
                _this.errors.clear();
            }, 100);
        },
        agregarPregunta: function(){
            var _this = this;
            let pregunta = new Pregunta((this.randomString() + new Date().getTime()), this.pregunta.pregunta, this.pregunta.opciones);
            for (let index = 0; index < this.template_info.temas.length; index++) {
                if (this.template_info.temas[index].id == this.CurrentTema[0].id) {
                    this.template_info.temas[index].preguntas.push(pregunta);
                }
            }

            $('#PreguntaModal').modal('hide');
            this.pregunta.pregunta = '';
            this.pregunta.opciones = [];
            setTimeout(function() {
                _this.errors.clear();
            }, 100);
        },
        agregarOpcion: function(){
            this.pregunta.opciones.push(this.adding_option);
            this.adding_option = ''
        },
        removerOpcion: function(opcion){
            let index = this.pregunta.opciones.indexOf(opcion);
            this.pregunta.opciones.splice(index, 1);
        },
        editarPregunta: function(id){
            this.current_pregunta = id;
            this.pregunta.pregunta = this.CurrentPregunta[0].pregunta;
            this.pregunta.opciones = this.CurrentPregunta[0].opciones;
            this.openModal('PreguntaModal', 'edit', 'pregunta');
        },
        updatePregunta: function(){
            var _this = this;
            for (let index = 0; index < this.template_info.temas.length; index++) {
                if (this.template_info.temas[index].id == this.CurrentTema[0].id) {
                    for (let ind = 0; ind < this.template_info.temas[index].preguntas.length; ind++) {
                        if (this.template_info.temas[index].preguntas[ind].id == this.CurrentPregunta[0].id) {
                            this.template_info.temas[index].preguntas[ind].pregunta = this.pregunta.pregunta;
                            this.template_info.temas[index].preguntas[ind].opciones = this.pregunta.opciones;
                        }
                    }
                }
            }

            $('#PreguntaModal').modal('hide');
            this.pregunta.pregunta = '';
            this.pregunta.opciones = [];
            setTimeout(function() {
                _this.errors.clear();
            }, 100);
        },
        eliminarPregunta: function(id){
            this.current_pregunta = id;
            for (let index = 0; index < this.template_info.temas.length; index++) {
                if (this.template_info.temas[index].id == this.CurrentTema[0].id) {
                    for (let ind = 0; ind < this.template_info.temas[index].preguntas.length; ind++) {
                        if (this.template_info.temas[index].preguntas[ind].id == this.CurrentPregunta[0].id) {
                            this.template_info.temas[index].preguntas.splice(ind, 1);
                            break;
                        }
                    }
                }
            }
        },
        actuaizarExamen: function(){
            var _this = this;
            swal({
                title: "¿Estas seguro?",
                text: "¡Esta acción eliminará toda informacion asociada a la estructura anterior!",
                // icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
                dangerMode: true,
            })
            .then(function(willDelete){
                var _this_ = _this;
                if (willDelete) {
                    $(".cancel_saving_button").LoadingOverlay("show");
                    axios.post(homepath + '/examenes/save_edit/' + _this.template_info.id, {template: _this.template_info, temas : _this.template_info.temas}).then(function(response){
                        $(".cancel_saving_button").LoadingOverlay("hide");
                        swal({
                            text: "¡El examen ha sido actualizado!",
                            icon: "success",
                        }).then(function(){
                            window.location.reload();
                        });
                    }).catch(function(error){
                        console.log(error)
                    });
                }
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
                    text: 'Necesitas corregir los errores',
                    showHideTransition: 'fade',
                    icon: 'error',
                    position : 'top-right'
                    })
                }
            })
        }
    }
});
