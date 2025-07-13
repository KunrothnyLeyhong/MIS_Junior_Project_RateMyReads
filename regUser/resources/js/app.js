import axios from 'axios';

// Make sure Axios sends cookies with every request
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://127.0.0.1:8000';
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


import './bootstrap';
import { createApp } from 'vue';
import navbar from './components/layout/navbar.vue';
import HomePage from './components/HomePage.vue';
import Dashboard from './components/Dashboard.vue'; 
import AddBook from './components/AddBook.vue';
import UpdateBook from './components/UpdateBook.vue';
import ViewBookPage from './components/ViewBookPage.vue';
import BookDetail from './components/BookDetail.vue';
import StarRating from './components/StarRating.vue';
import EditProfile from './components/EditProfile.vue';
import ChangePassword from './components/ChangePassword.vue';
import BookLists from './components/BookLists.vue';
import SearchBar from './components/SearchBar.vue';
import BookReview from './components/BookReview.vue';
import ReviewForm from './components/ReviewForm.vue';
import LibraryStatus from './components/LibraryStatus.vue';
import dayjs from 'dayjs';
import customParseFormat from 'dayjs/plugin/customParseFormat';
import advancedFormat from 'dayjs/plugin/advancedFormat'; // For 'Do' format like 1st, 2nd, 3rd

const app = createApp({});
app.component('home-page', HomePage);
app.component('navbar', navbar);
app.component('dashboard', Dashboard);
app.component('add-book-form', AddBook);
app.component('update-book-form', UpdateBook);
app.component('view-book-page', ViewBookPage);
app.component('book-detail', BookDetail);
app.component('star-rating', StarRating);
app.component('edit-profile', EditProfile);
app.component('change-password', ChangePassword);
app.component('book-lists', BookLists);
app.component('search-bar', SearchBar);
app.component('book-review', BookReview);
app.component('review-form', ReviewForm);
app.component('library-status', LibraryStatus);
dayjs.extend(customParseFormat);
dayjs.extend(advancedFormat);

app.mount('#app');

document.addEventListener('DOMContentLoaded', function () {
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const userDropdown = document.getElementById('userDropdown');

    // Toggle dropdown visibility only if both elements exist
    if (dropdownButton && dropdownMenu) {
        dropdownButton.addEventListener('click', function () {
            dropdownMenu.classList.toggle('hidden');
        });
    }

    // Close dropdown when clicking outside (only if dropdownMenu exists)
    if (dropdownMenu && userDropdown) {
        window.addEventListener('click', function (event) {
            if (!event.target.closest('#userDropdown')) {
                dropdownMenu.classList.add('hidden');
            }
        });
    }
});
