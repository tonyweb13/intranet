<template>
    <div class="form-group">
        <label>{{ label }}</label>
        <p>{{ p }}</p>
    </div>
</template>
<script>
    export default {
        props: ['label','p'],
    }
</script>