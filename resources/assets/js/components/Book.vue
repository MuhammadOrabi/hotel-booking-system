<template>
	<div>
		<div class="row">
	        <div class="col-md-10">
	        	<div class="alert alert-danger" v-if="errors != null" role="alert">
	        		<ul>
	        			<li v-for="error in errors"><strong v-for="msg in error">{{msg}}</strong></li>
	        		</ul>
	        	</div>
	        	<div class="alert alert-success" v-if="success != null" role="alert">
        			<strong class="text-center">{{success}}</strong>
	        	</div>
	            <div class="well">
	            	<div class="form-inline" v-if="dateStep">
		                <div class="form-group">
		                    <label for="in">Check-In</label>
		                    <input type="date" id="in" class="form-control" v-model="checkIn" min="2016-10-31">
		                    <label for="out">Check-Out</label>
		                    <input type="date" id="out" class="form-control" v-model="checkOut" min="2016-10-31">
		                </div>
		                <div class="form-group">
		                    <button class="btn btn-primary" v-if="checkOut > checkIn" @click="getTypes" >Next Step</button>
		                </div>
		            </div>
		            <div v-if="typeStep">
		            	<select class="form-control" v-model="selectedType">
						    <option v-for="type in types">{{ type.name }}</option>
						</select>
						<button class="btn btn-primary" v-if="selectedType != '' " @click="getInfo">Next Step</button>
		            </div>
		            <div v-if="infoStep">
		            	<div class="form-group">
		            		<div class="row">
			                    <div class="col-sm-5">
			                      <input type="text" class="form-control" v-model.lazy="ssn" placeholder="SSN(Social Security Number)">
			                    </div>
		                    </div>
		                </div>
		                <div class="form-group">
			                <div class="row">
			                    <div class="col-sm-5">
			                      <input type="text" class="form-control" v-model.lazy="name" placeholder="name">
			                    </div>
			                </div>
		                </div>
		                <div class="form-group">
		                    <div class="row">
			                    <div class="col-sm-5">
			                      <input type="email" class="form-control" v-model.trim.lazy="email" placeholder="email">
			                    </div>
		                    </div>
		                </div>
                		<div class="form-group">
                			<div class="row">
			                    <div class="col-sm-5">
			                    	<button class="btn btn-primary" @click="book" v-if="ssn != '' && name != '' && email != '' ">Book</button>
			                    </div>
			                </div>
		                </div>
		            </div>
	        	</div>
        	</div>
    	</div>
    </div>
</template>

<script>
	import  Vue from 'vue'
	var socket = io('http://localhost:3000');
	export default{
		props:[],
		data(){
			return{
				checkIn:'',
				checkOut:'',
				dateStep: true,
				typeStep: false,
				types:[],
				selectedType:'',
				infoStep: false,
				ssn:'',
				name:'',
				email:'',
				msgStep:'',
				errors: null,
				success: null
			}
		},
		created(){

		},
		methods: {
			getTypes(){
				this.dateStep = false;
				this.typeStep = true;
				this.$http.post('/api/types',{in: this.checkIn, out: this.checkOut}).then((response) => {
					this.types = response.body.types;
				}, (response) => {
					console.log(response)
				});
			},
			getInfo(){
				this.typeStep = false;
				this.infoStep = true;
			},
			book(){
				this.infoStep = false;
				this.dateStep = true;
				this.$http.post('/api/book',{Check_In: this.checkIn,Check_Out: this.checkOut,ssn: this.ssn,Room_Type: this.selectedType,Name: this.name,Email: this.email}).then((response) => {
						this.errors = response.body.errors;
						this.success = response.body.success;
						this.checkIn = '';
						this.checkOut = '';
						this.ssn = '';
						this.selectedType = '';
						this.name = '';
						this.email = '';
				}, (response) => {
					console.log(response)
				});	
			}
		}
	}	
</script>