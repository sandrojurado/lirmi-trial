<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prueba</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4/dist/flatpickr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/css/app.css')}}">
</head>
<body>
    <div id="app">
        <nav class="navbar has-shadow" role="navigation" aria-label="main navigation">
            <div id="navbarBasicExample" class="navbar-menu container">
                <div class="navbar-start">
                    <a class="navbar-item">
                        Unidad
                    </a>

                    <a class="navbar-item active">
                        Gantt
                    </a>

                    <a class="navbar-item">
                        Actividad
                    </a>
                </div>
                <div id="button-list" class="navbar-end">
                    <a class="navbar-item button">
                        <i class="fas fa-file"></i> Descargar
                    </a>

                    <a class="navbar-item button">
                        <i class="fas fa-chart-pie"></i> E. Aprendizaje
                    </a>
                    <a class="navbar-item button purple">
                        Guardar e ir a Actividades
                    </a>
                </div>
            </div>
        </nav>

        <div id="content" class="section is-paddingless">
            <div class="container">
                <div class="columns">
                    <div class="column is-3 is-paddingless">
                        <div class="cell header">
                            <p>
                                <strong>Total de clases: @{{goals.length}}</strong>
                                <a class="button is-bordered is-pulled-right" v-on:click="scrollLeft">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </p>

                        </div>
                        <div class="cell" v-for="goal in goals" :style="'background-color: ' + ((hoveredRow === goal.id)? '#e8e9ff' : 'transparent') " @mouseover="mouseOver(goal)">
                            <div class="bullet" v-bind:style="{ backgroundColor: goal.color }"></div>
                            <span class="goal-name">@{{ goal.name }}</span> <span class="goal-description" v-tooltip="goal.goal">@{{ getPostBody(goal) }}</span>
                        </div>
                        <div class="cell">
                            <p><strong>Evaluaciones</strong></p>
                        </div>
                    </div>
                    <div id="class-list" class="column is-8 is-paddingless is-clipped">
                        <div :style="{ width: classes.length * 90 + 'px'}">
                            <div v-for="(classitem, index) in classes" style="float: left;" class="col" v-bind:class="(classitem.evaluation === 1)?'disabled':''">
                                <div class="cell-header cell is-paddingless">
                                    <v-popover offset="1" :disabled="!isEnabled">
                                        <span class="class-title">Clase @{{ index + 1}} <i class="fas fa-chevron-down"></i></span>
                                        <template slot="popover">
                                            <a class="button is-block" v-on:click="addColumn(classitem.id, 1)" v-close-popover>
                                                <i class="fas fa-arrow-left"></i>
                                                Crear a la izquierda
                                            </a><br/>
                                            <a class="button is-block" v-on:click="addColumn(classitem.id, 2)" v-close-popover>
                                                <i class="fas fa-arrow-right"></i>
                                                Crear a la derecha
                                            </a><br/>
                                            <a class="button is-block is-danger" v-on:click="deleteColumn(classitem.id)" v-close-popover>
                                                <i class="fas fa-trash"></i>
                                                Eliminar
                                            </a>
                                        </template>
                                    </v-popover>
                                    <flat-pickr v-model="classitem.class_date" :config="config" @on-open="opened=true" @on-change="onDateChange" :name="'class-'+classitem.id"/>


                                </div>
                                <div v-for="(goal, index) in goals" class="cell" :style="'background-color: ' + ((hoveredRow === goal.id)? '#e8e9ff' : 'transparent') " @mouseover="mouseOver(goal)" v-on:click="addBullet(goal.id, classitem.id, classitem.evaluation)">
                                    <div class="bullet" v-bind:style="{ backgroundColor: inArray(goal.id, classitem.bullet_list) ? goal.color : 'transparent' }" ></div>
                                </div>
                                <div class="cell evaluation" v-on:click="addEvaluation(classitem.id, classitem.evaluation)">
                                    <div class="bullet" v-bind:style="{ backgroundColor: (classitem.evaluation === 1) ? '#000' : 'transparent' }" ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column is-1 is-paddingless">
                        <div class="only-button">
                            <p>
                                <a class="button is-bordered" v-on:click="scrollRight">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="floating-button">
            <a class="button is-rounded">
                <i class="far fa-comment"></i> Ayuda
            </a>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4/dist/l10n/es.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-flatpickr-component@8"></script>
    <script src="https://unpkg.com/v-tooltip"></script>
    <script src="{{url('/plugins/moment/moment.js')}}"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                message: 'Hello Vue!',
                opened: false,
                hoveredRow: null,
                classes: [],
                goals: [],
                isEnabled: true,
                date: null,
                config: {
                    altFormat: 'd-m',
                    altInput: true,
                    dateFormat: 'Y-m-d',
                    locale: {
                        weekdays: {
                            shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                            longhand: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]
                        },
                        months: {
                            shorthand: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                            longhand: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
                        },
                        firstDayOfWeek: 1,
                        rangeSeparator: " a "
                    }, // locale for this instance only
                },
            },
            methods: {
                getClasses () {
                    axios.get('/api/class')
                        .then(function (response) {
                            this.classes = response.data.classes;
                        }.bind(this))
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                getGoals () {
                    axios.get('/api/goal')
                        .then(function (response) {
                            this.goals = response.data.goals;
                        }.bind(this))
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                getPostBody (item) {
                    let body = item.goal;
                    return body.length > 15 ? body.substring(0, 15) + '...' : body;
                },
                formatDate (date) {
                  return moment(date).format('DD-MM');
                },
                mouseOver (obj) {
                    this.hoveredRow = obj.id
                },
                scrollRight() {
                    let content = document.querySelector("#class-list");
                    let scrollAmount = 0;
                    let slide = content.offsetWidth * 0.7;
                    let slideTimer = setInterval(function(){
                        content.scrollLeft += 10;
                        scrollAmount += 10;
                        if(scrollAmount >= slide){
                            window.clearInterval(slideTimer);
                        }
                    }, 15);
                },
                scrollLeft() {
                    let content = document.querySelector("#class-list");
                    let scrollAmount = 0;
                    let slide = content.offsetWidth * 0.7;
                    let slideTimer = setInterval(function(){
                        content.scrollLeft -= 10;
                        scrollAmount += 10;
                        if(scrollAmount >= slide){
                            window.clearInterval(slideTimer);
                        }
                    }, 15);
                },
                onDateChange(date, str, instance) {
                    if (this.opened) {
                        let id = instance.input.name.split('-')[1]
                        let newDate = str;
                        axios.put('/api/class/'+id,{
                            date: newDate
                        }).then(function (response) {
                            this.opened = false;
                            this.classes = response.data.classes;
                        }.bind(this))
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                },
                deleteColumn(item) {
                    axios.delete('/api/class/'+item).then(function (response) {
                        console.log(response.data)
                        this.classes = response.data.classes;
                    }.bind(this))
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                addColumn(item, direction) {
                    axios.post('/api/class/',{
                        item: item,
                        direction: direction
                    }).then(function (response) {
                        console.log(response.data)
                        this.classes = response.data.classes;
                    }.bind(this))
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                addBullet(goal, item, evaluation) {
                    if (evaluation === 0) {
                        axios.post('/api/class/bullet',{
                            item: item,
                            goal: goal
                        }).then(function (response) {
                            this.classes = response.data.classes;
                        }.bind(this))
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                },
                addEvaluation(item, evaluation) {
                    axios.post('/api/class/evaluation',{
                        item: item,
                    }).then(function (response) {
                        this.classes = response.data.classes;
                    }.bind(this))
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                inArray(needle, haystack) {
                    var length = haystack.length;
                    for(var i = 0; i < length; i++) {
                        if(haystack[i] == needle) return true;
                    }
                    return false;
                }

            },
            mounted() {
                this.getGoals();
                this.getClasses();

            },
        });
        Vue.component('flat-pickr', VueFlatpickr);
    </script>
</body>
</html>
