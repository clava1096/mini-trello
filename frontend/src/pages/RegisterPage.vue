<template>
  <q-page class="flex flex-center">
    <q-card class="q-pa-lg" style="width: 400px; max-width: 90%">
      <q-card-section>
        <div class="text-h6">Регистрация</div>
      </q-card-section>

      <q-card-section>
        <q-input v-model="form.username" label="Логин" outlined dense />
        <q-input v-model="form.email" label="Email" outlined dense />
        <q-input v-model="form.password" label="Пароль" type="password" outlined dense />
      </q-card-section>

      <q-card-actions align="right">
        <q-btn label="Зарегистрироваться" color="primary" @click="register" />
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
  email: '',
  password: ''
})

const loading = ref(false)

const register = async () => {
  loading.value = true
  try {
    await api.post('/api/user/register', form.value)
    $q.notify({ type: 'positive', message: 'Регистрация успешна!' })
    router.push('/login')
  } catch (err) {
    $q.notify({ type: 'negative', message: err.response?.data?.message || 'Ошибка при регистрации' })
  } finally {
    loading.value = false
  }
}
</script>
