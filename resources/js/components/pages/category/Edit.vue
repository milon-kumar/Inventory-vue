<template>
    <div>
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">Edit Category</h3>
            </div>
            <!--begin::Form-->
            <form class="form" @submit.prevent="updateCategory()" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control form-control-solid" v-model="editCategories.name" placeholder="Enter employee name..."/>
                        <small class="text-danger" v-if="errors.name">{{ errors.name[0]}}</small>
                    </div>

                    <div class="form-group">
                        <label for="exampleTextarea">Category Description</label>
                        <textarea id="exampleTextarea" class="form-control form-control-solid" v-model="editCategories.description" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file" class="form-control"  @change="uploadFile">
                    </div>
                    <img :src="`http://localhost:8000/${editCategories.photo}`" ref="showEditImage" alt="" style="width: 180px;height: 120px;">
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
    name: "Edit",
    data(){
        return{
            from: {
                name: '',
                description: '',
                photo:'',
            },
            errors:{},

            editCategories:{},
        }
    },
    methods: {
        uploadFile(event){
            this.editCategories.photo = event.target.files[0];
            let File = event.target.files[0];
            let reader = new FileReader();
            reader.onload = event => {
                this.$refs.showEditImage.src = event.target.result;

                // this.from.photo = event.target.result
            }
            reader.readAsDataURL(File);
        },
        updateCategory(){
            let id = this.$route.params.id;
            let formData = new FormData();

            formData.append('id', id);
            formData.append('name', this.editCategories.name);
            formData.append('description', this.editCategories.description);
            formData.append('photo', this.editCategories.photo);

            axios.post('/api/category/update/', formData)
                .then( res => {
                    this.from= '';
                    this.errors = '';
                    Toast.fire({
                        icon: 'success',
                        title: res.data.message
                    });
                    this.$router.push({name:'ManageCategory'});
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
        axios.get('/api/category/'+id)
        .then(res => {
            // this.from = res.data;


            this.editCategories = res.data;
        })
        .catch(err => {
            console.log(err.response.data)
        })
    }
}
</script>

<style scoped>

</style>
