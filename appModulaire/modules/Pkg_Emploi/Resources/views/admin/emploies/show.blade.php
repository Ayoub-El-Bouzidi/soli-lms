@extends('adminlte::page')

@section('title', 'Emploi creation')

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content_header')
    <h1>Emploi du temps de groupe {{$emploi->groupe->nom}} 
                <small class="text-muted">
                    ({{ $emploi->date_debut }} à {{ $emploi->date_fin }})
                </small></h1>
@stop
@section('content')
    <div class="card" >
        {{-- <div class="card-header">
           
            <div class="card-tools">
                <a href="{{ route('emploie.edit', $emploi->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit Timetable
                </a>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addLessonModal">
                    <i class="fas fa-plus"></i> Add Lesson
                </button>
                <button type="button" class="btn btn-success btn-sm ml-2">
                    <i class="fas fa-download"></i> Export PDF
                </button>
            </div>
        </div> --}}
        <div class="card-body p-0" >
            <div class="table-responsive">
                <table class="table table-bordered timetable-table">
                    <thead>
                        <tr class="bg-light">
                            <th class="day-header">Day</th>
                            @foreach($timeSlots as $slot)
                                <th class="time-header">{{ $slot }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daysForView as $dayKey => $dayName)
                            <tr>
                                <td class="day-cell">
                                    <strong>{{ strtoupper($dayName) }}</strong>
                                </td>
                                
                                @php $skipSlots = []; @endphp
                                @foreach($timeSlots as $slotIndex => $slot)
                                    @if(in_array($slotIndex, $skipSlots))
                                        @continue
                                    @endif
                                    
                                    @php
                                        $lesson = $timetable[$dayKey][$slotIndex] ?? null;
                                        $isStart = $lesson && ($lesson['start_slot'] ?? 0) == $slotIndex;
                                        $colspan = 1;
                                        
                                        if($lesson && $isStart) {
                                            $colspan = ($lesson['end_slot'] - $lesson['start_slot'] + 1);
                                            // Add slots to skip for this lesson
                                            for($i = $slotIndex + 1; $i <= $lesson['end_slot']; $i++) {
                                                $skipSlots[] = $i;
                                            }
                                        }
                                    @endphp
                                    
                                    @if($lesson && $isStart)
                                        <td style="background-color: {{ $lesson['color_class'] ?? 'black' }}; color: black;" colspan="{{ $colspan }}"
                                            class="lesson-cell"
                                            data-lesson-id="{{ $lesson['id'] ?? '' }}"
                                            title="Click to edit">
                                            <div class="lesson-content">
                                                <div class="lesson-subject">
                                                    <strong>{{ $lesson['subject'] ?? '' }}</strong>
                                                </div>
                                                <div class="lesson-instructor">
                                                    {{ $lesson['instructor'] ?? '' }}
                                                </div>
                                                <div class="lesson-room">
                                                    <small>{{ $lesson['room'] ?? '' }}</small>
                                                </div>
                                                <div class="lesson-time">
                                                    {{ $lesson['start_time'] ?? '' }} - {{ $lesson['end_time'] ?? '' }}
                                                </div>
                                            </div>
                                        </td>
                                    @else
                                        <td class="empty-cell" 
                                            data-day="{{ $dayKey }}" 
                                            data-slot="{{ $slotIndex }}" 
                                            data-time="{{ $slot }}"
                                            title="Click to add lesson"></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Legend -->
    {{-- <div class="card mt-3">
        <div class="card-body">
            <h5>Instructors Legend</h5>
            <div class="row">
                @foreach($formateurs as $formateur)
                    <div class="col-md-2 mb-2">
                        <span class="badge bg-dark p-2">
                            {{ $formateur->nom }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}

    <!-- Statistics Card -->
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $emploi->seancesemploies->count() }}</h3>
                    <p>Total Seances</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $emploi->seancesemploies->pluck('formateur_id')->unique()->count() }}</h3>
                    <p>Formateurs Actif</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $emploi->seancesemploies->pluck('salle_id')->unique()->count() }}</h3>
                    <p>Salles Utilisés</p>
                </div>
                <div class="icon">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ (6 * count($timeSlots)) - $emploi->seancesemploies->count() }}</h3>
                    <p>Cases vides</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Lesson Modal -->
    <div class="modal fade" id="addLessonModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="lessonForm">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Lesson</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject">Subject/Module</label>
                                    <select class="form-control" id="subject" name="subject" required>
                                        <option value="">Select Subject</option>
                                        @foreach($modules as $module)
                                            <option value="{{ $module->id }}">{{ $module->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instructor">Instructor</label>
                                    <select class="form-control" id="instructor" name="instructor" required>
                                        <option value="">Select Instructor</option>
                                        @foreach($formateurs as $formateur)
                                            <option value="{{ $formateur->id }}">{{ $formateur->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room">Room</label>
                                    <select class="form-control" id="room" name="room" required>
                                        <option value="">Select Room</option>
                                        @foreach($salles as $salle)
                                            <option value="{{ $salle->id }}">{{ $salle->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="day">Day</label>
                                    <select class="form-control" id="day" name="day" required>
                                        <option value="">Select Day</option>
                                        @foreach($daysForView as $key => $day)
                                            <option value="{{ $key }}">{{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_time">Start Time</label>
                                    <select class="form-control" id="start_time" name="start_time" required>
                                        <option value="">Select Start Time</option>
                                        <option value="09:00">09:00</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="12:00">12:00</option>
                                        <option value="12:30">12:30</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:30">17:30</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_time">End Time</label>
                                    <select class="form-control" id="end_time" name="end_time" required>
                                        <option value="">Select End Time</option>
                                        <option value="09:30">09:30</option>
                                        <option value="10:00">10:00</option>
                                        <option value="10:30">10:30</option>
                                        <option value="11:00">11:00</option>
                                        <option value="11:30">11:30</option>
                                        <option value="12:00">12:00</option>
                                        <option value="12:30">12:30</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="17:00">17:00</option>
                                        <option value="17:30">17:30</option>
                                        <option value="18:00">18:00</option>
                                        <option value="18:30">18:30</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Lesson</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop


@section('js')
    <script>
        $(document).ready(function() {
            // Handle lesson cell clicks for editing
            $('.lesson-cell').click(function() {
                var lessonId = $(this).data('lesson-id');
                if (lessonId) {
                    toastr.info('Edit functionality - Lesson ID: ' + lessonId);
                }
            });
            
            // Handle empty cell clicks for quick add
            $('.empty-cell').click(function() {
                var day = $(this).data('day');
                var slot = $(this).data('slot');
                var time = $(this).data('time');
                
                $('#addLessonModal').modal('show');
                $('#day').val(day);
                
                // Convert time slot to actual time
                var timeMap = {
                    '9h00': '09:00', '9h30': '09:30', '10h00': '10:00', '10h30': '10:30',
                    '11h00': '11:00', '11h30': '11:30', '12h00': '12:00', '12h30': '12:30',
                    '13h00': '13:00', '13h30': '13:30', '14h00': '14:00', '14h30': '14:30',
                    '15h00': '15:00', '15h30': '15:30', '16h00': '16:00', '16h30': '16:30',
                    '17h00': '17:00', '17h30': '17:30', '18h00': '18:00', '18h30': '18:30'
                };
                
                if (timeMap[time]) {
                    $('#start_time').val(timeMap[time]);
                }
            });
            
            // Auto-calculate end time based on start time (default 1.5 hours)
            $('#start_time').change(function() {
                var startTime = $(this).val();
                if (startTime) {
                    var start = new Date('2000-01-01 ' + startTime);
                    start.setMinutes(start.getMinutes() + 90); // Add 1.5 hours
                    var hours = start.getHours().toString().padStart(2, '0');
                    var minutes = start.getMinutes().toString().padStart(2, '0');
                    var endTime = hours + ':' + minutes;
                    $('#end_time').val(endTime);
                }
            });
            
            // Form submission
            $('#lessonForm').submit(function(e) {
                e.preventDefault();
                
                var formData = {
                    subject: $('#subject').val(),
                    instructor: $('#instructor').val(),
                    room: $('#room').val(),
                    day: $('#day').val(),
                    start_time: $('#start_time').val(),
                    end_time: $('#end_time').val()
                };
                
                // Validate form
                if (!formData.subject || !formData.instructor || !formData.room || !formData.day || !formData.start_time || !formData.end_time) {
                    toastr.error('Please fill in all required fields');
                    return;
                }
                
                if (formData.start_time >= formData.end_time) {
                    toastr.error('End time must be after start time');
                    return;
                }
                
                // Here you would send the data to your controller
                toastr.success('Lesson added successfully!');
                $('#addLessonModal').modal('hide');
                $('#lessonForm')[0].reset();
            });
            
            // Initialize tooltips
            $('[title]').tooltip();
        });
    </script>
@stop




@section('css')
    <style>
    .timetable-table {
    font-size: 11px;
    border-collapse: collapse;
    width: 100%;
    }

    .timetable-table th,
    .timetable-table td {
    border: 2px solid #dee2e6;
    padding: 4px;
    text-align: center;
    vertical-align: middle;
    }

    .day-header {
    background-color: #f8f9fa;
    font-weight: bold;
    width: 100px;
    }

    .time-header {
    background-color: #f8f9fa;
    font-weight: bold;
    min-width: 60px;
    writing-mode: vertical-rl;
    text-orientation: mixed;
    height: 60px;
    font-size: 10px;
    }

    .day-cell {
    background-color: #e9ecef;
    font-weight: bold;
    writing-mode: vertical-rl;
    text-orientation: mixed;
    width: 80px;
    font-size: 12px;
    }

    .lesson-cell {
    color: white;
    font-weight: bold;
    position: relative;
    min-height: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    }

    .lesson-cell.bg-primary {
    background-color: #4a90e2 !important;
    border: 2px solid #357abd;
    }

    .lesson-cell.bg-warning {
    background-color: #f5d76e !important;
    color: #333 !important;
    border: 2px solid #e6c757;
    }

    .lesson-cell.bg-success {
    background-color: #5cb85c !important;
    border: 2px solid #449d44;
    }

    .lesson-cell.bg-info {
    background-color: #5bc0de !important;
    border: 2px solid #46b8da;
    }

    .lesson-cell.bg-secondary {
    background-color: #6c757d !important;
    border: 2px solid #5a6268;
    }

    .lesson-cell.bg-danger {
    background-color: #dc3545 !important;
    border: 2px solid #c82333;
    }

    .lesson-content {
    padding: 3px;
    line-height: 1.3;
    }

    .lesson-subject {
    font-size: 12px;
    margin-bottom: 2px;
    }

    .lesson-instructor {
    font-size: 10px;
    margin-bottom: 1px;
    }

    .lesson-room {
    font-size: 9px;
    margin-bottom: 2px;
    opacity: 0.9;
    }

    .lesson-time {
    font-size: 8px;
    opacity: 0.8;
    border-top: 1px solid rgba(255,255,255,0.3);
    padding-top: 2px;
    }

    .empty-cell {
    background-color: #ffffff;
    height: 50px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    }

    .empty-cell:hover {
    background-color: #f8f9fa;
    }

    .lesson-cell:hover {
    opacity: 0.9;
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .small-box {
    border-radius: 10px;
    }

    .badge {
    font-size: 11px;
    }

    @media (max-width: 768px) {
    .timetable-table {
        font-size: 9px;
    }

    .time-header {
        min-width: 40px;
        height: 40px;
        font-size: 8px;
    }

    .day-cell {
        width: 60px;
        font-size: 10px;
    }

    .lesson-subject {
        font-size: 10px;
    }

    .lesson-instructor {
        font-size: 8px;
    }

    .lesson-room,
    .lesson-time {
        font-size: 7px;
    }
    }

    /* Print styles */
    @media print {
    .card-tools,
    .modal,
    .small-box {
        display: none !important;
    }

    .timetable-table {
        font-size: 10px;
    }
    }
    </style>
@stop