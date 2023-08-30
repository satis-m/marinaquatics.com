<template>
    <transition name="modal-fade">
        <div class="modal-overlay" @click="emit('close-modal')">
            <div class="modal" @click.stop>
                <div class="modal-header">
                    <slot name="header">
                        Saved!
                    </slot>
                </div>
                <div class="modal-body">
                <slot name="body">
                    <p>Your Details have been saved Successfully</p>
                </slot>
                </div>
                <div class="modal-footer">
                <slot name="footer">
                    <button>Ok</button>
                </slot>
                </div>
            </div>
        </div>
    </transition>
</template>
<script setup>

const emit =  defineEmits(['close-modal'])
</script>
<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #000000bd;
    z-index: 101;
}
.modal {
    text-align: center;
    background-color: white;
    min-width: 500px;
    border-radius: 10px;
    padding: 20px;
}

@media (width <= 600px) {

    .modal {
        min-width: unset;
        width: 100%;
    }
}


.check {
    width: 150px;
}

h6 {
    font-weight: 500;
    font-size: 28px;
    margin: 20px 0;
}

p {
    /* font-weight: 500; */
    font-size: 16px;
    margin: 20px 0;
}

.btn-danger {
    background-color: var(--tp-heading-secondary);
    min-width: 100px;
    height: 40px;
    color: white;
    font-size: 16px;
    border-radius: 10px;
    margin-top: 20px;
    font-weight: 600;
    display: inline-block;
}

.modal-fade-enter,
.modal-fade-leave-to {
    opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.5s ease;
}
.modal-header
{
    font-size: 22px;
    font-weight: 600;
    color: var(--tp-heading-primary);
    text-align: left;
    border-bottom: 1px solid #a7a7a7;
    margin-bottom: 20px;
    text-transform: capitalize;
}
.modal-footer
{
    display: flex;
    justify-content: flex-end;
    align-items: center;
    column-gap: 20px;
}

</style>

<style>
.modal-footer .btn{
    border: 1px solid lightgray;
    padding: 5px 20px;
    border-radius: 6px;
}
.modal-footer .btn.btn-danger{
    border: 1px solid var(--tp-heading-secondary);
    background-color: var(--tp-heading-secondary);
    color: var(--tp-common-white);
}
.modal-footer .btn.btn-danger:hover{
    border: 1px solid #859A00;
    background-color: #859A00;
    color: var(--tp-common-white);
}

.modal-footer .btn:hover{
    border: 1px solid #859A00;
    background-color: #f2f2f6;
}
</style>
