<x-admin-layout>

    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex p-2">
                    <a href="{{ route('admin.subjects.index') }}" class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Subject Index</a>
                </div>
                <div class="flex flex-col">
                    <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                        <form method="POST" action="{{ route('admin.subjects.store') }}">
                            @csrf
                          <div class="sm:col-span-6">
                            <label for="name_sub" class="block text-sm font-medium text-gray-700"> Subject name </label>
                            <div class="mt-1">
                              <input type="text" id="name_sub" name="name_sub" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                            @error('name_sub') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                          </div>
                          <div class="sm:col-span-6">
                            <label for="department" class="block text-sm font-medium text-gray-700"> Department name </label>
                            <div class="sm:col-span-6">
                                <select id="department" name="department_id"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name_dep }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('department_id') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                          </div>
                          <div class="sm:col-span-6 pt-5">
                            <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Create</button>
                          </div>
                        </form>
                      </div>

                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
