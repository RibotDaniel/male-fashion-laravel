<script>
    function soloLetras(e) {
        let key = e.keyCode || e.which;
        let tecla = String.fromCharCode(key);
        let regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
        let errorMsg = document.getElementById('name-error');

        if (e.key === 'Backspace' || e.key === 'Tab' || e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            return true;
        }

        if (!regex.test(tecla)) {
            if (errorMsg) errorMsg.classList.remove('hidden');
            return false;
        }

        if (errorMsg) errorMsg.classList.add('hidden');
        return true;
    }

    function validarNombre(input) {
        let errorMsg = document.getElementById('name-error');

        if (/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(input.value)) {
            if (errorMsg) errorMsg.classList.remove('hidden');
            input.value = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        }
    }
</script>

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                          onkeypress="return soloLetras(event)" 
                          oninput="validarNombre(this)" />
            
            <p id="name-error" class="text-sm text-red-600 mt-1 hidden">
                No se permiten números o caracteres especiales en el nombre.
            </p>

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>