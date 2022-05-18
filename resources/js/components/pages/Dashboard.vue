<template>
 <div>
   <h1>This is home components</h1>
 </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Dashboard",
    created() {
        // this.isLogined();
        if (!User.loggedIn()){
            this.$router.push({name:"Login"})
        }
    }
}
</script>

<style scoped>

</style>
