<template>
    <iframe ref="iframe" frameborder="0"></iframe>
</template>

<script>
  export default {
    name: 'IFrame',
    props: {
      content: String,
    },
    data() {
      return {
        document: null,
        el: null,
        window: null,
      };
    },
    mounted() {
      this.document = this.$refs.iframe.contentDocument;
      this.window = this.$refs.iframe.contentWindow;
      this.el = this.document.createElement('div');
      this.document.body.appendChild(this.el);
      this.el.innerHTML = this.content;
      this.resetHeight();
    },
    methods: {
      resetHeight() {
        this.$nextTick(() => {
          this.$refs.iframe.height = this.window.document.documentElement.scrollHeight ||
            this.window.document.body.scrollHeight;
        });
      },
    },
    watch: {
      content() {
        this.el.innerHTML = this.content;
        this.resetHeight();
      },
    },
  };
</script>