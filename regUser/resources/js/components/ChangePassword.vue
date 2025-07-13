<!-- resources/js/components/ChangePassword.vue -->
<template>
  <div class="py-10 pt-35">
    <div class="bg-[#B5E2FF] p-15 rounded-lg max-w-xl mx-auto mt-10 shadow">
      <h2 class="text-2xl font-bold text-center mb-8">CHANGE PASSWORD</h2>

      <form @submit.prevent="changePassword">
        <div v-for="(field, index) in fields" :key="index" class="mb-5 relative">
          <input :type="field.show ? 'text' : 'password'" v-model="field.value" :placeholder="field.placeholder"
            class="mt-1 w-full px-5 py-3 rounded-2xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white">
          <button type="button" class="absolute right-4 top-4 text-gray-600" @click="field.show = !field.show">
            <span v-if="field.show">👁️</span>
            <span v-else>🙈</span>
          </button>
        </div>

        <div class="text-center mt-6">
          <button @click="saveChanges"
            class="bg-[#45B6FE] hover:bg-blue-600 text-black font-semibold px-10 py-3 mt-5 rounded-2xl">SAVE
            CHANGES</button>
        </div>
      </form>

      <p v-if="message" class="text-center mt-4 text-green-600 font-medium">{{ message }}</p>
      <p v-if="error" class="text-center mt-4 text-red-600 font-medium">{{ error }}</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      fields: [
        { placeholder: 'Enter Old Password', value: '', show: false },
        { placeholder: 'Create New Password', value: '', show: false },
        { placeholder: 'Re-enter New Password', value: '', show: false },
      ],
      message: '',
      error: '',
    };
  },
  methods: {
    async changePassword() {
  const [old_password, new_password, new_password_confirmation] = this.fields.map(f => f.value);

  if (new_password !== new_password_confirmation) {
    this.error = 'New passwords do not match.';
    this.message = '';
    return;
  }

  try {
    const response = await axios.post('/update-password', {
      old_password,
      new_password,
      new_password_confirmation, // ✅ Correct key for Laravel
    });

    this.message = response.data.message;
    this.error = '';
    this.fields.forEach(f => (f.value = ''));
  } catch (err) {
    this.error = err.response?.data?.message || 'Something went wrong';
    this.message = '';
  }
}

  },
};
</script>
