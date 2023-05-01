<script>
import { ref, onMounted, onUpdated } from 'vue';
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import ModalCreateIndicador from "@/Custom/indicadores/ModalCreateIndicador.vue";
import ModalUpdateIndicador from "@/Custom/indicadores/ModalUpdateIndicador.vue";


import Swal from 'sweetalert2'

const indicador = ref({});
/*******PAGINADOR******/
const indicadores = ref([]);
const pages = ref(0);
const page = ref(1);

/********Create*****/
const ModalCreateShow = ref(false);
/*******Update******/
const ModalUpdateShow = ref(false);

export default{
    setup()
    {
        onMounted(()=>{
            getIndicadores();
        });

        const getIndicadores = async() =>{
            await axios.get('/get-indicadores/'+page.value)
            .then(response=>
            {
                indicadores.value = response.data.data;
                pages.value = response.data.page_count;
            });
        }

         //CREATE
        const openCreateIndicador = () => {
            ModalCreateShow.value = !ModalCreateShow.value;
        }

        //UPDATE
        const openUpdateIndicador = (indicadorSeleccionado) => {
            ModalUpdateShow.value = !ModalUpdateShow.value;
            indicador.value = indicadorSeleccionado;
        }

        const closeCreate = ()=>{
            ModalCreateShow.value = !ModalCreateShow.value;
        }

        const closeUpdate = ()=>{
            ModalUpdateShow.value = !ModalUpdateShow.value;
        }

        const borrarIndicador =  (indicadorSeleccionado) => {
            Swal.fire({
                        title: 'Estas seguro de eliminar indicador de id : '+indicadorSeleccionado.id,
                        text: "Este cambio es irreversible!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Borrar'
                        }).then(async (result) => {
                        if (result.isConfirmed) {
                            await axios.delete('/indicador/'+indicadorSeleccionado.id)
                            .then(response=>
                            {
                                getIndicadores();
                            });
                        }
            });
        }

        return {
            page,
            pages,
            indicadores,
            indicador,
            getIndicadores,
            openUpdateIndicador,
            ModalUpdateShow,
            closeUpdate,
            borrarIndicador,
            openCreateIndicador,
            ModalCreateShow,
            closeCreate
        }
    },
    components:{
        VPagination,
        ModalUpdateIndicador,
        ModalCreateIndicador
    }
}
</script>

<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <a href="indicadores" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mr-2 mb-2 float-left">Obtener indicadores desde la API</a>
        <button type="submit" @click="openCreateIndicador" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mr-2 mb-2 float-right">Crear Indicador</button>
        <table class="w-full text-sm text-left text-blue-100 dark:text-blue-100">
            <thead class="text-xs text-white uppercase bg-blue-600 dark:text-white">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre Indicador
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Código
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Unidad Medida
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Valor
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tiempo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Origen
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>

                <tr class="bg-blue-500 border-b border-blue-400" v-for="(indicador, key ) in indicadores" :key="key">
                    <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
                        {{ indicador.nombreIndicador }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
                        {{ indicador.codigoIndicador }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
                        {{ indicador.unidadMedidaIndicador }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
                        {{ indicador.valorIndicador }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
                        {{ indicador.fechaIndicador }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
                        {{ indicador.tiempoIndicador }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
                        {{ indicador.origenIndicador }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">

                        <svg xmlns="http://www.w3.org/2000/svg" @click="openUpdateIndicador(indicador)" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left mr-1 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" @click="borrarIndicador(indicador)" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 float-left mr-1 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </th>
                </tr>
            </tbody>
        </table>

        <modal-update-indicador :show="ModalUpdateShow" :indicador="indicador" @show="closeUpdate" @reloadTable = "getIndicadores"></modal-update-indicador>
        <modal-create-indicador :show="ModalCreateShow" @show="closeCreate" @reloadTable = "getIndicadores"> </modal-create-indicador>


        <v-pagination
    v-model="page"
    :pages="pages"
    :range-size="1"
    active-color="#3498db"
    @update:modelValue="getIndicadores"
    />
    </div>
</template>
<style>
.Page.Page-active{
    color:white !important;
}
</style>
