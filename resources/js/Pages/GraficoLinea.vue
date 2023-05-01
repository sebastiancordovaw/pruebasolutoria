<template>
    <div class="container">
        <div>
            <ul v-if="errores!=null" class="p-4 rounded-sm border-red-400">
                    <li class="text-red-500" v-for="(error,key) in errores" :key ="key">
                    {{ error[0] }}
                    </li>
            </ul>
        </div>
      <label class="mr-3">Desde <input v-model="fechaDesde" type="date"></label>
      <label class="mr-3">Hasta <input  v-model="fechaHasta" type="date"></label>
      <button type="button" @click="BuscarDatos" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mr-2">Crear</button>
      <Bar v-if="loaded" :data="chartData" />
    </div>
  </template>

  <script>
  import axios from 'axios';
  import { Bar } from 'vue-chartjs'
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
  import Swal from 'sweetalert2';
  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

  export default {
    name: 'BarChart',
    components: { Bar },
    data: () => ({
      loaded: false,
      chartData: null,
      errores:null,
      fechaDesde : '',
      fechaHasta:''
    }),
    methods:
    {
         async BuscarDatos(){
            await axios.post('/get-pick-uf/',{'fechaDesde':this.fechaDesde,'fechaHasta':this.fechaHasta})
            .then(response=>
            {
                this.loaded = false
                try {

                    let date = [];
                    let max = [];

                        for(let i =0; i < response.data.length; i++)
                        {
                            date.push(response.data[i].date);
                            max.push(response.data[i].max);
                        }

                        this.chartdata = this.chartData = {
                                                            labels: date,
                                                            datasets: [
                                                            {
                                                                label: 'Data One',
                                                                backgroundColor: '#f87979',
                                                                data: max
                                                            }
                                                        ]
                                                        }
                    this.loaded = true;
                    this.errores = null;
                } catch (e) {
                    console.error(e)
                }


            })
            .catch(error=>
            {
                if(error.response.data.errors)
                {
                    this.errores = error.response.data.errors;
                }

                if(error.response.data.error)
                {
                    Swal.fire(
                    'Ha ocurrido un Error',
                    error.response.data.error,
                    'info'
                    )
                }

            });

        }
    },
    async mounted () {
    }
  }
  </script>
