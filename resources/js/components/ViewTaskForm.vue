<template>
    <div class="relative p-2 overflow-x-auto h-full">
        <div v-show="errorMessage">
        <span class="p-2 text-xs text-red-500">
          {{ errorMessage }}
        </span>
        </div>
        <div v-show="successMessage">
        <span class="p-2 text-md text-green-500">
          {{ successMessage }}
        </span>
        </div>
        <h1>Task Detail</h1>
        <br />
        <div class="p-2"><strong>Title:</strong> {{task_detal.title}}</div>
        <div class="p-2"><strong>Description:</strong> {{task_detal.description}}</div>
        <div class="p-2"><strong>Status:</strong>
            <select class="p-2" v-model="selected" @change="handleChangeStatus($event)">
                <option v-for="option in statuses" v-bind:value="option.id">
                    {{ option.title }}
                </option>
            </select>
        </div>
        <br>
        <br>

    <div class="back_listing" v-on:click="handleShowTaskList">Back To Listing</div>
    </div>
</template>

<script>
    export default {
        props: {
            initialData: Object
        },
        data() {
            return {
                statuses: [],
                task_detal: {},
                selected: '',
                errorMessage: "",
                successMessage: "",

            };
        },
        mounted() {

            this.statuses = JSON.parse(JSON.stringify(this.initialData.status));
            this.task_detal = JSON.parse(JSON.stringify(this.initialData.task_detail));
            this.selected = this.task_detal.status_id;
        },
        methods: {
            handleShowTaskList(){
              window.location.href = "/tasks";
            },
            handleChangeStatus(event) {
                console.log(event.target.value);
                if(confirm("Do you want to change status?")){
                    axios.put("/tasks/"+this.task_detal.id, { status: event.target.value })
                        .then(res => {
                            // Tell the parent component we've added a new task and include it
                            this.successMessage = "Status changed successfully.";

                        })
                        .catch(err => {
                        // Handle the error returned from our request
                        this.handleErrors(err);
                    });


                }

                // Send new task to server

            },
            handleErrors(err) {

                if (err.response && err.response.status === 422) {
                    this.errorMessage = "Error in save data, please try again.";
                    // We have a validation error
                  /*  const errorBag = err.response.data.errors;
                    if (errorBag.title) {
                        this.errorMessage = errorBag.title[0];
                    } else if (errorBag.description) {
                        this.errorMessage = errorBag.description[0];
                    } else {
                        this.errorMessage = err.response.message;
                    }*/
                } else {
                    // We have bigger problems
                    console.log(err.response);
                }
            }
        }
    };
</script>
<style scoped>
    .back_listing {
        cursor: pointer;
        color: blue;
    }
</style>