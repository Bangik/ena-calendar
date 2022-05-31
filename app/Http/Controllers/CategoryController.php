<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index()
    {
        // $data = Category::with('getCreatedByUser', 'getUpdatedByUser')->get();
        // // dd($data->getCreatedByUser->name);
        // dd($data->toArray());
        // $start = Carbon::parse(request()->get('start'));
        // $end = Carbon::parse(request()->get('end'));
        // $data = Event::whereBetween('created_at', [$start, $end])->get();
        // $month = request()->get('month');
        // $data = Event::with(
        //     'category',
        //     'recurringPattern',
        //     'getCreatedByUser',
        //     'getUpdatedByUser'
        //     )->get()->groupBy(function ($d) {
        //         return Carbon::parse($d->created_at)->format('m-Y');
        //     });
        // if(isset($data[$month . "-" . Carbon::now()->format('Y')])){
        //     $data = $data[$month . "-". Carbon::now()->format('Y')];
        // } else {
        //     $data = [];
        // }
        // $data = file_get_contents("http://ena-calendar.id/api/categories");
        // $data = json_decode($data);
        // dd($data->data);
        $date_until = Carbon::parse("2022-05-25");
        $startTime = "2023-05-25";
        $count = $date_until->diffInYears($startTime);
        dd($count);
        return view('tes', compact('count'));

        
    }
}
