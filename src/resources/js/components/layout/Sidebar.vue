<template>
    <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">Mailgun Mailer</div>
        <div class="list-group list-group-flush">
            <router-link
                    :to="{name: 'compose'}"
                    class="list-group-item list-group-item-action bg-light">
                Compose
            </router-link>
            <router-link
                    :to="{name: 'inbox'}"
                    class="list-group-item list-group-item-action bg-light">
                Inbox
            </router-link>
            <router-link
                    :to="{name: 'sent'}"
                    class="list-group-item list-group-item-action bg-light">
                Sent
            </router-link>
            <router-link
                    :to="{name: 'trash'}"
                    class="list-group-item list-group-item-action bg-light">
                Trash
            </router-link>
            <router-link
                    :to="{name: 'templates'}"
                    class="list-group-item list-group-item-action bg-light">
                Templates
            </router-link>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'Sidebar',
  };
</script>