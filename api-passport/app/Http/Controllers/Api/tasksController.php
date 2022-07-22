<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tasks;
use Illuminate\Support\Carbon;
use App\Http\Resources\tasksResource;
use DB;

class tasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 'true',
            'message' => 'tasks viewed successfully',
            'data' => tasksResource::collection(tasks::all())
        ]);
    }
    public function originalFormat()
    {
        return response()->json([
            'status' => 'true',
            'message' => 'tasks viewed successfully',
            'data' => tasks::all()
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'Title' => 'required',
            'StartTime' => 'required',
            'Date' => 'required',
        ]);
        tasks::insert([
            'Title' => $request->Title,
            'Date' => $request->Date,
            'StartTime' => $request->StartTime,
            'EndTime' => $request->EndTime,
            'Description' => $request->Description,
            'created_at' => Carbon::now(),
        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'task inserted successfully',
            'data' => null
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'task viewed successfully',
            'data' => tasksResource::collection(tasks::all()->where('id', $id))
        ]);
    }

    public function search($Date)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'task viewed successfully',
            'data' => tasksResource::collection(tasks::all()->where('Date', $Date))
        ]);
    }

    public function patternsearch($Title)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'Attachment viewed successfully',
            'data' => tasks::query()
                ->where('Title', 'LIKE', "%" . $Title . "%")
                ->orWhere('Title', 'LIKE', "%" . ucfirst($Title) . "%")
                ->orWhere('Title', 'LIKE', "%" . strtolower($Title) . "%")
                ->orWhere('Title', 'LIKE', "%" . strtoupper($Title) . "%")
                ->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'Title' => 'required',
            'StartTime' => 'required',
            'Date' => 'required',
        ]);
        $data = array();
        $data['Title'] = $request->Title;
        $data['Date'] = $request->Date;
        $data['StartTime'] = $request->StartTime;
        $data['EndTime'] = $request->EndTime;
        $data['Description'] = $request->Description;
        DB::table('tasks')->where('id', $id)->update($data);
        return response()->json([
            'status' => 'true',
            'message' => 'task updated successfully',
            'data' => tasksResource::collection(tasks::all()->where('id', $id))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = tasks::find($id)->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'task deleted successfully',
            'data' => null
        ]);
    }
}
