<!DOCTYPE html>
<html lang="bn" class="h-full bg-[#f8fafc]">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title', 'Administrative Console — আগামীর শৈলকুপা')</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>

  <!-- Font Awesome 6 Free CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

  <!-- Remix Icon CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" />

  <!-- Google Fonts: Hind Siliguri & Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Noto+Sans+Bengali:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Quill.js Rich Text Editor CDN -->
  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

  <!-- Custom Scrollbar & Styles -->
  <style>
    /* Custom Modern Slim Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
      width: 5px;
      height: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
      background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 9999px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    /* Global page scrollbar */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #f8fafc;
    }
    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #0b4622;
    }

    body {
      font-family: 'Hind Siliguri', 'Inter', sans-serif;
    }

    /* Toast Animation */
    @keyframes toastSlideIn {
      from {
        opacity: 0;
        transform: translateY(20px) scale(0.96);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }
    .toast-animate-in {
      animation: toastSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
  </style>
  @stack('styles')
</head>
<body class="h-full bg-[#f8fafc] text-gray-800 antialiased selection:bg-[#0b4622] selection:text-white flex overflow-hidden">

  <!-- Sidebar Component -->
  @include('layouts.admin.sidebar')

  <!-- Main Content Wrapper (Shifted right for desktop) -->
  <div class="flex-1 flex flex-col min-w-0 lg:pl-64 overflow-hidden bg-[#f8fafc]">
    
    <!-- Navbar Component -->
    @include('layouts.admin.navbar')

    <!-- Scrollable Page Content Area with Custom Scrollbar -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-7 lg:p-9 custom-scrollbar">
      @yield('content')
    </main>

  </div>

  <!-- Bottom-Right Toast Notification Container -->
  <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col space-y-2.5 pointer-events-none"></div>

  <!-- Admin Interactive Scripts -->
  <script>
    // Sidebar Menu Dropdown Toggle with Smooth Height/Opacity Animation
    function toggleSidebarDropdown(menuId, buttonEl) {
      const menu = document.getElementById(menuId);
      if (!menu) return;

      const arrow = buttonEl.querySelector('.dropdown-arrow');
      const isClosed = menu.classList.contains('max-h-0') || menu.style.maxHeight === '0px' || getComputedStyle(menu).maxHeight === '0px';

      if (isClosed) {
        menu.classList.remove('max-h-0', 'opacity-0');
        menu.classList.add('opacity-100');
        menu.style.maxHeight = (menu.scrollHeight + 30) + 'px';
        buttonEl.classList.add('bg-gray-100/70', 'text-[#0b4622]');
        if (arrow) arrow.classList.add('rotate-180', 'text-[#0b4622]');
      } else {
        menu.style.maxHeight = '0px';
        menu.classList.remove('opacity-100', 'max-h-[1000px]', 'max-h-96');
        menu.classList.add('max-h-0', 'opacity-0');
        buttonEl.classList.remove('bg-gray-100/70', 'text-[#0b4622]');
        if (arrow) arrow.classList.remove('rotate-180', 'text-[#0b4622]');
      }
    }

    // Sidebar Toggle for Mobile
    function toggleAdminSidebar() {
      const sidebar = document.getElementById('admin-sidebar');
      const backdrop = document.getElementById('admin-sidebar-backdrop');
      if (!sidebar) return;

      const isClosed = sidebar.classList.contains('-translate-x-full');
      if (isClosed) {
        sidebar.classList.remove('-translate-x-full');
        backdrop?.classList.remove('hidden');
      } else {
        sidebar.classList.add('-translate-x-full');
        backdrop?.classList.add('hidden');
      }
    }

    // User Dropdown Toggle
    function toggleAdminUserDropdown(event) {
      if (event) event.stopPropagation();
      const menu = document.getElementById('admin-user-dropdown-menu');
      const notifMenu = document.getElementById('admin-notification-menu');
      if (notifMenu) notifMenu.classList.add('hidden');
      if (menu) menu.classList.toggle('hidden');
    }

    // Notification Dropdown Toggle
    function toggleAdminNotification(event) {
      if (event) event.stopPropagation();
      const menu = document.getElementById('admin-notification-menu');
      const userMenu = document.getElementById('admin-user-dropdown-menu');
      if (userMenu) userMenu.classList.add('hidden');
      if (menu) menu.classList.toggle('hidden');
    }

    // Close Dropdowns on Click Outside
    document.addEventListener('click', function(e) {
      const userContainer = document.getElementById('admin-user-dropdown-container');
      const userMenu = document.getElementById('admin-user-dropdown-menu');
      if (userContainer && userMenu && !userContainer.contains(e.target)) {
        userMenu.classList.add('hidden');
      }

      const notifContainer = document.getElementById('admin-notification-container');
      const notifMenu = document.getElementById('admin-notification-menu');
      if (notifContainer && notifMenu && !notifContainer.contains(e.target)) {
        notifMenu.classList.add('hidden');
      }
    });

    // Toast Notification System
    function showToast(message, type = 'success') {
      const container = document.getElementById('toast-container');
      if (!container) return;

      const toast = document.createElement('div');
      toast.className = `pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-2xl shadow-xl border text-xs sm:text-sm font-semibold max-w-sm toast-animate-in transition-all duration-300 ${
        type === 'success'
          ? 'bg-white border-emerald-200 text-gray-800'
          : 'bg-white border-red-200 text-gray-800'
      }`;

      const iconColor = type === 'success' ? 'bg-emerald-50 text-[#0b4622]' : 'bg-red-50 text-[#c8102e]';
      const iconClass = type === 'success' ? 'ri-checkbox-circle-fill' : 'ri-error-warning-fill';

      toast.innerHTML = `
        <span class="w-8 h-8 rounded-xl ${iconColor} flex items-center justify-center text-lg shrink-0">
          <i class="${iconClass}"></i>
        </span>
        <div class="flex-1 min-w-0">
          <p class="font-bold text-gray-900">${type === 'success' ? 'সফল হয়েছে' : 'ত্রুটি'}</p>
          <p class="text-[11px] text-gray-500 leading-tight mt-0.5">${message}</p>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 transition ml-1">
          <i class="ri-close-line text-base"></i>
        </button>
      `;

      container.appendChild(toast);

      setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px) scale(0.95)';
        setTimeout(() => toast.remove(), 300);
      }, 4000);
    }

    // AJAX System Cache & Route Refresh
    function runCacheRefresh() {
      const btn = document.getElementById('btn-cache-refresh');
      const icon = document.getElementById('btn-cache-refresh-icon');
      if (!btn || !icon) return;

      // Animate spin & disable
      btn.disabled = true;
      icon.classList.add('animate-spin');

      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

      fetch("{{ route('admin.optimize.cache') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken || '',
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          showToast(data.message, 'success');
        } else {
          showToast(data.message || 'ক্যাশ ক্লিয়ার হতে ব্যর্থ হয়েছে।', 'error');
        }
      })
      .catch(error => {
        showToast('সার্ভারের সাথে যোগাযোগ করতে ব্যর্থ হয়েছে।', 'error');
      })
      .finally(() => {
        btn.disabled = false;
        icon.classList.remove('animate-spin');
      });
    }
  </script>
  @stack('scripts')
</body>
</html>
