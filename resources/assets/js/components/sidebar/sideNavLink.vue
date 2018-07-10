<template>
        <li>
            <router-link :to="url">
                <div  v-if="!is_child">
                    <i :class="icon"></i><span class="nav-label">{{ name }}</span>
                </div>
                <div v-else>
                    <i :class="icon"></i>{{ name }}
                </div>
            </router-link>
        </li>
</template>

<script>
'use strict';

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export default {
    name: 'sideNavLink',
    props: {
        name: {
            type: String,
            default: ''
        },
        url: {
            type: String,
            default: ''
        },
        icon: {
            type: String,
            default: ''
        },
        is_child: {
            type: Boolean,
            default: false
        },
        id: {
            type: String,
            default: ''
        }
    },
    methods: {
        remove_slashes(id) {
            return id.replace(/\//g, '');
        }
    }
}
</script>
