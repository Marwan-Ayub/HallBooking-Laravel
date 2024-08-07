<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex p-2">
                    <a href="{{ route('admin.halls.index') }}"
                        class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Hall Index</a>
                </div>
                <div class="flex flex-col p-2 bg-slate-100">
                    <h2 class="text-2xl font-semibold">Hall</h2>

                    <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                        <form method="POST" action="{{ route('admin.halls.update', $hall->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="sm:col-span-6">
                                <label for="name" class="block text-sm font-medium text-gray-700"> Hall name </label>
                                <div class="mt-1">
                                    <input type="text" id="name" name="name_hall" value="{{ $hall->name_hall }}"
                                        class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                </div>
                                @error('name_hall')
                                    <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="sm:col-span-6 mt-2">
                                <label for="hall_type" class="block text-sm font-medium text-gray-700"> Hall Type </label>
                                <div class="mt-1">
                                    <input type="text" id="hall_type" name="hall_type" value="{{ $hall->hall_type }}"
                                        class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                </div>
                                @error('hall_type')
                                    <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="sm:col-span-6 mt-2">
                                <label for="size" class="block text-sm font-medium text-gray-700"> Hall Size </label>
                                <div class="mt-1">
                                    <input type="text" id="size" name="size" value="{{ $hall->size }}"
                                        class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                </div>
                                @error('size')
                                    <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="sm:col-span-6 mt-2">
                                <label for="hall_location" class="block text-sm font-medium text-gray-700"> Hall Location </label>
                                <div class="mt-1">
                                    <input type="text" id="hall_location" name="hall_location" value="{{ $hall->hall_location }}"
                                        class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                </div>
                                @error('hall_location')
                                    <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="sm:col-span-6 mt-6">
                                <label for="department" class="block text-sm font-medium text-gray-700"> Department name </label>
                                <select id="department" name="department_id"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                                    <option value="{{ $hall->department_id }}">{{ optional($hall->department)->name_dep ?? 'Department deleted' }}</option>
                                    @foreach ($departments as $department)
                                        @if ($department->name_dep == optional($hall->department)->name_dep ?? 'Department deleted')

                                        @else
                                        <option value="{{ $department->id }}">{{ $department->name_dep }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-6 mt-6">
                                <label for="faculty" class="block text-sm font-medium text-gray-700"> Faculty name </label>
                                <select id="faculty" name="faculty_id"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                                    <option value="{{ $hall->faculty_id }}">{{ optional($hall->faculty)->name_fac?? 'Faculty deleted' }}</option>
                                    @foreach ($faculties as $faculty)
                                        @if ($faculty->name_fac == optional($hall->faculty)->name_fac?? 'Faculty deleted')

                                        @else
                                        <option value="{{ $faculty->id }}">{{ $faculty->name_fac }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @error('faculty_id') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                          </div>
                            <div class="sm:col-span-6 pt-5">
                                <button type="submit"
                                    class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</x-admin-layout>
