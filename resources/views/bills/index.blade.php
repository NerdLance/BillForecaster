<x-app-layout>
    <x-slot name="header">
        <h2 class='font-semibold text-xl text-gray-800 leading-tight'>
            {{ __('Bills') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @unless ($bills->isEmpty())
                        <div class='grid grid-cols-1 md:grid-cols-4 gap-4'>
                            @foreach ($bills as $bill)
                                <div class='border rounded border-gray-300 p-4 mb-4'>
                                    <p class='text-xl'>{{ $bill->title }}</p>
                                    <p>{{ $bill->cost }}</p>
                                    <p>{{ $bill->start }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>You have no bills</p>
                    @endunless
                </div>
            </div>
        </div>
    </div>
</x-app-layout>