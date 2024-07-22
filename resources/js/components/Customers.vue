<template>
    <div class="container">
        <section style="overflow: auto">
                <v-table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Situação</th>
                        <th>Data de criação</th>
                        <th>Data de admissão</th>
                        <th>Data de atualização</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody v-if="response.customers">
                    <tr v-for="data in response.customers.data"
                        :key="response.id">
                        <th>{{data.name}}</th>
                        <td>{{data.situation}}</td>
                        <td>{{data.datetime_register}}</td>
                        <td>{{data.datetime_admission}}</td>
                        <td>{{data.datetime_update}}</td>
                        <td><button type="button"  @click="remove(data.id)" class="btn btn-danger">Remover</button></td>
                    </tr>
                    <nav>
                    <ul class="pagination" >
                        <li class="page-item"  v-for="data in response.customers.links"><a class="page-link" @click="pagination(data.url)" href="#" v-html="data.label"></a></li>
                    </ul>
                    </nav>
                </tbody>
                </v-table>
            <div class="group-button">
                <button type="button" @click="toogleModal(true)" class="btn btn-success">Novo usuário</button>
            </div>
        </section> 
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form ref="userForm" @submit.prevent="createUser">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Novo usuário</h5>
        </div>
        <div class="modal-body">
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" id="name" placeholder="Nome" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" id="email" placeholder="E-mail" required>
                </div>
                 <div class="form-group">
                    <label for="situation">Situação do usuário</label>
                    <select class="form-control" id="situation">
                    <option style="color: green" value="ADMITIDO">Admitido</option>
                    <option style="color: red" value="REPROVADO">Reprovado</option>
                    <option style="color: orange" value="EM TESTE">Em teste</option>
                    </select>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" @click="toogleModal(false)" class="btn-closedasda btn btn-secondary">Cancelar</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </form>
</div>
</template>
<style scoped src="@/../css/app.css">
</style>



<script>
    import axios from "axios";
    var modal;

export default {
    name: "Customers",
    data() {
        return {
            response: []
        }
    },
    mounted() {
        modal = new bootstrap.Modal('#createUserModal');;
    },
    created() {
        axios(
                {
                    method: "get",
                    url: "http://127.0.0.1:8000/api/customers",
                }
            )
            .then((response) => { 
                this.response = response.data;
            })
            .catch(
                (err) =>
                {
                    console.log(err);
                }
            );
    },
    methods: {
        createUser(submitEvent) {

            try {
            axios(
             {
                    method: "post",
                    url: "http://127.0.0.1:8000/api/customers",
                data: {
                name: submitEvent.target.elements.name.value,
                email: submitEvent.target.elements.email.value,
                situation: submitEvent.target.elements.situation.value,
            },
            headers: {
                headers: {
                "content-type": "text/json",
                },
            }}
            ).then( (response) => {
               this.fetchData();
               this.$refs.userForm.reset(); 
               modal.hide();
            } );
            
        } catch (error) {
            console.log(error);
        }
        },
        toogleModal(status)
        {
            if (status)
            {
                modal.show();
            } else{
                modal.hide();
            }
        },
        remove(id) {
            axios(
                {
                    method: "delete",
                    url: "http://127.0.0.1:8000/api/customers/"+id,
                }
            )
            .then((response) => { 
                this.fetchData();
            })
            .catch(
                (err) =>
                {
                    console.log(err);
                }
            );
        },
        fetchData() {
            axios(
                {
                    method: "get",
                    url: "http://127.0.0.1:8000/api/customers",
                }
            )
            .then((response) => { 
                this.response = response.data;
            })
            .catch(
                (err) =>
                {
                    console.log(err);
                }
            );
        },
        pagination(str) {
            if ( str == null )
                return;
            
            axios(
                {
                    method: "get",
                    url: str,
                }
            )
            .then((response) => { 
                this.response = response.data;
            })
            .catch(
                (err) =>
                {
                    console.log(err);
                }
            );
        }
    }
   }
</script>

