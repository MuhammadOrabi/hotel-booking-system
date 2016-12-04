<template>
	<div class="row">
        <div class="col-md-10">
            <div class="content-box-large">
                <h2 class="text-center">{{ now }}</h2>
                <input type="date" v-model="newDate">
                <button class="btn btn-default" @click="getbyDate" v-if="newDate != '' ">Get</button>
                <div class="table-responsive ">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center info" v-for="name in names">{{ name }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="odd gradeX" v-for="row in nos">
                                <td class="text-center" v-for="(value, key) in row">{{ value }}</td>
                        	</tr>
                        </tbody>
                    </table>
                </div>
  			</div>
        </div>
</template>

<script>
	
	import  Vue from 'vue'
	import axios from 'axios'
	
	export default {
		props: ['date'],
		data(){
			return{
				nos: [],
				names: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
				now:'',
				newDate:''
			}
		},
		created(){
			this.fetchData()
		},
		methods: {
			getbyDate(){
				this.$http.post('/api/postCalandar',{date: this.newDate}).then((response) => {
					console.log(response);

					this.nos = response.body.nos;				    
					this.now = response.body.now;				    
				}, (response) => {
					console.log(response)
				});
			},
			fetchData(){
				this.$http.post('/api/postCalandar',{date: this.date}).then((response) => {
					console.log(response);

					this.nos = response.body.nos;				    
					this.now = response.body.now;				    
				}, (response) => {
					console.log(response)
				});
			}
		}
	}
</script>