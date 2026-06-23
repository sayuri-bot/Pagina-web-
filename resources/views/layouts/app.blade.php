<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

  <title>@yield('title', 'PROCAFES')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    .bg-procafes { background-color:#f2dd6c; }
    .btn-procafes-dark { background-color:#3e350e; color:#fff; }
    .btn-procafes-dark:hover { filter:brightness(1.1); }
    .btn-procafes-accent { background-color:#daad29; color:#3e350e; }
    .btn-procafes-accent:hover { filter:brightness(1.05); }
    .link-procafes { color:#3e350e; }
    .link-procafes:hover { color:#2c250a; }
  </style>

  @if (class_exists(\Livewire\Livewire::class))
    @livewireStyles
  @endif

  <script>
    window.Laravel = {
      csrfToken: "{{ csrf_token() }}",
      routes: {
        index: "{{ url('cart') }}",
        add:   "{{ url('cart/add') }}",
        base:  "{{ url('cart') }}",
        clear: "{{ url('cart') }}"
      }
    };
  </script>

  @stack('styles')
</head>
<body class="bg-light">

  @includeIf('partials.header')

  {{-- Flash messages --}}
  <div class="container mt-3">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if (session('info'))
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
  </div>

  <main class="@yield('main_class', 'container py-4')">
    @hasSection('content')
      @yield('content')
    @else
      {{ $slot ?? '' }}
    @endif
  </main>

  @includeWhen(View::exists('partials.cart-offcanvas'), 'partials.cart-offcanvas')

  @if (class_exists(\Livewire\Livewire::class))
    @livewireScripts
  @endif

  <script>
    window.App = {
      isAuth: @json(auth()->check()),
      routes: {
        checkout: "{{ Route::has('checkout') ? route('checkout') : '' }}",
        login: "{{ route('login') }}"
      }
    };
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/cart.js') }}"></script>

  <script>
  document.addEventListener('DOMContentLoaded', () => {

    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    document.querySelectorAll('.js-wishlist-toggle').forEach(form => {

      form.addEventListener('submit', async (ev) => {
        ev.preventDefault();

        const productId = form.getAttribute('data-product');
        const btn = form.querySelector('button');

        btn?.setAttribute('disabled','disabled');

        try {
          const res = await fetch("{{ route('wishlist.toggle') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ product_id: productId })
          });

          const data = await res.json();

          if (data.count !== undefined) {
            const countEl = document.getElementById('wishlistCount');
            if (countEl) countEl.textContent = data.count;
          }

        } catch (e) {
          console.error(e);
        } finally {
          btn?.removeAttribute('disabled');
        }
      });

    });

  });
  </script>

<!-- ================= CHATBOT PROCAFES ================= -->

<!-- 🔘 BOTÓN -->
<div id="chatbot-btn">☕</div>

<!-- 💬 CHAT -->
<div id="chatbot-box">
    <div id="chat-header">PROCAFES ☕</div>

    <div id="chat-messages">
        <div class="bot">👋 Hola ¿En qué podemos ayudarte?</div>
    </div>

    <div id="chat-input">
        <input type="text" id="msg" placeholder="Escribe tu mensaje...">
        <button onclick="send()">Enviar</button>
    </div>
</div>

<!-- 🎨 ESTILOS -->
<style>
#chatbot-btn {
  position: fixed;
  width: 75px;
  height: 75px;
  bottom: 25px;
  right: 25px;
  background: linear-gradient(135deg, #6f4e37, #3e2723);
  border-radius: 50%;
  box-shadow: 0 3px 15px rgba(0,0,0,0.25);
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 32px;
  color: white;
  cursor: pointer;
  transition: 0.3s;
}

#chatbot-btn:hover {
  transform: scale(1.08);
}

#chatbot-box {
  position: fixed;
  bottom: 110px;
  right: 25px;
  width: 320px;
  height: 420px;
  background: white;
  display: none;
  flex-direction: column;
  border-radius: 12px;
  box-shadow: 0 0 15px rgba(0,0,0,0.2);
  z-index: 1000;
}

#chat-header {
  background: #6f4e37;
  color: white;
  padding: 12px;
  border-radius: 12px 12px 0 0;
  font-weight: bold;
}

#chat-messages {
  flex: 1;
  padding: 10px;
  overflow-y: auto;
  font-size: 14px;
}

.bot {
  margin: 5px 0;
}

.user {
  text-align: right;
  margin: 5px 0;
}

#chat-input {
  display: flex;
  border-top: 1px solid #ddd;
}

#chat-input input {
  flex: 1;
  border: none;
  padding: 10px;
  outline: none;
}

#chat-input button {
  background: #6f4e37;
  color: white;
  border: none;
  padding: 10px 15px;
  cursor: pointer;
}
</style>

<!-- ⚡ SCRIPT -->
<script>
// abrir / cerrar chatbot
document.getElementById('chatbot-btn').onclick = function () {
    let box = document.getElementById('chatbot-box');
    box.style.display = box.style.display === 'flex' ? 'none' : 'flex';
};

// enviar mensaje
function send() {
    let input = document.getElementById('msg');
    let msg = input.value.trim();

    if (!msg) return;

    let chat = document.getElementById('chat-messages');

    // mostrar mensaje usuario
    chat.innerHTML += `<div class="user">🧑 ${msg}</div>`;

    // enviar a Laravel
    fetch('/chatbot', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({message: msg})
    })
    .then(res => res.json())
    .then(data => {
        chat.innerHTML += `<div class="bot">🤖 ${data.reply}</div>`;
        chat.scrollTop = chat.scrollHeight;
    });

    input.value = "";
}
</script>

<!-- ================= FIN CHATBOT ================= -->
