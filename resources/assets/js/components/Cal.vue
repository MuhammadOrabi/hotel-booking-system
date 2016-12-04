<template>
	<div>
		<div class="row">
	        <div class="col-md-10">
	            <div class="well">
	            	<span v-for="n in 6" v-if="n == test">{{ test }}</span>
	            	<h2 class="text-center">{{ now }}</h2>
	            	<div class="row">
		            	<div class="col-md-offset-4 col-md-4">
			                <input type="date" class="form-control" v-model="newDate">
		                </div>
	                	<button class="btn btn-default" @click="getbyDate" v-if="newDate != '' ">Get</button>
	                </div>
	            </div>
	            <div class="content-box-large" v-for="room in rooms">
	            	<h3 class="text-center">{{ room.type.name }}</h3>
	                <div class="table-responsive ">
	                    <table class="table table-hover">
	                        <thead>
	                            <tr>
	                                <th class="text-center info" v-for="name in names">{{ name }}</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            <tr class="odd gradeX" v-for="row in nos">
	                                <td class="text-center" v-for="(value, key) in row" :id="value">{{ value }} </td>
	                        	</tr>
	                        </tbody>
	                    </table>
	                </div>
	  			</div>
	        </div>
        </div>
        <div class="row">
	        <div class="col-md-10">
	            <div class="content-box-large">
	                <h2 class="text-center">Rooms Reservations</h2>
	                <div class="table-responsive ">
	                    <table class="table table-hover">
	                		<thead>
	                            <tr>
	                                <th class="text-center info">room type</th>
	                                <th class="text-center info">room Numbers</th>
	                            </tr>
	                        </thead>
	                        <tbody v-for="row in rooms">
	                            <tr class="odd gradeX">
	                                <td class="text-center">{{ row.type.name }} </td>
	                                <td class="text-center" v-for="(value, key) in row.rooms">{{ value.id }} </td>
	                        	</tr>
	                        	<tr class="odd gradeX">
	                                <td class="text-center">Reservations</td>
	                                <td class="text-center" v-for="(room, index) in row.rooms">
	                                	<span v-for="res in room.reservations">
	                                		{{ res.in_day }} - {{ res.in_month }} - {{ res.in_year }}
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
		props: ['date'],
		data(){
			return{
				nos: [],
				names: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
				now:'',
				newDate:'',
				rooms: [],
				test: 2
			}
		},
		created(){
			this.fetchData()
			socket.on('admin-channel:BookingRoom', function(message) {
				console.log("Update");
				this.fetchData();
			}.bind(this));
		},
		mounted: function () {
						
		},
		methods: {
			getbyDate(){
				this.$http.post('/api/postCalandar',{date: this.newDate}).then((response) => {
					console.log(response);

					this.nos = response.body.nos;				    
					this.now = response.body.now;				    
					this.rooms = response.body.rooms;				    
				}, (response) => {
					console.log(response)
				});
			},
			fetchData(){
				this.$http.post('/api/postCalandar',{date: this.date}).then((response) => {
					console.log("it came :)");

					this.nos = response.body.nos;				    
					this.now = response.body.now;				    
					this.rooms = response.body.rooms;				    
				}, (response) => {
					console.log(response)
				});
			}
		}
	}
</script>