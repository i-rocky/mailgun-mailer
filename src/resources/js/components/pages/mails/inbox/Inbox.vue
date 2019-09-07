<template>
    <div class="inbox">
        <h1>Inbox</h1>
        <MailList box="inbox"/>
    </div>
</template>

<script>
  import MailList from '../../partials/MailList';

  export default {
    name: 'Inbox',
    components: {MailList},
  };
</script>
