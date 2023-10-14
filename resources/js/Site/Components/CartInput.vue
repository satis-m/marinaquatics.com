<template>
    <div class="cart-count-wrapper" :class="size == 'sm' ? 'input-sm' : ''">
        <button :disabled="props.disable" class="btn--minus" @click="changeCounter('-1')" type="button" name="button">
           <i class="icon-minus"></i>
        </button>
        <input class="input-quantity" type="text" readonly name="name" :value="counter">
        <button :disabled="props.disable" class="btn--plus" @click="changeCounter('1')" type="button" name="button">
            <i class="icon-plus"></i>
        </button>
    </div>
</template>

<script setup>
import {ref,unref} from "@vue/runtime-core";
const emit = defineEmits(['updateCount','limitReach'])
const props = defineProps({
    max: {
        type: Number,
        required: true,
    },
    disable: {
        type: Boolean,
        default: true
    },
    size:{
        type: String,
        default: 'lg'
    },
    value:{
        type: Number,
        default: 1,
    }
});
const counter = props.disable ? 0 : ref(+props.value);
const resetCounter = () =>{
    if (!props.disable)
    counter.value = 1
}

const changeCounter = function(num){
    const nextNumber = +counter.value + +num
    if (!props.disable && props.max >= nextNumber && nextNumber >=0 )
    {
        counter.value += +num
        !isNaN(counter.value) && counter.value > 0 ? counter.value : counter.value = 0;
        emit('updateCount',unref(counter))
    }
    else {
        if(counter.value != 0)
        {
        emit('limitReach');
        }
    }
}
defineExpose({
    counter,
    resetCounter
});
</script>

<style lang="scss" scoped>
*, *::before, *::after {
    box-sizing: border-box;
}
/* Product Quantity */
.cart-count-wrapper {
        background-color: #F3F3F9;

        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        padding: 0 5px;
    &:not(.input-sm)
    {
        width: 110px;
        border-radius: 20px;
        height: 40px;
        .btn--minus, .btn--plus {
            height: 30px;
            width: 30px;
        }
    }
    &.input-sm{
        width: 90px;
        border-radius: 20px;
        height: 26px;
        .btn--minus, .btn--plus {
            height: 20px;
            width: 20px;
        }
    }
}
.btn--minus, .btn--plus
{
    display: flex;

    justify-content: center;
    align-items: center;
    transition: none !important;
    border-radius: 50%;
    &:not([disabled]):hover{
        background-color: #12b3ca;
        color: #fff;
    }
    &[disabled]
    {
        cursor: not-allowed;
    }
    i{
        font-weight: 100;
    }
}
.input-quantity {
    -webkit-appearance: none;
    border: none;
    text-align: center;
    width: 40px;
    height: 100%;
    font-size: 16px;
    color: #43484D;
    font-weight: 500;
    border: none;
    background-color: #F3F3F9;
}

.btn {
    border: 1px solid #E1E8EE;
    width: 30px;
    background-color: #E1E8EE;
    /*   border-radius: 6px; */
    cursor: pointer;
}
button:focus,
input:focus {
    outline:0;
}
</style>
