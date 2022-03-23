<template>
  <page>
    <template #header>
      <h4>
        <span class="text-bold text-blue">Yeni</span> Takım
      </h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-md-center">
                <div class="col-md-6">
                  <add-team />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../components/Page'
import AddTeam from '../../components/teams/AddTeam'

export default {
  name: 'NewTeam',
  components: { Page, AddTeam },
  setup () {

  }
}
</script>

<style scoped>

</style>
