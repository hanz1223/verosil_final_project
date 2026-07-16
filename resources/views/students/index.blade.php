<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Students') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Manage student records in one place.') }}
                </p>
            </div>

            <a
                href="{{ route('students.create') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition"
            >
                {{ __('Add Student') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div id="student-alert"></div>
            
            @if (session('status') === 'student-created')
                <div class="px-4 py-3 rounded-lg border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30 text-sm text-green-700 dark:text-green-300">
                    {{ __('Student created successfully.') }}
                </div>
            @elseif (session('status') === 'student-updated')
                <div class="px-4 py-3 rounded-lg border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30 text-sm text-green-700 dark:text-green-300">
                    {{ __('Student updated successfully.') }}
                </div>
            @elseif (session('status') === 'student-deleted')
                <div class="px-4 py-3 rounded-lg border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30 text-sm text-green-700 dark:text-green-300">
                    {{ __('Student deleted successfully.') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                            {{ __('Student List') }}
                        </h3>
                        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" id="student-count-text">
                            {{ trans_choice('{0} No students yet|{1} :count student|[2,*] :count students', $students->total(), ['count' => $students->total()]) }}
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ __('First Name') }}</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ __('Last Name') }}</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ __('Email') }}</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ __('Student Number') }}</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ __('Year Level') }}</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ __('Course') }}</th>
                                <th scope="col" class="px-6 py-3.5 font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap text-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700/80" id="student-table">
                            @forelse ($students as $student)
                                <tr id="student-row-{{ $student->id }}" class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors">
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-medium whitespace-nowrap row-first-name">{{ $student->first_name }}</td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-medium whitespace-nowrap row-last-name">{{ $student->last_name }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap row-email">{{ $student->email }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-mono text-xs row-student-number">
                                            {{ $student->student_number }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 text-xs font-semibold row-year-level">
                                            {{ __($student->year_level_label) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap row-course">{{ $student->course }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('students.edit', $student) }}" class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 text-xs font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                                {{ __('Edit') }}
                                            </a>
                                            <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this student?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-md border border-red-200 dark:border-red-800 text-xs font-semibold uppercase tracking-wide text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="no-students-row">
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="mx-auto max-w-sm">
                                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ __('No students yet') }}</p>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Add your first student to start building the list.') }}</p>
                                            <a href="{{ route('students.create') }}" class="mt-5 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">{{ __('Add Student') }}</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($students->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof Echo !== 'undefined') {
                const channel = Echo.channel('students');

                const getCsrfToken = () => {
                    const meta = document.querySelector('meta[name="csrf-token"]');
                    return meta ? meta.getAttribute('content') : '';
                };

                // Kukuha ng umiiral na datos sa DOM kung may kulang na detalye sa broadcast payload
                function getRowHtml(data, existingRow = null) {
                    const id = data.id || (existingRow ? existingRow.id.replace('student-row-', '') : '');
                    const firstName = data.first_name || (existingRow ? existingRow.querySelector('.row-first-name')?.textContent.trim() : '') || '';
                    const lastName = data.last_name || (existingRow ? existingRow.querySelector('.row-last-name')?.textContent.trim() : '') || '';
                    const email = data.email || (existingRow ? existingRow.querySelector('.row-email')?.textContent.trim() : '') || '';
                    const studentNumber = data.student_number || (existingRow ? existingRow.querySelector('.row-student-number')?.textContent.trim() : '') || '';
                    const course = data.course || (existingRow ? existingRow.querySelector('.row-course')?.textContent.trim() : '') || '';
                    
                    // Ligtas na paghawak sa Year Level labels at integers
                    let yearLevel = '';
                    if (data.year_level_label) {
                        yearLevel = data.year_level_label;
                    } else if (data.year_level) {
                        const labels = { 1: '1st Year', 2: '2nd Year', 3: '3rd Year', 4: '4th Year' };
                        yearLevel = labels[data.year_level] || `${data.year_level} Year`;
                    } else if (existingRow) {
                        yearLevel = existingRow.querySelector('.row-year-level')?.textContent.trim() || '';
                    }

                    return `
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-medium whitespace-nowrap row-first-name">${firstName}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-medium whitespace-nowrap row-last-name">${lastName}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap row-email">${email}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-mono text-xs row-student-number">${studentNumber}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 text-xs font-semibold row-year-level">${yearLevel}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap row-course">${course}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="/students/${id}/edit" class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 text-xs font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">Edit</a>
                                <form method="POST" action="/students/${id}" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                    <input type="hidden" name="_token" value="${getCsrfToken()}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-md border border-red-200 dark:border-red-800 text-xs font-semibold uppercase tracking-wide text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition">Delete</button>
                                </form>
                            </div>
                        </td>
                    `;
                }

                function showAlert(message, bgColorClass = 'bg-blue-50 dark:bg-blue-900/30', borderEmptyClass = 'border-blue-200 dark:border-blue-800', textColorClass = 'text-blue-700 dark:text-blue-300') {
                    const alertContainer = document.getElementById('student-alert');
                    if (alertContainer) {
                        alertContainer.innerHTML = `
                            <div class="px-4 py-3 rounded-lg border ${borderEmptyClass} ${bgColorClass} text-sm ${textColorClass} transition-all duration-300">
                                ${message}
                            </div>
                        `;
                        setTimeout(() => { alertContainer.innerHTML = ''; }, 5000);
                    }
                }

                // UNIFIED UPSERT ENGINE: Pinipigilan ang duplicate anuman ang pagkakasunod-sunod ng mga kaganapan (events)
                function upsertStudentRow(data, isNewCreation = false) {
                    if (!data || !data.id) return;

                    const existingRow = document.getElementById(`student-row-${data.id}`);
                    if (existingRow) {
                        // Kung may nakitang katugmang row, i-update lang ito gamit ang bagong datos
                        existingRow.innerHTML = getRowHtml(data, existingRow);
                        
                        existingRow.classList.add('bg-yellow-50', 'dark:bg-yellow-900/20');
                        setTimeout(() => existingRow.classList.remove('bg-yellow-50', 'dark:bg-yellow-900/20'), 2000);

                        if (!isNewCreation) {
                            showAlert(`Student record for <strong>${data.first_name || ''} ${data.last_name || ''}</strong> was updated in real-time!`, 'bg-amber-50 dark:bg-amber-900/30', 'border-amber-200 dark:border-amber-800', 'text-amber-700 dark:text-amber-300');
                        }
                    } else {
                        // Kung bago talaga ang ID, i-insert ito sa pinakaunang posisyon sa listahan
                        const tableBody = document.getElementById('student-table');
                        if (tableBody) {
                            const noStudentsRow = document.getElementById('no-students-row');
                            if (noStudentsRow) noStudentsRow.remove();

                            const newRow = document.createElement('tr');
                            newRow.id = `student-row-${data.id}`;
                            newRow.className = "bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors border-b border-gray-100 dark:border-gray-700/80";
                            newRow.innerHTML = getRowHtml(data);
                            tableBody.insertBefore(newRow, tableBody.firstChild);

                            if (isNewCreation) {
                                showAlert(`A new student (<strong>${data.first_name || ''} ${data.last_name || ''}</strong>) has been added in real-time!`);
                            }
                        }
                    }
                }

                // 1. LISTEN FOR CREATE
                channel.listen('.student.created', (payload) => {
                    const data = payload.student ? payload.student : payload;
                    upsertStudentRow(data, true);
                });

                // 2. LISTEN FOR UPDATE
                channel.listen('.student.updated', (payload) => {
                    const data = payload.student ? payload.student : payload;
                    upsertStudentRow(data, false);
                });

                // 3. LISTEN FOR DELETE
                channel.listen('.student.deleted', (payload) => {
                    const studentId = payload.id !== undefined ? payload.id : (payload.student && payload.student.id ? payload.student.id : (typeof payload === 'object' && payload.student ? payload.student : null));
                    
                    if (studentId) {
                        const rowToDelete = document.getElementById(`student-row-${studentId}`);
                        if (rowToDelete) {
                            rowToDelete.remove();
                            
                            const tableBody = document.getElementById('student-table');
                            if (tableBody && tableBody.children.length === 0) {
                                tableBody.innerHTML = `
                                    <tr id="no-students-row">
                                        <td colspan="7" class="px-6 py-16 text-center">
                                            <div class="mx-auto max-w-sm">
                                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">No students yet</p>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            }

                            showAlert(`A student record was removed in real-time!`, 'bg-red-50 dark:bg-red-900/30', 'border-red-200 dark:border-red-800', 'text-red-700 dark:text-red-400');
                        }
                    }
                });

            } else {
                console.warn('Laravel Echo is not defined. Make sure you are running npm run dev.');
            }
        });
    </script>
</x-app-layout>