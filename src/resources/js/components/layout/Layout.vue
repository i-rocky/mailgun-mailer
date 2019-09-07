<template>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <Sidebar/>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <PageContent/>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
</template>

<script>
  import Sidebar from './Sidebar';
  import PageContent from './PageContent';
  export default {
    name: 'Layout',
    components: {PageContent, Sidebar},
  };
</script>