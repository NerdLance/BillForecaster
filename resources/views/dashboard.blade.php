<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class='grid grid-cols-1 md:grid-cols-2 gap-4'>
                        <a href="{{ route('bills-create') }}">
                            <div class='border rounded-md py-12 px-4 text-center hover:border-gray-300'>
                                <h3 class='text-3xl'>Add a Bill</h3>
                            </div>
                        </a>
                        <a href="{{ route('bills-index') }}">
                            <div class='border rounded-md py-12 px-4 text-center hover:border-gray-300'>
                                <h3 class='text-3xl'>View Bills</h3>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <p>Pointless Block of Nothingness</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
