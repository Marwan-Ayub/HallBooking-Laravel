<x-admin-layout>

    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex p-2">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">User Index</a>
                </div>
                <div class="flex flex-col">
                    <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
         <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />
                <x-input id="name" class="block mt-1 w-full p-2 border" type="text" name="name" :value="old('name')" required autofocus />
                @error('name')
                <div class="text-red-500 m-1">{{ $message }}</div>
            @enderror
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full p-2 border" type="email" name="email" :value="old('email')" required />
                @error('email')
                <div class="text-red-500 m-1">{{ $message }}</div>
            @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full p-2 border"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                                @error('password')
                                <div class="text-red-500 m-1">{{ $message }}</div>
                            @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full p-2 border"
                                type="password"
                                name="password_confirmation" required />
                                @error('password')
                                <div class="text-red-500 m-1">{{ $message }}</div>
                            @enderror
            </div>
             <!-- Faculty -->
             <div class="mt-4">
                <div class="sm:col-span-6">
                    <label  class="block font-medium text-gray-700">Faculty</label>
                    <select name="faculty" id="faculty-dropdown"
                        class="mt-1 block  w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach ($faculties as $faculty)
                            <option class="text-lg" value="{{ $faculty->id }}">{{ $faculty->name_fac }}</option>
                        @endforeach
                    </select>
                </div>
                @error('faculty')
                <div class="text-red-500 m-1">{{ $message }}</div>
            @enderror
        </div>
            <!-- Department -->
            <div class="mt-4">
                    <div class="sm:col-span-6">
                        <label  class="block font-medium text-gray-700">Department</label>
                        <select name="department" id="department-dropdown"
                            class="mt-1 block  w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            {{-- @foreach ($departments as $department)
                                <option class="text-lg" value="{{ $department->id }}">{{ $department->name_dep }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    @error('department')
                    <div class="text-red-500 m-1">{{ $message }}</div>
                @enderror
            </div>
            <!-- Subject -->
            <div class="mt-4">
                <div class="sm:col-span-6">
                <label class="block font-medium text-gray-700">Subject</label>
                <select id="subject-dropdown" name="subject" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <!-- Subject options will be dynamically populated here -->
                </select>
                </div>
                @error('subject')
                <div class="text-red-500 m-1">{{ $message }}</div>
                @enderror
            </div>


            <div class="flex items-center justify-end mt-4">

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
                      </div>

                </div>

            </div>
        </div>
    </div>
    <script>

     // For Subjects
document.addEventListener('DOMContentLoaded', function () {
    const departmentDropdown = document.getElementById('department-dropdown');
    const subjectDropdown = document.getElementById('subject-dropdown');

    // Get the subjects passed from the PHP variable
    const subjectsByDepartment = {!! $subjects->groupBy('department_id')->map->pluck('name_sub', 'id')->toJson() !!};
    // console.log(subjectsByDepartment);

    // Function to update the subject dropdown based on the selected department
    function updateSubjectDropdown(selectedDepartmentId) {
    const subjects = subjectsByDepartment[selectedDepartmentId] || [];

    // Clear existing options
    subjectDropdown.innerHTML = '<option value="">Select Subject</option>';

    // Populate the subject dropdown with options
    for (const [subjectId, subjectName] of Object.entries(subjects)) {
        const option = document.createElement('option');
        option.value = subjectId;
        option.textContent = subjectName;
        option.classList = 'text-lg';
        subjectDropdown.appendChild(option);
    }
}



    // Event listener for department dropdown change
    departmentDropdown.addEventListener('change', function () {
        const selectedDepartmentId = this.value;
        updateSubjectDropdown(selectedDepartmentId);
    });

    // Initialize subjects dropdown based on the initial selected department
    const initialSelectedDepartmentId = departmentDropdown.value;
    updateSubjectDropdown(initialSelectedDepartmentId);
});

// For Departmrnts
document.addEventListener('DOMContentLoaded', function () {
    const departmentDropdown = document.getElementById('faculty-dropdown');
    const subjectDropdown = document.getElementById('department-dropdown');

    // Get the subjects passed from the PHP variable
    const subjectsByDepartment = {!! $departments->groupBy('faculty_id')->map->pluck('name_dep', 'id')->toJson() !!};
    // console.log(subjectsByDepartment);

    // Function to update the subject dropdown based on the selected department
    function updateSubjectDropdown(selectedDepartmentId) {
    const subjects = subjectsByDepartment[selectedDepartmentId] || [];

    // Clear existing options
    subjectDropdown.innerHTML = '<option value="">Select Department</option>';

    // Populate the subject dropdown with options
    for (const [subjectId, subjectName] of Object.entries(subjects)) {
        const option = document.createElement('option');
        option.value = subjectId;
        option.textContent = subjectName;
        option.classList = 'text-lg';
        subjectDropdown.appendChild(option);
    }
}



    // Event listener for department dropdown change
    departmentDropdown.addEventListener('change', function () {
        const selectedDepartmentId = this.value;
        updateSubjectDropdown(selectedDepartmentId);
    });

    // Initialize subjects dropdown based on the initial selected department
    const initialSelectedDepartmentId = departmentDropdown.value;
    updateSubjectDropdown(initialSelectedDepartmentId);
});
</script>

</x-admin-layout>
