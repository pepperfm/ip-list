<template>
  <el-row :gutter="24">
    <el-col :span="24">
      <el-button
        type="primary"
        plain
        @click="create()"
      >
        Добавить адрес
      </el-button>
    </el-col>
    <el-col :span="24">
      <el-table
        :data="networks"
        border
        row-key="id"
        style="width: 100%"
      >
        <el-table-column
          prop="id"
          label="ID"
          width="180"
        />
        <el-table-column
          prop="name"
          label="Name"
          width="500"
        />
        <el-table-column
          fixed="right"
          label="Actions"
          width="300"
        >
          <template #default="scope">
            <el-button
              size="small"
              type="warning"
              @click="handleEdit(scope.$index, scope.row)"
            >
              Edit
            </el-button>
            <el-button
              size="small"
              type="danger"
              @click="handleDelete(scope.$index, scope.row)"
            >
              Delete
            </el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-col>
  </el-row>
</template>

<script>
export default {
  name: "IndexNetwork",
  data() {
    return {
      actions: {
        rest: '/api/networks',
      },
      form: {
        data: '',
      },
      networks: [],
    }
  },
  async created() {
    await this.getRecords()
  },
  methods: {
    async getRecords() {
      let response = await this.$http.get(this.actions.rest)
      this.networks = response.data.data
    },
    async create() {
      await this.$router.push({ name: 'form.create' })
    },
    handleEdit(index, row) {
      this.$router.push({
        name: 'form',
        params: { id: row.id },
      })
    },
    async handleDelete(index, row) {
      this.errors = []
      try {
        const response = await this.$http.delete(`${this.actions.rest}/${row.id}`)
        await this.getRecords()
        this.$message.success(response.data.message)
      } catch (e) {
        if (!e.response) {
          throw e
        }
        switch (e.response.status) {
          case 422:
            this.errors = e.response.data
            this.$message.error(this.errors.message)
            break
          default:
            this.$message.error('Server error')
        }
      } finally {
      }
    },
    handleNodeClick() {

    },
  },
}
</script>

<style scoped>

</style>
