@extends('layout.app')

@section('title', 'Absensi')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold mb-1">Staff Attendance</h2>
    <p class="text-gray-600 mb-4">Welcome, <span class="font-semibold text-blue-700">{{ Auth::user()->fullname }}</span></p>


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
                    <p class="text-sm text-gray-500">
                        Check-in at: 
                        {{ \Carbon\Carbon::parse($attendance->attendance_time)->timezone('Asia/Jakarta')->format('H:i') }} WIB
                    </p>
                @endif

                @if($attendance->image)
                    <div class="mt-2">
                        <img src="{{ Storage::url($attendance->image) }}" alt="Check-in Image" class="h-32 rounded shadow-md">
                        <p class="text-xs text-gray-400 mt-1">Check-in image</p>
                    </div>
                @endif

                @if($attendance->checkout_time)
                    <p class="mt-4 text-sm text-green-700">
                        Checked out at: {{ \Carbon\Carbon::parse($attendance->checkout_time)->timezone('Asia/Jakarta')->format('H:i') }} WIB
                    </p>
                    <p class="text-gray-500">You have completed your attendance today.</p>

                    @if($attendance->checkout_image)
                        <div class="mt-2">
                            <img src="{{ Storage::url($attendance->checkout_image) }}" alt="Checkout Image" class="h-32 rounded shadow-md">
                            <p class="text-xs text-gray-400 mt-1">Checkout image</p>
                        </div>
                    @endif
                @else
                    <hr class="my-4">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Absen Pulang</h4>
                    <form action="{{ route('staff.attendance.checkout') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">
                                Upload Checkout Image <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="image" id="image" required
                                class="mt-2 block w-full px-4 py-2 border rounded-md bg-gray-50"
                                accept="image/*">
                            @error('image')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                            class="bg-purple-600 text-white px-6 py-2 rounded-md hover:bg-purple-700">
                            Submit Checkout
                        </button>
                    </form>
                @endif
            @else
                {{-- Form Absen Masuk --}}
                <form action="{{ route('staff.attendance.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="shift" class="block text-sm font-medium text-gray-700">Select Shift:</label>
                        <select name="shift" id="shift" required
                            class="mt-2 block w-full px-4 py-2 border rounded-md bg-gray-50">
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
                        <label for="image" class="block text-sm font-medium text-gray-700">
                            Upload Attendance Image <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="image" id="image" required
                            class="mt-2 block w-full px-4 py-2 border rounded-md bg-gray-50"
                            accept="image/*">
                        @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="bg-green-600 text-white py-2 px-6 rounded-md hover:bg-green-700 focus:outline-none">
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

{{-- DAFTAR MEJA RESERVED/NOT AVAILABLE --}}
<section class="mt-10">
    <h3 class="text-2xl font-semibold mb-4">Daftar Meja Tidak Tersedia</h3>
    <div class="bg-white rounded-lg shadow p-4">
        @if($mejas->whereIn('ketersediaan', ['reserved', 'not available'])->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left font-semibold">No.</th>
                            <th class="px-4 py-2 text-left font-semibold">Nomor Meja</th>
                            <th class="px-4 py-2 text-left font-semibold">Kapasitas</th>
                            <th class="px-4 py-2 text-left font-semibold">Status</th>
                            <th class="px-4 py-2 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mejas->whereIn('ketersediaan', ['reserved', 'not available']) as $meja)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 font-bold text-blue-700">{{ $meja->nomor_meja }}</td>
                            <td class="px-4 py-2">{{ $meja->kapasitas }}</td>
                            <td class="px-4 py-2">
                                <span class="px-3 py-1 rounded-full
                                    @if($meja->ketersediaan === 'reserved') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($meja->ketersediaan) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('staff.meja.makeAvailable', $meja->id) }}">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded transition">
                                        Set Available
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">Tidak ada meja dengan status reserved/not available.</p>
        @endif
    </div>
</section>
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

                        // Tooltip konten
                        $tooltip = "Staff: {$entry->user->fullname}\\nStatus: $status";
                        if ($entry->shift) $tooltip .= "\\nShift: " . $entry->shift;
                        if ($entry->attendance_time) {
                            $tooltip .= "\\nMasuk: " . \Carbon\Carbon::parse($entry->attendance_time)->timezone('Asia/Jakarta')->format('H:i') . " WIB";
                        }
                        if ($entry->checkout_time) {
                            $tooltip .= "\\nPulang: " . \Carbon\Carbon::parse($entry->checkout_time)->timezone('Asia/Jakarta')->format('H:i') . " WIB";
                        }
                        $tooltip .= "\\nKlik untuk lihat gambar";


                        // Tentukan URL gambar yang diklik (checkout lebih prioritas jika ada)
                        $imageUrl = $entry->checkout_image 
                            ? Storage::url($entry->checkout_image) 
                            : ($entry->image ? Storage::url($entry->image) : '#');
                    @endphp
                    {
                        title: '{{ $status }}',
                        start: '{{ $entry->attendance_date->format('Y-m-d') }}',
                        color: '{{ $color }}',
                        url: '{{ $imageUrl }}',
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