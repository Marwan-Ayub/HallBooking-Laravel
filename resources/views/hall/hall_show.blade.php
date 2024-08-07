<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ('Hall Show') }}
        </h2>
    </x-slot>

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger"> {{$error}} </div>
    @endforeach
    @endif

    @if (session('Result'))
    <div class="py-3 px-5 bg-red-500 text-white"> {{session('Result')}}</div>
    @endif

    {{-- <div class=" min-w-full flex flex-wrap bg-white  px-10 pb-10 rounded-md shadow-md overflow-hidden md:max-w-2xl">
    @foreach ($hallBooks as $hallBook)
        <div class="md:flex pb-3 rounded-2xl">
          <div class="px-10 pb-10 mx-5 flex flex-col ">
            <div class="uppercase p-3 tracking-wide text-sm text-indigo-500 font-semibold">Subject
                <p class="mt-2 text-gray-900">{{ $hallBook->subject->name_sub }}</p>

            </div>
            <div class="uppercase p-3 tracking-wide text-sm text-indigo-500 font-semibold">Date

                <p class="mt-2 text-gray-900">{{ $hallBook['date_end'] }}</p>
            </div>
            <div class="uppercase p-3 tracking-wide text-sm text-indigo-500 font-semibold">Time Start

                <p class="mt-2 text-gray-900">{{ $hallBook['time_start'] }}</p>
            </div>
            <div class="uppercase p-3 tracking-wide text-sm text-indigo-500 font-semibold">Time End
                <p class="mt-2 text-gray-900">{{ $hallBook['time_end'] }}</p>

            </div>
            <div class="uppercase p-3 tracking-wide text-sm text-indigo-500 font-semibold">Hall
                <p class="mt-2 text-gray-900">{{ $hallBook->hall->name_hall }}</p>

            </div>
            <div class="mt-4">
                <form action="{{route('hall.destroy',$hallBook->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 focus:outline-none transition-colors">Delete</button>
                </form>
            </div>
          </div>
        </div>
        @endforeach
    </div> --}}

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-3 mt-2 justify-items-center">
        @foreach ($hallBooks as $hallBook)
        <div class="bg-gray-100 rounded-lg shadow-md text-lg p-10">

           {{-- Store details  --}}
            <p class="text-lg text-gray-600 mb-4"><b>Subject:</b> &nbsp; {{$hallBook->subject ? $hallBook->subject->name_sub : 'Subject Deleted'}}</p>
            <p class="text-gray-600 text-lg mb-2"><b>Date:</b>&nbsp; {{ $hallBook->date_end }}</p>
            <p class="text-gray-600 text-lg mb-2"><b>Time Start:</b>&nbsp; {{ $hallBook->time_start }}</p>
            <p class="text-gray-600 text-lg mb-2"><b>Time End:</b> &nbsp;{{ $hallBook->time_end }}</p>
            <p class="text-gray-600 text-lg mb-2"><b>Hall:</b> &nbsp;{{ $hallBook->hall->name_hall }}</p>

            <form action="{{ route('hall.destroy', $hallBook->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none transition-colors">Delete</button>
            </form>
        </div>
        @endforeach
    </div>

</x-app-layout>
