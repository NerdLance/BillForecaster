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
                    <div class='text-center'>
                        <h3 class='text-3xl mb-4'>Bills Due This Week (${{ $bills_this_week_total }})</h3>
                    </div>
                    @unless ($bills->isEmpty())
                        <div class='grid grid-cols-1 md:grid-cols-4 gap-4'>
                            @foreach ($bills_this_week as $bill)
                                <div class='text-center border rounded border-gray-300 p-4 mb-4 hover:shadow-md transition-all'>
                                    <p class='text-xl mb-2'>{{ $bill->title }}</p>
                                    <p>Cost: {{ "$" . $bill->cost . " / " . $bills_suffix[$bill->recurrance]}}</p>
                                    <p class='{{ ($bills_next[$bill->id] < 2) ? "font-bold text-red-500" : "" }}'>Due in {{ $bills_next[$bill->id] }} days</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>You have no bills due this week. Hooray!</p>
                    @endunless
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class='text-center'>
                        <h3 class='text-3xl mb-4'>All Bills</h3>
                    </div>
                    @unless ($bills->isEmpty())
                        <div class='grid grid-cols-1 md:grid-cols-4 gap-4'>
                            @foreach ($bills as $bill)
                                <div class='text-center border rounded border-gray-300 p-4 mb-4 hover:shadow-md transition-all'>
                                    <p class='text-xl mb-2'>{{ $bill->title }}</p>
                                    <p>Cost: {{ "$" . $bill->cost . " / " . $bills_suffix[$bill->recurrance]}}</p>
                                    <p>Due in {{ $bills_next[$bill->id] }} days</p>
                                    <a href='/bills/{{$bill->id}}/edit'>
                                        <x-basic-button class='mt-2'>Edit Bill</x-basic-button>
                                    </a>
                                    <form method="POST" action="/bills/{{$bill->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class='text-red-500 text-sm mt-2 hover:underline'>
                                            Delete
                                        </button>
                                    </form>
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