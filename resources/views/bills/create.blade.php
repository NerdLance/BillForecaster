<x-app-layout>
    <x-slot name="header">
        <h2 class='font-semibold text-xl text-gray-800 leading-tight'>
            {{ __('Add a Bill') }}
        </h2>
    </x-slot>

    <x-form-card>
        <h3 class='text-xl text-center mb-4 text-gray-800'>Bill Details</h3>
        <x-auth-validation-errors class='mb-4' :errors="$errors" />
            
        <form method="POST" action="{{ route('bills-store') }}">
            @csrf

            <div>
                <x-input-label for="title" :value="__('Bill Title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title') }}" required /> 
            </div>

            <div class='mt-4'>
                <x-input-label for="cost" :value="__('Bill Cost')" />
                <x-text-input id="cost" class="block mt-1 w-full" type="text" name="cost" value="{{ old('cost') }}" required /> 
            </div>

        </form>
    </x-form-card>

</x-app-layout>