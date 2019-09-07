<template>
    <div class="inbox">
        <MailList/>
    </div>
</template>

<script>
  import MailList from '../partials/MailList';

  export default {
    name: 'Inbox',
    components: {MailList},
  };
</script>
