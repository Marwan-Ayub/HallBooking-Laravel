<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            {{ ('Hall') }}
        </h2>
    </x-slot>

    @if (session('Result'))
    <div class="py-3 px-5 bg-green-500 text-white"> {{session('Result')}}</div>
    @endif

    @if ($errors->any())
    <div class="py-3 px-5  bg-red-500 text-white">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex w-44 mt-2 text-white  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-2 py-2.5 me-2 ml-10 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mx-1 mb-6">
        <img src="{{asset('img/arrow.png')}}" class="w-6"> &nbsp;&nbsp;
        <a href="{{ route('welcome') }}" class="text-lg text-white dark:text-white ">Table of Books</a>
    </div>
  <!-- component -->
      <div class="relative min-h-screen flex-col justify-center overflow-hidden bg-gray-50  sm:py-12">
        <div class=" flex justify-center pb-6">
            <div class="w-full max-w-md flex relative self-center bg-blue-500 rounded-full" id="switch">
                <input name="time_of_day" class="sr-only [&:checked+label]:text-white [&:checked~span]:translate-x-full " type="radio" value="no" name="question_2" id="no">
                <label class="flex-1 py-2 text-lg font-medium text-center text-white whitespace-nowrap rounded-full border border-4 border-transparent cursor-pointer focus:ring-2 focus:ring-blue-500 focus:outline-none z-[1]" for="no">Evening</label>
                <input name="time_of_day" class="sr-only " type="radio" value="yes" name="question_2" id="yes">
                <label class="flex-1 py-2 text-lg font-medium text-center text-white whitespace-nowrap rounded-full border border-4 border-transparent cursor-pointer focus:ring-2 focus:ring-blue-500 focus:outline-none z-[1]" for="yes">Morning</label>
                <span class="absolute top-0  bottom-0 left-0 w-1/2 bg-white shadow-sm rounded-full transition-transform ease-[cubic-bezier(.4,0,.2,1)] translate-x-0 border-4 border-gray-300"></span>
            </div>
            <h1 class=" pt-1 px-4 text-xl font-bold">
                @if ($date_select)
                    {{$date_select->format('Y-m-d')}}
                @else
                    {{$date_now}}
                @endif
                <br>
                <span id="current-time"></span>
            </h1>
        </div>

        {{-- <div class=" justify-center align-item-center">
            <h3 class=" pt-1 text-lg font-bold">Date Selection:</h3>

        </div> --}}
          <div class="pb-8 mr-32 flex justify-center">
            <!-- Button to navigate to the previous day -->
            <form method="GET" action="{{ route('previousDay', $previousDay) }}">
                @csrf
                <div class="flex w-44 text-white  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-2 py-1.5 ml-10 dark:bg-gray-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mx-1 mb-4">
                    <img src="{{asset('img/arrow.png')}}" class="w-6"> &nbsp;&nbsp;
                    <button class="text-lg text-white dark:text-white " type="submit">Previous Day</button>
                    {{-- <a href="{{ route('welcome') }}" >Table of Books</a> --}}
                </div>
            </form>

            <form action="{{route('hall.index2','day')}}">
              @csrf
              @method('POST')
              <div class="flex flex-row">
                  <div class="form-group">
                      <input type="date" value='{{ old('date_end') }}' name="date_end" class="bg-gray-50 h-10 ml-10 border text-lg border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-60 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  </div>
                  <button type="submit"  class="text-white  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-5 py-2.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mx-1 mb-6">Submit</button>
                </div>
            </form>

                <!-- Button to navigate to the next day -->
                <form method="GET" action="{{ route('nextDay', $nextDay) }}">
                    @csrf
                    {{-- <button type="submit">Next Day</button> --}}
                    <div class="flex text-center justify-between w-44 text-white  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-6 py-1.5 ml-10 dark:bg-gray-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mx-1 mb-4">
                        <button class="text-lg text-white dark:text-white " type="submit">Next Day</button>
                        <img src="{{asset('img/right-arrow.png')}}" class="w-6"> &nbsp;&nbsp;
                        {{-- <a href="{{ route('welcome') }}" >Table of Books</a> --}}
                    </div>
                </form>


        </div>
          <div class="flex justify-center gap-14 mr-14 " id="timeDay">

            <p>{{ optional($times[0])->timeStart }} - {{ optional($times[0])->timeEnd }}</p>
            <p>{{ optional($times[1])->timeStart }} - {{ optional($times[1])->timeEnd }}</p>
            <p>{{ optional($times[2])->timeStart }} - {{ optional($times[2])->timeEnd }}</p>
            <p>{{ optional($times[3])->timeStart }} - {{ optional($times[3])->timeEnd }}</p>
            {{-- <p><input type="time"  value="{{$times[3]->timeStart}}"> - <input type="time"  value="{{$times[3]->timeEnd}}"></p> --}}

          </div>

          <div class="flex justify-center gap-14 mr-14 hidden" id="timeNight">

            <p>{{ optional($times[4])->timeStart }} - {{ optional($times[4])->timeEnd }}</p>
            <p>{{ optional($times[5])->timeStart }} - {{ optional($times[5])->timeEnd }}</p>
            <p>{{ optional($times[6])->timeStart }} - {{ optional($times[6])->timeEnd }}</p>
            <p>{{ optional($times[7])->timeStart }} - {{ optional($times[7])->timeEnd }}</p>

          </div>
            {{--------  Day  -----------}}
          <div class="hidden" id="day">
          @foreach ($halls as $hall)
          <div class=" absolute py-10 left-0 pl-60 text-lg font-bold ">
            <p>{{ $hall->name_hall }}</p>
          </div>
        <div class="max-w-screen-md mx-auto py-6 px-22">
          <div class="space-y-8">
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-4" >
            @if ($hallBooks->isNotEmpty())

                    @foreach ($hallBooks as $hallBook)

                        <div  @if ($hall->isAvailable($times[0]->timeStart, $times[0]->timeEnd,optional($hallBook)->date_end))  id="open-modal"  @endif     data-time-start="{{$times[0]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end="{{$times[0]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group {{ $hall->isAvailable($times[0]->timeStart, $times[0]->timeEnd,optional($hallBook)->date_end) ? 'bg-gray-50' : 'bg-red-400' }}  hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                            <h1 class="font-bold text-lg">{{ $hall->isAvailable($times[0]->timeStart, $times[0]->timeEnd,optional($hallBook)->date_end) ? 'Book' : 'Booked' }}</h1>
                        </div>

                        <div  @if ($hall->isAvailable($times[1]->timeStart, $times[1]->timeEnd,optional($hallBook)->date_end))  id="open-modal"  @endif     data-time-start="{{$times[1]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end="{{$times[1]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group {{ $hall->isAvailable($times[1]->timeStart, $times[1]->timeEnd,optional($hallBook)->date_end) ? 'bg-gray-50' : 'bg-red-400' }}  hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                            <h1 class="font-bold text-lg">{{ $hall->isAvailable($times[1]->timeStart, $times[1]->timeEnd,optional($hallBook)->date_end) ? 'Book' : 'Booked' }}</h1>
                        </div>

                        <div  @if ($hall->isAvailable($times[2]->timeStart, $times[2]->timeEnd,optional($hallBook)->date_end))  id="open-modal"  @endif    data-time-start="{{$times[2]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end="{{$times[2]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group  {{ $hall->isAvailable($times[2]->timeStart, $times[2]->timeEnd,optional($hallBook)->date_end) ? 'bg-gray-50' : 'bg-red-400' }}  hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                            <h1 class="font-bold text-lg">{{ $hall->isAvailable($times[2]->timeStart, $times[2]->timeEnd,optional($hallBook)->date_end) ? 'Book' : 'Booked' }}</h1>
                        </div>

                        <div  @if ($hall->isAvailable($times[3]->timeStart, $times[3]->timeEnd,optional($hallBook)->date_end))  id="open-modal"  @endif   data-time-start="{{$times[3]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end="{{$times[3]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group   {{ $hall->isAvailable($times[3]->timeStart, $times[3]->timeEnd,optional($hallBook)->date_end) ? 'bg-gray-50' : 'bg-red-400' }}  hover:cursor-pointer relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                            <h1 class="font-bold text-lg">{{ $hall->isAvailable($times[3]->timeStart, $times[3]->timeEnd,optional($hallBook)->date_end) ? 'Book' : 'Booked' }}</h1>
                        </div>
                        @break
                    @endforeach
            @else
                <div id="open-modal"   data-time-start="{{$times[0]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end="{{$times[0]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group  bg-gray-50 hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                    <h1 class="font-bold text-lg">Book</h1>
                </div>

                <div  id="open-modal"   data-time-start="{{$times[1]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end="{{$times[1]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group  bg-gray-50 hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                    <h1 class="font-bold text-lg">Book</h1>
                </div>

                <div  id="open-modal"  data-time-start="{{$times[2]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end="{{$times[2]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group   bg-gray-50 hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                    <h1 class="font-bold text-lg">Book</h1>
                </div>

                <div id="open-modal"  data-time-start="{{$times[3]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end="{{$times[3]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group    bg-gray-50 hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                    <h1 class="font-bold text-lg">Book</h1>
                </div>
            @endif
            </div>


        </div>

    </div>
    @endforeach
</div>
            {{--------  Night  -----------}}
          <div class="hidden" id="night">
          @foreach ($halls as $hall)
          <div class=" absolute py-10 left-0 pl-60 text-lg font-bold ">
            <p>{{ $hall->name_hall }}</p>
          </div>
        <div class="max-w-screen-md mx-auto py-6 px-22">
          <div class="space-y-8">
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-4 ">
                @if ($hallBooks->isNotEmpty())

                    @foreach ($hallBooks as $hallBook)

                        <div  @if ($hall->isAvailable($times[4]->timeStart, $times[4]->timeEnd,optional($hallBook)->date_end))  id="open-modal-night"  @endif     data-time-start-night="{{$times[4]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end-night="{{$times[4]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group {{ $hall->isAvailable($times[4]->timeStart, $times[4]->timeEnd,optional($hallBook)->date_end) ? 'bg-gray-50' : 'bg-red-400' }}  hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                            <h1 class="font-bold text-lg">{{ $hall->isAvailable($times[4]->timeStart, $times[4]->timeEnd,optional($hallBook)->date_end) ? 'Book' : 'Booked' }}</h1>
                        </div>

                        <div  @if ($hall->isAvailable($times[5]->timeStart, $times[5]->timeEnd,optional($hallBook)->date_end))  id="open-modal-night"  @endif     data-time-start-night="{{$times[5]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end-night="{{$times[5]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group {{ $hall->isAvailable($times[5]->timeStart, $times[5]->timeEnd,optional($hallBook)->date_end) ? 'bg-gray-50' : 'bg-red-400' }}  hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                            <h1 class="font-bold text-lg">{{ $hall->isAvailable($times[5]->timeStart, $times[5]->timeEnd,optional($hallBook)->date_end) ? 'Book' : 'Booked' }}</h1>
                        </div>

                        <div  @if ($hall->isAvailable($times[6]->timeStart, $times[6]->timeEnd,optional($hallBook)->date_end))  id="open-modal-night"  @endif    data-time-start-night="{{$times[6]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end-night="{{$times[6]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group  {{ $hall->isAvailable($times[6]->timeStart, $times[6]->timeEnd,optional($hallBook)->date_end) ? 'bg-gray-50' : 'bg-red-400' }}  hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                            <h1 class="font-bold text-lg">{{ $hall->isAvailable($times[6]->timeStart, $times[6]->timeEnd,optional($hallBook)->date_end) ? 'Book' : 'Booked' }}</h1>
                        </div>

                        <div  @if ($hall->isAvailable($times[7]->timeStart, $times[7]->timeEnd,optional($hallBook)->date_end))  id="open-modal-night"  @endif   data-time-start-night="{{$times[7]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end-night="{{$times[7]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group   {{ $hall->isAvailable($times[7]->timeStart, $times[7]->timeEnd,optional($hallBook)->date_end) ? 'bg-gray-50' : 'bg-red-400' }}  hover:cursor-pointer relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                            <h1 class="font-bold text-lg">{{ $hall->isAvailable($times[7]->timeStart, $times[7]->timeEnd,optional($hallBook)->date_end) ? 'Book' : 'Booked' }}</h1>
                        </div>
                        @break
                    @endforeach
                @else

                <div id="open-modal-night"   data-time-start-night="{{$times[4]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end-night="{{$times[4]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group  bg-gray-50 hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                    <h1 class="font-bold text-lg">Book</h1>
                </div>

                <div  id="open-modal-night"   data-time-start-night="{{$times[5]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end-night="{{$times[5]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group  bg-gray-50 hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                    <h1 class="font-bold text-lg">Book</h1>
                </div>

                <div  id="open-modal-night"  data-time-start-night="{{$times[6]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end-night="{{$times[6]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group   bg-gray-50 hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                    <h1 class="font-bold text-lg">Book</h1>
                </div>

                <div id="open-modal-night"  data-time-start-night="{{$times[7]->timeStart}}" data-hall-size="{{$hall->size}}" data-hall-name="{{$hall->name_hall}}" data-hall-type="{{$hall->hall_type}}" data-time-end-night="{{$times[7]->timeEnd}}" data-hall-id="{{ $hall->id }}" class="group    bg-gray-50 hover:cursor-pointer  relative group h-12 w-36 flex flex-col rounded-lg shadow-lg justify-center items-center">
                    <h1 class="font-bold text-lg">Book</h1>
                </div>
                @endif
            </div>

        </div>

    </div>
    @endforeach
</div>

</div>
</div>

    {{-- Model Booking --}}

    <!-- Modal container -->
    <div class="fixed top-0 left-0 w-full h-full flex justify-center  items-center bg-gray-900 bg-opacity-50 hidden" id="modal-container">
        <!-- Modal content -->
        <div class="bg-white p-8 rounded shadow-lg w-1/2">
          <h1 class="text-2xl font-bold mb-4 text-blue-600">Hall Booking</h1>
          <p class="text-black text-xl dark:text-black mb-6">please filling the form below</p>
          <form method="POST" action="{{route('hall.store')}}">
              @csrf

            <!-- Add this code within your form -->
            <div class="mt-4">
                <label for="numWeeks" class="block text-gray-700">Number of weeks to book ahead:</label>
                <input type="number" id="numWeeks" name="num_weeks" class="form-input mt-1 block w-full" min="1" max="52" value="1">
            </div>

        <label class=" text-black">Subject</label>
          <select required name="subject" class="border p-2 rounded w-full">

              @foreach ($userSubjects as $userSubject)
              @foreach ($subjects as $subject)
              @if ($userSubject->subject->name_sub == $subject->name_sub )

              <option value="{{ $subject->id }}">{{ $subject->name_sub }}</option>
              @endif

              @endforeach
              @endforeach
          </select>

          <div>
            <label class=" text-black">Hall</label>
            <input readonly name="hallName" type="text" class="bg-zinc-200 mt-2 p-2 rounded w-full">
            <input readonly hidden name="hall" type="text" class="bg-zinc-200 mt-2 p-2 rounded w-full">
        </div>
          <div>
            <label class=" text-black">Hall Type</label>
            <input  readonly name="hallType" type="text"  class="bg-zinc-200 mt-2 p-2 rounded w-full">
        </div>
          <div>
            <label class=" text-black">Hall Size</label>
            <input  readonly name="hallSize" type="text"  class="bg-zinc-200 mt-2 p-2 rounded w-full">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 h-20">
            <div>
                <label class=" text-black">Time Start</label>
                <input readonly name="timeStart" type="time"   class="bg-zinc-200 mt-2 p-2 rounded w-full">

            </div>

            <div>
                <label class=" text-black">Time End</label>
                <input readonly  name="timeEnd" type="time"  class=" bg-zinc-200 mt-2 p-2 rounded w-full">
              </div>

          </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 h-20">
            <div>
                <label class=" text-black ">Date Start</label>
                <input  readonly name="dateStart" type="date" value="{{$date_now}}" class=" bg-zinc-200 mt-2 p-2 rounded w-full">
            </div>
            <div>
                <label class=" text-black ">Date End</label>
                <input readonly name="dateEnd" type="date"
                @if ($date_select)
                    value="{{$date_select->format('Y-m-d')}}"
                @else
                    value="{{$date_now}}"
                @endif
                class="bg-zinc-200 mt-2 p-2 rounded w-full">
            </div>

          </div>

          <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 focus:outline-none transition-colors">
              Submit
          </button>

          <span class="px-4 py-2.5 ml-4 rounded cursor-pointer  bg-red-600 text-white hover:bg-red-700 focus:outline-none transition-colors" id="close-modal">Close</span>
        </form>
        </div>

      </div>


    {{-- Model Booking Night --}}

    <!-- Modal container -->
    <div class="fixed top-0 left-0 w-full h-full flex justify-center  items-center bg-gray-900 bg-opacity-50 hidden" id="modal-container-night">
        <!-- Modal content -->
        <div class="bg-white p-8 rounded shadow-lg w-1/2">
          <h1 class="text-2xl font-bold mb-4 text-blue-600">Hall Booking night</h1>
          <p class="text-black text-xl dark:text-black mb-6">please filling the form below</p>
          <form method="POST" action="{{route('hall.store')}}">
              @csrf

            <!-- Add this code within your form -->
            <div class="mt-4">
                <label for="numWeeks" class="block text-gray-700">Number of weeks to book ahead:</label>
                <input type="number" id="numWeeks" name="num_weeks" class="form-input mt-1 block w-full" min="1" max="52" value="1">
            </div>

        <label class=" text-black">Subject</label>
          <select required name="subject" class="border p-2 rounded w-full">
              {{-- <option selected disabled>subject</option> --}}
              @foreach ($userSubjects as $userSubject)

              <option value="{{ $userSubject->id }}">{{ $userSubject->subject->name_sub }}</option>

              @endforeach
          </select>

          <div>
            <label class=" text-black">Hall</label>
            <input readonly name="hallNameNight" type="text" class="bg-zinc-200 mt-2 p-2 rounded w-full">
            <input readonly hidden name="hallNight" type="text" class="bg-zinc-200 mt-2 p-2 rounded w-full">
        </div>
          <div>
            <label class=" text-black">Hall Type</label>
            <input  readonly name="hallTypeNight" type="text"  class="bg-zinc-200 mt-2 p-2 rounded w-full">
        </div>
          <div>
            <label class=" text-black">Hall Size</label>
            <input  readonly name="hallSizeNight" type="text"  class="bg-zinc-200 mt-2 p-2 rounded w-full">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 h-20">
            <div>
                <label class=" text-black">Time Start</label>
                <input readonly name="timeStartNight" type="time"   class="bg-zinc-200 mt-2 p-2 rounded w-full">

            </div>

            <div>
                <label class=" text-black">Time End</label>
                <input readonly  name="timeEndNight" type="time"  class=" bg-zinc-200 mt-2 p-2 rounded w-full">
              </div>

          </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 h-20">
            <div>
                <label class=" text-black ">Date Start</label>
                <input  readonly name="dateStart" type="date" value="{{$date_now}}" class=" bg-zinc-200 mt-2 p-2 rounded w-full">
            </div>
            <div>
                <label class=" text-black ">Date End</label>
                <input readonly name="dateEnd" type="date"
                @if ($date_select)
                    value="{{$date_select->format('Y-m-d')}}"
                @else
                    value="{{$date_now}}"
                @endif
                class="bg-zinc-200 mt-2 p-2 rounded w-full">
            </div>

          </div>

          <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 focus:outline-none transition-colors">
              Submit
          </button>

          <span class="px-4 py-2.5 ml-4 rounded cursor-pointer  bg-red-600 text-white hover:bg-red-700 focus:outline-none transition-colors" id="close-modal-night">Close</span>
        </form>
        </div>

      </div>

      <script>



        // Model Booking
        const openModalButtons = document.querySelectorAll('#open-modal');
        const openModalButtonsNight = document.querySelectorAll('#open-modal-night');
        const closeModalButton = document.getElementById('close-modal');
        const closeModalButtonNight = document.getElementById('close-modal-night');
        const modalContainer = document.getElementById('modal-container');
        const modalContainerNight = document.getElementById('modal-container-night');

        // Function to open modal
        openModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                const timeStart = button.getAttribute('data-time-start');
                const timeEnd = button.getAttribute('data-time-end');
                const hallId = button.getAttribute('data-hall-id');
                const hallType = button.getAttribute('data-hall-type');
                const hallSize = button.getAttribute('data-hall-size');
                const hallName = button.getAttribute('data-hall-name');
                // const subjectSelect = document.querySelector('select[name="subject"]');
                const hallInput = document.querySelector('input[name="hall"]');
                const hallTypeInput = document.querySelector('input[name="hallType"]');
                const hallSizeInput = document.querySelector('input[name="hallSize"]');
                const hallNameInput = document.querySelector('input[name="hallName"]');
                const timeStartInput = document.querySelector('input[name="timeStart"]');
                const timeEndInput = document.querySelector('input[name="timeEnd"]');
                // const dateStartInput = document.querySelector('input[name="dateStart"]');


                // Set values in modal fields
                // Set time and date values based on timeId, hallId, or any other logic
                // Example: timeStartInput.value = ''; timeEndInput.value = ''; dateStartInput.value = '';

                hallInput.value = hallId;
                hallNameInput.value = hallName;
                hallTypeInput.value = hallType;
                hallSizeInput.value = hallSize;
                timeStartInput.value = timeStart;
                timeEndInput.value = timeEnd;

                modalContainer.classList.remove('hidden');
                switchDN.classList.add('hidden');
            });
        });

        // Function to open modal night
        openModalButtonsNight.forEach(button => {
            button.addEventListener('click', () => {
                const timeStartNight = button.getAttribute('data-time-start-night');
                const timeEndNight = button.getAttribute('data-time-end-night');
                const hallId = button.getAttribute('data-hall-id');
                const hallType = button.getAttribute('data-hall-type');
                const hallSize = button.getAttribute('data-hall-size');
                const hallName = button.getAttribute('data-hall-name');
                // const subjectSelect = document.querySelector('select[name="subject"]');
                const hallInput = document.querySelector('input[name="hallNight"]');
                const hallTypeInput = document.querySelector('input[name="hallTypeNight"]');
                const hallSizeInput = document.querySelector('input[name="hallSizeNight"]');
                const hallNameInput = document.querySelector('input[name="hallNameNight"]');
                const timeStartInput2 = document.querySelector('input[name="timeStartNight"]');
                const timeEndInput2 = document.querySelector('input[name="timeEndNight"]');
                // const dateStartInput = document.querySelector('input[name="dateStart"]');


                // Set values in modal fields
                // Set time and date values based on timeId, hallId, or any other logic
                // Example: timeStartInput.value = ''; timeEndInput.value = ''; dateStartInput.value = '';

                hallInput.value = hallId;
                hallNameInput.value = hallName;
                hallTypeInput.value = hallType;
                hallSizeInput.value = hallSize;
                timeStartInput2.value = timeStartNight;
                timeEndInput2.value = timeEndNight;

                modalContainerNight.classList.remove('hidden');
                switchDN.classList.add('hidden');
            });
        });

        // Function to close modal
        closeModalButton.addEventListener('click', () => {
            modalContainer.classList.add('hidden');
            switchDN.classList.remove('hidden');
        });

        // Close modal when clicking outside the modal content
        modalContainer.addEventListener('click', (event) => {
            if (event.target === modalContainer) {
                modalContainer.classList.add('hidden');
                switchDN.classList.remove('hidden');
            }
        });
        // Function to close modal night
        closeModalButtonNight.addEventListener('click', () => {
            modalContainerNight.classList.add('hidden');
            switchDN.classList.remove('hidden');
        });

        // Close modal night when clicking outside the modal content
        modalContainerNight.addEventListener('click', (event) => {
            if (event.target === modalContainerNight) {
                modalContainerNight.classList.add('hidden');
                switchDN.classList.remove('hidden');
            }
        });
        // Refresh page every 10 second

    //    setTimeout(function(){
    //        location.reload();
    //        }, 10000);

        // Script to toggle visibility based on radio button selection
        const switchButtons = document.querySelectorAll('input[name="time_of_day"]');
        const daySection = document.getElementById('day');
        const nightSection = document.getElementById('night');
        const timeNight = document.getElementById('timeNight');
        const timeDay = document.getElementById('timeDay');
        const switchDN = document.getElementById('switch');
        daySection.classList.remove('hidden');
        timeDay.classList.remove('hidden');
        nightSection.classList.add('hidden');
        timeNight.classList.add('hidden');

        switchButtons.forEach(button => {
            button.addEventListener('change', function() {
                if (this.value === 'yes') {
                    daySection.classList.remove('hidden');
                    timeDay.classList.remove('hidden');
                    nightSection.classList.add('hidden');
                    timeNight.classList.add('hidden');
                } else if (this.value === 'no') {
                    nightSection.classList.remove('hidden');
                    timeNight.classList.remove('hidden');
                    daySection.classList.add('hidden');
                    timeDay.classList.add('hidden');
                }
            });
        });


            // Function to update the time
            function updateTime() {
                // Get the current time
                let now = new Date();

                // Format the time
                let hours = now.getHours();
                let minutes = now.getMinutes();
                let seconds = now.getSeconds();
                let ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // Handle midnight (0 hours)
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                // Display the time
                let timeString = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
                document.getElementById('current-time').innerText = timeString;

                // Call updateTime again after 1 second
                setTimeout(updateTime, 1000); // 1000 milliseconds = 1 second
            }
            // Call updateTime to start updating the time
            updateTime();
    </script>
</x-app-layout>
