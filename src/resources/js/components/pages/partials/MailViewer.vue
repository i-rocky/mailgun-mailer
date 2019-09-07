<template>
    <iframe ref="iframe" frameborder="0"></iframe>
</template>

<script>
  export default {
    name: 'MailViewer',
    props: {
      body: String,
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
      this.el.innerHTML = this.body;
    },
    watch: {
      body() {
        this.el.innerHTML = this.body;
      },
    },
  };
</script>