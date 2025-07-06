@extends('layout.master')
@section('content')
<title>Register User List</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

<main class="flex-1 bg-[#B5E2FF] p-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Listed of Register User</h2>
            <form action="{{ route('user.registers') }}" method="GET" class="w-1/3">
                <input type="text" name="search" placeholder="Search by first name or last name or email"
                    value="{{ request('search') }}"
                    class="border rounded px-3 py-1 w-full" />
            </form>
        </div>

        <table class="min-w-full bg-white shadow-md rounded">
            <thead class="bg-[#D9D9D9] text-gray-600 uppercase text-sm">
                <tr>
                    <th class="py-3 px-6 text-left">No</th>
                    <th class="py-3 px-6 text-left">First Name</th>
                    <th class="py-3 px-6 text-left">Last Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach($users as $index => $user)
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-3 px-6">{{ $index + 1 }}</td>
                    <td class="py-3 px-6">{{ $user->first_name }}</td>
                    <td class="py-3 px-6">{{ $user->last_name }}</td>
                    <td class="py-3 px-6">{{ $user->email }}</td>
                    <td class="py-3 px-6">
                        <label class="switch">
                            <input type="checkbox"
                                class="status-toggle"
                                data-id="{{ $user->id }}"
                                {{ $user->status ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td class="py-3 px-6 text-center flex gap-2 justify-center">
                        <a href="{{ route('user.detailuser', $user->id) }}" class="bg-blue-500 text-white rounded px-4 py-2">Detail</a>
                        <button onclick="openModal({{ $user->id }})" class="bg-red-500 text-white rounded px-4 py-2">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-6">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>
</main>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
        <p class="mb-4">Are you sure you want to delete this user?</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript -->
<script>
function openModal(userId) {
    document.getElementById('deleteForm').action = `/user/registers/${userId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function () {
            const userId = this.dataset.id;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const checkbox = this;
            const originalState = checkbox.checked;

            fetch(`/user/registers/${userId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                // Update checkbox based on actual DB result (ensure sync)
                checkbox.checked = !!data.status;
            })
            .catch(err => {
                // Revert checkbox state silently if error happens
                checkbox.checked = originalState;
                console.error('Status update error:', err); // Optional for debugging
            });
        });
    });
});
</script>
@endsection
