<header>
  <div class="logo">Dopix</div>
  <nav id="nav" class="full-flex flex-col md:flex-row md:items-center justify-between px-4 py-2 bg-white shadow hidden md:flex">
    <!-- Liens de navigation -->
    <div class="flex flex-col md:flex-row items-start md:items-center space-y-2 md:space-y-0 md:space-x-4 w-full">
        <a href="{{ route('dashboard') }}">Accueil</a>
        <a href="{{ route('historique') }}">Historique</a>
        <a href="{{ route('verification') }}">Vérifier</a>

        <!-- Profile Dropdown -->
        <div class="relative ml-auto">
            <button id="profile-btn" class="flex items-center gap-2 text-indigo-700 font-semibold hover:text-indigo-800 focus:outline-none transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
                <span>👤 Mon Compte</span>
            </button>

            <!-- Dropdown Menu -->
            <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl hidden z-50">
                <div class="px-4 py-3 border-b border-gray-200">
                    <p class="text-sm text-gray-600">Connecté en tant que</p>
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('account.show') }}" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                    ⚙️ Paramètres du compte
                </a>
                <form method="POST" action="{{ route('logout') }}" class="border-t">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition font-semibold">
                        🚪 Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div> 
  </nav>

  <!-- Burger visible en mobile -->
  <button id="burger" class="burger md:hidden">
    <span></span>
  </button>

</header>

<script>
  // Burger menu JS
  const burger = document.getElementById('burger');
  const nav = document.getElementById('nav');
  function checkWidth() {
    if(window.innerWidth < 600) {
      burger.style.display = "block";
      nav.classList.remove('open');
    } else {
      burger.style.display = "none";
      nav.classList.remove('open');
    }
  }
  window.addEventListener('resize', checkWidth);
  checkWidth();
  burger.addEventListener('click', function(){
    nav.classList.toggle('open');
  });

  // Profile Dropdown Toggle
  const profileBtn = document.getElementById('profile-btn');
  const profileDropdown = document.getElementById('profile-dropdown');

  profileBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    profileDropdown.classList.toggle('hidden');
  });

  // Fermer le dropdown en cliquant ailleurs
  document.addEventListener('click', (e) => {
    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
      profileDropdown.classList.add('hidden');
    }
  });

  // Empêcher la fermeture en cliquant dans le dropdown
  profileDropdown.addEventListener('click', (e) => {
    e.stopPropagation();
  });
</script>