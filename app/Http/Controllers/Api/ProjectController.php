<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Project;
use Illuminate\Http\Request;



class ProjectController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return ProjectResource::collection($projects)->additional(['status' => 200]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'name' => 'required|min:5',
            'desciption' => 'required|string|min:8',
            'image' => 'required|image|dimensions:min_width=200,min_height=200',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $project = new Project($request->all());
        $path = $request->image->store('projects');
        $project -> image = $path;
        $project -> save();

        //Project::create($request->all());
        return response()->json(['status'=> 201, 'message' => 'save project!']);
        //return ProjectResource::make($project)->additional(['status' => 200]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return ProjectResource::make($project)->additional(['status' => 200]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate($request->all(),[
            'name' => 'required|min:5',
            'desciption' => 'string|min:8',
            //'image' => 'required|image|dimensions:min_width=200,min_height=200',
        ]);

        if($request->fails()){
            return response()->json($request->errors(),400);
        }

        $project->fill($request->all());
        $project->save();

        return response()->json(['status'=> 200, 'message' => 'update project!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(['status' => 'delete project']);
    }
}
