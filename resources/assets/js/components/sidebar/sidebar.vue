<template>
    <div v-for="(item, index) in navItems">
        <template v-if="item.children">
            <side-nav-dropdown nav_level="nav-second-level" :name="item.name" :icon="item.icon">
                <template v-for="(child1, index) in item.children">
                    <template v-if="child1.children">
                        <side-nav-dropdown nav_level="nav-third-level" :name="child1.name" :icon="child1.icon">
                            <template v-for="(child2, index) in child1.children">
                                <side-nav-link :name="child2.name" :url="child2.url" :icon="child2.icon" :is_child="true" />
                            </template>
                        </side-nav-dropdown>
                    </template>
                    <template v-else>
                        <side-nav-link :name="child1.name" :url="child1.url" :icon="child1.icon" :is_child="true" />
                    </template>
                </template>
            </side-nav-dropdown>
        </template>
        <template v-else>
            <side-nav-link :name="item.name" :url="item.url" :icon="item.icon" :id="item.url"/>
        </template>
    </div>

</template>

<style media="scope">
    .navbar-static-side {
        z-index: 1000 !important;
    }
</style>

<script>
'use strict';

import sideNavLink from './sideNavLink';
import sideNavDropdown from './sideNavDropdown';

export default {
    name: 'sidebar',
    props: {
        navItems: {
            type: Array,
            required: true,
            default: () => []
        }
    },
    components: {
        sideNavLink,
        sideNavDropdown
    }
}

</script>