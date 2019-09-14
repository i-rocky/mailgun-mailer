<template>
    <div class="mail">

        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <td>Sender</td>
                        <td v-text="mail.sender"></td>
                    </tr>
                    <tr>
                        <td>Recipient</td>
                        <td v-text="mail.recipient"></td>
                    </tr>
                    <tr>
                        <td>Time</td>
                        <td v-text="mail.time"></td>
                    </tr>
                    <tr>
                        <td>Subject</td>
                        <td v-text="mail.subject"></td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-8">
                <IFrame :content="mail.body" style="width: 100%"/>
            </div>
            <div class="col-md-3">
                <h3>Attachments</h3>
                <ul class="list">
                    <li v-for="attachment in mail.attachments" :key="attachment.id">
                        <a :href="attachment.url" v-text="attachment.name" target="_blank"></a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</template>

<script>

  import IFrame from '../../partials/IFrame';
  import MailMessageFactory from '../../../../factories/MailMessageFactory';
  import MailMessageAPI from '../../../../MailMessageAPI';

  export default {
    name: 'Mail',
    components: {IFrame},
    data() {
      return {
        mail: MailMessageFactory.getDummy(),
      };
    },
    mounted() {
      this.loadMail();
    },
    methods: {
      loadMail() {
        MailMessageAPI
          .view(this.$route.params.mail_id)
          .then(mail => {
            this.mail = mail;
          })
          .catch(error => {
            console.log(error);
          });
      },
    },
  };
</script>