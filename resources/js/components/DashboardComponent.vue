<template>
    <div v-if="this.isLogged" class="d-body">
        <div class="nav">
            <div class="div-logo">
                <img src="/storage/img/icon_mg.png" alt="logo" class="logo">
            </div>
            <div class="company">
                <span class="nameCompany">MileniumGroup</span>
                <span class="sloganCompany">Comunication Consulting</span>
            </div>
            <div class="btn-group buttons" role="group">
                <button class="btn btn-logout" @click="logout()">Cerrar Sesión</button>
            </div>
        </div>
        <h1 class="text-center">DASHBOARD</h1>
        <div class="container">
            <div class="row row-top">
                <div class="col cont">
                    <!-- TABLA DE USUARIOS POR APROBAR -->
                    <h2><b>Aprobar Usuarios</b></h2>
                    <table class="table table-bordered">
                        <colgroup>
                            <col style="width:30%">
                            <col style="width:40%">
                            <col style="width:30%">
                        </colgroup>
                        <thead>
                            <tr class="head-table">
                                <th>NOMBRE</th>
                                <th>EMAIL</th>
                                <th>ACCIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td class="col-btn">
                                    <div class="btn-group" role="group">
                                        <button class="btn aprob" @click="update(user.id, 2)">Aceptar</button>
                                        <button class="btn rech" @click="update(user.id, 3)">Rechazar</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col cont">
                    <!-- TABLA DE NOTICIAS POR VER -->
                    <h2><b>Noticias</b></h2>
                    <table class="table table-bordered" id="table-notices">
                        <colgroup>
                            <col style="width:75%">
                            <col style="width:25%">
                        </colgroup>
                        <thead>
                            <tr class="head-table">
                                <th>TITULO</th>
                                <th>ACCIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="notice in notices" :key="notice.id">
                                <td>{{ notice.title }}</td>
                                <td class="col-btn">
                                    <div class="btn-group" role="group">
                                        <button class="btn ver-modal" @click="showModal = true; dataModal = notice">Ver
                                            más</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col cont">
                    <!-- CREACION DE NOTICIAS -->
                    <div>
                        <h2><b>Crear Noticias</b></h2>
                        <form @submit.prevent="CreacionNoticia">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating inputs">
                                            <input type="text" id="titleNoticia" class="form-control"
                                                placeholder="title" v-model="data.title">
                                            <label for="titleNoticia">Titulo</label>
                                        </div>
                                        <div class="form-floating  inputs">
                                            <input type="date" id="dateNoticia" class="form-control"
                                                placeholder="01/01/2022" v-model="data.date">
                                            <label for="dateNoticia">Fecha</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating inputs">
                                            <input type="text" id="mediumNoticia" class="form-control"
                                                placeholder="medium" v-model="data.medium">
                                            <label for="mediumNoticia">Medio</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" id="fileNoticia" class="form-control inputs fileInput"
                                                accept="image/png, image/jpeg" v-on:change="uploadFile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn send-data">GUARDAR</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <modal :show="showModal" @close="showModal = false">
            <template #header>
                <h3>{{ dataModal.title }}</h3>
            </template>
            <template #body>
                <img :src="`${dataModal.file}`" alt="...">
                <p>{{ dataModal.medium }}</p>
            </template>
        </modal>
    </div>
</template>
<script>
import Modal from './Modal.vue'
export default {
    components: {
        Modal
    },
    data() {
        return {
            data: [],
            notices: [],
            users: [],
            dataModal: [],
            isLogged: false,
            showModal: false
        }
    },
    mounted() {
        if (!localStorage.getItem('token')) {
            window.location.assign('/login');
        } else this.isLogged = true;
    },
    async created() {
        const notices_res = await this.callApi('get', '/api/notice/all');
        this.notices = notices_res.data.data;
        const users_pend_res = await this.callApi('get', '/api/user/by-state/1');
        this.users = users_pend_res.data.data;
    },
    methods: {
        async uploadFile(e) {
            this.data.file = e.target.files[0];
        },
        async CreacionNoticia() {
            let dataSend = new FormData();
            dataSend.append('title', this.data.title);
            dataSend.append('medium', this.data.medium);
            dataSend.append('date', this.data.date);
            dataSend.append('file', this.data.file);
            const res_update = await this.callApi('post', '/api/notice/create', dataSend);
            window.location.reload(true);
        },
        async update(id, state) {
            const res_update = await this.callApi('put', '/api/user/update/' + id, { state_id: state });
            window.location.reload(true);
        },
        async logout() {
            const res_logout = await this.callApi('post', '/api/logout');
            localStorage.removeItem('token');
            window.location.assign('/login');
        },
    }
}
</script>

<style scoped>
* {
    text-decoration: none;
}

.d-body {
    width: 100%;
    background-color: #ECECEC;
}

img {
    max-width: 700px;
    max-height: 50vh;
    min-height: 400px;
}

.nav {
    background-color: #303030;
    align-content: center;
    width: 100%;
    color: #fff;
}

img.logo {
    width: 60px;
    min-height: 0px;
}

div.div-logo {
    margin: 15px 2px 15px 15px;
    display: inline-block;
}

div.company {
    margin: auto auto auto 2px;
    display: inline-block;
}

.nameCompany {
    font-size: 20px;
    margin-bottom: 0;
    display: block;
}
.sloganCompany{
    font-size: 8px;
    margin-top: -10px;
    display: block;
}

div.buttons {
    right: 0;
    margin: auto 0;
    display: inline-block;
}

h1 {
    text-decoration: underline;
    margin-top: 20px;
}

tr.head-table {
    background-color: #000;
    color: #fff;
    text-align: center;
}

td.col-btn {
    text-align: center;
}

tbody > tr {
    border: 1px solid #dbdbdb;
    text-align: left;
}

th,
td {
    border: 1px none;
}

button.aprob,
button.ver-modal {
    background-color: #8a5def;
}

button.rech {
    background-color: #ff385e;
}

button.btn {
    border-radius: .5rem !important;
    margin: 0 .5rem;
    padding: .1rem .5rem;
    color: #fff;
}

button.send-data {
    background-color: #8a5def;
    border-radius: .5rem !important;
    padding: .4rem 1rem;
}

.cont {
    background-color: #fff;
    border-radius: .7rem;
    margin: 1.2rem;
    padding: 1.2rem;
    text-align: center;
}

div.row-top > div.cont {
    min-height: 400px;
}

.inputs {
    margin: 10px 0;
}

.fileInput {}
</style>
