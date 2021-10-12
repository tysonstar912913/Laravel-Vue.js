<template>
  <transition name="modal-fade">
    <div class="modal-backdrop">
      <div
        class="modal"
        v-bind:class="modalSize"
        role="dialog"
        aria-labelledby="modalTitle"
        aria-describedby="modalDescription"
      >
        <header class="modal-header" id="modalTitle">
          <slot name="header">
            Modal Title
          </slot>
          <button
            type="button"
            class="btn-close"
            @click="close"
            aria-label="Close modal"
            v-if="showBtn"
          >
            ×
          </button>
        </header>

        <section class="modal-body" id="modalDescription">
          <slot name="body">
            Modal Body
          </slot>
        </section>

        <footer class="modal-footer">
          <slot name="footer">
            Modal Footer
          </slot>
        </footer>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'Modal',
  props: ['showBtn', 'modalSize'],
  methods: {
    close() {
      this.$emit('close')
    },
  },
}
</script>

<style>
.modal-backdrop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(200, 200, 200, 0.6);
  display: flex;
  justify-content: center;
  align-items: flex-start;
  opacity: 1;
}

.modal {
  background: #ffffff;
  box-shadow: 3px 3px 7px 0px #b1b1b1, 2px 3px 1px 0px #9a9a9a;
  overflow-x: auto;
  display: flex;
  flex-direction: column;
  position: absolute;
  top: 10%;
  left: 50%;
  transform: translateX(-50%);
  max-height: 80%;
  height: unset;
  border-radius: 12px;
  padding: 24px;
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 15px;
  font-weight: 700;
  color: #333333;
  font-family: Lato, sans-serif;
  padding: 0;
  border: none;
  margin: 0 0 16px 0;
}

.modal-footer {
  border: none;
  flex-direction: column;
  padding: 0;
  margin: 16px 0 0 0;
  display: flex;
}

.modal-body {
  padding: 0;
  overflow-y: auto;
}

.btn-close {
  border: none;
  /* font-size: 20px;
  cursor: pointer;
  font-weight: bold;
  color: #333333; */
  font-size: 28px;
  position: relative;
  background: transparent;
}

.close-icon {
  position: absolute;
  left: -10px;
    background: #fff;
    width: 30px;
    top: -10px;
    height: 30px;
}

.close-icon::before {
  position: absolute;
  content: '';
  top: 0;
  left: 0;
  width: 20px;
  height: 2px;
  border-radius: 1px;
  background-color: #a3a3a3;
  transform: rotate(-45deg);
}
.close-icon::after {
  position: absolute;
  content: '';
  top: 0;
  left: 0;
  width: 20px;
  height: 2px;
  border-radius: 1px;
  background-color: #a3a3a3;
  transform: rotate(45deg);
}

.btn-green {
  color: white;
  background: #4aae9b;
  border: 1px solid #4aae9b;
  border-radius: 2px;
}

.modal-fade-enter,
.modal-fade-leave-to {
  opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}

.modal-lg {
  max-width: 980px;
}

.modal-md {
  max-width: 750px;
}

.modal-sm {
  max-width: 450px;
}
</style>
