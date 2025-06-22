@extends('Emploi::layouts.admin')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<style>
        .external-event {
            padding: 5px 10px;
            margin: 5px 0;
            color: #fff;
            cursor: move;
            border-radius: 4px;
        }
</style>
@endsection
 



@section('content')
    <div class="content-wrapper p-4">
            <div class="row">
                <!-- External Events -->
                <div class="col-md-3">
                    <h5>Modules</h5>
                    <div id="external-events">
                        <div class="external-event bg-primary" draggable="true"
                            data-module="Math" data-room="A101" data-tutor="Mr. Smith" data-color="#007bff">
                            Math - Mr. Smith (A101)
                        </div>
                        <div class="external-event bg-success" draggable="true"
                            data-module="Physics" data-room="B202" data-tutor="Ms. Green" data-color="#28a745">
                            Physics - Ms. Green (B202)
                        </div>
                        <div class="external-event bg-warning" draggable="true"
                            data-module="Biology" data-room="C303" data-tutor="Dr. White" data-color="#ffc107">
                            Biology - Dr. White (C303)
                        </div>
                    </div>
                </div>

                <!-- Scheduler -->
                <div class="col-md-9">
                    <div id="scheduler" style="height: 600px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    {{-- <script src="https://cdn.daypilot.org/daypilot-all.min.js"></script> --}}
    <script src="{{ asset('vendor/daypilot/daypilot-all.min.js') }}"></script>

    <script>
        // External Drag Setup
        document.querySelectorAll(".external-event").forEach(el => {
            el.addEventListener("dragstart", e => {
                const data = {
                    module: el.dataset.module,
                    room: el.dataset.room,
                    tutor: el.dataset.tutor,
                    color: el.dataset.color
                };
                e.dataTransfer.setData("text", JSON.stringify(data));
            });
        });

        const scheduler = new DayPilot.Scheduler("scheduler", {
            timeHeaders: [
                { groupBy: "Day", format: "dddd, MMM d" },
                { groupBy: "Hour" }
            ],
            scale: "Hour",
            startDate: DayPilot.Date.today(),
            days: 5,
            cellDuration: 60,
            businessBeginsHour: 9,
            businessEndsHour: 18,
            showNonBusiness: false,
            rowHeaderColumns: [
                { title: "Day" }
            ],
            resources: [
                { name: "Monday", id: "mon" },
                { name: "Tuesday", id: "tue" },
                { name: "Wednesday", id: "wed" },
                { name: "Thursday", id: "thu" },
                { name: "Friday", id: "fri" }
            ],
            onTimeRangeSelected: function (args) {
                // Skip if not triggered by a drag-drop event
                if (!args.originalEvent || !args.originalEvent.dataTransfer) {
                    scheduler.clearSelection();
                    return;
                }

                try {
                    const json = args.originalEvent.dataTransfer.getData("text");
                    const data = JSON.parse(json);

                    scheduler.events.add({
                        start: args.start,
                        end: args.end,
                        resource: args.resource,
                        text: `${data.module} - ${data.tutor} (${data.room})`,
                        backColor: data.color,
                        data: data
                    });
                } catch (error) {
                    console.error("Error parsing drag data", error);
                }

                scheduler.clearSelection();
            },

            eventMoveHandling: "Update",
            eventResizeHandling: "Update"
        });

        scheduler.init();
    </script>
@endsection
