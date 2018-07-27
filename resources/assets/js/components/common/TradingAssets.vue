<template>
    <div class="assets-strip-wrap">
        <div class="assets-strip" :style="{width: assets.length * 2 * 150 + 'px'}">
            <div class="assets-strip-item" v-for="asset in assets">
                <p>{{asset.name}} <span> {{asset.value}}</span></p><span>{{asset.percentage}}</span>
            </div>
            <div class="assets-strip-item" v-for="asset in assets">
                <p>{{asset.name}} <span> {{asset.value}}</span></p><span>{{asset.percentage}}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "trading-assets",
        data() {
            return {
                assets: [
                    {id: 2, name: 'BTCUSD', value: 1.077770, percentage: '0.258%'},
                    {id: 3, name: 'BTCEUR', value: 1.077770, percentage: '0.258%'},
                    {id: 8, name: 'LTCUSD', value: 1.077770, percentage: '0.258%'},
                    {id: 13,name: 'LTCEUR', value: 1.077770, percentage: '0.258%'},
                    {id: 14,name: 'ETHEUR', value: 1.077770, percentage: '0.258%'},
                    {id: 15,name: 'ETHUSD', value: 1.077770, percentage: '0.258%'},
                    {id: 17,name: 'XRPEUR', value: 1.077770, percentage: '0.258%'},
                    {id: 18,name: 'XRPUSD', value: 1.077770, percentage: '0.258%'},
                    {id: 19,name: 'DASHUSD', value: 1.077770, percentage: '0.258%'},
                    {id: 33,name: 'DASHEUR', value: 1.077770, percentage: '0.258%'},
                ]
            }
        }
    }
</script>

<style scoped>
    .assets-strip-wrap {
        overflow: hidden;
    }
    .assets-strip {
        display: flex;
        background-color: #eee;
        justify-content: space-around;
        flex-wrap: wrap;
    }
    .assets-strip-item {
        width: 150px;
    }
</style>