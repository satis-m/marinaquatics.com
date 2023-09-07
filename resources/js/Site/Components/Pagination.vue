<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap items-center paginator justify-center">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null && p === 0 " class="disabled"> <i class="icon-chevrons-left"></i></div>
                <div v-else-if="link.url === null && links.length == (p + 1)" class="disabled"> <i class="icon-chevrons-right"></i></div>
                <NavLink v-else-if="p === 0" :href="link.url">  <i class="icon-chevrons-left"></i></NavLink>
                <NavLink v-else-if="links.length == (p + 1)" :href="link.url"> <i class="icon-chevrons-right"></i></NavLink>
                <NavLink v-else
                              class=""
                              :class="{ 'active': link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>
<script setup>
const  props = defineProps({
    links: Array,
});
</script>
<style lang="scss">
.paginator{
    column-gap: 6px;
    a{
        width: 38px;
        height: 38px;
        border-radius: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #DCE1E8;
        color: var(--tp-text-3);
        &.active, &:hover{
            background: var(--tp-heading-secondary);
            border-color: var(--tp-heading-secondary);
            color: var(--tp-common-white);
        }
    }
    .disabled
    {
        cursor: not-allowed;
        width: 38px;
        height: 38px;
        border-radius: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #DCE1E8;
        background: #e5e5e5;
        color: var(--tp-text-3);
    }
}

</style>
