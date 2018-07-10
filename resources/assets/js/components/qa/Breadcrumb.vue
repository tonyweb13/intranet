<template>
    <ol class="breadcrumb ">
        <li class="breadcrumb-item m-lg-3" v-for="(item, index) in list">
            <span class="active" v-if="isLast(index)"><i :class="item.icon"></i> {{ showName(item) }}</span>
            <router-link :to="item.url" v-else><i :class="item.icon"></i> {{ showName(item) }}</router-link>
        </li>
    </ol>
</template>
<script>
'use strict';

export default {
    props: {
        list: {
            type: Array,
            required: true,
            default: () => []
        }
    },
    methods: {
        isLast (index) {
            return index === this.list.length - 1
        },
        showName (item) {
            if (item.meta && item.meta.label) {
                item = item.meta && item.meta.label
            }
            if (item.name) {
                item = item.name
            }
            return item
        }
    }
}
</script>
