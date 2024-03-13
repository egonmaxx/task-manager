<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading my-3">
                        <div class="panel-heading d-flex flex-row gap-2">
                            <h3 class="my-2">
                                <span
                                    class="glyphicon glyphicon-dashboard"
                                ></span>
                                Assignment Dashboard
                            </h3>
                        </div>
                        <div class="w-100 flex-row">
                            <button
                                @click="initAddTask()"
                                class="btn btn-success p-1"
                            >
                                Add New Assignment
                            </button>
                            <button
                                @click="deleteSelectedTaskItems()"
                                class="btn btn-danger p-1"
                            >
                                Delete selected tasks
                            </button>
                        </div>
                        <div class="w-100 flex-row">
                            <div>
                                Total Estimated Time:
                                {{ totalEstimatedTime | hours }}
                            </div>
                            <div>
                                Total Used Time: {{ totalUsedTime | hours }}
                            </div>
                        </div>
                    </div>
                    <div class="panel-heading my-3">
                        <label for="searchInput ">
                            <b>Search input field: </b>
                        </label>
                        <input
                            type="text"
                            id="searchInput"
                            v-model="searchQuery"
                            placeholder="Search..."
                        />
                    </div>
                    <div class="panel-body">
                        <table
                            class="table table-bordered table-striped table-responsive"
                            v-if="filteredTasks.length > 0"
                        >
                            <tbody>
                                <tr>
                                    <th>
                                        <p>
                                            Select all
                                            <input
                                                type="checkbox"
                                                v-model="selectAll"
                                                @change="toggleAll"
                                            />
                                        </p>
                                    </th>
                                    <th>No.</th>
                                    <th
                                        style="cursor: pointer"
                                        title="click to sort by"
                                        @click="sortBy('userId')"
                                    >
                                        User Name
                                    </th>
                                    <th
                                        style="cursor: pointer"
                                        title="click to sort by"
                                        @click="sortBy('description')"
                                    >
                                        Description
                                    </th>
                                    <th
                                        style="cursor: pointer"
                                        title="click to sort by"
                                        @click="sortBy('estimatedTime')"
                                    >
                                        Estimated Time
                                    </th>
                                    <th
                                        style="cursor: pointer"
                                        title="click to sort by"
                                        @click="sortBy('usedTime')"
                                    >
                                        Used Time
                                    </th>
                                    <th
                                        style="cursor: pointer"
                                        title="click to sort by"
                                        @click="sortBy('createdAt')"
                                    >
                                        Created At
                                    </th>
                                    <th
                                        style="cursor: pointer"
                                        title="click to sort by"
                                        @click="sortBy('completedAt')"
                                    >
                                        Completed At
                                    </th>
                                    <th
                                        style="cursor: pointer"
                                        title="click to sort by"
                                        @click="sortBy('done')"
                                    >
                                        Done
                                    </th>

                                    <th>Action</th>

                                    <th>
                                        <button
                                            @click="toggleAllDone"
                                            class="btn btn-info p-1"
                                        >
                                            Done all
                                        </button>
                                    </th>
                                </tr>
                                <tr
                                    v-for="(task, index) in filteredTasks"
                                    :key="task.id"
                                >
                                    <td>
                                        <input
                                            type="checkbox"
                                            @click="selectedTaskItem(index)"
                                            :checked="isSelected(index)"
                                        />
                                    </td>
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        {{ task.user.name }}
                                    </td>
                                    <td>
                                        {{ task.description }}
                                    </td>
                                    <td>
                                        {{ task.estimatedTime | hours }}
                                    </td>
                                    <td>
                                        {{ task.usedTime | hours }}
                                    </td>
                                    <td>
                                        {{ task.created_at | dateTimeFormat }}
                                    </td>
                                    <td>
                                        {{ task.completedAt | dateTimeFormat }}
                                    </td>
                                    <td>
                                        {{ task.done | isDone }}
                                    </td>
                                    <td>
                                        <button
                                            @click="initUpdate(index)"
                                            class="btn btn-success btn-xs"
                                            style="padding: 8px"
                                        >
                                            <span
                                                class="glyphicon glyphicon-edit"
                                            ></span>
                                            Edit
                                        </button>
                                        <button
                                            @click="deleteTask(index)"
                                            class="btn btn-danger btn-xs"
                                            style="padding: 8px"
                                        >
                                            <span
                                                class="glyphicon glyphicon-trash"
                                            ></span>
                                            Delete
                                        </button>
                                    </td>

                                    <td>
                                        <input
                                            type="checkbox"
                                            :checked="task.done"
                                            @change="markAsDone(index)"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="add_task_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Task</h4>
                    </div>
                    <div class="modal-body">
                        <div
                            class="alert alert-danger"
                            v-if="errors.length > 0"
                        >
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <!-- Modal New -->
                            <label for="userId">User name: </label>
                            <select
                                v-model="task.userId"
                                name="userId"
                                id="userId"
                                class="form-control"
                            >
                                <option
                                    v-for="user in users"
                                    :value="user.id"
                                    :key="user.id"
                                >
                                    {{ user.name }}
                                </option>
                            </select>
                            <!-- Modal New -->

                            <!-- <input
                                type="text"
                                name="userId"
                                id="userId"
                                placeholder="User Id"
                                class="form-control"
                                v-model="task.userId"
                            /> -->
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea
                                name="description"
                                id="description"
                                cols="30"
                                rows="5"
                                class="form-control"
                                placeholder="Task Description"
                                v-model="task.description"
                            >
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="estimatedTime">Estimated Time:</label>
                            <input
                                type="number"
                                min="0"
                                max="1000"
                                value="0"
                                name="estimatedTime"
                                id="estimatedTime"
                                placeholder="Estimated Time"
                                class="form-control"
                                v-model="task.estimatedTime"
                            />
                        </div>
                        <div class="form-group">
                            <label for="usedTime">Used Time:</label>
                            <input
                                type="number"
                                min="0"
                                max="1000"
                                value="0"
                                name="usedTime"
                                id="usedTime"
                                placeholder="Used Time"
                                class="form-control"
                                v-model="task.usedTime"
                            />
                        </div>
                        <!-- <div class="form-group">
                            <label for="createdAt">Created At:</label>
                            <input
                                type="datetime-local"
                                name="createdAt"
                                id="createdAt"
                                placeholder="Created At"
                                class="form-control"
                                v-model="task.createdAt"
                            />
                        </div> -->
                        <div class="form-group">
                            <label for="completedAt">Completed At:</label>
                            <input
                                type="datetime-local"
                                name="completedAt"
                                id="completedAt"
                                placeholder="Completed At"
                                class="form-control"
                                v-model="task.completedAt"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            @click="closeNewTaksModal"
                            class="btn btn-default"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            @click="createTask"
                            class="btn btn-primary"
                        >
                            Submit
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div
            class="modal fade"
            tabindex="-1"
            role="dialog"
            id="update_task_model"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Task</h4>
                    </div>
                    <div class="modal-body">
                        <div
                            class="alert alert-danger"
                            v-if="errors.length > 0"
                        >
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <!-- Modal Edit -->
                            <label for="userId">User Id:</label>

                            <select
                                v-model="task.userId"
                                name="userId"
                                id="userId"
                                class="form-control"
                            >
                                <option
                                    v-for="user in users"
                                    :value="user.id"
                                    :key="user.id"
                                >
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea
                                name="description"
                                id="description"
                                cols="30"
                                rows="5"
                                class="form-control"
                                placeholder="Task Description"
                                v-model="task.description"
                            >
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="estimatedTime">Estimated Time:</label>
                            <input
                                type="number"
                                min="0"
                                max="1000"
                                value="0"
                                name="estimatedTime"
                                id="estimatedTime"
                                placeholder="Estimated Time"
                                class="form-control"
                                v-model="task.estimatedTime"
                            />
                        </div>
                        <div class="form-group">
                            <label for="usedTime">Used Time:</label>
                            <input
                                type="number"
                                min="0"
                                max="1000"
                                value="0"
                                name="usedTime"
                                id="usedTime"
                                placeholder="Used Time"
                                class="form-control"
                                v-model="task.usedTime"
                            />
                        </div>
                        <!-- <div class="form-group">
                            <label for="createdAt">Created At:</label>
                            <input
                                type="datetime-local"
                                name="createdAt"
                                id="createdAt"
                                placeholder="Created At"
                                class="form-control"
                                v-model="task.createdAt"
                            />
                        </div> -->
                        <div class="form-group">
                            <label for="completedAt">Completed At:</label>
                            <input
                                type="datetime-local"
                                name="completedAt"
                                id="completedAt"
                                placeholder="Completed At"
                                class="form-control"
                                v-model="task.completedAt"
                            />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            @click="closeUpdateTaskModal"
                            class="btn btn-default"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            @click="updateTask"
                            class="btn btn-primary"
                        >
                            Submit
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>
import $ from "jquery";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
export default {
    components: { DatePicker },
    data() {
        return {
            task: {
                userId: "",
                description: "",
                estimatedTime: "",
                usedTime: "",
                createdAt: "",
                completedAt: "",
                done: "",
            },
            errors: [],
            tasks: [],
            searchQuery: "",
            taskId: null,
            users: [],
            selectedTask: [],
            update_task: {},
            currentUpdateIndex: null,
            selectAll: false,
            totalEstimatedTime: 0,
            totalUsedTime: 0,
            sortKey: "",
            sortOrders: {
                userId: 1, // 1 for ascending, -1 for descending
                description: 1,
                estimatedTime: 1,
                usedTime: 1,
                createdAt: 1,
                completedAt: 1,
            },
        };
    },

    mounted() {
        this.readTasks();
        this.readUsers();
    },
    computed: {
        getUsers() {
            let userIds = new Set();

            this.tasks.forEach((task) => {
                if (task.user && task.user.id) {
                    userIds.add(task.user.id);
                }
            });

            return Array.from(userIds).map((userId) => {
                let taskWithUser = this.tasks.find(
                    (task) => task.user && task.user.id === userId
                );
                return {
                    id: userId,
                    name: taskWithUser.user.name,
                };
            });
        },
        filteredTasks() {
            return this.tasks.filter(
                (task) =>
                    (task.user.name &&
                        typeof task.user.name === "string" &&
                        task.user.name
                            .toLowerCase()
                            .includes(this.searchQuery.toLowerCase())) ||
                    (task.description &&
                        typeof task.description === "string" &&
                        task.description
                            .toLowerCase()
                            .includes(this.searchQuery.toLowerCase())) ||
                    (task.estimatedTime &&
                        typeof task.estimatedTime === "string" &&
                        task.estimatedTime
                            .toLowerCase()
                            .includes(this.searchQuery.toLowerCase())) ||
                    (task.usedTime &&
                        typeof task.usedTime === "string" &&
                        task.usedTime
                            .toLowerCase()
                            .includes(this.searchQuery.toLowerCase())) ||
                    (task.created_at &&
                        typeof task.created_at === "string" &&
                        task.created_at
                            .toLowerCase()
                            .includes(this.searchQuery.toLowerCase())) ||
                    (task.completedAt &&
                        typeof task.completedAt === "string" &&
                        task.completedAt
                            .toLowerCase()
                            .includes(this.searchQuery.toLowerCase()))
            );
        },
    },
    methods: {
        deleteTask(index) {
            let conf = confirm("Do you really want to delete this task?");
            if (conf === true) {
                axios
                    .delete("/task/" + this.tasks[index].id)
                    .then((response) => {
                        this.tasks.splice(index, 1);
                    })
                    .catch((error) => {
                        console.error("Error deleting task:", error);
                    });
            }
            this.readTasks();
        },
        selectedTaskItem(index) {
            console.log("selectedDelete", index);
            if (!this.selectedTask.includes(index)) {
                this.selectedTask.push(index);
            } else {
                this.selectedTask = this.selectedTask.filter(
                    (n) => n !== index
                );
            }
            console.log("selectedTask", this.selectedTask);
            let totalEstimatedTime = 0;
            let totalUsedTime = 0;
            this.selectedTask.forEach((taskIndex) => {
                const task = this.tasks[taskIndex];
                totalEstimatedTime += task.estimatedTime;
                totalUsedTime += task.usedTime;
            });
            this.totalEstimatedTime = totalEstimatedTime;
            this.totalUsedTime = totalUsedTime;
        },

        markAsDone(index) {
            console.log("index", index);
            if (this.tasks[index].done == 1) {
                this.tasks[index].done = 0;
            } else {
                this.tasks[index].done = 1;
            }
            // this.tasks[index].done = !this.tasks[index].done;
            this.setToDone(this.tasks[index].id);
        },
        toggleAll() {
            this.tasks.forEach((task) => {
                task.completedAt = this.selectAll;
            });
            console.log("toggleAll - tasks", this.tasks);
        },
        toggleAllDone() {
            this.tasks.forEach((task) => {
                task.done = 1;
                this.setToDone(task.id);
            });
            console.log("toggleAllDone - tasks", this.tasks);
        },
        deleteSelectedTaskItems() {
            if (this.selectedTask.length > 0) {
                let conf = confirm("Do you really want to delete these tasks?");
                if (conf === true) {
                    this.selectedTask.sort((a, b) => b - a);
                    this.selectedTask.forEach((index) => {
                        axios
                            .delete("/task/" + this.tasks[index].id)
                            .then((response) => {
                                this.tasks.splice(index, 1);
                            })
                            .catch((error) => {
                                console.error("Error deleting task:", error);
                            });
                    });
                    this.selectedTask = [];
                }
            } else {
                console.log("No tasks selected for deletion");
            }
            this.readTasks();
        },
        isSelected(index) {
            return this.selectedTask.includes(index);
        },
        toggleAll() {
            if (this.selectAll) {
                this.selectedTask = this.tasks.map((_, index) => index);
            } else {
                this.selectedTask = [];
            }
            this.sumOfTimes();
        },
        sortBy(key) {
            // Toggle sort order if the same key is clicked again
            if (this.sortKey === key) {
                this.sortOrders[key] *= -1;
            } else {
                this.sortKey = key;
            }

            // Sort tasks based on the selected key and sort order
            this.tasks.sort((a, b) => {
                const order = this.sortOrders[key];
                const valueA = a[key];
                const valueB = b[key];
                return (
                    (valueA === valueB ? 0 : valueA > valueB ? 1 : -1) * order
                );
            });
        },

        initAddTask() {
            $("#add_task_model").modal("show");
        },

        closeNewTaksModal() {
            $("#add_task_model").modal("hide");
        },
        createTask() {
            axios
                .post("/task", {
                    userId: this.task.userId,
                    description: this.task.description,
                    estimatedTime: this.task.estimatedTime,
                    usedTime: this.task.usedTime,
                    createdAt: this.task.createdAt,
                    completedAt: this.task.completedAt,
                })
                .then((response) => {
                    this.reset();
                    this.readTasks();
                    // this.tasks.push(response.data.task);
                    $("#add_task_model").modal("hide");
                })
                .catch((error) => {
                    this.errors = [];
                    if (
                        error.response.data.errors &&
                        error.response.data.errors.name
                    ) {
                        this.errors.push(error.response.data.errors.name[0]);
                    }
                    if (
                        error.response.data.errors &&
                        error.response.data.errors.description
                    ) {
                        this.errors.push(
                            error.response.data.errors.description[0]
                        );
                    }
                });
        },
        reset() {
            this.task.name = "";
            this.task.description = "";
        },
        readTasks() {
            axios.get("/task").then((response) => {
                this.tasks = response.data.tasks;
            });
        },
        readUsers() {
            axios.get("/users").then((response) => {
                this.users = response.data.users;
            });
        },
        setToDone(taskId) {
            console.log("taskId", taskId);
            axios.get("/set-to-done/" + taskId).then((response) => {
                // this.users = response.data.users;
            });
        },
        initUpdate(index) {
            this.currentUpdateIndex = index;
            this.errors = [];
            $("#update_task_model").modal("show");
            this.update_task = this.tasks[index];
            //todo fill up update form with the selected element values
            this.task.userId = this.tasks[index].userId;
            this.task.description = this.tasks[index].description;
            this.task.estimatedTime = this.tasks[index].estimatedTime;
            this.task.usedTime = this.tasks[index].usedTime;
            this.task.createdAt = this.tasks[index].createdAt;
            this.task.completedAt = this.tasks[index].completedAt;
        },
        closeUpdateTaskModal() {
            $("#update_task_model").modal("hide");
        },
        updateTask() {
            console.log(this.task.userId);
            axios
                .patch("/task/" + this.update_task.id, {
                    userId: this.task.userId,
                    description: this.task.description,
                    estimatedTime: this.task.estimatedTime,
                    usedTime: this.task.usedTime,
                    createdAt: this.task.createdAt,
                    completedAt: this.task.completedAt,
                })
                .then((response) => {
                    $("#update_task_model").modal("hide");
                    //todo upddate list row

                    // if (this.tasks.length > 0) {
                    this.tasks[this.currentUpdateIndex].userId =
                        this.task.userId;
                    this.tasks[this.currentUpdateIndex].description =
                        this.task.description;
                    this.tasks[this.currentUpdateIndex].estimatedTime =
                        this.task.estimatedTime;
                    this.tasks[this.currentUpdateIndex].usedTime =
                        this.task.usedTime;
                    this.tasks[this.currentUpdateIndex].createdAt =
                        this.task.createdAt;
                    this.tasks[this.currentUpdateIndex].completedAt =
                        this.task.completedAt;
                    // }
                })
                .catch((error) => {
                    this.errors = [];
                    if (error.response.data.errors.name) {
                        this.errors.push(error.response.data.errors.name[0]);
                    }
                    if (error.response.data.errors.description) {
                        this.errors.push(
                            error.response.data.errors.description[0]
                        );
                    }
                });
        },
        sumOfTimes() {
            let totalEstimatedTime = 0;
            let totalUsedTime = 0;
            this.selectedTask.forEach((taskIndex) => {
                const task = this.tasks[taskIndex];
                totalEstimatedTime += task.estimatedTime;
                totalUsedTime += task.usedTime;
            });
            this.totalEstimatedTime = totalEstimatedTime;
            this.totalUsedTime = totalUsedTime;
        },
    },
    filters: {
        dateTimeFormat(dateTime){
            if (dateTime === null)
            {
                return '';
            }
            var d = new Date(dateTime);
            return d.toLocaleString();
        },
        datetime(duration) {
            const hrs = ~~(duration / 3600);
            const mins = ~~((duration % 3600) / 60);
            const secs = ~~duration % 60;

            // Output like "1:01" or "4:03:59" or "123:03:59"
            let ret = "";

            if (hrs > 0) {
                ret += "" + hrs + ":" + (mins < 10 ? "0" : "");
            }

            ret += "" + mins + ":" + (secs < 10 ? "0" : "");
            ret += "" + secs;

            return ret;
        },
        isDone(value) {
            if (value === 0) {
                return "NO";
            }

            return "YES";
        },
        hours(duration) {
            if (duration === null) {
                duration = 0;
            }
            return duration + " hrs";
        },
    },
};
</script>

<style lang="css" scoped>
input[type="checkbox"] {
    transform: scale(1.5);
    cursor: pointer;
}
</style>
