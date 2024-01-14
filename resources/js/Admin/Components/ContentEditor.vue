<template>
    <div style="width: 100%" >
        <QuillEditor :key="editorKey" theme="snow" :modules="modules" v-model:content="editorValue" contentType="html" :toolbar="toolbarOptions"/>
    </div>
</template>
<script setup>
import { QuillEditor , Quill } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import {ref,toRefs,watch,onMounted} from 'vue';
import htmlEditButton from 'quill-html-edit-button';
const props = defineProps({
    toolbarOptions: {
        type: Object,
        default:[['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            // ['blockquote', 'code-block'],

            [{ 'header': 1 }, { 'header': 2 }],               // custom button values
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            // [{ 'script': 'sub' }, { 'script': 'super' }],     // superscript/subscript
            [{ 'indent': '-1' }, { 'indent': '+1' }],         // outdent/indent
            // [{ 'direction': 'rtl' }],                         // text direction

            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            // [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

            // [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            // [{ 'font': [] }],
            // [{ 'align': [] }],

            // ['link', 'video', 'image'],
            ['link'],

            ['clean']
            ['html']
        ]
    },
    modelValue: {
        type: String,
        default: '',
    },
    editorHeight:{
        type:String,
        default:'250px'
    }
});

const modules = {
    name:'html',
    module:htmlEditButton,
    options:{
            debug: true, // logging, default:false
            msg: "Edit the content in HTML format", //Custom message to display in the editor, default: Edit HTML here, when you click "OK" the quill editor's contents will be replaced
            okText: "OK", // Text to display in the OK button, default: Ok,
            cancelText: "Cancel", // Text to display in the cancel button, default: Cancel
            buttonHTML: "HTML", // Text to display in the toolbar button, default: <>
            buttonTitle: "View HTML", // Text to display as the tooltip for the toolbar button, default: Show HTML source
            syntax: false, // Show the HTML with syntax highlighting. Requires highlightjs on window.hljs (similar to Quill itself), default: false
           // a string used to select where you want to insert the overlayContainer, default: null (appends to body),
            editorModules: {} // The default mod

    }
}
const emit = defineEmits(['update:modelValue']);
const { modelValue } = toRefs(props);
const editorValue = ref(modelValue.value);
const editorKey = ref(0);
const editorHeight = '250px';
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
onMounted(()=>{
   document.documentElement.style.setProperty('--ql-container-height', props.editorHeight);
})
</script>
<style>
:root {
    --ql-container-height: 250px;
}
.ql-container{
    height: var(--ql-container-height) ;
}
.ql-snow.ql-toolbar button[title='View HTML']{
    display: contents;
}
.ql-html-buttonGroup
{
    bottom: -24px !important;
}
.ql-html-buttonCancel
{
    border:1px solid gray;
    font-size: 14px;
    padding: 0 5px;
    border-radius: 3px;
    background-color: whitesmoke;
}
.ql-html-buttonOk
{
    border:1px solid gray;
    font-size: 14px;
    padding: 0 10px;
    border-radius: 3px;
}
</style>
