<template>
    <div style="width: 100%" >
        <QuillEditor :key="editorKey" theme="snow" v-model:content="editorValue" contentType="html" :toolbar="toolbarOptions"/>
    </div>
</template>
<script setup>
import { QuillEditor , Quill } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import {ref,toRefs,watch} from 'vue';


const toolbarOptions = [['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    // ['blockquote', 'code-block'],

    // [{ 'header': 1 }, { 'header': 2 }],               // custom button values
    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
    // [{ 'script': 'sub' }, { 'script': 'super' }],     // superscript/subscript
    [{ 'indent': '-1' }, { 'indent': '+1' }],         // outdent/indent
    // [{ 'direction': 'rtl' }],                         // text direction

    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
    // [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

    // [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
    // [{ 'font': [] }],
    [{ 'align': [] }],

    // ['link', 'video', 'image'],
    ['link'],

    ['clean'] ]
const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
});
const emit = defineEmits(['update:modelValue']);
const { modelValue } = toRefs(props);
const editorValue = ref(modelValue.value);
const editorKey = ref(0);
watch(modelValue, (newValue) => {
    editorValue.value = newValue;
});
watch(editorValue, (newValue) => {
    emit('update:modelValue', newValue);
});
const clearContent = ()=>{
    editorValue.value = ''
    editorKey.value += 1;
}
defineExpose({clearContent})
</script>
<style>
.ql-container{
    height: 250px;
}
</style>
