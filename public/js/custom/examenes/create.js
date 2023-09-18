function Tema(id, nombre, tipo){
    this.id = id;
    this.nombre = nombre;
    this.tipo = tipo;
    this.preguntas = [];
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
            var _this = this;
            swal({
                title: "¿Estas seguro?",
                text: "¡Esta materia va a ser eliminada!",
                // icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
                dangerMode: true,
            })
            .then(function(willDelete){
                var _this_ = _this;
                if (willDelete) {
                    for (let index = 0; index < _this.template_info.temas.length; index++) {
                        if (_this.template_info.temas[index].id == _this.CurrentTema[0].id) {
                            _this.template_info.temas.splice(index, 1);
                            _this.CurrentTema = [];
                            break;
                        }
                    }
                }
            });

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
            var _this = this;
            this.current_pregunta = id;
            swal({
                title: "¿Estas seguro?",
                text: "¡Esta pregunta va a ser eliminada!",
                // icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
                dangerMode: true,
            })
            .then(function(willDelete){
                var _this_ = _this;
                if (willDelete) {
                    for (let index = 0; index < _this.template_info.temas.length; index++) {
                        if (_this.template_info.temas[index].id == _this.CurrentTema[0].id) {
                            for (let ind = 0; ind < _this.template_info.temas[index].preguntas.length; ind++) {
                                if (_this.template_info.temas[index].preguntas[ind].id == _this.CurrentPregunta[0].id) {
                                    _this.template_info.temas[index].preguntas.splice(ind, 1);
                                    break;
                                }
                            }
                        }
                    }
                }
            });

        },
        guardarExamen: function(){
            var _this = this;
            $(".cancel_saving_button").LoadingOverlay("show");
            axios.post(homepath + '/examenes/store', {template: this.template_info, temas : this.template_info.temas}).then(function(response){
                $(".cancel_saving_button").LoadingOverlay("hide");
                swal({
                    text: "¡El examen ha sido creado!",
                    icon: "success",
                }).then(function(){
                    window.location.href = homepath + '/examenes';
                });
            }).catch(function(error){
                console.log(error)
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
