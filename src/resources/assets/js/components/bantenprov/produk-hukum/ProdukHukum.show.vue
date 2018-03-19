<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Show produk-hukum {{ model.label }}

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" role="button" @click="back">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <vue-form class="form-horizontal form-validation" :state="state" @submit.prevent="onSubmit">
        <div class="form-row">
          <div class="col-md">
            <b>Label :</b> {{ model.label }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Description :</b> {{ model.description }}
          </div>
        </div>

        <div class="form-row mt-4">
					<div class="col-md">
						<b>Username :</b> {{ model.user.name }}
					</div>
				</div>

        <div class="form-row mt-4">
					<div class="col-md">
						<b>Group :</b> {{ model.group_egovernment.label }}
					</div>
				</div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Sector :</b> {{ model.sector_egovernment.label }}
          </div>
        </div>

      </vue-form>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    axios.get('api/produk-hukum/' + this.$route.params.id)
      .then(response => {
        if (response.data.status == true) {
          this.model.label = response.data.produk_hukum.label;
          this.model.old_label = response.data.produk_hukum.label;
          this.model.description = response.data.produk_hukum.description;
          this.model.group_egovernment = response.data.group_egovernment;
          this.model.sector_egovernment = response.data.sector_egovernment;
          this.model.user = response.data.user;
        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/produk-hukum';
      }),

      axios.get('api/produk-hukum/create')
      .then(response => {
          response.data.group_egovernment.forEach(element => {
            this.group_egovernment.push(element);
          });
      })
      .catch(function(response) {
        alert('Break');
      })
  },
  data() {
    return {
      state: {},
      model: {
        label: "",
        description: "",
        user:"",
        group_egovernment: "",
        sector_egovernment: "",
      },
      group_egovernment: [],
      sector_egovernment: []
    }
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.put('api/produk-hukum/' + this.$route.params.id, {
            label: this.model.label,
            description: this.model.description,
            old_label: this.model.old_label,
            group_egovernment_id: this.model.group_egovernment.id,
            sector_egovernment_id: this.model.sector_egovernment.id
          })
          .then(response => {
            if (response.data.status == true) {
              if(response.data.message == 'success'){
                alert(response.data.message);
                app.back();
              }else{
                alert(response.data.message);
              }
            } else {
              alert(response.data.message);
            }
          })
          .catch(function(response) {
            alert('Break ' + response.data.message);
          });
      }
    },
    reset() {
      axios.get('api/produk-hukum/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            this.model.label = response.data.produk_hukum.label;
            this.model.description = response.data.produk_hukum.description;
          } else {
            alert('Failed');
          }
        })
        .catch(function(response) {
          alert('Break ');
        });
    },
    back() {
      window.location = '#/admin/produk-hukum';
    }
  }
}
</script>
