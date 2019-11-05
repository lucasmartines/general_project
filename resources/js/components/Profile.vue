<style>
.widget-user-header{
    background: url('https://images.pexels.com/photos/592077/pexels-photo-592077.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500') center center;
    background-size:cover;
    min-height:300px;
}
</style>
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white" >

                        <h3 class="widget-user-username text-right">{{form.name}}</h3>
                        <!--<h5 class="widget-user-desc text-right">Web Designer</h5>-->
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">3,200</h5>
                            <span class="description-text">SALES</span>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">13,000</h5>
                            <span class="description-text">FOLLOWERS</span>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                        <div class="description-block">
                            <h5 class="description-header">35</h5>
                            <span class="description-text">PRODUCTS</span>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    </div>
                </div>
            </div>
            <!-- ./col-md-8 -->
        </div>
        <!-- ./row -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="card col-md-12">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Setttings</a></li>
                            
                            
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">

                            <form class="tab-pane active">
                                <div class="form-group ">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input  type="input"
                                                class="form-control"
                                                id="inputName"
                                                placeholder="Name"
                                                 v-model="form.name">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email"
                                                class="form-control"
                                                id="inputEmail"
                                                placeholder="Your Email"
                                                v-model="form.email">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                    <div class="col-sm-10">
                                        <textarea type="email"
                                                class="form-control"
                                                id="inputExperience"
                                                placeholder="Experience"
                                                ></textarea>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label for="inputPassport" class="col-sm-2 col-form-label">Passport</label>
                                    <div class="col-sm-10">
                                        <input type="email"
                                                class="form-control"
                                                id="inputPassport"
                                                placeholder="Passport"
                                                >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputFile" class="col-sm-2 col-form-label">Your File</label>
                                    <div class="col-sm-6 col-12">
                                        <input type="file"
                                                class=" "
                                                id="inputFile"
                                                @change="updateProfile">
                                    </div>
                                </div>
                                <div class="form-group col-sm-10 mt-4 ">
                                    <div class="col-sm-2 pr-0">
                                        <input 
                                            @click.prevent="updateInfo"
                                            type="submit"
                                            class="btn btn-success ">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
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
            updateProfile(e){/*update image profile*/
            
                let file = e.target.files[0];
                let reader = new FileReader();

                reader.onloadend = (file)=>{
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            },
            updateInfo(){

                this.form.put('api/profile')
                    .then(()=>{
                        
                    })
                    .catch(()=>{

                    })

            },
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('api/profile')
                .then(({data})=>{
                    this.form.fill(data)
                })

        }
    }
</script>
