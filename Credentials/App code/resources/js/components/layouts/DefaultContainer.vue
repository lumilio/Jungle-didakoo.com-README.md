<template>
    <div>
        <Navbar/>
        <router-view ></router-view>
    </div>
</template>
<script>
import Navbar from "../includes/Navbar";
export default {
    name: "DefaultContainer",
    components: {
        Navbar
    }
}
</script>
<style scoped>
</style>
