<template>
    <div>
        <div class="table-responsive">
            <!--Toolbar-->
            <form class="navbar-form navbar-left" role="search" :inline="true" :model="filters" action="#">
                <div class="form-group">
                    <input class="form-control" v-model="filters.search_type" placeholder="search type" type="text">
                </div>
                <button type="primary" v-on:click="getActivities" class="btn btn-default">
                    Search
                </button>
                <button type="primary" @click="handleReset" class="btn btn-default">
                    Reset
                </button>
            </form>
            <table class="table table-striped table-bordered table-hover table-condensed smart-form has-tickbox" width="100%">
                <thead>
                <tr >
                    <th>
                    #
                    </th>
                    <th>
                       Type
                    </th>
                    <th>
                       User
                    </th>
                    <th>
                        IP Address
                    </th>
                    <th>
                        Description
                    </th>
                    <th>
                        View
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(activity, index) in activities" >
                                <td class="hidden-xs">{{ index+1 }}</td>
                                <td><p class="text-capitalize">{{ activity.content_type }}</p></td>
                                <td><p class="text-capitalize">{{ activity.user.username }}</p></td>
                                <td><p class="text-capitalize">{{ activity.ip_address }}</p></td>
                                <td><p class="text-capitalize">{{ activity.description }}</p></td>
                                <td><button data-toggle="modal" data-target="#viewActivity" size="small" @click="handleEdit(index, activity)" >view</button></td>
                </tr>
                </tbody>
                
                <tfoot>

                <tr>
                    <td align="right" colspan="6">
                        <pagination :data="activities" v-on:pagination-change-page="getActivities"></pagination>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- view activity -->
        <!-- Modal Confirm -->
    <div class="modal fade" id="viewActivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" v-model="editFormVisible">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Activity Detail</h4>
          </div>
          <div class="modal-body" >
                <p><b>Content Type:</b> {{ editForm.content_type }}</p>
                <p><b>Action:</b> {{ editForm.action }}</p>
                <p v-if='editForm.user'><b>User Detail:</b>  {{ editForm.user.first_name+' ' +editForm.user.last_name}} ( {{ editForm.user.username +'--'+editForm.user.email }} )</p>
                <p><b>IP Address:</b> {{ editForm.ip_address }}</p>
                <p><b>Description:</b> {{ editForm.description }} ( Content ID: {{ editForm.content_id }} )</p>
                <p><b>Details:</b> {{ editForm.details }} </p>
                <p><b>User Agent:</b> {{ editForm.user_agent }} </p>
                <p><b>Created At:</b> {{ editForm.created_at }}</p>
          </div>
          <div class="modal-footer">            
            <div class="pull-right">
                <button type="button" class="btn btn--raised theme--dark" data-dismiss="modal"  @click.native="editFormVisible=false">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
      
    </div>
</template>

<script>
    import Vue from 'vue'
    import pagination from 'laravel-vue-pagination'

    Vue.use(pagination)
    //import NProgress from 'nprogress'
    import { getActivityList } from '../routes';

    export default {

        name:'my-activitytable',
        data() {
            return {
                filters: {
                    search_type: '',
                },
                activities: [],
                total: 0,
                page: 1,
                listLoading: false,
                sels: [],//List selected column

                editFormVisible: false,//Whether the editing interface is displayed
                editLoading: false,
                editFormRules: {
                    search_type: [
                        { required: true, message: 'Please type in your content', trigger: 'blur' }
                    ]
                },
                //Edit interface data
                editForm: {
                    id: 0,
                    content_type: '',
                    action:'',
                    content_id: '',
                    ip_address: '',
                    details: '',
                    user_agent: ''
                },

            }
        },
        methods: {
            handleCurrentChange(val) {
                this.page = val;
                this.getActivities();
            },
            handleReset(val) {
                this.page = 1;
                this.filters.search_type = '';
                this.getActivities();
            },
            //Get the user list
            getActivities() {
                let para = {
                    page: this.page,
                    search_type: this.filters.search_type
                };
                this.listLoading = true;
                //NProgress.start();
                getActivityList(para).then((res) => {
                    this.total = res.data.total;
                this.activities = res.data.data;
                this.listLoading = false;
                //NProgress.done();
            });
            },

            //Display the editing interface
            handleEdit: function (index, row) {
                this.editFormVisible = true;
                this.editForm = row;
                console.log(this.editForm.user);
            },

            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        mounted() {
            this.getActivities();
        }
    }

</script>

<style scoped>

</style>