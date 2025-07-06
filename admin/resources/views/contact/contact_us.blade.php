@extends('layout.master')
@section('content')
<title>Contact Messages</title>
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
<script src="https://cdn.tailwindcss.com"></script>

<main class="flex-1 bg-[#B5E2FF] p-6 min-h-screen">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Messages from Users</h2>

        <table class="min-w-full bg-white shadow-md rounded">
            <thead class="bg-[#D9D9D9] text-gray-600 uppercase text-sm">
                <tr>
                    <th class="py-3 px-6 text-left">No</th>
                    <th class="py-3 px-6 text-left">First Name</th>
                    <th class="py-3 px-6 text-left">Last Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Message</th>
                    <th class="py-3 px-6 text-left">Date</th>
                    <!-- <th class="py-3 px-6 text-center">Action</th> -->
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach($contacts_us as $contact_us)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6">{{ $contact_us->first_name }}</td>
                        <td class="py-3 px-6">{{ $contact_us->last_name }}</td>
                        <td class="py-3 px-6">{{ $contact_us->email }}</td>
                        <td class="py-3 px-6">{{ \Illuminate\Support\Str::words($contact_us->message, 10, '...') }}</td>
                        <td class="py-3 px-6">{{ optional($contact_us->created_at)->format('g:i A l, F d, Y') ?? '—' }} </td>
                        <!-- <td class="py-3 px-6 text-center">
                            <button onclick="openModal({{ $contact_us->id }})"
                                class="bg-green-500 hover:bg-green-600 text-white rounded px-4 py-2 text-sm">
                                Reply
                            </button>
                        </td> -->
                    </tr>

                    <!-- Modal for reply -->
                    <div id="modal-{{ $contact_us->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white p-6 rounded shadow-xl w-full max-w-xl relative">
                            <button onclick="closeModal({{ $contact_us->id }})" class="absolute top-2 right-2 text-gray-500 hover:text-red-600">&times;</button>
                            <h3 class="text-center text-lg font-bold mb-4">Send Email</h3>
                            <div class="bg-blue-100 p-4 rounded mb-4">
                                <div class="flex items-center mb-2">
                                    <img src="https://via.placeholder.com/40" class="rounded-full mr-3" />
                                    <div>
                                        <p class="font-bold">{{ $contact_us->first_name }} {{ $contact_us->last_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $contact_us->email }}</p>
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $contact_us->content }}</p>
                            </div>

                            <form action="{{ route('contact.sendReply', $contact_us->id) }}" method="POST">
                                @csrf
                                <label class="block font-medium mb-1">Admin Reply</label>
                                <textarea name="reply" class="w-full border rounded p-2 mb-4" rows="4" required></textarea>
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">Reply</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

<script>
    function openModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
    }
</script>
@endsection
