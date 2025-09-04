<template>
  <q-page class="flex flex-center">
    <q-card class="q-pa-lg" style="width: 400px; max-width: 90%">
      <q-card-section>
        <div class="text-h6">Авторизация</div>
      </q-card-section>

      <q-card-section>
        <q-input
          v-model="form.username"
          label="Username"
          outlined
          dense
          :rules="[val => !!val || 'Обязательное поле']"
        />
        <q-input
          v-model="form.password"
          label="Password"
          type="password"
          outlined
          dense
          :rules="[val => !!val || 'Обязательное поле']"
        />
      </q-card-section>

      <q-card-actions align="right">
        <q-btn
          label="Войти"
          color="primary"
          @click="login"
          :loading="loading"
        />
      </q-card-actions>
    </q-card>
  </q-page>
</template>

<script setup>
import { ref } from 'vue'
import { api } from 'boot/axios'
import { useQuasar } from 'quasar'
import { useRouter } from 'vue-router'

const $q = useQuasar()
const router = useRouter()

const form = ref({
  username: '',
  password: ''
})
const loading = ref(false)

const login = async () => {
  loading.value = true
  try {
    const res = await api.post('/api/user/login', form.value)
    localStorage.setItem('token', res.data.token) // <-- если сервер возвращает JWT
    await api.get('/api/user/me')
    $q.notify({ type: 'positive', message: 'Добро пожаловать!' })
    router.push('/projects')
  } catch (err) {
    console.error(err)
    $q.notify({ type: 'negative', message: err.response?.data?.error || 'Ошибка авторизации' })
  } finally {
    loading.value = false
  }
}
</script>
