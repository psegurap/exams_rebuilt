function Tema(id, nombre, tipo, preguntas) {
    this.id = id;
    this.nombre = nombre;
    this.tipo = tipo;
    this.preguntas = preguntas;
}

function Pregunta(id, pregunta, opciones) {
    this.id = id;
    this.pregunta = pregunta;
    this.opciones = opciones;
    this.respuesta = ''
}

var main = new Vue({
    el: 'main',
    data: {
        examen: examen,
        completado: completado,
        current_examen: null,
        examen_info: {
            estudiante: 'et dolorem qui',
            facilitador: 'architecto itaque cupiditate',
            fecha: 'illo laboriosam dolorem',
            descripcion: 'quo ipsum laborum Maxime ex quia sit provident voluptatibus recusandae dolor eligendi sint. Impedit autem eos optio. Omnis ratione velit quia voluptatem. Aperiam corporis et est ab doloremque facere asperiores et saepe. Odio deserunt et. Optio voluptate ullam nobis iusto rerum aliquid odit.',
        },
        current_tema: null,
        current_pregunta: null,
        date: null,
        alert_type: null,
    },
    mounted: function() {

        if (this.completado.length > 0 || this.examen.disponible == 0) {
            if (this.completado.length > 0) {
                this.alert_type = 'completado';
            } else {
                this.alert_type = 'disponible';
            }
            $('#AlertModal').modal('show')
        }

        if (window.innerWidth > 500) {
            $('#sidebar').toggleClass('active');
        }

        this.date = moment().format('DD-MM-YYYY');

        this.current_examen = this.examen.temas.map(function(tema) {
            tema = new Tema(tema.id, tema.nombre, tema.tipo_pregunta, tema.preguntas);
            tema.preguntas = tema.preguntas.map(function(pregunta) {
                pregunta = new Pregunta(pregunta.id, pregunta.pregunta, pregunta
                    .select_options);
                return pregunta;
            });
            return tema;
        })

        var _this = this;
        setTimeout(function() {
            $(".custom-control-input").on('change', function(val) {
                var _this_ = _this;
                var coming_values = $(this).attr('pregunta_info').split(",");
                _this_.updatePregunta(coming_values[0], coming_values[1], coming_values[
                    2]);
            });

            $(".single-input-form").on('change', function(val) {
                var _this_ = _this;
                var coming_values = $(this).attr('pregunta_info').split(",");
                _this_.updatePregunta(coming_values[0], coming_values[1], $(this)
            .val());
            });

            $(".single-area-form").on('change', function(val) {
                var _this_ = _this;
                var coming_values = $(this).attr('pregunta_info').split(",");
                _this_.updatePregunta(coming_values[0], coming_values[1], $(this)
            .val());
            });

        }, 1000);

        var timer_date;
        if (window.localStorage.getItem('timer_date')) {
            timer_date = window.localStorage.getItem('timer_date');
        } else {
            window.localStorage.setItem('timer_date', moment(new Date()).add(10, 'm').format(
                'YYYY/MM/DD HH:mm:ss'));
            timer_date = window.localStorage.getItem('timer_date');
        }

        setTimeout(function() {
            $('#timer').countdown(timer_date, function(event) {
                $(this).html(event.strftime('%M:%S'));
            }).on('finish.countdown', function() {
                _this.alert_type = 'unavailable';
                $('#AlertModal').modal('show')
            });
        }, 500);
    },
    computed: {
        CurrentTema: function() {
            var _this = this;
            return this.template_info.temas.filter(function(tema) {
                _this.preguntas = tema.preguntas;
                return tema.id == _this.current_tema;
            });
        },
        CurrentPregunta: function() {
            var _this = this;
            return this.preguntas.filter(function(pregunta) {
                return pregunta.id == _this.current_pregunta;
            });
        },
    },
    watch: {

    },
    methods: {
        randomString: function() {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < 10; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        },
        openModal: function(modal, type, current_modal) {
            this.tema_view = type;
            this.pregunta_view = type;
            this.current_modal = current_modal;
            setTimeout(function() {
                $("#" + modal).modal('show');
            }, 100);
        },
        closeModal: function() {
            var _this = this
            this.tema.nombre = '';
            this.tema.tipo = '';
            this.pregunta.pregunta = '';
            this.pregunta.opciones = [];
            setTimeout(function() {
                _this.errors.clear();
            }, 100);
        },
        updatePregunta: function(tema_id, pregunta_id, respuesta) {
            var _this = this;
            for (let index = 0; index < this.current_examen.length; index++) {
                if (this.current_examen[index].id == tema_id) {
                    for (let ind = 0; ind < this.current_examen[index].preguntas.length; ind++) {
                        if (this.current_examen[index].preguntas[ind].id == pregunta_id) {
                            this.current_examen[index].preguntas[ind].respuesta = respuesta;
                        }
                    }
                }
            }
        },
        validarCompletadas: function() {
            var completado = true;
            for (let index = 0; index < this.current_examen.length; index++) {
                for (let ind = 0; ind < this.current_examen[index].preguntas.length; ind++) {
                    if (this.current_examen[index].preguntas[ind].respuesta == '') {
                        completado = false;
                        break;
                    }
                }
            }
            if (completado) {
                this.guardarRespuestas();
            } else {
                $.toast({
                    heading: 'Error',
                    text: 'Aun tienes preguntas sin responder',
                    showHideTransition: 'fade',
                    icon: 'error',
                    position: 'top-right'
                })
            }
        },
        guardarRespuestas: function() {
            var _this = this;
            $(".cancel_saving_button").LoadingOverlay("show");
            axios.post(homepath + '/examenes/store/respuestas', {
                examen_id: this.examen.id,
                temas: this.current_examen
            }).then(function(response) {
                $(".cancel_saving_button").LoadingOverlay("hide");
                swal({
                    text: "¡Tus respuestas fueron guardadas!",
                    icon: "success",
                }).then(function() {
                    window.localStorage.removeItem('timer_date');
                    window.location.href = homepath + '/examenes/completado/' + response
                        .data;
                });
                console.log(response.data)
            }).catch(function(error) {
                if (error.response.data == 'unavailable') {
                    _this.alert_type = 'unavailable';
                    $('#AlertModal').modal('show')
                } else {
                    $.toast({
                        heading: 'Error',
                        text: 'Ha ocurrido un error guardando las respuestas.',
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right'
                    })
                    console.log(error.response.data)
                }
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
                        text: 'You need to fix the errors',
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right'
                    })
                }
            })
        }
    }
});
