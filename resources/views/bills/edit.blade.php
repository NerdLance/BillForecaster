<x-app-layout>
    <x-slot name="header">
        <h2 class='font-semibold text-xl text-gray-800 leading-tight'>
            {{ __('Edit Bill') }}
        </h2>
    </x-slot>

    <x-form-card>
        <h3 class='text-xl text-center mb-4 text-gray-800'>Edit Bill: {{ $bill->title }}</h3>
        <x-auth-validation-errors class='mb-4' :errors="$errors" />
            
        <form method="POST" action="/bills/{{$bill->id}}">
            @csrf
            @method('PUT')
            <div>
                <x-input-label for="title" :value="__('Bill Title (required)')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $bill->title }}" required /> 
            </div>

            <div class='mt-4'>
                <x-input-label for="cost" :value="__('Bill Cost')" />
                <x-text-input id="cost" class="block mt-1 w-full" type="text" name="cost" value="{{ $bill->cost }}" required /> 
            </div>

            <div class='mt-4'>
                <x-input-label for="start" :value="__('Next Bill Date (required)')" />
                <x-text-input id="start" class="block mt-1 w-full" type="date" name="start" value="{{ $bill->start }}" required /> 
            </div>

            <div class='mt-4'>
                <x-input-label for='recurrance' :value="__('Recurrance (required)')" />
                {{-- <div class='flex justify-left'> --}}
                    <select id='recurrance' name='recurrance' class='w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50'>
                        <option value='one' {{ ($bill->recurrance == 'one') ? 'selected' : '' }}>One Time</option>
                        <option value='daily' {{ ($bill->recurrance == 'daily') ? 'selected' : '' }}>Daily</option>
                        <option value='weekly' {{ ($bill->recurrance == 'weekly') ? 'selected' : '' }}>Weekly</option>
                        <option value='monthly' {{ ($bill->recurrance == 'monthly') ? 'selected' : '' }}>Monthly</option>
                        <option value='quarterly' {{ ($bill->recurrance == 'quarterly') ? 'selected' : '' }}>Quarterly</option>
                        <option value='yearly' {{ ($bill->recurrance == 'yearly') ? 'selected' : '' }}>Yearly</option>
                    </select>
                {{-- </div> --}}
            </div>
            
            <div class='mt-6'>
                <x-primary-button>Update Bill</x-primary-button>
            </div>

        </form>
    </x-form-card>

</x-app-layout>