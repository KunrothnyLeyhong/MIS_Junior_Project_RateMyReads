<template>
    <div class="pt-53 pb-10">
        <div class="flex flex-wrap justify-around">
            <!-- Left Column -->
            <div class="bg-[#B5E2FF] p-6 rounded-xl shadow-lg w-full md:w-1/4 text-center pt-20">
                <img :src="form.profile_picture || defaultPicture" alt="Uploaded Profile Picture"
                    class="w-40 h-40 rounded-full mx-auto mt-3 object-cover" />
                <input type="file" ref="fileInput" class="hidden" @change="uploadImage" accept="image/*">
                <button
                    class="mt-4 mb-2 w-full px-5 py-3 rounded-2xl border border-black focus:outline-none shadow-xl focus:ring-2 bg-white"
                    @click="$refs.fileInput.click()">Upload from device</button>
            </div>

            <!-- Right Column -->
            <div class="bg-[#B5E2FF] p-15 rounded-xl shadow-lg w-full md:w-2/3">
                <h2 class="text-center text-2xl font-bold mb-10">EDIT PROFILE</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input v-model="form.first_name" type="text" placeholder="First Name"
                        class="mt-1 w-full px-5 py-3 rounded-2xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white">
                    <input v-model="form.last_name" type="text" placeholder="Last Name"
                        class="mt-1 w-full px-5 py-3 rounded-2xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white">
                    <input v-model="form.email" type="email" placeholder="Email"
                        class="mt-1 w-full px-5 py-3 rounded-2xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white">
                    <input v-model="form.phone" type="text" placeholder="Phone number"
                        class="mt-1 w-full px-5 py-3 rounded-2xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white">
                </div>
                <div class="text-center mt-6">
                    <button @click="saveChanges"
                        class="bg-[#45B6FE] hover:bg-blue-600 text-black font-semibold px-10 py-3 mt-5 rounded-2xl">SAVE
                        CHANGES</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Loading Popup -->
    <div v-if="loading" class="fixed bg-[rgba(108,114,118,0.5)] inset-0 flex items-center justify-center z-50">
        <div class="bg-white px-6 py-3 rounded-xl shadow-xl text-center text-sm font-medium">
            Uploading image...
        </div>
    </div>


</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            form: {
                first_name: this.user.first_name || '',
                last_name: this.user.last_name || '',
                email: this.user.email || '',
                phone: this.user.phone || '',
                profile_picture: this.user.profile_picture || '',
            },
            defaultPicture: '/img/default_picture.avif',
            loading: false, // loading state
        };
    },
    methods: {
        async uploadImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.loading = true; // Start loading

            const formData = new FormData();
            formData.append('file', file);
            formData.append('upload_preset', 'RateMyReads_bookImage');

            try {
                const res = await fetch('https://api.cloudinary.com/v1_1/dvkvc9lxe/image/upload', {
                    method: 'POST',
                    body: formData,
                });

                const data = await res.json();
                this.form.profile_picture = data.secure_url;
            } catch (err) {
                console.error('Upload error:', err);
                alert("Image upload failed.");
            } finally {
                setTimeout(() => {
                    this.loading = false;
                }, 1200); // keep it for a moment
            }
        },

        async saveChanges() {
            try {
                await axios.post('/profile/update', this.form);
                alert("Profile updated successfully!");
                window.location.reload();
            } catch (error) {
                console.error(error);
                alert("Error updating profile.");
            }
        }
    }
};
</script>
