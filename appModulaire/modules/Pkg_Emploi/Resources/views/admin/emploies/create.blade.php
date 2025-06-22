@extends('adminlte::page')

@section('title', 'Emploi creation')

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content_header')
    <h1>Interactif emploi avec création des séances</h1>
@stop

@section('content')
    @php
    // Sample existing lessons data
    $existingLessons = [
        [
            'id' => 'lesson-1',
            'title' => 'M11 - Mathematics',
            'module' => 'M11',
            'formateur' => 'ES SERRAJ FOUAD',
            'salle' => 'SALLE05',
            'color' => '#4a90e2',
            'textColor' => '#ffffff'
        ],
        [
            'id' => 'lesson-2',
            'title' => 'M101 - Programming',
            'module' => 'M101',
            'formateur' => 'EL KHALLOUI FIRDAOUS',
            'salle' => 'LAB01',
            'color' => '#f5d76e',
            'textColor' => '#333333'
        ]
    ];

    // Sample scheduled events
    $scheduledEvents = [
        [
            'id' => 'event-1',
            'title' => 'M11 - Mathematics',
            'start' => '2024-01-08T09:00:00',
            'end' => '2024-01-08T11:00:00',
            'module' => 'M11',
            'formateur' => 'ES SERRAJ FOUAD',
            'salle' => 'SALLE05',
            'color' => '#4a90e2'
        ]
    ];

    // Predefined colors
    $colors = [
        ['value' => '#4a90e2', 'name' => 'Blue'],
        ['value' => '#f5d76e', 'name' => 'Yellow'],
        ['value' => '#5cb85c', 'name' => 'Green'],
        ['value' => '#5bc0de', 'name' => 'Light Blue'],
        ['value' => '#dc3545', 'name' => 'Red'],
        ['value' => '#6c757d', 'name' => 'Gray'],
        ['value' => '#fd7e14', 'name' => 'Orange'],
        ['value' => '#e83e8c', 'name' => 'Pink'],
        ['value' => '#20c997', 'name' => 'Teal'],
        ['value' => '#6f42c1', 'name' => 'Purple']
    ];
    @endphp

    <!-- Notification Area -->
    <div id="notification-area" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

    <!-- Timetable Configuration -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cog"></i> Emploi Configuration
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="start-date">Date debut</label>
                                <input type="date" class="form-control" id="start-date" value="2025-06-23">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="end-date">Date fin</label>
                                <input type="date" class="form-control" id="end-date" value="2024-07-01">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="group-select">Groupes</label>
                                <select class="form-control" id="group-select">
                                    @foreach ($groupes as $groupe)
                                    <option value="{{$groupe->id}}">{{$groupe->nom}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-primary btn-block" id="apply-config">
                                    <i class="fas fa-check"></i> Appliquer Configuration
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Lesson Creation Panel -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i> Créer Nouveau Séance
                    </h3>
                </div>
                <div class="card-body">
                    <form id="lesson-creation-form">
                        <div class="form-group">
                            <label for="lesson-module">Module</label>
                            <select class="form-control" id="lesson-module" required>
                                <option value="">Choisissez Module</option>
                                @foreach ($modules as $module)
                                    <option value="{{$module->id}}">{{$module->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lesson-formateur">Formateur</label>
                            <select class="form-control" id="lesson-formateur" required>
                                <option value="">Choisissez Formateur</option>
                                @foreach ($formateurs as $formateur)
                                    <option value="{{$formateur->id}}">{{$formateur->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lesson-salle">Salle</label>
                            <select class="form-control" id="lesson-salle" required>
                                <option value="">Choisissez Salle</option>
                                @foreach ($salles as $salle)
                                    <option value="{{$salle->id}}">{{$salle->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Couleur</label>
                            <div class="color-selection">
                                @foreach($colors as $index => $color)
                                    <label class="color-option">
                                        <input type="radio" name="lesson-color" value="{{ $color['value'] }}" 
                                            {{ $index === 0 ? 'checked' : '' }}>
                                        <div class="color-circle" style="background-color: {{ $color['value'] }};" 
                                            title="{{ $color['name'] }}"></div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-plus"></i> Créer Séance
                        </button>
                    </form>
                </div>
            </div>

            <!-- Lesson Palette -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-palette"></i> Palette de séance
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" id="clear-palette">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="lesson-palette">
                        <p class="text-muted mb-2">Faites glisser les leçons vers le calendrier</p>
                        @foreach($existingLessons as $lesson)
                            <div class="palette-lesson" 
                                data-lesson='@json($lesson)'
                                style="background-color: {{ $lesson['color'] }}; color: {{ $lesson['textColor'] }};">
                                <div class="lesson-title">{{ $lesson['module'] }}</div>
                                <div class="lesson-details">
                                    <small>
                                        <i class="fas fa-user"></i> {{ $lesson['formateur'] }}<br>
                                        <i class="fas fa-door-open"></i> {{ $lesson['salle'] }}
                                    </small>
                                </div>
                                <button class="btn btn-sm btn-danger delete-lesson" data-lesson-id="{{ $lesson['id'] }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-3">
                        <label>
                            <input type="checkbox" id="drop-remove" />
                            Supprimer après la chute
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar"></i> Emploi
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-info mr-2" id="current-group">DM101</span>
                        <button type="button" class="btn btn-primary btn-sm" id="clear-calendar">
                            <i class="fas fa-trash"></i> Vider Emploi
                        </button>
                        <button type="button" class="btn btn-success btn-sm" id="save-timetable">
                            <i class="fas fa-save"></i> Enregistrer Emploi
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- FIXED: Event Details Modal - Removed day, start time, and end time editing -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modifier Séance</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <input type="hidden" id="eventId">
                        
                        <!-- FIXED: Only allow editing of module, formateur, and salle -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="eventModule">Module</label>
                                    <select class="form-control" id="eventModule">
                                        @foreach ($modules as $module)
                                            <option value="{{$module->id}}">{{$module->nom}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="eventFormateur">Formateur</label>
                                    <select class="form-control" id="eventFormateur">
                                        @foreach ($formateurs as $formateur)
                                            <option value="{{$formateur->id}}">{{$formateur->nom}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="eventSalle">Salle</label>
                                    <select class="form-control" id="eventSalle">
                                        @foreach ($salles as $salle)
                                            <option value="{{$salle->id}}">{{$salle->nom}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- FIXED: Display-only fields for day and time -->
                                <div class="form-group">
                                    <label>Jour</label>
                                    <div class="form-control-plaintext" id="eventDayDisplay"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Heure de début</label>
                                    <div class="form-control-plaintext" id="eventStartDisplay"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Heure de fin</label>
                                    <div class="form-control-plaintext" id="eventEndDisplay"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hidden fields to store original timing data -->
                        <input type="hidden" id="eventDay">
                        <input type="hidden" id="eventStart">
                        <input type="hidden" id="eventEnd">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="deleteEvent">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="saveEvent">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<!-- FullCalendar CSS -->
{{-- <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' /> --}}
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
/* Color Selection Styling */
.color-selection {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 5px;
}

.color-option {
    position: relative;
    cursor: pointer;
    margin: 0;
}

.color-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.color-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 3px solid transparent;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.color-option input[type="radio"]:checked + .color-circle {
    border-color: #333;
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.color-option:hover .color-circle {
    transform: scale(1.05);
}

/* Lesson Palette Styling */
#lesson-palette {
    padding: 10px 0;
    min-height: 200px;
}

.palette-lesson {
    cursor: move;
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
    border-left: 4px solid rgba(0,0,0,0.2);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
}

.palette-lesson:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.lesson-title {
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 5px;
}

.lesson-details {
    font-size: 11px;
    line-height: 1.3;
}

.lesson-details i {
    width: 12px;
    margin-right: 3px;
}

.delete-lesson {
    position: absolute;
    top: 5px;
    right: 5px;
    padding: 2px 6px;
    font-size: 10px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.palette-lesson:hover .delete-lesson {
    opacity: 1;
}

/* FIXED: Calendar Styling with consistent time slots */
.fc {
    font-size: 13px;
}

.fc-event {
    border-radius: 4px;
    border: none !important;
    padding: 2px 4px;
}

.fc-event-title {
    font-weight: bold;
}

/* FIXED: Ensure all time slots have consistent height */
.fc-timegrid-slot {
    height: 30px !important;
    min-height: 30px !important;
    max-height: 30px !important;
    border-bottom: 1px solid #ddd !important;
}

.fc-timegrid-slot-minor {
    border-bottom-style: dotted !important;
}

.fc-timegrid-slot-major {
    border-bottom: 1px solid #ddd !important;
    font-weight: bold;
}

.fc-timegrid-slot-lane {
    height: 30px !important;
    min-height: 30px !important;
    max-height: 30px !important;
}

.fc-timegrid-slots table {
    table-layout: fixed !important;
}

.fc-timegrid-slots td {
    height: 30px !important;
    min-height: 30px !important;
    max-height: 30px !important;
    vertical-align: top;
}

/* Force consistent slot heights for all time grid elements */
.fc-timegrid-body .fc-timegrid-slots .fc-timegrid-slot {
    height: 30px !important;
}

.fc-col-header-cell {
    background-color: #f8f9fa;
    font-weight: bold;
}

.fc-timegrid-axis {
    background-color: #f8f9fa;
}

/* Custom event content */
.fc-event-main {
    padding: 2px;
}

.event-formateur {
    font-size: 10px;
    opacity: 0.9;
}

.event-salle {
    font-size: 9px;
    opacity: 0.8;
}

/* Custom notification styles */
.custom-notification {
    padding: 12px 20px;
    margin-bottom: 10px;
    border-radius: 4px;
    color: white;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    animation: slideInRight 0.3s ease-out;
    max-width: 300px;
}

.custom-notification.success {
    background-color: #28a745;
}

.custom-notification.info {
    background-color: #17a2b8;
}

.custom-notification.warning {
    background-color: #ffc107;
    color: #212529;
}

.custom-notification.error {
    background-color: #dc3545;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Form styling */
.form-control:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
}

/* FIXED: Display-only field styling */
.form-control-plaintext {
    padding: 0.375rem 0.75rem;
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    color: #495057;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .palette-lesson {
        margin: 5px 0;
        padding: 8px;
    }
    
    .lesson-title {
        font-size: 12px;
    }
    
    .lesson-details {
        font-size: 10px;
    }
    
    .color-circle {
        width: 25px;
        height: 25px;
    }
}

/* Drag feedback */
.fc-event-dragging {
    opacity: 0.7;
}

.palette-lesson.fc-event-mirror {
    opacity: 0.5;
}
</style>
@stop

@section('js')
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
    // Configure toastr
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "3000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };

    function showNotification(message, type = 'success') {
        if (typeof toastr !== 'undefined') {
            toastr[type](message);
        } else {
            const notificationArea = document.getElementById('notification-area');
            const notification = document.createElement('div');
            notification.className = `custom-notification ${type}`;
            notification.textContent = message;
            notificationArea.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }
    }

    function getFrenchDayName(date) {
        const days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        return days[date.getDay()];
    }

    // Get data from Laravel controller
    const modules = @json($modules);
    const formateurs = @json($formateurs);
    const salles = @json($salles);

    // Create lookup objects for easy access
    const moduleNames = {};
    modules.forEach(module => {
        moduleNames[module.id] = module.nom;
    });

    const formateurNames = {};
    formateurs.forEach(formateur => {
        formateurNames[formateur.id] = formateur.nom;
    });

    const salleNames = {};
    salles.forEach(salle => {
        salleNames[salle.id] = salle.nom;
    });

    // Helper function to populate missing lesson data
    function populateLessonData(lessonData) {
        if (!lessonData.module_id && lessonData.module) {
            for (const [id, name] of Object.entries(moduleNames)) {
                if (name === lessonData.module) {
                    lessonData.module_id = id;
                    break;
                }
            }
        }
        
        if (!lessonData.formateur_id && lessonData.formateur) {
            for (const [id, name] of Object.entries(formateurNames)) {
                if (name === lessonData.formateur) {
                    lessonData.formateur_id = id;
                    break;
                }
            }
        }
        
        if (!lessonData.salle_id && lessonData.salle) {
            for (const [id, name] of Object.entries(salleNames)) {
                if (name === lessonData.salle) {
                    lessonData.salle_id = id;
                    break;
                }
            }
        }
        
        if (!lessonData.module_id) lessonData.module_id = '1';
        if (!lessonData.formateur_id) lessonData.formateur_id = '1';
        if (!lessonData.salle_id) lessonData.salle_id = '1';
        
        if (!lessonData.module) lessonData.module = moduleNames[lessonData.module_id];
        if (!lessonData.formateur) lessonData.formateur = formateurNames[lessonData.formateur_id];
        if (!lessonData.salle) lessonData.salle = salleNames[lessonData.salle_id];
        
        return lessonData;
    }

    function validateAndRepairLessonElements() {
        const paletteItems = document.querySelectorAll('.palette-lesson');
        let repairedCount = 0;
        
        paletteItems.forEach(item => {
            try {
                const lessonDataAttr = item.getAttribute('data-lesson');
                if (!lessonDataAttr) {
                    console.warn('Palette item missing data-lesson attribute, skipping:', item);
                    return;
                }
                
                let lessonData = JSON.parse(lessonDataAttr);
                const originalData = JSON.stringify(lessonData);
                
                lessonData = populateLessonData(lessonData);
                
                if (JSON.stringify(lessonData) !== originalData) {
                    item.setAttribute('data-lesson', JSON.stringify(lessonData));
                    repairedCount++;
                    console.log('Repaired lesson data for:', lessonData.module || 'Unknown');
                }
                
            } catch (error) {
                console.error('Error validating lesson element:', error, item);
            }
        });
        
        if (repairedCount > 0) {
            console.log(`Repaired ${repairedCount} existing lesson elements`);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var paletteEl = document.getElementById('lesson-palette');
        var checkbox = document.getElementById('drop-remove');
        var currentEvent = null;
        var draggableInstance = null;

        function initializeDraggable() {
            if (draggableInstance) {
                try { 
                    draggableInstance.destroy(); 
                } catch(e) { 
                    console.warn('Error destroying draggable instance:', e);
                }
                draggableInstance = null;
            }

            validateAndRepairLessonElements();

            setTimeout(() => {
                try {
                    draggableInstance = new FullCalendar.Draggable(paletteEl, {
                        itemSelector: '.palette-lesson',
                        eventData: function(eventEl) {
                            try {
                                const lessonDataAttr = eventEl.getAttribute('data-lesson');
                                if (!lessonDataAttr) {
                                    console.error('No data-lesson attribute found on element:', eventEl);
                                    return false;
                                }

                                let lessonData = JSON.parse(lessonDataAttr);
                                lessonData = populateLessonData(lessonData);
                                eventEl.setAttribute('data-lesson', JSON.stringify(lessonData));
                                
                                if (!lessonData.module_id || !lessonData.formateur_id || !lessonData.salle_id) {
                                    console.error('Still missing required fields after population:', lessonData);
                                    return false;
                                }

                                return {
                                    title: lessonData.module || moduleNames[lessonData.module_id] || 'Unknown Module',
                                    module_id: lessonData.module_id,
                                    formateur_id: lessonData.formateur_id,
                                    salle_id: lessonData.salle_id,
                                    backgroundColor: lessonData.color || '#007bff',
                                    textColor: lessonData.textColor || '#ffffff',
                                    borderColor: lessonData.color || '#007bff',
                                    duration: '02:00'
                                };
                            } catch (error) {
                                console.error('Error parsing lesson data:', error, eventEl);
                                return false;
                            }
                        }
                    });
                    
                    const paletteItems = document.querySelectorAll('.palette-lesson');
                    console.log('Draggable initialized successfully with', paletteItems.length, 'items');
                } catch (error) {
                    console.error('Error initializing draggable:', error);
                }
            }, 100);
        }

        initializeDraggable();

        // FIXED: Calendar with consistent slot sizing
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,timeGridDay'
            },
            initialView: 'timeGridWeek',
            height: 600,
            slotMinTime: '09:00:00',
            slotMaxTime: '18:00:00',
            slotDuration: '00:30:00',
            snapDuration: '00:30:00',
            slotLabelInterval: '01:00:00',
            slotHeight: 30, // FIXED: Consistent slot height
            allDaySlot: false,
            editable: true,
            selectable: true,
            weekends: false,
            businessHours: {
                daysOfWeek: [1,2,3,4,5],
                startTime: '09:00',
                endTime: '18:00'
            },
            events: @json($scheduledEvents),
            eventContent: function(arg) {
                return {
                    html: `
                        <div class="fc-event-main">
                            <div class="fc-event-title">${arg.event.title}</div>
                            <div class="event-formateur">${formateurNames[arg.event.extendedProps.formateur_id] || 'Unknown Formateur'}</div>
                            <div class="event-salle">${salleNames[arg.event.extendedProps.salle_id] || 'Unknown Salle'}</div>
                        </div>`
                };
            },
            droppable: true,
            dropAccept: '.palette-lesson',
            eventReceive: function(info) {
                console.log('Event received:', info.event.title);
                
                if (!info.event.extendedProps.module_id || 
                    !info.event.extendedProps.formateur_id || 
                    !info.event.extendedProps.salle_id) {
                    console.error('Dropped event missing required data, removing...');
                    info.event.remove();
                    showNotification('Error: Lesson data incomplete', 'error');
                    return;
                }
                
                if (checkbox.checked) {
                    info.draggedEl.remove();
                    setTimeout(initializeDraggable, 50);
                }
                showNotification(`${info.event.title} scheduled successfully!`, 'success');
            },
            eventClick: function(info) {
                currentEvent = info.event;
                showEventModal(info.event);
            },
            eventResize: function() {
                showNotification('Lesson duration updated', 'info');
            },
            eventDrop: function() {
                showNotification('Lesson moved successfully', 'info');
            },
            // FIXED: Force consistent slot heights after rendering
            viewDidMount: function() {
                setTimeout(() => {
                    const slots = document.querySelectorAll('.fc-timegrid-slot');
                    slots.forEach(slot => {
                        slot.style.height = '30px';
                        slot.style.minHeight = '30px';
                        slot.style.maxHeight = '30px';
                    });
                }, 100);
            }
        });
        calendar.render();

        // Force consistent slot sizing after initial render
        setTimeout(() => {
            const slots = document.querySelectorAll('.fc-timegrid-slot');
            slots.forEach(slot => {
                slot.style.height = '30px';
                slot.style.minHeight = '30px';
                slot.style.maxHeight = '30px';
            });
        }, 300);

        // Lesson creation form
        let isSubmitting = false;
        document.getElementById('lesson-creation-form').addEventListener('submit', function(e) {
            e.preventDefault();
            if (isSubmitting) return;
            isSubmitting = true;
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
            
            try {
                const moduleId = document.getElementById('lesson-module').value;
                const formateurId = document.getElementById('lesson-formateur').value;
                const salleId = document.getElementById('lesson-salle').value;
                const colorInput = document.querySelector('input[name="lesson-color"]:checked');
                
                if (!moduleId || !formateurId || !salleId || !colorInput) {
                    showNotification('Please fill in all required fields', 'error');
                    return;
                }
                
                const color = colorInput.value;
                const lessonId = 'lesson-' + Date.now();
                const textColor = (function(c) {
                    const hex = c.replace('#','');
                    const r = parseInt(hex.substr(0,2),16),
                          g = parseInt(hex.substr(2,2),16),
                          b = parseInt(hex.substr(4,2),16),
                          bright = (r*299 + g*587 + b*114)/1000;
                    return bright > 155 ? '#333333' : '#ffffff';
                })(color);
                
                const lessonData = {
                    id: lessonId,
                    module: moduleNames[moduleId],
                    module_id: moduleId,
                    formateur: formateurNames[formateurId],
                    formateur_id: formateurId,
                    salle: salleNames[salleId],
                    salle_id: salleId,
                    color: color,
                    textColor: textColor
                };
                
                const el = document.createElement('div');
                el.className = 'palette-lesson';
                el.setAttribute('data-lesson', JSON.stringify(lessonData));
                el.style.backgroundColor = color;
                el.style.color = textColor;
                el.innerHTML = `
                    <div class="lesson-title">${moduleNames[moduleId]}</div>
                    <div class="lesson-details"><small>
                        <i class="fas fa-user"></i> ${formateurNames[formateurId]}<br>
                        <i class="fas fa-door-open"></i> ${salleNames[salleId]}
                    </small></div>
                    <button class="btn btn-sm btn-danger delete-lesson"><i class="fas fa-times"></i></button>`;
                
                document.getElementById('lesson-palette').appendChild(el);
                setTimeout(initializeDraggable, 150);
                
                this.reset(); 
                const firstColorInput = document.querySelector('input[name="lesson-color"]');
                if (firstColorInput) firstColorInput.checked = true;
                
                showNotification(`Lesson ${moduleNames[moduleId]} created successfully!`, 'success');
            } catch (err) {
                console.error('Error creating lesson:', err);
                showNotification('Error creating lesson', 'error');
            } finally {
                setTimeout(() => {
                    isSubmitting = false;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 500);
            }
        });

        // Delete from palette with re-initialization
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-lesson')) {
                const el = e.target.closest('.palette-lesson');
                if (confirm('Delete this lesson?')) {
                    el.remove();
                    setTimeout(initializeDraggable, 50);
                    showNotification('Lesson deleted', 'success');
                }
            }
        });

        document.getElementById('clear-palette').addEventListener('click', () => {
            if (confirm('Clear all lessons?')) {
                document.querySelectorAll('.palette-lesson').forEach(el => el.remove());
                setTimeout(initializeDraggable, 50);
                showNotification('Palette cleared', 'success');
            }
        });

        // Apply config (date & group)
        document.getElementById('apply-config').addEventListener('click', () => {
            const startDate = document.getElementById('start-date').value;
            const endDate   = document.getElementById('end-date').value;
            const groupEl   = document.getElementById('group-select');
            const groupText = groupEl.selectedOptions[0].text;
            document.getElementById('current-group').textContent = groupText;
            if (startDate) calendar.gotoDate(startDate);
            showNotification(`Config applied for ${groupText}`, 'success');
        });

        // FIXED: Event modal functions - restricted editing
        function showEventModal(event) {
            currentEvent = event;
            document.getElementById('eventModule').value = event.extendedProps.module_id || '';
            document.getElementById('eventFormateur').value = event.extendedProps.formateur_id || '';
            document.getElementById('eventSalle').value = event.extendedProps.salle_id || '';
            
            // FIXED: Display-only fields for day and time
            const dayName = getFrenchDayName(event.start);
            const startTime = event.start.toTimeString().slice(0,5);
            const endTime = event.end ? event.end.toTimeString().slice(0,5) : '';
            
            document.getElementById('eventDayDisplay').textContent = dayName;
            document.getElementById('eventStartDisplay').textContent = startTime;
            document.getElementById('eventEndDisplay').textContent = endTime;
            
            // Store original values in hidden fields
            document.getElementById('eventDay').value = dayName;
            document.getElementById('eventStart').value = startTime;
            document.getElementById('eventEnd').value = endTime;
            
            $('#eventModal').modal('show');
        }

        // FIXED: Save event - only update module, formateur, and salle
        document.getElementById('saveEvent').addEventListener('click', () => {
            if (!currentEvent) return;
            try {
                const mid = document.getElementById('eventModule').value;
                const fid = document.getElementById('eventFormateur').value;
                const sid = document.getElementById('eventSalle').value;
                
                // Only update the lesson details, not timing
                currentEvent.setProp('title', moduleNames[mid]);
                currentEvent.setExtendedProp('module_id', mid);
                currentEvent.setExtendedProp('formateur_id', fid);
                currentEvent.setExtendedProp('salle_id', sid);
                
                $('#eventModal').modal('hide');
                showNotification('Lesson details updated successfully!', 'success');
            } catch (err) {
                console.error('Error updating lesson:', err);
                showNotification('Error updating lesson', 'error');
            }
        });
        
        document.getElementById('deleteEvent').addEventListener('click', () => {
            if (currentEvent && confirm('Delete this lesson?')) {
                currentEvent.remove();
                $('#eventModal').modal('hide');
                showNotification('Lesson deleted successfully!', 'success');
            }
        });
        
        document.getElementById('clear-calendar').addEventListener('click', () => {
            if (confirm('Clear all scheduled lessons?')) {
                calendar.removeAllEvents();
                showNotification('Calendar cleared!', 'success');
            }
        });

        // Save timetable to Laravel
        document.getElementById('save-timetable').addEventListener('click', function () {
            const groupId   = document.getElementById('group-select').value;
            const startDate = document.getElementById('start-date').value;
            const endDate   = document.getElementById('end-date').value;

            let seanceEmploies = calendar.getEvents().map(ev => ({
                heur_debut:   ev.start.toTimeString().slice(0,5),
                heur_fin:     ev.end   ? ev.end.toTimeString().slice(0,5) : '',
                jours:        getFrenchDayName(ev.start),
                module_id:    parseInt(ev.extendedProps.module_id),
                formateur_id: parseInt(ev.extendedProps.formateur_id),
                salle_id:     parseInt(ev.extendedProps.salle_id),
                color:        ev.backgroundColor || '#007bff',
            }));

            seanceEmploies.shift();

            if (seanceEmploies.length === 0) {
                showNotification('Please add at least one lesson to the timetable', 'warning');
                return;
            }

            const emploieData = {
                date_debut: startDate,
                date_fin:   endDate,
                groupe_id:  parseInt(groupId),
            };

            const btn = this;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            fetch('/emploie', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    emploie: emploieData,
                    seances: seanceEmploies
                })
            })
            .then(async res => {
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                    console.error('Validation errors:', data.errors);
                }
            })
            .catch(err => {
                console.error('Save failed:', err);
                showNotification('Network or server error.', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        });
    });
    </script>
@stop