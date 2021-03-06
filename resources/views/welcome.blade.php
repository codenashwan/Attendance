<div class="p-3">
    <div>
            <h3 class="fw-bolder my-3"> <span wire:click="$toggle('hideOne' , true)" class="point"> {{ $hideOne ? "+" : "-" }} </span> <i class="bi bi-file-text mx-2"></i> Attendance System For Teacher</h3> 
            <div class="{{ $hideOne ? "d-none" : "d-flex flex-wrap" }}">
                @component('components.form.select', [
                'icon' => 'building',
                'model' => 'department',
                'array' => $departments,
                ])
                @endcomponent
                @component('components.form.select', [
                'icon' => 'sort-down-alt',
                'model' => 'stage',
                'array' => $stages,
                ])
                @endcomponent
                @component('components.form.select', [
                'icon' => 'easel2',
                'model' => 'subject',
                'array' => $subjects,
                ])
                @endcomponent
                @component('components.form.select', [
                'icon' => 'bezier2',
                'model' => 'class',
                'array' => $subject ? $classes : [],
                ])
                @endcomponent
                @component('components.form.select', [
                'icon' => 'alarm',
                'model' => 'time',
                'array' => $times,
                ])
                @endcomponent
                @component('components.form.input', [
                'icon' => 'calendar-range',
                'model' => 'today',
                'type' => 'date',
                ])
                @endcomponent
            </div>
            <div class="col-12">
                <h3 class="fw-bolder my-3"> <span wire:click="$toggle('hideTwo' , true)" class="point"> {{ $hideTwo ? "+" : "-" }} </span> <i class="bi bi-person-plus mx-2"></i> Create Student</h3>
                <form wire:submit.prevent="newStudent" class="{{ $hideTwo ? "d-none" : "" }}">
                    <div class="d-flex">
                        @component('components.form.input', [
                        'icon' => 'person-plus',
                        'model' => 'name',
                        'type' => 'text',
                        ])
                        @endcomponent
                        <div class="col-lg-4 col-12 p-2">
                            <button class="btn btn-dark rounded-0 btn-lg mb-3">Insert Student</button>
                        </div>
                    </div>
                    @if($errors->any())
                    {!! implode('', $errors->all('<span class="badge bg-white rounded-3 p-2 text-danger border m-1">:message</span>')) !!}
                    @endif
                </form>
            </div>
            <hr>
            <div class="mt-3">
                <h3>Result Students ({{ $students->count() }})</h3>
                @component('components.form.input', [
                'icon' => 'search',
                'model' => 'search',
                'type' => 'search',
                ])
                @endcomponent

                <table class="table bg-white table-borderless table-hover table-lg">
                    <thead>
                        <tr class="text-center bg-warning">
                            <th scope="col" dir="rtl">5 ?????????? ????????????</th>
                            <th scope="col" dir="rtl">20 ?????????? ????????????????</th>
                            <th scope="col">???????? ??????????</th>
                            <th scope="col">Attendance</th>
                            <th scope="col">Vacation</th>
                            <th scope="col">Total Attendance</th>
                            <th scope="col">Total Vacation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr class="text-center">
                            <th>
                                <span wire:click="mark(`{{ $student->id }}`, `{{ $student->mark->value ?? 0 }}`,`0`)" class="point badge text-danger border rounded-circle mx-3">-</span>
                                <input wire:model.defer="calc" wire:keydown.enter="calc(`{{ $student->id }}`)" type="text" width="65px" class="border border-light rounded-3 text-center" placeholder="{{ $student->mark->value  ?? "0"}}">
                                <span wire:click="mark(`{{ $student->id }}`, `{{ $student->mark->value ?? 0 }}`,`1`)" class="point badge text-success border rounded-circle mx-3">+</span>
                            </th>
                            <th>
                                
                                <input wire:model.defer="first_term_mark_20" wire:keydown.enter="first_term_mark_20(`{{ $student->id }}`)" type="text" width="65px" class="border border-light rounded-3 text-center" placeholder="{{ $student->emoji().$student->first_term_mark_20  ?? "0"}}">
                            </th>
                            <td>{{ $student->name }}</td>
                            <td class="border point {{  $student->nowattendance($subject,$today) ? "bg-danger text-white" : ""}}"
                                @if($student->nowattendance($subject , $today))
                                wire:click="removeLastAttendance(`{{ $student->id }}`)"
                                @else
                                wire:click="attendance(`{{ $student->id }}`)"
                                @endif
                                >
                                <i class="bi bi-{{  $student->nowattendance($subject,$today) ? "x-lg" : ""}}"></i>
                            </td>
                            <td class="border point {{  $student->nowattendance($subject,$today,1) ? "bg-warning text-white" : ""}}"
                                @if($student->nowattendance($subject , $today,1))
                                wire:click="removeLastAttendance(`{{ $student->id }}` , 1)"
                                @else
                                wire:click="attendance(`{{ $student->id }}`,1)"
                                @endif
                                >
                                <i class="bi bi-{{  $student->nowattendance($subject,$today,1) ? "box-arrow-in-up-right" : ""}}"></i>
                            </td>
                            <td class="text-danger" title="{{ $student->attendances($subject)->count() > 0 ? $student->ShowAllAttendances($subject)  : "0"}}">
                                {{ $student->attendances($subject)->count() }}
                            </td>
                            <td class="text-danger" title="{{ $student->attendances($subject,1)->count() > 0 ? $student->ShowAllAttendances($subject,1)  : "0"}}">
                                {{ $student->attendances($subject,1)->count() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
