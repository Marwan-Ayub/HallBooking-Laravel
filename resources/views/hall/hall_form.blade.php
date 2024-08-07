<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ('Hall Form') }}
        </h2>
    </x-slot>

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger"> {{$error}} </div>
    @endforeach
    @endif

    @if (session('Result'))
    <div class="alert alert-warning"> {{session('Result')}}</div>
    @endif

<div class="bg-gray-100 dark:bg-gray-800 transition-colors duration-300">
    <div class="container mx-auto p-4">
        <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4 text-blue-600">Hall Booking</h1>
            <p class="text-gray-600 dark:text-gray-300 mb-6">please filling the form below</p>
            <form method="POST" action="{{route('hall.store')}}">
                @csrf

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                    <label class=" text-gray-400">Subject</label>
                    <select required name="subject" class="border p-2 rounded w-full">
                        <option selected disabled>subject</option>
                        @foreach ($subjects as $subject)

                        <option value="{{ $subject->id }}">{{ $subject->name_sub }}</option>

                        @endforeach
                    </select>
{{--
                    <select required name="hall" class="border p-2 rounded w-full">
                        <option selected disabled>Room</option>
                        @foreach ($halls as $hall)

                        @php
                            $hallBook = $hallBooks[$hall->id] ?? null;
                        @endphp --}}

                        {{-- @if ($hallBook == null) --}}
                        {{-- @endif --}}
{{--
                        <option value="{{$hall->id}}">{{$hall->name_hall}}</option>
                        @endforeach
                    </select> --}}
                    {{-- <select class="border p-2 rounded w-full">
                        <option selected>Department</option>
                        @foreach ($hallBooks as $books)
                        <option value="{{$books->department->id}}">{{$books->department->name_dep}}</option>
                        @endforeach
                    </select>
                    <select class="border p-2 rounded w-full">
                        <option selected>Faculty</option>
                        @foreach ($hallBooks as $books)
                        <option value="{{$books->faculty->id}}">{{$books->faculty->name_fac}}</option>
                        @endforeach
                    </select> --}}

                </div>
                <div>
                    <label class=" text-gray-400">Hall</label>
                    <input  readonly name="hall" type="text" value="{{$hall->id}}"  class="bg-gray-500 mt-2 p-2 rounded w-full">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 h-20">
                    <div>
                        <label class=" text-gray-400">Time Start</label>
                        <input readonly name="timeStart" type="text" value="{{$time->timeStart}}" class="bg-gray-500 mt-2 p-2 rounded w-full">
                    </div>

                    <div>
                        <label class=" text-gray-400">Time End</label>
                        <input readonly  name="timeEnd" type="text" value="{{$time->timeEnd}}"  class=" bg-gray-500 mt-2 p-2 rounded w-full">
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 h-20">
                    <div>
                        <label class=" text-gray-400">Date Start</label>
                        <input  readonly name="dateStart" type="text" value="{{$date_start}}" class="bg-gray-500 p-2 rounded-full">
                        {{-- @php
                            dd($date_start);
                        @endphp --}}

                    </div>

                    <div>
                        <label class=" text-gray-400">Date End</label>
                        <input required name="dateEnd" type="date" placeholder="Date" class="border mt-2 p-2 rounded w-full">
                    </div>

                </div>


                <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 focus:outline-none transition-colors">
                    submit
                </button>

            </form>
        </div>
    </div>

  </div>
</x-app-layout>
