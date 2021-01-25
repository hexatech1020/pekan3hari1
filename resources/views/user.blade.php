<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User List</title>
</head>
<body>
    
	<div id="app">

		<form>
			<input type="text" v-model="form.name">
			<button @click.prevent="add" v-show="!updateSubmit" >Add</button>
			<button @click.prevent="update" v-show="updateSubmit">Update</button>
		</form>

		<ul v-for="(user, index) in users">
			<li>
				<span>@{{user.name}}</span>
				<button @click="edit(user,index)">Edit</button> || <button @click="del(index, user)">Delete</button>
			</li>
		</ul>
	</div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
	<script>
		var app = new Vue({
			el: '#app',
			data (){
				return {
					users : 
					[
						// {
						// 	name : 'Muhammad Iqbal Mubarok',
						// },
						// {
						// 	name : 'Ruby Purwanti',
						// },
						// {
						// 	name : 'Faqih Muhammad',
						// },
					],
					updateSubmit : false,
					form : {
						'name' : ''
					},
					selectedUserId : '',
				}
			},
			methods : {
				add(){

                    if(this.form.name){
                        this.$http.post('api/user', {name: this.form.name}).then(response => {
                        
                            this.users.unshift(this.form)
                            this.form={}
                        });
                    }

				},
				edit(user, index){
					this.selectedUserId = index
					this.updateSubmit = true
					this.form.name = user.name
				},
				update(){

                    let textInput = this.form.name.trim()

                    this.$http.post('api/user/change-name/' + this.users[this.selectedUserId].id, {name : this.form.name}).then(response => {
                        
                        this.users[this.selectedUserId].name = this.form.name
                        this.form = {}
                        this.updateSubmit = false
                        this.selectedUserId =''
                    });


				},
				del(index, user){
					if(confirm("Anda Yakin ?")){
                    
                    this.$http.post('api/user/delete/' + user.id).then(response => {
				   		this.users.splice(index,1)
                    });
  
				   }
				}
			},
            mounted: function(){
                this.$http.get('api/user').then(response => {
                let result = response.body.data;
                this.users = result

                });                
            }
		})
	</script>

</body>
</html>