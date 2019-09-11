<template>
    <div class="composer row">
        <div class="col-md-12">
            <div id="contact-form" role="form">
                <div class="controls row">

                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input id="subject"
                                           type="text"
                                           name="subject"
                                           class="form-control"
                                           v-model="mailMessage.subject"
                                           placeholder="Please enter subject">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea id="message"
                                              name="message"
                                              class="form-control"
                                              placeholder=""
                                              rows="4"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="from_name">Sender Name</label>
                                    <input id="from_name"
                                           type="text"
                                           name="sender_name"
                                           class="form-control"
                                           v-model="mailMessage.sender_name"
                                           placeholder="Please enter sender name">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="from_email">Sender Email</label>
                                    <div class="input-group">
                                        <input id="from_email"
                                               type="text"
                                               name="sender_email"
                                               class="form-control"
                                               v-model="mailMessage.sender_email"
                                               placeholder="Please enter sender email">
                                        <div class="input-group-append">
                                            <span class="input-group-text">@clearequityrelease.co.uk</span>
                                        </div>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="recipient_name">Recipient Name</label>
                                    <input id="recipient_name"
                                           type="text"
                                           name="recipient_name"
                                           class="form-control"
                                           v-model="mailMessage.recipient_name"
                                           placeholder="Please enter recipient name">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="recipient_email">Recipient Email</label>
                                    <input id="recipient_email"
                                           type="text"
                                           name="recipient_email"
                                           class="form-control"
                                           v-model="mailMessage.recipient_email"
                                           placeholder="Please enter recipient email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-md-12 right">
                                <button
                                        class="btn btn-success btn-send"
                                        :disabled="sending"
                                        @click="send">
                                    <i v-if="sending" class="fa fa-spin fa-spinner"></i>
                                    <span v-else>Send</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
  import tinymce from 'tinymce';
  import debounce from 'debounce';
  import {cloneDeep} from 'lodash';
  import MailMessage from '../../../models/MailMessage';
  import MailMessageFactory from '../../../factories/MailMessageFactory';
  import MailMessageAPI from '../../../MailMessageAPI';
  import message from '../../../helpers/message';

  let mailEditor;

  export default {
    name: 'Composer',
    props: {
      value: MailMessage,
    },
    data() {
      return {
        mailMessage: MailMessageFactory.getDummy(),
        sending: false,
      };
    },
    mounted() {
      if (this.value) {
        this.mailMessage = cloneDeep(this.value);
      }
      this.mailUpdated = debounce(this.updateBody, 300);
      this.initializeMailEditor()
          .then(e => {
            this.updateEditor(this.mailMessage.body);
          });
    },
    beforeDestroy() {
      mailEditor.destroy();
      mailEditor = null;
    },
    methods: {
      initializeMailEditor() {
        return new Promise((resolve) => {
          this.initializeEditor('#message', ed => {
            mailEditor = ed;
            ed.on('change', () => {
              this.mailUpdated();
            });
            ed.on('init', e => resolve(e));
          });
        });
      },
      initializeEditor(selector, callback) {
        tinymce.init({
          selector,
          plugins: 'advlist autolink link image lists charmap print preview hr anchor pagebreak,' +
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking,' +
            'save table directionality emoticons template paste',
          toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview fullpage | forecolor backcolor emoticons | fullscreen',
          height: 600,
          setup: callback,
        });
      },
      updateBody() {
        this.mailMessage.body = mailEditor.getContent();
      },
      updateEditor(content) {
        mailEditor.setContent(content);
      },
      doNothing() {

      },
      send() {
        this.sending = true;
        MailMessageAPI
          .send(this.mailMessage)
          .then(response => {
            message.success(response.message);
            this.$router.push({name: 'sent'});
          })
          .catch(error => {
            message.error(error.message);
          })
          .finally(() => {
            this.sending = false;
          });
      },
    },
    computed: {
      hostname() {
        return `@${window.location.host.replace('admin.', '')}`;
      },
    },
    watch: {
      value() {
        this.mailMessage = cloneDeep(this.value);
        mailEditor.assetContent(this.mailMessage.body);
      },
      mailMessage() {
        this.$emit('input', this.mailMessage);
      },
    },
  };
</script>

<style scoped>
    label {
        font-weight: bold;
    }
</style>