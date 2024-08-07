<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ('Hall Update') }}
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
            <h1 class="text-2xl font-bold mb-4 text-blue-600">Hall Update</h1>
            <form method="POST" action="{{route('hall.update', $hallEdit->id)}}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">

                    <select required name="subject" class="border p-2 rounded w-full">
                        <option value="{{ $hallEdit->subject->id }}">{{ $hallEdit->subject->name_sub }}</option>
                        @foreach ($subjects as $subject)
                        @if ($subject->name_sub != $hallEdit->subject->name_sub)

                        <option value="{{ $subject->id }}">{{ $subject->name_sub }}</option>

                        @endif
                        @endforeach

                    </select>

                    {{-- <select required name="hall" class="border p-2 rounded w-full">
                        <option selected>Room</option>
                        @foreach ($combinedData as [$hall, $hallBooks])

                        @if (!(optional($hallBooks)->is_available))
                            <option value="{{$hall->id}}">{{$hall->name_hall}}</option>
                        @endif

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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 h-20">
                    <div>
                        <label class=" text-gray-400">Time Start</label>
                        <input required value="{{$hallEdit->time_start}}" name="timeStart" type="time" placeholder="Time" class="border mt-2 p-2 rounded w-full">

                    </div>

                    <div>
                        <label class=" text-gray-400">Time End</label>
                        <input required value="{{$hallEdit->time_end}}" name="timeEnd" type="time" placeholder="time" class="border mt-2 p-2 rounded w-full">
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 h-20">
                    <div>
                        <label class=" text-gray-400">Date Start</label>
                        <input required value="{{$hallEdit->date_start}}" name="dateStart" type="date" placeholder="date" class="border mt-2 p-2 rounded w-full">

                    </div>

                    <div>
                        <label class=" text-gray-400">Date End</label>
                        <input required value="{{$hallEdit->date_end}}" name="dateEnd" type="date" placeholder="Date" class="border mt-2 p-2 rounded w-full">
                    </div>

                </div>


                <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 focus:outline-none transition-colors">
                    Update
                </button>

            </form>
        </div>
    </div>

  </div>
</x-app-layout>
