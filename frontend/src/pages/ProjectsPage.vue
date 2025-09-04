<template>
  <q-page class="q-pa-md">
    <div class="text-h4 q-mb-lg">Список проектов</div>

    <!-- Кнопка добавления -->
    <q-page-sticky position="top-right" :offset="[18, 18]">
      <q-btn fab icon="add" color="accent" @click="addNewProject" />
    </q-page-sticky>

    <!-- Список проектов -->
    <div class="row q-col-gutter-md">
      <div
        v-for="project in projects"
        :key="project.id"
        class="col-12 col-md-4"
      >
        <q-card class="q-pa-md hover-card">
          <q-card-section @click="openProject(project.id)" class="cursor-pointer">
            <div class="text-h6">{{ project.name }}</div>
            <div class="text-subtitle2 text-grey">
              Владелец: {{ project.ownerId }}
            </div>
          </q-card-section>

          <q-card-section>
            <div>{{ project.description }}</div>
          </q-card-section>

          <q-card-actions align="right">
            <q-btn flat color="primary" label="Открыть" @click="openProject(project.id)" />
            <q-btn flat color="negative" icon="delete" @click="deleteProject(project.id)" />
          </q-card-actions>
        </q-card>
      </div>
    </div>

    <!-- Диалог создания проекта -->
    <q-dialog v-model="modalOpened" persistent>
      <q-card style="width: 400px; max-width: 90vw">
        <q-card-section>
          <div class="text-h6">Новый проект</div>
        </q-card-section>

        <q-card-section>
          <q-input v-model="newProject.name" label="Название" outlined dense />
          <q-input v-model="newProject.description" label="Описание" outlined dense type="textarea" class="q-mt-md" />
          <q-input v-model.number="newProject.ownerId" label="ID владельца" type="number" outlined dense class="q-mt-md" disable />
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Отмена" v-close-popup />
          <q-btn color="primary" label="Создать" :loading="loading" @click="createProject" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { api } from 'boot/axios'
import { useQuasar } from 'quasar'
import {useRouter} from "vue-router";

const $q = useQuasar()
const projects = ref([])
const modalOpened = ref(false)
const loading = ref(false)
const router = useRouter()

const newProject = ref({
  name: '',
  description: '',
  ownerId: null
})

const fetchProjects = async () => {
  try {
    const response = await api.get('/api/projects')
    projects.value = response.data
  } catch (err) {
    console.error(err)
    $q.notify({ type: 'negative', message: 'Ошибка при загрузке проектов' })
  }
}

const addNewProject = () => {
  // todo: Вытащить id пользователя из другого запроса, а не текущих проектов
  newProject.value = { name: '', description: '', ownerId: projects.value[0].ownerId }
  modalOpened.value = true
}

const createProject = async () => {
  loading.value = true
  try {
    await api.post('/api/projects', newProject.value)
    $q.notify({ type: 'positive', message: 'Проект создан' })
    modalOpened.value = false
    await fetchProjects()
  } catch (err) {
    console.error(err)
    $q.notify({
      type: 'negative',
      message: err.response?.data?.message || 'Ошибка при создании проекта'
    })
  } finally {
    loading.value = false
  }
}

const deleteProject = async (id) => {
  try {
    await api.delete(`/api/projects/${id}`)
    $q.notify({ type: 'positive', message: 'Проект удалён' })
    await fetchProjects()
  } catch (err) {
    console.error(err)
    $q.notify({
      type: 'negative',
      message: err.response?.data?.message || 'Ошибка при удалении проекта'
    })
  }
}

const openProject = (id) => {
  $q.notify({ type: 'info', message: `Открыт проект с ID: ${id}` })
  router.push(`/project/${id}`)
}

onMounted(fetchProjects)
</script>

<style scoped>
.hover-card {
  transition: 0.2s;
}
.hover-card:hover {
  transform: scale(1.02);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
</style>
