<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\EventRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{

    public function __construct() {
        //$this->middleware('auth')->except('index');
        //$this->middleware('role')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $events = Event::get();
        $cal = collect();
        foreach($events as $event) {
            $content = [
                'id' => $event->id,
                'name' => $event->name,
                'description' => $event->details,
                'date' => Carbon::parse($event->due_date)->toDateString(),
                'type' => 'event',
            ];
            $cal->push($content);
        }
        if ($req->ajax()) {
            //return response()->json($cal);
        }
        return view('events.index', ['events' => $events, 'cal' => $cal]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:events,name',
            'start_date' => 'required',
            'end_date' => 'required',
            'details' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = array();
            if (array_key_exists('title', $validator->errors()->toArray())) {
                $errors['titleError'] = $validator->errors()->toArray()['title'][0];
            }
            if (array_key_exists('end_date', $validator->errors()->toArray())) {
                $errors['endDateError'] = $validator->errors()->toArray()['end_date'][0];
            }
            if (array_key_exists('start_date', $validator->errors()->toArray())) {
                $errors['startDateError'] = $validator->errors()->toArray()['start_date'][0];
            }
            if (array_key_exists('details', $validator->errors()->toArray())) {
                $errors['detailsError'] = $validator->errors()->toArray()['details'][0];
            }
            return response()->json($errors);
        }
        $now = Carbon::now();
        if (Carbon::parse($request->start_date) < $now) {
            return response()->json(['dateError1' => 'Start date cannot be less than today\'s date']);
        }
        if (Carbon::parse($request->start_date) > Carbon::parse($request->end_date)) {
            return response()->json(['dateError2' => 'Start date cannot be greater than end date']);
        }
        $validated = $validator->valid();
        $event = new Event;
        $event->creator_id = auth()->user()->id;    //$user->id;
        $event->name = $request->title;
        $event->due_date = Carbon::parse($request->start_date);
        //$event->due_date = Carbon::parse($request->start_date.''.$request->start_time);
        $event->end_date = Carbon::parse($request->end_date);
        //$event->end_date = Carbon::parse($request->end_date.''.$request->end_time);
        $event->details = $request->details;
        $event->save();
        return response()->json($event);
        //return redirect()->route('event.index')->with('status', 'Creation effectif');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::where('id', $id)->first();
        return view();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::where('id', '=', $id)->first();
        $start_date = Carbon::parse($event->due_date)->toDateString();
        $start_time = Carbon::parse($event->due_date)->toTimeString();
        $end_date = Carbon::parse($event->end_date)->toDateString();
        $end_time = Carbon::parse($event->end_date)->toTimeString();
        return view('events.edit', ['event' => $event, 
        'start_date' => $start_date, 'start_time' => $start_time,
        'end_date' => $end_date, 'end_time' => $end_time]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        $event = Event::where('id', '=', $id)->first();
        $event->creator_id = auth()->user()->id;    //$user->id;
        $event->name = $request->title;
        $event->due_date = Carbon::parse($request->start_date);
        //$event->due_date = Carbon::parse($request->start_date.''.$request->start_time);
        $event->end_date = Carbon::parse($request->end_date);
        //$event->end_date = Carbon::parse($request->end_date.''.$request->end_time);
        $event->details = $request->details;
        $event->save();
        return redirect()->route('event.index')->with('status', 'Modification reussi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::where('id', '=', $id)->first();
        $event.delete();
        return redirect()->route('event.index')->with('status', 'La suppression a ete un success');
    }
}
