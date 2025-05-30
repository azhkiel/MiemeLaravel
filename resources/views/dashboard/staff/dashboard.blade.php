@extends('layout.app')

@section('title', 'Absensi')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold mb-4">Staff Attendance</h2>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#2563eb', // Tailwind's blue-600
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#e3342f', // Tailwind's red-600
                });
            });
        </script>
    @endif

    <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="card-header bg-blue-600 text-white p-4 text-lg font-semibold">
            Today's Attendance
        </div>

        <div class="card-body p-6">
            @if($attendance)
                <p class="text-xl mb-2">
                    Your current status:
                    <span class="font-bold text-blue-600">{{ ucfirst($attendance->status) }}</span>
                    @if($attendance->shift)
                        <span class="ml-2 text-sm text-gray-600">(Shift: {{ $attendance->shift }})</span>
                    @endif
                </p>
                @if($attendance->attendance_time)
                    <p class="text-sm text-gray-500 mb-4">
                        Recorded at: 
                        {{ \Carbon\Carbon::parse($attendance->attendance_time)->timezone('Asia/Jakarta')->format('H:i') }} WIB
                    </p>
                @endif
                <p class="text-gray-500">You have already submitted attendance for today.</p>
            @else
                <form action="{{ route('staff.attendance.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="shift" class="block text-sm font-medium text-gray-700">Select Shift:</label>
                        <select name="shift" id="shift" required class="mt-2 block w-full px-4 py-2 border rounded-md bg-gray-50">
                            <option value="">-- Choose Shift --</option>
                            <option value="Pagi" {{ old('shift') == 'Pagi' ? 'selected' : '' }}>Pagi (Before 07:00)</option>
                            <option value="Siang" {{ old('shift') == 'Siang' ? 'selected' : '' }}>Siang (Before 14:00)</option>
                            <option value="Sore" {{ old('shift') == 'Sore' ? 'selected' : '' }}>Sore (Before 18:00)</option>
                        </select>
                        @error('shift')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Upload Attendance Image <span class="text-red-500">*</span></label>
                        <input type="file" name="image" id="image" required class="mt-2 block w-full px-4 py-2 border rounded-md bg-gray-50" accept="image/*">
                        @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="mt-3 bg-green-600 text-white py-2 px-6 rounded-md hover:bg-green-700 focus:outline-none">
                        Submit Attendance
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Attendance Calendar -->
    <div class="mt-12">
        <h3 class="text-2xl font-semibold mb-4">Attendance Calendar</h3>
        <div id="attendance-calendar"></div>
        <div class="mt-4 space-y-2 text-sm">
            <div class="flex items-center space-x-2">
                <span class="w-4 h-4 rounded bg-green-400 inline-block"></span><span>Present</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-4 h-4 rounded bg-yellow-400 inline-block"></span><span>Late</span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-4 h-4 rounded bg-red-400 inline-block"></span><span>Absent</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('attendance-calendar');
        if (!calendarEl) return;

        // Get current date in Asia/Jakarta timezone for calendar initial date
        function getJakartaDate() {
            const d = new Date();
            // Convert local time to UTC +7 offset for Jakarta
            const utc = d.getTime() + (d.getTimezoneOffset() * 60000);
            const jakartaTime = new Date(utc + 1 * 3600000);
            return jakartaTime.toISOString().split('T')[0];
        }

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 500,
            initialDate: getJakartaDate(),
            events: [
                @foreach($history as $entry)
                    @php
                        $status = ucfirst($entry->status);
                        $color = match ($entry->status) {
                            'present' => '#34D399',
                            'absent'  => '#F87171',
                            'late'    => '#FBBF24',
                            default   => '#A5B4FC',
                        };
                        $tooltip = "Status: $status";
                        if ($entry->shift) $tooltip .= "\\nShift: " . $entry->shift;
                        if ($entry->attendance_time) {
                            $timeWIB = \Carbon\Carbon::parse($entry->attendance_time)->timezone('Asia/Jakarta')->format('H:i');
                            $tooltip .= "\\nTime: " . $timeWIB . " WIB";
                        }
                        if ($entry->image) $tooltip .= "\\nClick to view image";
                    @endphp
                    {
                        title: '{{ $status }}',
                        start: '{{ $entry->attendance_date->format('Y-m-d') }}',
                        color: '{{ $color }}',
                        url: '{{ $entry->image ? Storage::url($entry->image) : "#" }}',
                        extendedProps: {
                            tooltip: `{!! nl2br(e($tooltip)) !!}`
                        }
                    },
                @endforeach
            ],
            eventDidMount: function(info) {
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip bg-black text-white text-xs rounded px-2 py-1 absolute z-10 hidden';
                tooltip.innerHTML = info.event.extendedProps.tooltip;
                document.body.appendChild(tooltip);

                info.el.addEventListener('mouseenter', function () {
                    tooltip.style.display = 'block';
                    const rect = info.el.getBoundingClientRect();
                    tooltip.style.top = `${rect.top + window.scrollY - 30}px`;
                    tooltip.style.left = `${rect.left + window.scrollX}px`;
                });

                info.el.addEventListener('mouseleave', function () {
                    tooltip.style.display = 'none';
                });
            },
            eventClick: function(info) {
                if (info.event.url && info.event.url !== "#") {
                    window.open(info.event.url, '_blank');
                    info.jsEvent.preventDefault();
                }
            }
        });

        calendar.render();
    });
</script>
@endpush