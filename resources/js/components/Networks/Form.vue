<template>
  <el-row :gutter="24">
    <el-col :span="8">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-xl-6  col-md-6 col-sm-6 col-xs-12 text-left">
              <el-button
                type="warning"
                @click="backToIndex()"
              >
                <i class="ArrowLeft"></i>
                Назад
              </el-button>
              <el-button
                type="success"
                @click="save()"
              >
                <em class="CircleCheck"></em>
                Сохранить
              </el-button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <el-form :model="network" label-width="120px">
            <el-form-item label="Name">
              <el-input v-model="network.name"/>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </el-col>
    <el-col :span="16"></el-col>
    <el-col :span="8">
      <div class="card">
        <div class="card-body">
          <el-switch
            v-model="creating_type"
            @change="clearModels"
            class="mb-2"
            active-text="Добавить по одному"
            inactive-text="Добавить по маске"
          />
          <el-form
            v-if="creating_type"
            ref="formRef"
            :model="network.addresses"
            label-width="120px"
          >
            <el-form-item
              v-for="(address, index) in network.addresses"
              :key="index"
              :label="'Address ' + index"
              :prop="'address.' + index + '.value'"
            >
              <el-input v-model="address.name"/>
              <el-radio-group v-model="address.frozen">
                <el-radio :label="1" border>Заморожен</el-radio>
                <el-radio :label="0" border>Свободен</el-radio>
              </el-radio-group>
              <el-button v-if="index !== 0" @click.prevent="removeAddress(address)">Delete</el-button>
            </el-form-item>
            <el-form-item>
              <el-button @click="addAddress">New address</el-button>
            </el-form-item>
          </el-form>
          <el-input v-if="!creating_type" v-model="network.addresses_mask"></el-input>
        </div>
      </div>
    </el-col>
    <el-col :span="16"></el-col>
  </el-row>
</template>

<script>
export default {
  name: "FormNetwork",
  data() {
    return {
      actions: {
        rest: '/api/networks',
      },
      errors: [],
      creating_type: false,
      network: {
        name: '',
        addresses_mask: '',
        addresses: [
          {
            name: '',
            frozen: false
          }
        ]
      },
    }
  },
  async created() {
    if (this.$route.params.id) {
      await this.getRecord(this.$route.params.id)
    }
  },
  methods: {
    async getRecord(id) {
      try {
        const response = await this.$http.get(`${this.actions.rest}/${id}`)
        this.network = response.data.data
      } catch (e) {
        this.$message.error('Error')
      }
    },
    async save() {
      this.errors = []
      try {
        let response
        if (this.network.id) {
          response = await this.$http.put(`${this.actions.rest}/${this.network.id}`, this.network)
        } else {
          response = await this.$http.post(this.actions.rest, this.network)
        }
        this.$message.success(response.data.message)
        await this.$router.push({name: 'index'})
      } catch (e) {
        if (!e.response) {
          throw e
        }
        this.errors = e.response.data.errors
        switch (e.response.status) {
          case 422:
            Object.values(this.errors).forEach((message) => this.$message.error(message))
            break
          default:
            this.$message.error('Server error')
        }
      }
    },
    backToIndex() {
      this.$router.push({name: 'index'})
    },

    async removeAddress(address) {
      console.log(address);
      const index = this.network.addresses.indexOf(address)
      if (index !== -1) {
        this.network.addresses.splice(index, 1)
        if (this.$route.params.id) {
          await this.$http.delete(`/api/addresses/${address.id}`);
        }
      }
    },
    addAddress() {
      this.network.addresses.push({
        key: Date.now(),
        value: '',
      })
    },
    clearModels() {
      if (this.creating_type) {
        if (this.network.addresses.length <= 1) {
          this.network.addresses = [{
            name: '',
            frozen: false
          }];
        }
      } else {
        this.network.addresses_mask = ''
      }
    },
  },
}
</script>

<style scoped>

</style>
