<script>
import { ref } from 'vue';
import axios from 'axios';
import Modal from '@/Components/Modal.vue'

const errores = ref(null);

const nombreIndicador = ref('');
const codigoIndicador = ref('');
const unidadMedidaIndicador = ref('');
const valorIndicador = ref(0);
const fechaIndicador = ref('');
const tiempoIndicador = ref('');
const origenIndicador = ref('');
export default{
    emits:['show','reloadTable'],
    setup(props,{emit})
    {
        const crearIndicador = async () =>
        {
            let formData = new URLSearchParams();
            formData.append("nombreIndicador", nombreIndicador.value);
            formData.append("codigoIndicador", codigoIndicador.value);
            formData.append("unidadMedidaIndicador", unidadMedidaIndicador.value);
            formData.append("valorIndicador", valorIndicador.value);
            formData.append("fechaIndicador", fechaIndicador.value);
            formData.append("tiempoIndicador", tiempoIndicador.value);
            formData.append("origenIndicador", origenIndicador.value);

            const AxiosConfig = {
                method: 'POST',
                url: '/indicador',
                data: formData,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                }
            };

            await axios(AxiosConfig)
            .then(response=>
            {
                errores.value = null;
                emit('reloadTable');
                emit('show');
            })
            .catch(error=>
            {
                if(error.response.status === 422)
                {
                    errores.value = error.response.data.errors;
                }
            });
        }

        const ChangeStateModal = () =>{
            emit('show');
            errores.value = null;
        }

        return {
            ChangeStateModal,
            crearIndicador,
            errores,
            nombreIndicador,
            codigoIndicador,
            unidadMedidaIndicador,
            valorIndicador,
            fechaIndicador,
            tiempoIndicador,
            origenIndicador
        }
    },
    components:{
        Modal
    },
    props:['show']
}
</script>

<template>

<modal :show = "show" @close="ChangeStateModal">
    <div class="border-b border-gray-900/10 p-10">
        <div>
            <ul v-if="errores!=null" class="p-4 rounded-sm border-red-400">
                 <li class="text-red-500" v-for="(error,key) in errores" :key ="key">
                    {{ error[0] }}
                 </li>
            </ul>
        </div>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="nombreIndicador" class="block text-sm font-medium leading-6 text-gray-900">Nombre Indicador</label>
                <div class="mt-2">
                <input type="text" v-model="nombreIndicador" id="nombreIndicador" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="codigoIndicador" class="block text-sm font-medium leading-6 text-gray-900">Código</label>
                <div class="mt-2">
                <input type="text" v-model="codigoIndicador" id="codigoIndicador" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="unidadMedidaIndicador" class="block text-sm font-medium leading-6 text-gray-900">Unidad Medida</label>
                <div class="mt-2">
                <input type="text" v-model="unidadMedidaIndicador" id="unidadMedidaIndicador" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="valorIndicador" class="block text-sm font-medium leading-6 text-gray-900">Valor</label>
                <div class="mt-2">
                <input type="text" v-model="valorIndicador" id="valorIndicador" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="fechaIndicador" class="block text-sm font-medium leading-6 text-gray-900">Fecha</label>
                <div class="mt-2">
                <input type="date" v-model="fechaIndicador" id="fechaIndicador" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="tiempoIndicador" class="block text-sm font-medium leading-6 text-gray-900">Tiempo</label>
                <div class="mt-2">
                <input type="datetime-local" v-model="tiempoIndicador" id="tiempoIndicador" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>

            <div class="sm:col-span-6">
                <label for="origenIndicador" class="block text-sm font-medium leading-6 text-gray-900">Origen</label>
                <div class="mt-2">
                <input type="text" v-model="origenIndicador" id="origenIndicador" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" @click="crearIndicador" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mr-2">Crear</button>
            <button type="button" @click="ChangeStateModal" class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancelar</button>
        </div>

    </div>
</modal>
</template>

