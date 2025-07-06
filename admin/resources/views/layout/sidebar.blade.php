<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@section('content')
<div class="flex h-screen bg-gray-100">
  <!-- Sidebar -->
  <div class="w-64 bg-white border-r flex flex-col justify-between shadow">
    
    <!-- Navigation -->
    <nav class="px-4 py-6 space-y-10 text-gray-700">
      <a href="/dashboard" class="flex items-center gap-8 hover:text-blue-500">
        <i class="fas fa-th-large"></i> Dashboard
      </a>
      <a href="/book/listbooks" class="flex items-center gap-8 hover:text-blue-500">
        <i class="fas fa-book"></i> Books
      </a>
      <a href="/user/registers" class="flex items-center gap-8 hover:text-blue-500">
        <i class="fas fa-users"></i> Registered User
      </a>
      <a href="/admin" class="flex items-center gap-8 hover:text-blue-500">
        <i class="fas fa-building"></i> Administration
      </a>
      <a href="/report/allreport" class="flex items-center gap-8 hover:text-blue-500">
        <i class="fas fa-chart-bar"></i> Reports
      </a>
      <a href="/contact/contact_us" class="flex items-center gap-8 hover:text-blue-500">
        <i class="fa-solid fa-message"></i> Contact Us
      </a>
    </nav>

    <!-- Footer Button -->
    <div class="px-4 py-4">
      <button class="w-full py-2 bg-[#B5E2FF] hover:bg-blue-300 text-sm font-semibold text-gray-800 rounded-lg transition">
        RATEMYREADS
      </button>
    </div>
  </div>

