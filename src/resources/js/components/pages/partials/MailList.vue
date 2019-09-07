<template>
    <div class="mail-list">
        <table class="table">
            <tbody>
            <tr v-for="mail in mails" :key="mail.id" @click="goToMail(mail)">
                <th scope="row" style="width:20px">
                    <input type="checkbox" value="mail.id" @click.stop>
                </th>
                <td style="width:20px">
                    <i v-if="!mail.read" class="fa fa-circle"></i>
                </td>
                <td style="width:150px" v-text="mail.sender_name"></td>
                <td v-html="mail.excerpt"></td>
                <td style="width: 120px" v-text="mail.read_at.format('DD/MM/YYYY')"></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
  import MailMessageAPI from '../../../MailMessageAPI';
  import message from '../../../helpers/message';

  export default {
    name: 'MailList',
    props: {
      box: String,
    },
    data() {
      return {
        mails: [],
      };
    },
    mounted() {
      this.loadMails();
    },
    methods: {
      loadMails() {
        MailMessageAPI
          .get(this.box)
          .then(mails => {
            this.mails = mails;
          })
          .catch(error => {
            message.error(error.message);
          });
      },
      goToMail(mail) {
        console.log(mail);
      },
    },
  };
</script>

<style scoped>
    tr:hover {
        -webkit-box-shadow: 0 1px 2px 0 #120617;
        box-shadow: 0 1px 2px 0 #120617;
        cursor: pointer;
    }

    td {
        max-width: 0;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>