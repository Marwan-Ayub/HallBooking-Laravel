<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                <div class="flex p-2">
                    <a href="{{ route('admin.users.index') }}"
                        class="px-4 py-2 bg-green-700 hover:bg-green-500 text-slate-100 rounded-md">Users Index</a>
                </div>
                <div class="flex flex-col p-2 bg-slate-100">
                    <div>User Name: {{ $user->name }}</div>
                    <div>User Email: {{ $user->email }}</div>
                </div>
                <div class="mt-6 p-2 bg-slate-100 ">
                    <h2 class="text-2xl font-semibold mb-6">User</h2>
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full p-2 border" type="text" name="name" :value="$user->name" required autofocus />
                                @error('name')
                                    <div class="text-red-500 m-1">{{ $message }}</div>
                                @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" class="block mt-1 w-full p-2 border" type="email" name="email" :value="$user->email" required />
                        @error('email')
                            <div class="text-red-500 m-1">{{ $message }}</div>
                        @enderror
                        </div>

                        <!-- Password -->
                        {{-- <div class="mt-4">
                            <x-label for="password" :value="__('Password')" />

                            <x-input id="password" class="block mt-1 w-full p-2 border"
                                            type="text"
                                            name="password"
                                            required autocomplete="new-password" />
                             @error('password')
                            <div class="text-red-500 m-1">{{ $message }}</div>
                            @enderror
                        </div> --}}



                        {{-- Not need  --}}
                        <!-- Confirm Password -->
                        {{-- <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-input id="password_confirmation" class="block mt-1 w-full p-2 border"
                                            type="password"
                                            name="password_confirmation" required />
                        </div> --}}
                        <!-- Faculty -->
                        <div class="mt-4">
                            <div class="sm:col-span-6">
                                <label  class="block font-medium text-gray-700">Faculty</label>
                                <select name="faculty" id="faculty-dropdown"
                                    class="mt-1 block  w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option class="text-lg" value="{{ $user->faculty_id }}">{{ optional($user->faculty)->name_fac?? 'Faculty deleted' }}</option>
                                @foreach ($faculties as $faculty)
                                    @if ($faculty->name_fac == optional($user->faculty)->name_fac?? 'Faculty deleted')

                                    @else
                                    <option class="text-lg" value="{{ $faculty->id }}">{{ $faculty->name_fac }}</option>
                                    @endif
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
                                        <option class="text-lg" value="{{ $user->department_id }}">{{ optional($user->department)->name_dep ?? 'Department deleted' }}</option>
                                        @foreach ($departments as $department)
                                        @if ($department->name_dep == optional($user->department)->name_dep ?? 'Department deleted')

                                        @else
                                        <option class="text-lg" value="{{ $department->id }}">{{ $department->name_dep }}</option>

                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                @error('department')
                                <div class="text-red-500 m-1">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="flex items-left justify-start mt-4">

                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
                {{-- @if(!($user->hasRole('admin'))) --}}
                <div class="mt-6 p-2 bg-slate-100">
                    <h2 class="text-2xl font-semibold">Subjects</h2>
                    <div class="flex space-x-2 mt-4 p-2 items-center">
                        <span>Delete Subjects: </span>
                            @foreach ($subjectUsers as $subjectUser)
                                <form @if ($subjectUser->user_id) class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" @endif  method="POST"
                                    action="{{ route('admin.users.deleteSubject', $subjectUser->id) }}">
                                    @csrf
                                    <button type="submit">{{ $subjectUser->subject->name_sub }}</button>
                                </form>
                            @endforeach
                    </div>
                    <div class="max-w-xl mt-6">
                        <form method="POST" action="{{ route('admin.users.storeSubject', $user->id) }}">
                            @csrf
                            <div class="sm:col-span-6">
                                <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                                <select id="subject" name="subject"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name_sub }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('subject')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                    </div>
                    <div class="sm:col-span-6 pt-5">
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Add</button>
                    </div>
                    </form>
                </div>
                {{-- @endif --}}
                <div class="mt-6 p-2 bg-slate-100">
                    <h2 class="text-2xl font-semibold">Roles</h2>
                    <div class="flex items-center space-x-2 mt-4 p-2">
                        @if ($user->roles)
                        <span>Delete Roles: </span>
                            @foreach ($user->roles as $user_role)
                                <form class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" method="POST"
                                    action="{{ route('admin.users.roles.remove', [$user->id, $user_role->id]) }}"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">{{ $user_role->name }}</button>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <div class="max-w-xl mt-6">
                        <form method="POST" action="{{ route('admin.users.roles', $user->id) }}">
                            @csrf
                            <div class="sm:col-span-6">
                                <label for="role" class="block text-sm font-medium text-gray-700">Roles</label>
                                <select id="role" name="role" autocomplete="role-name"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('role')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                    </div>
                    <div class="sm:col-span-6 pt-5">
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Assign</button>
                    </div>
                    </form>
                </div>
                {{-- <div class="mt-6 p-2 bg-slate-100">
                    <h2 class="text-2xl font-semibold">Permissions</h2>
                    <div class="flex items-center space-x-2 mt-4 p-2">
                        @if ($user->permissions)
                        <span>Delete Permissions: </span>
                            @foreach ($user->permissions as $user_permission)
                                <form class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" method="POST"
                                    action="{{ route('admin.users.permissions.revoke', [$user->id, $user_permission->id]) }}"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">{{ $user_permission->name }}</button>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <div class="max-w-xl mt-6">
                        <form method="POST" action="{{ route('admin.users.permissions', $user->id) }}">
                            @csrf
                            <div class="sm:col-span-6">
                                <label for="permission"
                                    class="block text-sm font-medium text-gray-700">Permission</label>
                                <select id="permission" name="permission" autocomplete="permission-name"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('name')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                    </div>
                    <div class="sm:col-span-6 pt-5">
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Assign</button>
                    </div>
                    </form>

                </div> --}}
            </div>

        </div>
    </div>
    </div>
    <script>
        
// document.addEventListener('DOMContentLoaded', function () {
//     const departmentDropdown = document.getElementById('faculty-dropdown');
//     const subjectDropdown = document.getElementById('department-dropdown');

//     // Get the subjects passed from the PHP variable
//     const subjectsByDepartment = {!! $departments->groupBy('faculty_id')->map->pluck('name_dep', 'id')->toJson() !!};
//     // console.log(subjectsByDepartment);

//     // Function to update the subject dropdown based on the selected department
//     function updateSubjectDropdown(selectedDepartmentId) {
//     const subjects = subjectsByDepartment[selectedDepartmentId] || [];

//     // Clear existing options
//     subjectDropdown.innerHTML = '<option value="">Select Department</option>';

//     // Populate the subject dropdown with options
//     for (const [subjectId, subjectName] of Object.entries(subjects)) {
//         const option = document.createElement('option');
//         option.value = subjectId;
//         option.textContent = subjectName;
//         option.classList = 'text-lg';
//         subjectDropdown.appendChild(option);
//     }
// }



//     // Event listener for department dropdown change
//     departmentDropdown.addEventListener('change', function () {
//         const selectedDepartmentId = this.value;
//         updateSubjectDropdown(selectedDepartmentId);
//     });

//     // Initialize subjects dropdown based on the initial selected department
//     const initialSelectedDepartmentId = departmentDropdown.value;
//     updateSubjectDropdown(initialSelectedDepartmentId);
// });
    </script>
</x-admin-layout>
