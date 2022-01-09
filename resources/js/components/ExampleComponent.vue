<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            window.Echo.channel('points-redeem').listen('PointsReward', (e) => {
                console.log('Hola mundo en tiempo real')
            })
        }
    }
</script>
