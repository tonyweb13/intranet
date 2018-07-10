<?php

namespace App\Http\Controllers\Api\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator, Input, Image, Carbon\Carbon, File, Storage;

class TicketController extends Controller
{
    public function index()
    {
        $auth = Auth::user()->department_id;
        $tickets = Ticket::where('department_to', $auth)->get();

        return response()->json($tickets);
    }
    
    public function create(Request $request)
    {        
        $tickets = new Ticket();
        $tickets->department_to = $request->department_to;
        $tickets->date_from = $request->date_from;
        $tickets->date_to = $request->date_to;
        $tickets->description = $request->description;
        $tickets->priority = $request->priority;
        $tickets->issue = $request->issue;
        $tickets->save();

        return $tickets;
        
    }

    public function show($id)
    {
        $tickets = Tickets::updateOrCreate(['id' => $id], $request->all());

        return $tickets;
    }

    public function edit($id)
    {
        $tickets = Tickets::all()->where('id', $id)->first();

        return $tickets;
    }
    
    public function update(Request $request, $id)
    {
        $tickets = Tickets::findOrFail($id)->delete();

        return response()->json($tickets);
    }
    
    public function destroy($id)
    {
        
    }

    public function upload(Request $request)
    {
        $storage = Storage::put('public/ticket_issue', $request->file('image'));
        $url = Storage::url($storage);
        
        return asset('/').  $url;
       
    }
}
