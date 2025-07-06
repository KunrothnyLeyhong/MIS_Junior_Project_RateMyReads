@extends('layout.master')
@section('content')

<title>Edit Profile</title>
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

<main class="flex-1 bg-[#B5E2FF] p-10">
    <div class="bg-white p-6 rounded shadow-md max-w-4xl mx-auto min-h-[500px]">
        <h2 class="text-xl font-semibold text-center mb-6">Edit Admin Profile</h2>
        <form id="updateForm" action="{{ route('adminprofile.profile.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex gap-10 items-center">
                <div class="flex flex-col items-center">
                    <label for="photoInput" class="cursor-pointer">
                        <img id="photoPreview" 
                             src="{{ $admin->photo ? asset('storage/' . $admin->photo) : 'https://i.pinimg.com/736x/6f/4d/6a/6f4d6a5a9940a1f2a8e62aaae24e9c3a.jpg' }}" 
                             class="w-24 h-24 rounded-full object-cover hover:opacity-80 transition duration-200" 
                             title="Click to change photo" />
                    </label>
                    <input id="photoInput" type="file" name="photo" class="hidden" accept="image/*" />
                </div>
                <div class="flex-1 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-600">First Name</label>
                            <input type="text" name="firstname" value="{{ $admin->firstname }}" class="w-full p-2 rounded bg-gray-100 border" />
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Last Name</label>
                            <input type="text" name="lastname" value="{{ $admin->lastname }}" class="w-full p-2 rounded bg-gray-100 border" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-600">Email</label>
                            <input type="email" name="email" value="{{ $admin->email }}" class="w-full p-2 rounded bg-gray-100 border" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-6">
                <button type="button" onclick="confirmUpdate()" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Update Profile</button>
            </div>
            <!-- Confirmation Modal -->
            <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Confirm Update</h3>
                    <p class="text-gray-600 mb-6">Are you sure you want to update your profile?</p>
                    <div class="flex justify-end space-x-3">
                        <button onclick="closeConfirmModal()" 
                            class="px-4 py-2 rounded bg-gray-300 text-gray-700 hover:bg-gray-400">Cancel</button>
                        <button onclick="submitUpdateForm()" 
                            class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600">Confirm</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
    // Preview the image before submitting
    document.getElementById('photoInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('photoPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Show confirmation popup before submit
    function confirmUpdate() {
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    function submitUpdateForm() {
        document.getElementById('updateForm').submit();
    }
</script>

@endsection
