<?php

namespace Modules\Pkg_Emploi\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pkg_CahierText\Models\Formateur;
use Modules\Pkg_CahierText\Models\Module;
use Modules\Pkg_Emploi\Models\Emploi;
use Modules\Pkg_Emploi\Models\Salle;
use Modules\Pkg_Emploi\Models\SeanceEmploi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\Pkg_CahierText\Models\Groupe;

class EmploiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $emplois = Emploi::all();
        $modules = Module::all();
        $formateurs = Formateur::all();
        $salles = Salle::all();

        return view('Emploi::admin.emploies.index',compact('modules', 'formateurs', 'salles','emplois'));
    }

   

    public function create(){
        $modules = Module::all();
        $formateurs = Formateur::all();
        $salles = Salle::all();
        $groupes = Groupe::all();

        return view('Emploi::admin.emploies.create',compact('modules', 'formateurs', 'salles','groupes'));
    }

    /**
     * Store the timetable data from FullCalendar
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming data
            $validator = Validator::make($request->all(), [
                'emploie.date_debut' => 'required|date',
                'emploie.date_fin' => 'required|date|after_or_equal:emploie.date_debut',
                'emploie.groupe_id' => 'required|integer',
                'seances' => 'required|array|min:1',
                'seances.*.heur_debut' => 'required|string',
                'seances.*.heur_fin' => 'required|string',
                'seances.*.color' => 'required|string',
                'seances.*.jours' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi',
                'seances.*.module_id' => 'required|integer|exists:modules,id',
                'seances.*.formateur_id' => 'required|integer|exists:formateurs,id',
                'seances.*.salle_id' => 'required|integer|exists:salles,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Start database transaction
            DB::beginTransaction();

            // Create the main emploi record
            $emploi = Emploi::create([
                'date_debut' => $request->input('emploie.date_debut'),
                'date_fin' => $request->input('emploie.date_fin'),
                'groupe_id' => $request->input('emploie.groupe_id'),
            ]);

            // Create seance emploi records
            $seances = $request->input('seances');
            $createdSeances = [];

            foreach ($seances as $seanceData) {
                // Check for conflicts (optional)
                // $conflict = $this->checkForConflicts($seanceData, $emploi->id);
                // if ($conflict) {
                //     throw new \Exception("Conflict detected: {$conflict}");
                // }

                $seance = SeanceEmploi::create([
                    'heur_debut' => $seanceData['heur_debut'],
                    'heur_fin' => $seanceData['heur_fin'],
                    'jours' => $seanceData['jours'],
                    'module_id' => $seanceData['module_id'],
                    'formateur_id' => $seanceData['formateur_id'],
                    'salle_id' => $seanceData['salle_id'],
                    'color' => $seanceData['color'], // ADD THIS LINE
                    'emploie_id' => $emploi->id,
                ]);

                $createdSeances[] = $seance;
            }

            // Commit the transaction
            DB::commit();

            // Log the successful creation
            Log::info('Timetable created successfully', [
                'emploi_id' => $emploi->id,
                'groupe_id' => $emploi->groupe_id,
                'seances_count' => count($createdSeances)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Timetable saved successfully!',
                'data' => [
                    'emploi_id' => $emploi->id,
                    'emploi' => $emploi,
                    'seances_count' => count($createdSeances),
                    'seances' => $createdSeances
                ]
            ], 201);

        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();

            // Log the error
            Log::error('Error creating timetable', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error saving timetable: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check for scheduling conflicts
     */
    private function checkForConflicts($seanceData, $emploiId = null)
    {
        // Check for room conflicts
        $roomConflict = SeanceEmploi::where('salle_id', $seanceData['salle_id'])
            ->where('jours', $seanceData['jours'])
            ->where(function($query) use ($seanceData) {
                $query->whereBetween('heur_debut', [$seanceData['heur_debut'], $seanceData['heur_fin']])
                      ->orWhereBetween('heur_fin', [$seanceData['heur_debut'], $seanceData['heur_fin']])
                      ->orWhere(function($q) use ($seanceData) {
                          $q->where('heur_debut', '<=', $seanceData['heur_debut'])
                            ->where('heur_fin', '>=', $seanceData['heur_fin']);
                      });
            });

        if ($emploiId) {
            $roomConflict->where('emploie_id', '!=', $emploiId);
        }

        if ($roomConflict->exists()) {
            $conflictingSeance = $roomConflict->first();
            return "Room conflict in {$conflictingSeance->salle->nom} on {$seanceData['jours']} at {$seanceData['heur_debut']}";
        }

        // Check for formateur conflicts
        $formateurConflict = SeanceEmploi::where('formateur_id', $seanceData['formateur_id'])
            ->where('jours', $seanceData['jours'])
            ->where(function($query) use ($seanceData) {
                $query->whereBetween('heur_debut', [$seanceData['heur_debut'], $seanceData['heur_fin']])
                      ->orWhereBetween('heur_fin', [$seanceData['heur_debut'], $seanceData['heur_fin']])
                      ->orWhere(function($q) use ($seanceData) {
                          $q->where('heur_debut', '<=', $seanceData['heur_debut'])
                            ->where('heur_fin', '>=', $seanceData['heur_fin']);
                      });
            });

        if ($emploiId) {
            $formateurConflict->where('emploie_id', '!=', $emploiId);
        }

        if ($formateurConflict->exists()) {
            $conflictingSeance = $formateurConflict->first();
            return "Formateur conflict for {$conflictingSeance->formateur->nom} on {$seanceData['jours']} at {$seanceData['heur_debut']}";
        }

        return null; // No conflicts
    }

    /**
     * Convert time to slot index (30-minute intervals starting from 09:00)
     */
    private function timeToSlot($time)
    {
        $startTime = strtotime('09:00');
        $currentTime = strtotime($time);
        $diffMinutes = ($currentTime - $startTime) / 60;
        return intval($diffMinutes / 30);
    }

    /**
     * Get instructor color class based on formateur
     */
    public function getInstructorColorClass($formateurNom)
    {
        $colorMap = [
            'ES SERRAJ FOUAD' => 'bg-primary',
            'EL KHALLOUI FIRDAOUS' => 'bg-warning',
            'AHMED BENALI' => 'bg-success',
            'FATIMA ZAHRA' => 'bg-info',
            'OMAR ALAMI' => 'bg-danger',
            'HASSAN TAZI' => 'bg-secondary'
        ];
        
        return $colorMap[$formateurNom] ?? 'bg-dark';
    }

    public function show($id){
        // 30-minute time slots from 09:00 to 18:30
        $timeSlots = [
            '9h00', '9h30', '10h00', '10h30', '11h00', '11h30', 
            '12h00', '12h30', '13h00', '13h30', '14h00', '14h30', 
            '15h00', '15h30', '16h00', '16h30', '17h00', '17h30', '18h00', '18h30'
        ];

        // Days mapping
        $days = [
            'Lundi' => 'monday',
            'Mardi' => 'tuesday', 
            'Mercredi' => 'wednesday',
            'Jeudi' => 'thursday',
            'Vendredi' => 'friday',
            'Samedi' => 'saturday'
        ];

        $emploi = Emploi::with(['seancesemploies.module', 'seancesemploies.formateur', 'seancesemploies.salle'])
            ->findOrFail($id);

        // Initialize timetable structure
        $timetable = [];
        foreach ($days as $frenchDay => $englishDay) {
            $timetable[$englishDay] = [];
        }

        // Process seances and convert to timetable format
        foreach ($emploi->seancesemploies as $seance) {
            $dayKey = array_search($seance->jours, array_keys($days));
            if ($dayKey !== false) {
                $englishDay = $days[$seance->jours];
                
                $startSlot = $this->timeToSlot($seance->heur_debut);
                $endSlot = $this->timeToSlot($seance->heur_fin);
                
                $timetable[$englishDay][$startSlot] = [
                    'id' => $seance->id,
                    'subject' => $seance->module->nom ?? 'Unknown Module',
                    'instructor' => $seance->formateur->nom ?? 'Unknown Instructor',
                    'room' => $seance->salle->nom ?? 'Unknown Room',
                    'start_slot' => $startSlot,
                    'end_slot' => $endSlot - 1, // Adjust for colspan calculation
                    'start_time' => substr($seance->heur_debut, 0, 5), // Remove seconds
                    'end_time' => substr($seance->heur_fin, 0, 5), // Remove seconds
                    'color_class' => $seance->color,
                ];
            }
        }

        // Convert days back to the format expected by the view
        $daysForView = [
            'monday' => 'Lundi',
            'tuesday' => 'Mardi', 
            'wednesday' => 'Mercredi',
            'thursday' => 'Jeudi',
            'friday' => 'Vendredi',
            'saturday' => 'Samedi'
        ];

        // Get all modules, formateurs, and salles for the modal
        $modules = Module::all();
        $formateurs = Formateur::all();
        $salles = Salle::all();

        return view('Emploi::admin.emploies.show', compact(
            'emploi', 
            'timeSlots', 
            'timetable', 
            'daysForView',
            'modules',
            'formateurs', 
            'salles'
        ));
    }

    public function destroy($id){
    try {
        DB::beginTransaction();

        $emploi = Emploi::findOrFail($id);
        

        $emploi->seancesemploies()->delete();
        // STEP 2: Check if deletion of seances works

        $emploi->delete();
        DB::commit();

        return redirect()->route('emploie.index')
                         ->with('success', 'Timetable deleted successfully');

    } catch (\Exception $e) {
        DB::rollBack();
        dd($e->getMessage()); // STEP 3: Catch exact error message
    }
}


    /**
     * Get timetable data for editing
     */
    public function edit($id)
    {
        try {
            $emploi = Emploi::with(['seanceEmplois.module', 'seanceEmplois.formateur', 'seanceEmplois.salle'])
                           ->findOrFail($id);

            $modules = Module::all();
            $formateurs = Formateur::all();
            $salles = Salle::all();

            // Format seances for FullCalendar
            $events = $emploi->seanceEmplois->map(function($seance) {
                // Convert French day names to date
                $dayMapping = [
                    'Lundi' => 1,
                    'Mardi' => 2,
                    'Mercredi' => 3,
                    'Jeudi' => 4,
                    'Vendredi' => 5
                ];

                // Create a date for the current week
                $startOfWeek = now()->startOfWeek();
                $lessonDate = $startOfWeek->copy()->addDays($dayMapping[$seance->jours] - 1);

                return [
                    'id' => $seance->id,
                    'title' => $seance->module->nom ?? 'Unknown Module',
                    'start' => $lessonDate->format('Y-m-d') . 'T' . $seance->heur_debut,
                    'end' => $lessonDate->format('Y-m-d') . 'T' . $seance->heur_fin,
                    'backgroundColor' => $this->getModuleColor($seance->module_id),
                    'extendedProps' => [
                        'module_id' => $seance->module_id,
                        'formateur_id' => $seance->formateur_id,
                        'salle_id' => $seance->salle_id,
                        'jours' => $seance->jours
                    ]
                ];
            });

            return view('Emploi::admin.timetable.edit', compact(
                'emploi', 'events', 'modules', 'formateurs', 'salles'
            ));

        } catch (\Exception $e) {
            return redirect()->route('emploie.index')
                           ->with('error', 'Error loading timetable: ' . $e->getMessage());
        }
    }

    /**
     * Get a color for a module (you can customize this)
     */
    private function getModuleColor($moduleId)
    {
        $colors = [
            '#4a90e2', '#f5d76e', '#5cb85c', '#5bc0de', '#dc3545',
            '#6c757d', '#fd7e14', '#e83e8c', '#20c997', '#6f42c1'
        ];
        
        return $colors[$moduleId % count($colors)];
    }
}