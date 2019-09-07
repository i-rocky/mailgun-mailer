<template>
    <div class="inbox">
        <h1>Sent</h1>
        <MailList box="sent"/>
    </div>
</template>

<script>
  import MailList from '../../partials/MailList';

  export default {
    name: 'Sent',
    components: {MailList},
  };
</script>
