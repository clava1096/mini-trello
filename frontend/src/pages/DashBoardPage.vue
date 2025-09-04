<template>
  <q-page class="q-pa-lg">
    <div class="row items-center q-mb-lg">
      <q-avatar color="primary" text-color="white" size="60px" class="q-mr-md">
        {{ userInitials }}
      </q-avatar>
      <div v-if="user.username">
        <div class="text-h4">Добро пожаловать, {{ user.username }}!</div>
        <div class="text-subtitle1 text-grey">Email: {{ user.email }}</div>
      </div>
    </div>

    <q-card class="q-pa-md">
      <q-card-section>
        <div class="text-h6">Ваши данные</div>
      </q-card-section>

      <q-card-section>
        <div class="row q-col-gutter-md">
          <div class="col-12 col-md-6">
            <q-input
              label="ID пользователя"
              :model-value="user.id"
              readonly
              outlined
            />
          </div>
          <div class="col-12 col-md-6">
            <q-input
              label="Имя пользователя"
              :model-value="user.name"
              readonly
              outlined
            />
          </div>
          <div class="col-12 col-md-6">
            <q-input
              label="Email"
              :model-value="user.email"
              readonly
              outlined
            />
          </div>
        </div>
      </q-card-section>
    </q-card>

    <div class="q-mt-lg">
      <q-btn
        label="Выйти"
        color="negative"
        @click="logout"
      />
    </div>
  </q-page>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { api } from 'boot/axios'
import { useQuasar } from 'quasar'
import { useRouter } from 'vue-router'

const $q = useQuasar()
const router = useRouter()

const user = ref({})

const userInitials = computed(() => {
  if (!user.value.username) return 'U'
  return user.value.username.charAt(0).toUpperCase()
})

const fetchUserData = async () => {
  try {
    const response = await api.get('/api/user/me')
    user.value = response.data
    console.log(user.value)
  } catch {
    $q.notify({
      type: 'negative',
      message: 'Ошибка загрузки данных пользователя'
    })
    router.push('/login')
  }
}

const logout = async () => {
  try {
    await api.post('/api/user/logout')
    $q.notify({
      type: 'positive',
      message: 'Вы успешно вышли из системы'
    })
    router.push('/login')
  } catch {
    $q.notify({
      type: 'negative',
      message: 'Ошибка при выходе из системы'
    })
  }
}

onMounted(() => {
  fetchUserData()
})
</script>
