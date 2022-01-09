<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <transition name="fade">
                    <img v-if="elementVisible" src="/assets/images/dance.gif" alt="" class="center">
                </transition>

            </div>
        </div>
    </div>

</template>
<script>
    export default {
        data(){
            return{
                elementVisible: false
            }
        },
        mounted() {
            window.Echo.channel('points-redeem').listen('PointsReward', (e) => {
                console.log('Hola mundo en tiempo real')

                //Lo hacemos visible
                this.elementVisible = true

                //Lo ocultamos despues de 2 segundos
                setTimeout(() => this.elementVisible = false, 2000)

            })
        },

    }
</script>

<style scoped>
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 70%;
}


</style>
