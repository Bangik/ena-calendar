<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\EventRequest;
use App\Models\Category;
use App\Models\RecurringPattern;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('month')) {
            $month = request()->get('month');
            $data = Event::with('category','recurring')->get()->groupBy(function ($d) {
                return Carbon::parse($d->start)->format('m-Y');
            });
            $month = $month < 10 ? '0'.$month : $month;
            if(isset($data[$month."-".Carbon::now()->format('Y')])){
                return ResponseFormatter::success($data[$month."-".Carbon::now()->format('Y')]);
            } else {
                return ResponseFormatter::error("Data not found");
            }
            
        } else if(request()->has('start') && request()->has('end')) {
            $start = date_parse(request()->get('start'));
            $start = Carbon::create($start['year'], $start['month'], $start['day']);
            $end = date_parse(request()->get('end'));
            $end = Carbon::create($end['year'], $end['month'], $end['day']);

            $data = Event::with('category','recurring')->whereBetween('start', [$start, $end])->get();

            if($data->count() > 0) {
                return ResponseFormatter::success($data);
            } else {
                return ResponseFormatter::error("Data not found");
            }

        } else {
            $data = Event::with('category','recurring')->get();

            if($data->count() > 0) {
                return ResponseFormatter::success($data);
            } else {
                return ResponseFormatter::error("Data not found");
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        // $idCategori = Category::get('id');
        // $idCat = $idCategori[5]->id;
        $user = User::get('id');
        $userId = $user[0]->id;

        $recurrences = [
            'daily'     => [
                'function'  => 'addDay',
                'tipe'      => 'Harian',
            ],
            'weekly'    => [
                'function'  => 'addWeek',
                'tipe'      => 'Mingguan',
            ],
            'monthly'    => [
                'function'  => 'addMonth',
                'tipe'      => 'Bulanan',
            ],
            'yearly'    => [
                'function'  => 'addYear',
                'tipe'      => 'Tahunan',
            ],
        ];

        $recurrence = $recurrences[$request->recurrence] ?? null;
        $startTime = Carbon::parse($request->start);
        $endTime = Carbon::parse($request->end);
        $count = $request->count;
        
        if($endTime->lt($startTime)) {
            return ResponseFormatter::error("Tanggal selesai harus lebih dari tanggal mulai");
        }

        if($recurrence){
            
            if($request->count == 0 || $request->count == null || $request->count == '') {
                $date_until = Carbon::parse($request->date_until);
                if($request->date_until == null || $request->date_until == '') {
                    return ResponseFormatter::error("Sampai berapa kali atau tanggal selesai harus diisi");
                } else if ($date_until->lt($startTime)) {
                    return ResponseFormatter::error($date_until, "Tanggal selesai harus lebih dari tanggal mulai");
                } else if ($request->recurrence == 'daily') {
                    $count = $date_until->diffInDays($startTime) + 1;
                } else if ($request->recurrence == 'weekly') {
                    $count = $date_until->diffInWeeks($startTime) + 1;
                } else if ($request->recurrence == 'monthly') {
                    $count = $date_until->diffInMonths($startTime) + 1;
                } else if($request->recurrence == 'yearly') {
                    $count = $date_until->diffInYears($startTime) + 1;
                }
            } else {
                if($count > 99 || $count < 1) {
                    return ResponseFormatter::error("Tidak boleh kurang dari satu atau lebih dari 99");
                }
                $count = $request->count - 1;
            }

            if(!is_numeric($count)) {
                return ResponseFormatter::error("Jumlah harus di isi");
            }

            try {
                $data = RecurringPattern::create([
                    'id' => (string) Str::uuid(),
                    'type' => $request->recurrence,
                    'tipe' => $recurrence['tipe'],
                    'count' => $count + 1,
                    'date' => $request->date_until,
                ]);
    
                for($i = -1; $i < $count; $i++){
                    
                    Event::create([
                        'id' => (string) Str::uuid(),
                        'category_id' => $request->category_id,
                        'created_by' => $userId,
                        'updated_by' => $userId,
                        'recurring_id' => $data->id,
                        'title' => $request->title,
                        'description' => $request->description,
                        'location' => $request->location,
                        'start' => $startTime,
                        'end' => $endTime,
                        'color' => $request->color,
                        'is_active' => 1,
                    ]);
                    $startTime->{$recurrence['function']}();
                    $endTime->{$recurrence['function']}();
                }
                return ResponseFormatter::success($data);
            } catch (\Exception $e) {
                return ResponseFormatter::error($e->getMessage(), 'Server Error', 500);
            }

        } else {
            try {
                $data = Event::create([
                    'id' => (string) Str::uuid(),
                    'category_id' => $request->category_id,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                    'title' => $request->title,
                    'description' => $request->description,
                    'location' => $request->location,
                    'start' => $request->start,
                    'end' => $request->end,
                    'color' => $request->color,
                    'is_active' => 1,
                ]);
                return ResponseFormatter::success($data);
            } catch (\Exception $e) {
                return ResponseFormatter::error($e->getMessage(), 'Server Error', 500);
            }
        }

        return ResponseFormatter::error('Server Error');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id){

        //declare variabel
        // $idCategori = Category::get('id');
        // $idCat = $idCategori[0]->id;
        $user = User::get('id');
        $userId = $user[0]->id;
        
        
        $recurrences = [
            'daily'     => [
                'function'  => 'addDay',
                'tipe'      => 'Harian',
            ],
            'weekly'    => [
                'function'  => 'addWeek',
                'tipe'      => 'Mingguan',
            ],
            'monthly'    => [
                'function'  => 'addMonth',
                'tipe'      => 'Bulanan',
            ],
            'yearly'    => [
                'function'  => 'addYear',
                'tipe'      => 'Tahunan',
            ],
        ];
            
        $data = Event::find($id);
        
        $recurrence = $recurrences[$request->recurrence] ?? null;
        $startTime = Carbon::parse($request->start);
        $endTime = Carbon::parse($request->end);
        
        if($endTime->lt($startTime)) {
            return ResponseFormatter::error("Tanggal selesai harus lebih dari tanggal mulai");
        }

        try {
            if ($data) {
                if ($request->allEvent == 1) {
                    $dataCheck = RecurringPattern::where('id', $data->recurring_id)->first();
                    if (!$dataCheck) {
                        return ResponseFormatter::error("Data not found");
                    }

                    if($dataCheck->type != $request->recurrence) {
                        $dataCheck->delete();
                        if($recurrence){
                            $count = $request->count;
    
                            if($request->count == 0 || $request->count == null) {
                                $date_until = Carbon::parse($request->date_until);
                                if ($date_until->lt($startTime)) {
                                    return ResponseFormatter::error($date_until, "Tanggal selesai harus lebih dari tanggal mulai");
                                } else if ($request->recurrence == 'daily') {
                                    $count = $date_until->diffInDays($startTime) + 1;
                                } else if ($request->recurrence == 'weekly') {
                                    $count = $date_until->diffInWeeks($startTime) + 1;
                                } else if ($request->recurrence == 'monthly') {
                                    $count = $date_until->diffInMonths($startTime) + 1;
                                } else if($request->recurrence == 'yearly') {
                                    $count = $date_until->diffInYears($startTime) + 1;
                                }
                            } else {
                                if($count > 99 || $count < 1) {
                                    return ResponseFormatter::error("Tidak boleh kurang dari satu atau lebih dari 99");
                                }
                                $count = $request->count - 1;
                            }
            
                            $dataRecc = RecurringPattern::create([
                                'id' => (string) Str::uuid(),
                                'type' => $request->recurrence,
                                'tipe' => $recurrence['tipe'],
                                'count' => $count + 1,
                                'date' => $request->date_until,
                            ]);
            
                            for($i = -1; $i < $count; $i++){
                                
                                Event::create([
                                    'id' => (string) Str::uuid(),
                                    'category_id' => $request->category_id,
                                    'created_by' => $userId,
                                    'updated_by' => $userId,
                                    'recurring_id' => $dataRecc->id,
                                    'title' => $request->title,
                                    'description' => $request->description,
                                    'location' => $request->location,
                                    'start' => $startTime,
                                    'end' => $endTime,
                                    'color' => $request->color,
                                    'is_active' => 1,
                                ]);
                                $startTime->{$recurrence['function']}();
                                $endTime->{$recurrence['function']}();
                            }
                            return ResponseFormatter::success($dataRecc);
                        }else{
                            $newEvent = Event::create([
                                'id' => (string) Str::uuid(),
                                'category_id' => $request->category_id,
                                'created_by' => $userId,
                                'updated_by' => $userId,
                                'recurring_id' => null,
                                'title' => $request->title,
                                'description' => $request->description,
                                'location' => $request->location,
                                'start' => $request->start,
                                'end' => $request->end,
                                'color' => $request->color,
                                'is_active' => 1,
                            ]);
                            return ResponseFormatter::success($newEvent);
                        }
                    }

                    $dataFirst = Event::where('recurring_id', $data->recurring_id)->first();
                    $dateFirstStart = Carbon::parse($dataFirst->start);
                    $dateFirstEnd = Carbon::parse($dataFirst->end);
                    if (!$dataFirst) {
                        return ResponseFormatter::error("Data not found");
                    }

                    $dataCheck->delete();

                    $count = $request->count;

                    if($request->count == 0 || $request->count == null) {
                        $date_until = Carbon::parse($request->date_until);
                        if ($date_until->lt($dateFirstStart)) {
                            return ResponseFormatter::error($date_until, "Tanggal selesai harus lebih dari tanggal mulai");
                        } else if ($request->recurrence == 'daily') {
                            $count = $date_until->diffInDays($dateFirstStart) + 1;
                        } else if ($request->recurrence == 'weekly') {
                            $count = $date_until->diffInWeeks($dateFirstStart) + 1;
                        } else if ($request->recurrence == 'monthly') {
                            $count = $date_until->diffInMonths($dateFirstStart) + 1;
                        } else if($request->recurrence == 'yearly') {
                            $count = $date_until->diffInYears($dateFirstStart) + 1;
                        }
                    } else {
                        if($count > 99 || $count < 1) {
                            return ResponseFormatter::error("Tidak boleh kurang dari satu atau lebih dari 99");
                        }
                        $count = $request->count - 1;
                    }

                    $dataRecc = RecurringPattern::create([
                        'id' => (string) Str::uuid(),
                        'type' => $request->recurrence,
                        'tipe' => $recurrence['tipe'],
                        'count' => $count + 1,
                        'date' => $request->date_until,
                    ]);

                    for($i = -1; $i < $count; $i++){
                            
                        Event::create([
                            'id' => (string) Str::uuid(),
                            'category_id' => $request->category_id,
                            'created_by' => $userId,
                            'updated_by' => $userId,
                            'recurring_id' => $dataRecc->id,
                            'title' => $request->title,
                            'description' => $request->description,
                            'location' => $request->location,
                            'start' => $dateFirstStart,
                            'end' => $dateFirstEnd,
                            'color' => $request->color,
                            'is_active' => 1,
                        ]);
                        $dateFirstStart->{$recurrence['function']}();
                        $dateFirstEnd->{$recurrence['function']}();
                    }
        
                    return ResponseFormatter::success($dataRecc);
        
                } else {
                    if($recurrence){
                        $data->delete();
                        if($request->count == 0 || $request->count == null || $request->count == '') {
                            $date_until = Carbon::parse($request->date_until);
                            if ($date_until->lt($startTime)) {
                                return ResponseFormatter::error($date_until, "Tanggal selesai harus lebih dari tanggal mulai");
                            } else if ($request->recurrence == 'daily') {
                                $count = $date_until->diffInDays($startTime) + 1;
                            } else if ($request->recurrence == 'weekly') {
                                $count = $date_until->diffInWeeks($startTime) + 1;
                            } else if ($request->recurrence == 'monthly') {
                                $count = $date_until->diffInMonths($startTime) + 1;
                            } else if($request->recurrence == 'yearly') {
                                $count = $date_until->diffInYears($startTime) + 1;
                            }
                        } else {
                            if($request->count > 99 || $request->count < 1) {
                                return ResponseFormatter::error("Tidak boleh kurang dari satu atau lebih dari 99");
                            }

                            $count = $request->count - 1;
                        }
            
                        try {
                            $data = RecurringPattern::create([
                                'id' => (string) Str::uuid(),
                                'type' => $request->recurrence,
                                'tipe' => $recurrence['tipe'],
                                'count' => $count,
                                'date' => $request->date_until,
                            ]);
                
                            for($i = -1; $i < $count; $i++){
                                
                                Event::create([
                                    'id' => (string) Str::uuid(),
                                    'category_id' => $request->category_id,
                                    'created_by' => $userId,
                                    'updated_by' => $userId,
                                    'recurring_id' => $data->id,
                                    'title' => $request->title,
                                    'description' => $request->description,
                                    'location' => $request->location,
                                    'start' => $startTime,
                                    'end' => $endTime,
                                    'color' => $request->color,
                                    'is_active' => 1,
                                ]);
                                $startTime->{$recurrence['function']}();
                                $endTime->{$recurrence['function']}();
                            }
                            return ResponseFormatter::success($data);
                        } catch (\Exception $e) {
                            return ResponseFormatter::error($e->getMessage(), 'Server Error', 500);
                        }
            
                    } else {
                        $data->category_id = $request->category_id;
                        $data->title = $request->title;
                        $data->description = $request->description;
                        $data->location = $request->location;
                        $data->start = $request->start;
                        $data->end = $request->end;
                        $data->is_active = 1;
                        $data->recurring_id = null;
                        $data->color = $request->color;
                        $data->save();
                        return ResponseFormatter::success($data);
                    }
                }
                
            } else {
                return ResponseFormatter::error("Data not found");
            }

        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Server Error', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data = Event::find($id);
        if($data) {
            if($request->allEvent == 1) {
                $dataAllEvents = Event::where('recurring_id', $data->recurring_id)->get();
                foreach($dataAllEvents as $dataAllEvent) {
                    $dataAllEvent->delete();
                }
                return ResponseFormatter::success($dataAllEvents, "All event deleted");
            } else {
                $data->delete();
                return ResponseFormatter::success($id, "Event deleted");
            }
        } else {
            return ResponseFormatter::error("Data not found");
        }
    }

    public function search(Request $request)
    {
        if($request->search == '') {
            return ResponseFormatter::error("Search is empty");
        }

        $data = Event::where(DB::raw('lower(title)'), 'like', '%' . strtolower($request->search) . '%')->take(10)->get();
        if($data) {
            return ResponseFormatter::success($data);
        } else {
            return ResponseFormatter::error("Data not found");
        }
    }

    public function show(Request $request, $id)
    {
        $data = Event::with(
            'category',
            'recurring',
        )->find($id);
        if($data) {
            return ResponseFormatter::success($data);
        } else {
            return ResponseFormatter::error("Data not found");
        }
    }
}
