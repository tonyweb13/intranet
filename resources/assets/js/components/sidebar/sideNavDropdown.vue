<template>
    <li>
        <a href="#"><i :class="icon"></i><span class="fa arrow"></span> <span class="nav-label"> {{ name }} </span></a>
        <ul :class="nav_level" class="nav collapse">
            <slot></slot>
        </ul>
    </li>
</template>

<script>
'use strict';

export default {
    name: 'sideNavDropdown',
    props: {
        name: {
            type: String,
            default: ''
        },
        icon: {
            type: String,
            default: ''
        },
        nav_level: {
            type: String,
            default: ''
        }
    }
}
</script>
