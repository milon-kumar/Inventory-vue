<template>
    <div>
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">Add New Product</h3>
            </div>
            <!--begin::Form-->
            <form class="form" @submit.prevent="saveProduct()" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" v-model="from.title" class="form-control form-control-solid" placeholder="Enter Product Title">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Buying price</label>
                                <input type="number" v-model="from.buying_price" class="form-control form-control-solid" placeholder="Enter Buying price">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Selling price</label>
                                <input type="number" v-model="from.selling_price" class="form-control form-control-solid" placeholder="Enter Selling price">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Supplier id</label>
                                <select class="form-control form-control-solid"  v-model="from.supplier_id">
                                    <option value="" selected disabled="true">~~Select Brand Id~~</option>
                                    <option v-for="(supp, i) in suppliers" :value="supp.id">{{ supp.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Category id</label>
                                <select class="form-control form-control-solid" v-model="from.cat_id">
                                    <option value="" selected disabled="true">~~Select Category Id~~</option>
                                    <option v-for="(cat, i) in categories" :value="cat.id">{{ cat.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Brand id</label>
                                <select class="form-control form-control-solid" v-model="from.brand_id">
                                    <option value="" selected disabled="true">~~Select Supplier Id~~</option>
                                    <option v-for="(brand, i) in brands" :value="brand.id">{{ brand.title }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Summary</label>
                                <textarea type="text" v-model="from.summary" class="form-control form-control-solid" rows="5" placeholder="Enter sum product summery"></textarea>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea type="text" v-model="from.description" class="form-control form-control-solid" rows="5" placeholder="Enter product Details"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Product Stoke</label>
                                <input type="number" v-model="from.stock" class="form-control form-control-solid" placeholder="Enter Product Title">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="">Godwin Root</label>
                                <input type="text" v-model="from.root" class="form-control form-control-solid" placeholder="Enter Product Title">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group" >
                                <label for="">Upload Single Image</label>
                                <label class="inputFileButton form-control">Input Single Image....
                                    <input type="file" id="noShow" class="form-control"  @change="uploadFile">
                                </label>
                            </div>
                            <img v-if="from.showImg" :src="from.showImg" alt="" style="width: 100%;height: 250px;margin-top: -13px;">
                            <img v-if="!from.showImg" :src="`img/download.png`" alt="" style="width: 100%;height: 250px;margin-top: -13px;">
                            <span @click="deleteImage()" class="deleteImage" v-show="from.photo">x</span>
                        </div>
                        <div class="col">
                            <div class="custom-file-container mt-5" data-upload-id="productPhotos">
                                <label
                                >Upload File
                                    <a
                                        href="javascript:void(0)"
                                        class="custom-file-container__image-clear"
                                        title="Clear Image"
                                    >&times;</a
                                    ></label
                                >
                                <label class="custom-file-container__custom-file">
                                    <input
                                        type="file"
                                        class="custom-file-container__custom-file__custom-file-input"
                                        accept="*"
                                        multiple
                                        aria-label="Choose File"
                                        @change="imagesUpload"
                                    />
                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                    <span
                                        class="custom-file-container__custom-file__custom-file-control"
                                    ></span>
                                </label>
                                <div class="custom-file-container__image-preview"></div>
                            </div>
                        </div>
                    </div>



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
    name: "Add",
    data(){
        return{
            // from: new FormData,

            from: {
                title: '',
                summary: '',
                description:'',
                stock: '',
                brand_id: '',
                cat_id : '',
                supplier_id:'',
                photo:'',
                root:'',
                buying_price:'',
                selling_price:'',
                showImg:'',
                images: [],
            },
            errors:{},
            categories:{},
            suppliers:{},
            brands:{},
        }
    },
    methods: {
        uploadFile(event){
             this.from.photo = event.target.files[0];

            let reader = new FileReader();
            reader.onload = event => {
                this.from.showImg = event.target.result
            }
            reader.readAsDataURL(this.from.photo);
        },

        imagesUpload(event){
            let inputValue = event.target.files;
            for (let i=0; i<inputValue.length; i++){
                this.from.images.push(inputValue[i]);
            }
        },
        saveProduct(){
            var fromData = new FormData;

            fromData.append('title', this.from.title)
            fromData.append('summary', this.from.summary)
            fromData.append('description', this.from.description)
            fromData.append('stock', this.from.stock)
            fromData.append('brand_id', this.from.brand_id)
            fromData.append('cat_id', this.from.cat_id)
            fromData.append('supplier_id', this.from.supplier_id)
            fromData.append('photo', this.from.photo)
            fromData.append('root', this.from.root)
            fromData.append('buying_price', this.from.buying_price)
            fromData.append('selling_price', this.from.selling_price)
            for (let j=0; j<this.from.images.length; j++){
                fromData.append('images[]',this.from.images[j])
            }


            axios.post('api/product', fromData)
            .then( res => {
                Toast.fire({
                    icon: 'success',
                    title: res.data.message
                })
                this.from= '';
                this.errors = '';
                this.from.images = null;


            })
            .catch(err => {
                this.errors = err.response.data.errors;
                Toast.fire({
                    icon: 'warning',
                    title: err.response.statusText
                })
            })
        },
        deleteImage(){
            this.from.showImg = ''
        },
        allCategory(){
            axios.get('/api/category')
            .then(res => {
                this.categories = res.data
            })
            .catch(err => {
                Toast.fire({
                    icon: 'warning',
                    title: err.response.statusText
                })
            })
        },
        allSuppliers(){
            axios.get('/api/supplier')
            .then(res => {
                this.suppliers = res.data
            })
            .catch(err => {
                Toast.fire({
                    icon: 'warning',
                    title: err.response.statusText
                })
            })
        },
        allBrands(){
            axios.get('/api/brand')
                .then(res => {
                    this.brands = res.data
                })
                .catch(err => {
                    Toast.fire({
                        icon: 'warning',
                        title: err.response.statusText
                    })
                })
        }
    },
    created() {
        this.allCategory();
        this.allSuppliers();
        this.allBrands();
    }
}
</script>

<style scoped>
.deleteImage{
    position: relative;
    top: -41px;
    left: -31px;
    width: 20px;
    height: 20px;
    background: #00000014;
    display: inline-block;
    color: #efcdcd;
    border-radius: 15px;
    border: none;
    padding: 2px 6px;
    transition: 0.3s all ease;
    cursor:pointer;
}
.deleteImage:hover{
    background: #000;
}


#noShow {
    display: none;
}

.inputFileButton{
    border: 1px solid #ccc;
    display: inline-block;
    padding: 9px 12px;
    cursor: pointer;
    margin-top: 19px;
}
</style>




