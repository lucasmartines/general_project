<template>
    <div class="container">

        <div class="row" v-if="!$gate.isAdminOrAuthor()">
          <not-found></not-found>
        </div>
         <!-- /.row -->
        <div class="row" v-if="$gate.isAdminOrAuthor()"> 
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                   <button class="btn btn-success" @click="newModal"  > <!-- data-toggle="modal" data-target="#addNew" -->
                   
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
                    <tr v-for="user in users.data" :key="user.id">
                      <td>{{ user.id }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.type |upText }}</td>
                      <td> {{user.created_at | myDate }} </td>
                      <td>
                        <a href="" @click.prevent="editModal(user)"> <i class="fa fa-edit blue"></i> </a> /
                        <a href="" @click.prevent="deleteUser(user.id)"> <i class="fa fa-trash red"></i> </a>
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <div class="card-footer">
                <pagination :data="users"
                            @pagination-change-page="getUsers">
                </pagination>
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
                        <h5 v-if="!editMode" class="modal-title" id="exampleModalLabel">Add New User</h5>
                        <h5 v-if="editMode" class="modal-title" id="exampleModalLabel">Update User's info</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- ./FORM -->
                    <form @submit.prevent="editMode ? updateUser() : createUser()" > 
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
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button v-show='editMode' type="submit" class="btn btn-primary">Edit</button>
                          <button v-show='!editMode' type="submit" class="btn btn-success">Create</button>

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
          editMode:false,
          users:{},
          form: new Form({
            id:'',
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
        getUsers(page = 1) 
        {
          
           if( this.$gate.isAdminOrAuthor() ){
              axios.get( appURL + '/api/user/?page=' + page)
                .then(response => {
                  this.users = response.data;
                   
            });
       
            
           }
        },
        updateUser(){
            this.$Progress.start()// progress bar

            this.form.put('api/user/'+this.form.id)
              .then(()=>{
                  
                this.$Progress.finish()// progress bar

                swal.fire( /// all right 
                  'Updated!',
                  'Information has been updated.',
                  'success'
                )
                Fire.$emit('AfterCreate');
                $("#addNew").modal('hide') // hide when added user
              })
              .catch(()=>{
                 
              })
          
        },
        editModal(user){

          this.editMode = true
          this.form.reset();
          $('#addNew').modal('show')
          this.form.fill(user)
          
        },
        newModal(){
           this.editMode = false
           this.form.reset();
           $('#addNew').modal('show')
        },
        deleteUser(id){

          //show message
          swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'

          }).then((result) => {


              if(result.value){// if user click yes

                  // delete request
                  this.form.delete('api/user/'+id)
                    .then(()=>{ 

                          // show feedback
                          swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                          )
                          // refresh users 
                          Fire.$emit('AfterCreate');

                    })
                    .catch( ()=>{
                        swal.fire("Failed!","There something wrong","warning")
                        this.$Progress.fail()// progress bar
                    })
              }
                
            });




        },
        loadUsers(){
            if( this.$gate.isAdminOrAuthor() ){
              axios.get('api/user')
                .then( ({data}) => (this.users = data)  )
            }
            
                
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
                .catch(()=>{
                    this.$Progress.fail()// progress bar
                })

           

            
        }
      },
      created() {
          this.loadUsers();
          // setInterval(()=>this.loadUsers(),3000);
          Fire.$on("AfterCreate",()=>{
            this.loadUsers();
          });

          Fire.$on("searching",()=>{

            let query = this.$parent.search;
           
            axios.get('api/findUser?q='+query)
              .then(({data})=>{
                this.users = data;
              })
              .catch();
            
          })
      }
    }
</script>
