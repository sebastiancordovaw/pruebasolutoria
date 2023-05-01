<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import GraficoLinea from '@/Pages/GraficoLinea.vue';
export default{
    setup()
    {

    },
    components:{
        AppLayout,
        GraficoLinea
    }
}
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <grafico-linea></grafico-linea>
                </div>
            </div>
        </div>
    </AppLayout>
</template>



