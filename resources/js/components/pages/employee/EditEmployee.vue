<template>
    <div>
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">Edit Employee</h3>
            </div>
            <!--begin::Form-->
            <form class="form" @submit.prevent="updateEmployee()" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control form-control-solid" v-model="from.name" placeholder="Enter employee name..."/>
                        <small class="text-danger" v-if="errors.name">{{ errors.name[0]}}</small>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control form-control-solid" v-model="from.email" placeholder="Example: employee@checkmail.com..."/>
                        <small class="text-danger" v-if="errors.email">{{ errors.email[0]}}</small>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control form-control-solid" v-model="from.phone" placeholder="Enter employee phone number..."/>
                        <small class="text-danger" v-if="errors.phone">{{ errors.phone[0]}}</small>
                    </div>

                    <div class="form-group">
                        <label>Position</label>
                        <select class="form-control form-control-solid" v-model="from.position">
                            <option disabled="true" selected>~~Select Employee Positions~~</option>
                            <option value="new">New</option>
                            <option value="starting">Starting</option>
                        </select>
                        <small class="text-danger" v-if="errors.position">{{ errors.position[0]}}</small>
                    </div>

                    <div class="form-group">
                        <label for="exampleTextarea">Address</label>
                        <textarea id="exampleTextarea" class="form-control form-control-solid" v-model="from.address" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" class="form-control"  @change="uploadFile">
                    </div>
                    <img :src="`http://localhost:8000/${ from.photo }`" alt="" style="width: 180px;height: 120px;">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
            <!--end::Form-->
        </div>


    </div>
</template>

<script>
export default {
    name: "EditEmployee",
    data(){
        return{
            from: {
                name: '',
                email: '',
                phone:'',
                position: '',
                address: '',
                photo:'',
                image:{},
            },
            errors:{},

            editData:{
                name: '',
                email: '',
                phone:'',
                position: '',
                address: '',
                photo:'',
                image:{},
            }
        }
    },
    methods: {
        uploadFile(event){
            let File = event.target.files[0];

            this.from.image = File;
            let reader = new FileReader();
            reader.onload = event => {
                this.from.photo = event.target.result
            }
            reader.readAsDataURL(File);
        },


        updateEmployee(){
            let id = this.$route.params.id;
            let fromData = new FormData;
            fromData.append('name', this.from.name)
            fromData.append('email', this.from.email)
            fromData.append('phone', this.from.phone)
            fromData.append('position', this.from.position)
            fromData.append('address', this.from.address)
            fromData.append('image', this.image)


            axios.patch('/api/employee/'+id, this.from)
                .then( res => {
                    this.from= '';
                    this.errors = '';
                    Toast.fire({
                        icon: 'success',
                        title: res.data.message
                    })
                    this.$router.push({name:'ManageEmployee'});
                })
                .catch(err => {
                    this.errors = err.response.data.errors;
                    Toast.fire({
                        icon: 'warning',
                        title: err.response.statusText
                    })
                })
        },

        isLogined(){
            if (!User.loggedIn()){
                this.$router.push({name:"Login"})
            }
        }
    },

    created() {
        this.isLogined();
        let id = this.$route.params.id;
        axios.get('/api/employee/'+id)
        .then(res => {
            this.from = res.data;
            console.log(res.data)
        })
        .catch(err => {
            console.log(err.response.data)
        })
    }
}
</script>

<style scoped>

</style>
