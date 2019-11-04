<template>
    <div class="container">
         <!-- /.row -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                   <button class="btn btn-success"  data-toggle="modal" data-target="#addNew">
                    <i class="fas fa-user-plus"></i> Add New
                   </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Registered At </th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users" :key="user.id">
                      <td>{{ user.id }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.type |upText }}</td>
                      <td> {{user.created_at | myDate }} </td>
                      <td>
                        <a href=""> <i class="fa fa-edit blue"></i> </a> /
                        <a href=""> <i class="fa fa-trash red"></i> </a>
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
        <!-- Modal Add User-->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- ./FORM -->
                    <form @submit.prevent="createUser" > 
                    <div class="modal-body">
                        <div class="form-group">
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" 
                                placeholder="Name">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.email" type="email" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" 
                                placeholder="email@email">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.password" type="password" name="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" 
                                placeholder="Password">
                            <has-error :form="form" field="password"></has-error>
                        </div>
                        <div class="form-group">
                            <select v-model="form.type"  name="type"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('type') }" 
                                 >
                                    <option value=""> Select a user Role </option>
                                    <option value="admin">Admin </option>
                                    <option value="user"> Usuario </option>
                                    <option value="author"> Autor </option>
                             </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>
                        <div class="form-group">
                            <textarea v-model="form.bio"  name="bio"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }" 
                                placeholder="Bio">
                              </textarea>
                            <has-error :form="form" field="bio"></has-error>
                        </div>

                    </div>
                    
                   
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                          <button type="submit" class="btn btn-primary">Salvar</button>
                      </div>
                    </form>
                     <!-- ./FORM -->
                </div>
            </div>
        </div>
        <!-- ./ Modal Add User-->
    </div>
</template>

<script>
    export default {
      data(){
        return {
          users:{},
          form: new Form({
            name:'',
            email:'',
            password:'',
            type:'',
            bio:'',
            photo:''
          } )
        }
      },
      methods:{
        loadUsers(){

            axios.get('api/user')
                .then( ({data}) => (this.users = data.data)  )
                
        },
        createUser()
        {
            this.$Progress.start()// progress bar

            this.form.post('api/user')
                .then(()=>{
                  
                      
                      this.$Progress.finish()// progress bar
                
                      toast.fire({ // ui : show to the user toast added
                          type: 'success',
                          title: 'User Created'
                      })

                      Fire.$emit('AfterCreate');

                      $("#addNew").modal('hide') // hide when added user


                })
                // .catch(()=>{

                // })

           

            
        }
      },
      created() {
          this.loadUsers();
          // setInterval(()=>this.loadUsers(),3000);
          Fire.$on("AfterCreate",()=>{
            this.loadUsers();
          });
      }
    }
</script>
