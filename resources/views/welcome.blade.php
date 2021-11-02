<div>
    <div class="d-flex flex-wrap">
        <div class="col-lg-5 d-lg-block d-none vh-100">
            <img src="{{ asset('assets/img/bg.jpg') }}" class="p-2 rounded-3 img-fluid h-100 w-100 cover">
        </div>

        <div class="col-lg-7 col-12 p-2">
            <h3 class="fw-bolder my-3"><i class="bi bi-card-checklist mx-2"></i> Attendance System For Teacher</h3>
            <div class="d-flex flex-wrap">
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
                <div class="col-12 p-2">
                    <button class="btn btn-dark mx-2 shadow btn-lg">Insert Students</button>
                </div>
            </div>

            {{-- @if(count($students) > 0) --}}
            <hr class="my-5">
            <h3>Result Students</h3>
            @component('components.form.input', [
                'icon' => 'search',
                'model' => 'search',
                'type' => 'search',
                ])
                @endcomponent

            <table class="table bg-white table-borderless table-hover table-lg">
                <thead>
                  <tr class="text-center">
                    <th scope="col">Mark</th>
                    <th scope="col">Name</th>
                    <th scope="col">Today</th>
                    <th scope="col">Total Attendance</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($students as $student)
                  <tr class="text-center">
                    <th>
                      <span  wire:click="mark(`{{ $student->id }}`, `{{ $student->mark->value ?? 0 }}`,`0`)" class="point badge text-danger border rounded-circle mx-3">-</span>
                      {{ $student->mark->value  ?? "0"}}
                      <span wire:click="mark(`{{ $student->id }}`, `{{ $student->mark->value ?? 0 }}`,`1`)" class="point badge text-success border rounded-circle mx-3">+</span>
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
                    <td class="text-danger">
                      {{ $student->attendances($subject)->count() }}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              {{-- @endif --}}
        </div>
    </div>
</div>
