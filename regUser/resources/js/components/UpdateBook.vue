<template>
  <h2 class="text-3xl font-bold text-center mb-10 pt-35">UPDATE BOOK DETAILS</h2>
  <div class="bg-[#B5E2FF] px-4 md:px-16 py-10 rounded-xl max-w-4xl mx-auto shadow-md mb-10">
    <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-6">

      <!-- Book Title & Author -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div>
          <label class="mb-1 block pl-4 pt-3 pb-2">Book Title</label>
          <input v-model="form.title" type="text"
            class="mt-1 w-full px-5 py-1.5 rounded-2xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white" />
        </div>
        <div>
          <label class="mb-1 block pl-4 pt-3 pb-2">Author Name</label>
          <input v-model="form.author" type="text"
            class="mt-1 w-full px-5 py-1.5 rounded-2xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white" />
        </div>
      </div>

      <!-- Book Genre -->
      <div>
        <label class="mb-1 block pl-4 pt-3 pb-2">Book Genre</label>
        <select v-model="form.genre"
          class="mt-1 w-full px-5 py-3 rounded-2xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white appearance-none relative"
          style="background-image: url('data:image/svg+xml;utf8,<svg fill=\'%23000\' height=\'24\' viewBox=\'0 0 24 24\' width=\'24\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>'); background-repeat: no-repeat; background-position: right 1rem center;">
          <option value="" disabled>Select a genre</option>
          <option value="Romance">Romance</option>
          <option value="Fiction">Fiction</option>
          <option value="Non-fiction">Non-fiction</option>
          <option value="Mystery">Mystery</option>
          <option value="Fantasy">Fantasy</option>
          <option value="Sci-Fi">Sci-Fi</option>
          <option value="Historical">Historical</option>
          <option value="Thriller">Thriller</option>
          <option value="Horror">Horror</option>
          <option value="Young Adult">Young Adult</option>
          <option value="Children's">Children's</option>
          <option value="Biography/Memoir">Biography/Memoir</option>
          <option value="Self-Help">Self-Help</option>
          <option value="Poetry">Poetry</option>
          <option value="Graphic Novels">Graphic Novels</option>
          <option value="Others">Others</option>
        </select>
      </div>

      <!-- Publisher & Date -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div>
          <label class="mb-1 block pl-4 pt-3 pb-2">Book Pages</label>
          <input v-model="form.pages" type="number"
            class="mt-1 w-full px-5 py-1.5 rounded-2xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white" />
        </div>

        <div>
          <div class="flex pt-3 pb-2">
            <label class="mb-1 block pl-4 pr-2">Published Date</label>
            <img src="/img/calendar.png" class="w-7" />
          </div>
          <input v-model="form.published_date" type="date"
            class="mt-1 w-full px-5 py-1.5 rounded-2xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white" />
        </div>
      </div>

      <!-- Description -->
      <div>
        <label class="pl-4 pt-3 pb-2 mb-1 block">Book Descriptions</label>
        <textarea v-model="form.description" rows="5"
          class="mt-1 w-full px-5 py-1.5 rounded-2xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white"></textarea>
      </div>

      <!-- Image Upload -->
      <label class="mb-1 block pl-4 pr-2 pb-3">Book Image</label>
      <div class="w-full md:w-auto border border-gray-200 rounded-xl shadow-sm bg-white">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
          <label
            class="bg-[#45B6FE] text-black font-bold px-10 py-4 rounded-xl shadow cursor-pointer hover:bg-blue-500 transition duration-200">
            CHOOSE FILE
            <input type="file" @change="handleFile" class="hidden" />
          </label>
          <span class="text-sm text-gray-700 break-all">{{ fileName }}</span>
        </div>
      </div>

      <!-- Image preview -->
      <img
        v-if="previewImage"
        :src="previewImage"
        alt="Book Image Preview"
        class="w-1/3 object-cover rounded-lg border border-gray-300 shadow-sm mt-4"
      />

      <!-- Submit Button -->
      <div class="text-right mt-9">
        <button type="submit"
          class="bg-[#45B6FE] hover:bg-blue-500 text-black font-bold px-8 py-2 rounded-lg shadow-md">
          CONFIRM
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import axios from 'axios';

// Props
const props = defineProps({
  bookData: Object,
  bookId: Number,
});

const form = ref({
  title: props.bookData.title || '',
  author: props.bookData.author || '',
  genre: props.bookData.genre || '',
  pages: props.bookData.pages || '',
  published_date: props.bookData.published_date || '',
  description: props.bookData.description || '',
  image: props.bookData.image || '',  // Initialize with existing image URL!
});

// Track new file if selected
const newImage = ref(null);
const fileName = ref('');

// Computed preview URL for image
const previewImage = computed(() => {
  if (newImage.value) {
    // Show local selected image preview
    return URL.createObjectURL(newImage.value);
  } else if (form.value.image) {
    // Show existing image URL
    return form.value.image;
  }
  return null;
});

function handleFile(e) {
  const file = e.target.files[0];
  if (file) {
    newImage.value = file;
    fileName.value = file.name;
  }
}

async function uploadToCloudinary(file) {
  const formData = new FormData();
  formData.append('file', file);
  formData.append('upload_preset', 'RateMyReads_bookImage');

  // Remove withCredentials here — Cloudinary does NOT expect credentials
  const response = await axios.post(
    'https://api.cloudinary.com/v1_1/dvkvc9lxe/image/upload',
    formData,
    {
      // Don't send cookies or credentials here
      withCredentials: false,  // or just remove this line completely
    }
  );

  return response.data.secure_url;
}


async function submitForm() {
  try {
    // CSRF (adjust base URL to your backend)
    await axios.get('/sanctum/csrf-cookie', { withCredentials: true });
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

    // If new image selected, upload and update form.image
    if (newImage.value) {
      const imageUrl = await uploadToCloudinary(newImage.value);
      form.value.image = imageUrl;
    }

    const payload = {
      title: form.value.title,
      author: form.value.author,
      genre: form.value.genre,
      pages: form.value.pages,
      published_date: form.value.published_date,
      description: form.value.description,
      image: form.value.image,
    };

    await axios.put(
      `/books/${props.bookId}`,
      payload,
      { withCredentials: true }
    );

    alert('Book updated successfully!');
    window.location.href = '/books';

  } catch (error) {
    console.error(error);
    if (error.response?.status === 401) {
      alert('Unauthorized: Please login again.');
      window.location.href = '/login';
    } else {
      alert('Update failed');
    }
  }
}
</script>
