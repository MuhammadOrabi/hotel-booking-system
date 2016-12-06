<template>
	<div>
		<div class="row">
	        <div class="col-md-10">
	            <div class="content-box-large">
	                <div class="well">
		            	<h1 class="text-center">{{ type }}</h1>
		            	<h2 class="text-center">{{ now }}</h2>
		            	<div class="row">
			            	<div class="col-md-offset-4 col-md-4">
				                <input type="date" class="form-control" v-model="newDate">
			                </div>
		                	<button class="btn btn-default" @click="getbyDate" v-if="newDate != '' ">Get</button>
		                </div>
		            </div>
	                <div class="table-responsive ">
	                    <table class="table table-hover">
	                        <thead>
	                            <tr>
	                                <th class="text-center info" v-for="name in names">{{ name }}</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            <tr class="odd gradeX" v-for="row in nos">
	                                <td class="text-center" v-for="(value, key) in row" :name="value"> 
	                                	{{ value }} <br> 
	                                	<span v-if="value > 0">
		                                	Busy rooms: {{ countBusy(value) }} 
		                                	<br>
		                                	Free rooms: {{ rooms - countBusy(value) > 0 ? rooms - countBusy(value) : 0}}
	                                	</span>
	                                </td>
	                        	</tr>
	                        </tbody>
	                    </table>
	                </div>
	  			</div>
	        </div>
        </div>
    </div>
</template>

<script>
	
	import  Vue from 'vue'
	import axios from 'axios'
	var socket = io('http://localhost:3000');
	
	export default {
		props: ['date', 'type'],
		data(){
			return{
				nos: [],
				names: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
				now:'',
				newDate:'',
				month: 0,
				reservations: [],
				mint: 0,
				rooms: 0
			}
		},
		created(){
			this.fetchData();
			socket.on('admin-channel:BookingRoom', function(message) {
				console.log("Updating.....");
				if(this.newDate != '')
				{
					this.getbyDate();
				}else{
					this.fetchData();
				}
			}.bind(this));
		},
		methods: {
			getbyDate(){
				this.$http.post('/api/postCalandar',{date: this.newDate, type: this.type}).then((response) => {
					this.nos = response.body.nos;				    
					this.now = response.body.now;
					this.month = response.body.month;
					this.reservations = response.body.reservations;
					this.rooms = response.body.rooms;		    
				}, (response) => {
					console.log(response)
				});
			},
			fetchData(){
				this.$http.post('/api/postCalandar',{date: this.date, type: this.type}).then((response) => {
					this.nos = response.body.nos;				    
					this.now = response.body.now;
					this.month = response.body.month;
					this.rooms = response.body.rooms;
					this.reservations = response.body.reservations;
				}, (response) => {
					console.log(response)
				});
			},
			countBusy(day){
				var count = 0;
				this.reservations.forEach(function(res) {
					if (res.in_month == this.month) {
						if (day >= res.in_day && day <= res.out_day && res.out_month == this.month) {
							count += 1;
						}else if(day >= res.in_day && day <= res.out_day && res.out_month > this.month){
							count += 1;
						}
					}else if(res.out_month == this.month){
						if (day <= res.out_day) {
							count += 1;
						}
					}
				}.bind(this));
				return count;
			}
		}
	}
</script>