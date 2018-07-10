<template>
    <button type="submit" @click="logout()">
        <i class="fa fa-sign-out-alt"></i> Log out
    </button>
</template>
<style scoped>
    .nav.navbar-right > li > button {
        color: #999c9e;
        border: 0px;
    }
    .nav.navbar-top-links button {
        font-size: 14px;
    }
    .navbar-top-links li button {
        padding: 20px 10px;
        min-height: 50px;
    }
    .nav > li > button {
        color: #a7b1c2;
        font-weight: 600;
        padding: 14px 20px 14px 25px;
    }
    .nav>li>button {
        position: relative;
        display: block;
        padding: 10px 15px;
    }
    button {
        cursor: pointer;
        background-color: transparent;
        padding: 3px 20px;
        border: 0px;
        margin-bottom: 8px;
    }
</style>
<script>
    export default {
        methods: {
            logout () {
                swal({
                    title: 'Are you sure you want to logout?',
                    type: 'warning',
                    showCancelButton: true,
                    showConfirmButton: true,
                }).then((result) => {
                    if (result.value) {
                        this.$session.destroy();
                        this.$session.clear();
                        location.href = '/logout';
                    }
                })
            }
        }
    }
</script>