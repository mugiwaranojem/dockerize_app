<template>
  <div>

    <div class="container">
        <div class="table-wrapper">
          <div class="table-title">
            <div class="row">
              <div class="col-sm-6">
                <h3>Manage <b>Topics</b></h3>
              </div>
              <div class="col-sm-6 text-right">
                <a @click.prevent="addTopicModal" href="#addTopicModal" class="btn btn-success" data-toggle="modal">
                  <i class="fas fa-plus"></i> <span>Add new topic</span></a>     
              </div>
            </div>
          </div>
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody v-if="fetching">
              <tr>
                <td colspan="4">Fetching data...</td>
              </tr>
            </tbody>
            <tbody v-else>
              <template v-if="topics.length > 0">
                <tr
                  v-for="(topic, index) in topics">
                  <td>{{ topic.id }}</td>
                  <td>{{ topic.subject }}</td>
                  <td>{{ topic.description }}</td>
                  <td>
                    <a href="#" class="action view mr-2 text-info">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a @click.prevent="updateTopicModal(index)" class="action edit text-warning mr-2" data-toggle="modal">
                      <i class="fas fa-pen"></i>
                    </a>
                    <a @click.prevent="deleteModal(index)" href="#deleteTopicModal" class="action delete text-danger" data-toggle="modal">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </template>
              
              <tr v-else>
                <td colspan="4">No topics</td>
              </tr>
            </tbody>
          </table>
          <div class="clearfix">
            <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
            <ul class="pagination">
              <li class="page-item disabled"><a href="#">Previous</a></li>
              <li class="page-item"><a href="#" class="page-link">1</a></li>
              <li class="page-item"><a href="#" class="page-link">2</a></li>
              <li class="page-item active"><a href="#" class="page-link">3</a></li>
              <li class="page-item"><a href="#" class="page-link">4</a></li>
              <li class="page-item"><a href="#" class="page-link">5</a></li>
              <li class="page-item"><a href="#" class="page-link">Next</a></li>
            </ul>
          </div>
        </div>
    </div>

    <div id="addTopicModal" class="modal fade" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">            
              <h4 class="modal-title">Add Topic</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">          
              <div class="form-group">
                <label>Subject</label>
                <input v-model="subject" type="text" class="form-control" required="">
              </div>
              <div class="form-group">
                <label>Description</label>
                <input v-model="description" type="text" class="form-control" required="">
              </div>        
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
              <button @click.prevent="updateTopic()" type="submit" class="btn btn-success" :disabled="addingTopic">
                {{ this.currentAction === 'add' ? 'Add' : 'Update' }} <i class="fas fa-circle-notch fa-spin loader" :class="{'d-none': !addingTopic }"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="deleteTopicModal" class="modal fade in" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">            
              <h4 class="modal-title">Delete Topic</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">          
              <p>Are you sure you want to delete this topic?</p>
              <p class="text-warning"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
              <input ref="closeModal" type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
              <input @click.prevent="confirmDelete" type="submit" class="btn btn-danger" value="Delete">
            </div>
          </form>
        </div>
      </div>
    </div>
    
  </div>
</template>
<script>
import jquery from 'jquery'
import toastr from 'toastr'
import userService from '../service/userService'

export default {
  data() {
    return {
      topics: [],
      fetching: false,
      addingTopic: false,
      subject: '',
      description: '',
      currentAction: ''
    }
  },
  methods: {
    updateTopic () {
      this.addingTopic = true

      if (!this.subject.length) {
        toastr.error('Subject field is required!', 'Error')
        this.addingTopic = false
        return
      }

      const token = localStorage.getItem('token')
      const formData = new FormData();
      formData.append('subject', this.subject)
      formData.append('description', this.description)
      formData.append('token', token)

      if (this.currentAction === 'add') {
        userService.addTopic(formData).then(topic => {
          if (topic.id) {
            this.getTopics().then(() => {
              this.subject = '';
              this.description = ''
              jquery('#addTopicModal').modal('hide')
              toastr.success('A new topic has been added', 'Success')
            })
          }
        })
        .finally(() => {
          this.addingTopic = false
        })
      } else {
        const index = this.currentAction.split('-')[1]
        const updateId = this.topics[index].id
        userService.updateTopic(updateId, formData).then(topic => {
          if (topic.id) {
            this.getTopics().then(() => {
              this.subject = '';
              this.description = ''
              jquery('#addTopicModal').modal('hide')
              toastr.success('Topic has been added', 'Success')
            })
          }
        })
        .finally(() => {
          this.addingTopic = false
        })
      }

    },

    addTopicModal() {
      this.currentAction = 'add'
      this.subject = ''
      this.description = ''
      jquery('#addTopicModal').modal('show')
    },

    updateTopicModal(index) {
      
      this.currentAction = `update-${index}`

      const topic = this.topics[index]
      this.subject = topic.subject
      this.description = topic.description
      jquery('#addTopicModal').modal('show')
    },

    deleteModal(index) {
      this.currentAction = `delete-${index}`
    },

    confirmDelete() {
      const index = this.currentAction.split('-')[1]
      const topic = this.topics[index];
      const token = localStorage.getItem('token') 
      const formData = new FormData()
      formData.append('token', token)

      userService.deleteTopic(topic.id, formData).then(()=> {
        this.getTopics()
        jquery('#deleteTopicModal').modal('hide')
        toastr.success('Topic has been deleted', 'success')
      });
    },

    getTopics () {
      const token = localStorage.getItem('token')
      return userService.getTopics(token).then(response => {
        // if (response.token_expired) {
        //   localStorage.removeItem('token')
        //   toastr.error('Token expired', 'Error')
        //   location.href = '/#/user/login'
        // }
        if (response.data) {
          this.topics = response.data
        }
      })
    }
  },
  mounted () {
    toastr.success('Welcome!', 'BlogSite')

    this.fetching = true
    this.getTopics().then(() => {
      this.fetching = false
    })
  }
}
</script>

<style scoped>
.table-wrapper {
  background: #fff;
  padding: 20px 25px;
  margin: 30px 0;
  border-radius: 3px;
  box-shadow: 0 1px 1px rgba(0,0,0,.05);
}

.table-title {
  padding-bottom: 15px;
  background: #435d7d;
  color: #fff;
  padding: 16px 30px;
  margin: -20px -25px 10px;
  border-radius: 3px 3px 0 0;
}

table.table tr th, table.table tr td {
  vertical-align: middle;
}

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 16px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}

.hint-text {
  float: left;
  margin-top: 10px;
  font-size: 13px;
}

.pagination {
  float: right;
  margin: 0 0 5px;
}

.pagination {
  display: inline-block;
  padding-left: 0;
  margin: 20px 0;
  border-radius: 4px;
}

.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
    z-index: 3;
    color: #fff;
    cursor: default;
    background-color: #337ab7;
    border-color: #337ab7;
}

.pagination li a {
    border: none;
    font-size: 13px;
    min-width: 30px;
    min-height: 30px;
    color: #999;
    margin: 0 2px;
    line-height: 30px;
    border-radius: 2px !important;
    text-align: center;
    padding: 0 6px;
}

.pagination>li {
  margin: 0 6px;
}

.pagination>li>a, .pagination>li>span {
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: #337ab7;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
}
</style>
