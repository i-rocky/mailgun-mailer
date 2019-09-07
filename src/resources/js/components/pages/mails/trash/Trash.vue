<template>
    <div class="inbox">
        <h1>Trash</h1>
        <MailList box="trash"/>
    </div>
</template>

<script>
  import MailList from '../../partials/MailList';

  export default {
    name: 'Trash',
    components: {MailList},
  };
</script>
