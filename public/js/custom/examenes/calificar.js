function Tema(id, nombre, tipo, preguntas){
    this.id = id;
    this.nombre = nombre;
    this.tipo = tipo;
    this.preguntas = preguntas;
}

function Pregunta(id, pregunta, opciones, respuesta, calificacion){
    this.id = id;
    this.pregunta = pregunta;
    this.opciones = opciones;
    this.respuesta = respuesta;
    this.calificacion = calificacion;
}

var main = new Vue({
    el : 'main',
    data: {
        examen_completado : examen_completado,
        current_examen : null,
        examen : {
            id: examen_completado.id,
            calificacion : examen_completado.calificacion_final,
            notas : examen_completado.notas,
        },
        current_tema : null,
        current_pregunta : null,
    },
    mounted: function(){
        var _this = this;
        this.examen_completado.created_at = moment(examen_completado.created_at).format('DD-MM-YYYY');

        setTimeout(function(){
            $(document).ready(function () {
                $("#calificacion").keypress(function (e) {
                    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                            return false;
                    }
                });
            });
        }, 100);

        this.examen_completado.examen.temas = this.examen_completado.examen.temas.map(function(tema){
            tema.preguntas = tema.preguntas.map(function(pregunta){
                pregunta = new Pregunta(pregunta.id, pregunta.pregunta, pregunta.select_options, pregunta.respuesta.respuesta, pregunta.respuesta.respuesta_calificacion);
                return pregunta;
            });
            return tema;
        })

        setTimeout(function(){
            $(".custom-control-input").on('change', function (val) {
                var _this_ = _this;
                var coming_values = $(this).attr('pregunta_info').split(",");
                _this_.updatePregunta(coming_values[0], coming_values[1], coming_values[2]);
            });
        }, 1000);
    },
    computed : {
        CurrentTema: function(){
            var _this = this;
            return this.template_info.temas.filter(function(tema){
                _this.preguntas = tema.preguntas;
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
        updatePregunta: function(tema_id, pregunta_id, calificacion){
            var _this = this;
            for (let index = 0; index < this.examen_completado.examen.temas.length; index++) {
                if (this.examen_completado.examen.temas[index].id == tema_id) {
                    for (let ind = 0; ind < this.examen_completado.examen.temas[index].preguntas.length; ind++) {
                        if (this.examen_completado.examen.temas[index].preguntas[ind].id == pregunta_id) {
                            this.examen_completado.examen.temas[index].preguntas[ind].calificacion = calificacion;
                        }
                    }
                }
            }
        },
        validarCalificadas: function(){
            var completado = true;
            for (let index = 0; index < this.examen_completado.examen.temas.length; index++) {
                for (let ind = 0; ind < this.examen_completado.examen.temas[index].preguntas.length; ind++) {
                    if (this.examen_completado.examen.temas[index].preguntas[ind].calificacion === '' || this.examen_completado.examen.temas[index].preguntas[ind].calificacion == null) {
                        completado = false;
                        break;
                    }
                }
            }
            console.log(completado)
            if(completado){
                this.guardarRespuestas();
            }else{
                $.toast({
                    heading: 'Error',
                    text: 'Aun tienes preguntas sin calificar',
                    showHideTransition: 'fade',
                    icon: 'error',
                    position : 'top-right'
                })
            }
        },
        guardarRespuestas: function(){
            var _this = this;
            $(".cancel_saving_button").LoadingOverlay("show");
            axios.post(homepath + '/examenes/store/calificacion', {examen: this.examen, temas : this.examen_completado.examen.temas}).then(function(response){
                $(".cancel_saving_button").LoadingOverlay("hide");
                swal({
                    text: "¡La calificación fue guardada!",
                    icon: "success",
                }).then(function(){
                    window.location.href = homepath + "/examenes/completados";
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
                    text: 'You need to fix the errors',
                    showHideTransition: 'fade',
                    icon: 'error',
                    position : 'top-right'
                    })
                }
            })
        }
    }
});
