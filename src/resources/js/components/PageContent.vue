<template>
    <div id="page-content-wrapper">
        <NavBar/>

        <div class="container-fluid">
            <transition name="fade" mode="out-in">
                <router-view></router-view>
            </transition>
        </div>
    </div>
</template>

<script>
  import NavBar from './NavBar';
  export default {
    name: 'PageContent',
    components: {NavBar},
  };
</script>