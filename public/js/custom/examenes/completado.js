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
        examen_completado: examen_completado,
        current_examen: null,
        examen_info: {
            materia: 'deleniti provident nobis',
            estudiante: 'et dolorem qui',
            facilitador: 'architecto itaque cupiditate',
            fecha: 'illo laboriosam dolorem',
            descripcion: 'quo ipsum laborum Maxime ex quia sit provident voluptatibus recusandae dolor eligendi sint. Impedit autem eos optio. Omnis ratione velit quia voluptatem. Aperiam corporis et est ab doloremque facere asperiores et saepe. Odio deserunt et. Optio voluptate ullam nobis iusto rerum aliquid odit.',
        },
        current_tema: null,
        current_pregunta: null,
    },
    mounted: function() {
        this.examen_completado.created_at = moment(examen_completado.created_at).format('DD-MM-YYYY');
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
            axios.post(homepath + '/examenes/store/respuestas', {
                examen_id: this.examen.id,
                temas: this.current_examen
            }).then(function(response) {
                console.log(response.data)
            }).catch(function(error) {
                console.log(error)
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
