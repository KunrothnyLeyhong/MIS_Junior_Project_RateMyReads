<template>
    <h2 class="text-3xl font-bold text-center mb-10 pt-25">ADD NEW BOOK</h2>
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
                        <img src="img/calendar.png" class="w-7" />
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

<script>
export default {
    data() {
        return {
            form: {
                title: '',
                author: '',
                genre: '',
                pages: '',
                published_date: '',
                description: '',
                image: null,
                cloudinaryImageUrl: ''
            },
            fileName: ''
        };
    },
    methods: {
        // Handle file selection
        handleFile(e) {
            this.form.image = e.target.files[0];
            this.fileName = this.form.image?.name ?? '';
        },

        // Upload image to Cloudinary
        async uploadToCloudinary(file) {
    const formData = new FormData();
    formData.append('file', file);
    formData.append('upload_preset', 'RateMyReads_bookImage'); // Replace with your Cloudinary preset

    try {
        const response = await axios.post(
            'https://api.cloudinary.com/v1_1/dvkvc9lxe/image/upload',
            formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                // ✅ Disable credentials to fix CORS issue
                withCredentials: false
            }
        );
        return response.data.secure_url;  // Return Cloudinary image URL
    } catch (error) {
        console.error('Image upload failed:', error);
        throw new Error('Image upload failed');
    }
},


        async submitForm() {
    // Upload image if selected
    if (this.form.image) {
        try {
            const imageUrl = await this.uploadToCloudinary(this.form.image);
            this.form.cloudinaryImageUrl = imageUrl;  // This is the URL you want to send to the backend
        } catch (error) {
            alert('Failed to upload image to Cloudinary');
            return;
        }
    }

    // Create form data for submission
    const formData = new FormData();
    
    // Append form data (including image URL)
    for (let key in this.form) {
        formData.append(key, this.form[key]);
    }

    // // If you have cloudinaryImageUrl, make sure it is added to the formData
    // if (this.form.cloudinaryImageUrl) {
    //     formData.append('cloudinaryImageUrl', this.form.cloudinaryImageUrl);
    // }

    // Send form data to the backend (Laravel)
    try {
        await axios.post('/addBook', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        });

        // On success, reset the form and redirect
        alert('Book added successfully!');
        this.resetForm();
        window.location.href = '/books';  // Redirect to view books page
    } catch (error) {
        console.error(error);
        alert('Something went wrong. Please try again.');
    }
},


        // Reset the form after successful submission
        resetForm() {
            this.form = {
                title: '',
                author: '',
                genre: '',
                pages: '',
                publisher: '',
                published_date: '',
                description: '',
                image: null,
                cloudinaryImageUrl: ''
            };
            this.fileName = '';
        }
    }
};
</script>

<style scoped></style>
