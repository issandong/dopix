@extends('layouts.app')

@section('title', 'Mon Compte')

@section('content')
<div class="container mx-auto max-w-3xl mt-10 pb-24 px-4">
    <h2 class="text-3xl font-extrabold text-indigo-700 mb-8 text-center">Mon Compte</h2>

    @if(session('status') === 'account-updated')
        <div class="text-green-600 font-semibold text-center mb-4 bg-green-50 p-3 rounded-lg border border-green-200">
            ✅ Profil mis à jour !
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="flex gap-0 mb-6 border-b border-gray-200 overflow-x-auto">
        <button class="tab-btn active px-6 py-3 font-semibold text-indigo-700 border-b-2 border-indigo-700 whitespace-nowrap hover:text-indigo-800" data-tab="profil">
            👤 Profil
        </button>
        <button class="tab-btn px-6 py-3 font-semibold text-gray-600 hover:text-indigo-700 whitespace-nowrap" data-tab="abonnement">
            💳 Abonnement
        </button>
        <button class="tab-btn px-6 py-3 font-semibold text-gray-600 hover:text-indigo-700 whitespace-nowrap" data-tab="securite">
            🔒 Sécurité
        </button>
    </div>

    <!-- TAB: PROFIL -->
    <div id="profil" class="tab-content block bg-white rounded-2xl shadow-md p-8">
        <form method="POST" action="{{ route('account.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-6">
                <label for="name" class="block font-semibold text-gray-700 mb-2">Nom</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
                @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="block font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" readonly 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="sport" class="block font-semibold text-gray-700 mb-2">Sport</label>
                    <input type="text" name="sport" id="sport" value="{{ old('sport', $user->sport) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    @error('sport') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label for="federation" class="block font-semibold text-gray-700 mb-2">Fédération</label>
                    <input type="text" name="federation" id="federation" value="{{ old('federation', $user->federation) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    @error('federation') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="competitionLevel" class="block font-semibold text-gray-700 mb-2">Niveau de compétition</label>
                <select name="competitionLevel" id="competitionLevel" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    <option value="">-- Choisir --</option>
                    @foreach(['Olympique', 'Professionnel', 'Amateur', 'Autre'] as $level)
                        <option value="{{ $level }}" @if(old('competitionLevel', $user->competitionLevel) == $level) selected @endif>{{ $level }}</option>
                    @endforeach
                </select>
                @error('competitionLevel') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-6">
                <label for="allergies" class="block font-semibold text-gray-700 mb-2">Allergies</label>
                @php
                    $allergiesList = ['Arachides', 'Gluten', 'Lactose', 'Pollen', 'Autre'];
                    $userAllergies = $user->allergies ? json_decode($user->allergies, true) : [];
                @endphp
                <select name="allergies[]" id="allergies" multiple 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    @foreach($allergiesList as $item)
                        <option value="{{ $item }}" @if(in_array($item, old('allergies', $userAllergies))) selected @endif>{{ $item }}</option>
                    @endforeach
                </select>
                <small class="text-gray-500 block mt-1">Ctrl+Clic pour sélectionner plusieurs options</small>
                @error('allergies') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <button class="w-full bg-indigo-700 hover:bg-indigo-800 text-white px-6 py-3 rounded-lg font-bold transition" type="submit">
                💾 Enregistrer les modifications
            </button>
        </form>
    </div>

    <!-- TAB: ABONNEMENT -->
    <div id="abonnement" class="tab-content hidden bg-white rounded-2xl shadow-md p-8">
        <h3 class="text-2xl font-bold text-indigo-700 mb-2">Choisissez votre offre</h3>
        <p class="text-gray-600 mb-6">Sélectionnez le plan qui vous convient</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Plan Gratuit -->
            <div class="border-2 border-blue-200 rounded-xl p-6 bg-[#F7FAFD] hover:shadow-lg transition">
                <h4 class="font-bold text-lg mb-2 text-gray-800">Free Plan
                    @if($currentTier === 'Free')
                        <span class="ml-2 px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full font-semibold">✓ ACTUEL</span>
                    @endif
                </h4>
                <div class="text-blue-700 text-3xl font-semibold mb-4">0,00 €</div>
                <ul class="text-gray-700 text-sm space-y-2 mb-4">
                    <li>✓ 3 vérifications AI/mois</li>
                    <li>✓ OCR OpenAI</li>
                    <li>✗ Pas de téléchargements en lot</li>
                </ul>
            </div>

            <!-- Plan Pro -->
            <div class="border-2 border-blue-500 rounded-xl p-6 bg-blue-50 shadow-md hover:shadow-xl transition">
                <h4 class="font-bold text-lg mb-2 text-gray-800">Pro Plan
                    @if($currentTier === 'Pro')
                        <span class="ml-2 px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full font-semibold">✓ ACTUEL</span>
                    @endif
                </h4>
                <div class="text-blue-700 text-3xl font-semibold mb-4">9,99 € <span class="text-lg font-normal text-gray-600">/mois</span></div>
                <ul class="text-gray-700 text-sm space-y-2 mb-4">
                    <li>✓ Vérifications illimitées</li>
                    <li>✓ Historique complet</li>
                    <li>✓ Export des données</li>
                    <li>✓ OCR prioritaire</li>
                </ul>
                @if($currentTier !== 'Pro')
                    <button id="upgrade-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-bold transition">
                        🚀 Passer au Pro
                    </button>
                @endif
            </div>
        </div>

        @if($currentTier === 'Free')
        <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
            <strong class="block text-gray-800 mb-3">Utilisation actuelle</strong>
            <div class="w-full bg-gray-300 rounded-full h-3 mb-3 overflow-hidden">
                <div class="bg-blue-500 h-3 rounded-full transition-all" style="width:{{ min($usage / 3 * 100, 100) }}%"></div>
            </div>
            <span class="text-sm text-gray-700"><strong>{{ $usage }}</strong> sur <strong>3</strong> vérifications utilisées ce mois</span>
        </div>
        @endif

        <!-- Stripe Modal -->
        <div id="stripe-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-[1000] p-4">
            <div class="bg-white p-8 rounded-xl shadow-2xl max-w-sm w-full">
                <h3 class="text-2xl font-bold mb-6 text-gray-800">Upgrade vers Pro</h3>
                <form id="subscription-form">
                    <div id="card-element" class="mb-4 p-4 border-2 border-gray-300 rounded-lg bg-gray-50"></div>
                    <button type="submit" id="pay-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-bold mb-3 transition">
                        💳 Payer & Passer au Pro
                    </button>
                    <div id="card-errors" class="text-red-600 text-sm text-center"></div>
                </form>
                <button id="close-modal" class="mt-4 w-full text-gray-600 hover:text-indigo-700 font-semibold transition">Annuler</button>
            </div>
        </div>
    </div>

    <!-- TAB: SÉCURITÉ -->
    <div id="securite" class="tab-content hidden bg-white rounded-2xl shadow-md p-8">
        <h3 class="text-2xl font-bold text-indigo-700 mb-6">Sécurité & Déconnexion</h3>

        <div class="border-t pt-6">
            <h4 class="font-semibold text-gray-800 mb-2">Profil de connexion</h4>
            <p class="text-gray-600 mb-6">Vous êtes connecté en tant que : <span class="font-semibold text-indigo-700">{{ auth()->user()->email }}</span></p>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-bold transition flex items-center gap-2">
                    🚪 Se déconnecter
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    // Système d'onglets
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const tabName = btn.getAttribute('data-tab');
            
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active', 'border-b-2', 'border-indigo-700', 'text-indigo-700');
                b.classList.add('text-gray-600');
            });
            btn.classList.add('active', 'border-b-2', 'border-indigo-700', 'text-indigo-700');
            
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(tabName).classList.remove('hidden');
        });
    });

    // Stripe
    const STRIPE_PUBLIC_KEY = "{{ config('services.stripe.key') }}";
    const PRICE_ID = "{{ config('services.stripe.price_id') }}";
    const stripe = Stripe(STRIPE_PUBLIC_KEY);
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    document.getElementById('upgrade-btn')?.addEventListener('click', () => {
        document.getElementById('stripe-modal').style.display = 'flex';
    });

    document.getElementById('close-modal')?.addEventListener('click', () => {
        document.getElementById('stripe-modal').style.display = 'none';
    });

    document.getElementById('subscription-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const {paymentMethod, error} = await stripe.createPaymentMethod({
            type: 'card',
            card: card,
        });

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
            return;
        }

        const response = await fetch('{{ route("subscribe") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                payment_method_id: paymentMethod.id,
                price_id: PRICE_ID
            })
        });

        const result = await response.json();

        if (result.requires_action) {
            const {error: confirmError} = await stripe.confirmCardPayment(result.payment_intent_client_secret);
            if (confirmError) {
                document.getElementById('card-errors').textContent = confirmError.message;
                return;
            }
            window.location.reload();
        } else if (result.error) {
            document.getElementById('card-errors').textContent = result.error;
        } else {
            window.location.reload();
        }
    });
</script>
@endsection
