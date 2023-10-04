<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Course::class, 'course');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $courses = Course::all();
        $courses = Course::where('user_id', auth()->user()->id)->get();

        // return CourseResource::collection($courses);
        return new CourseCollection($courses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        // cara 1 - Resource
        // $user_id = auth()->user()->id;

        // $course = new Course();
        // $course->user_id = $user_id;
        // $course->title = $request->input('title');
        // $course->description = $request->input('description');
        // $course->save();
        // return new CourseResource($course);

        // Cara 2 - Menggunakan Eloquent Create
        $user_id = auth()->user()->id;

        $course = Course::create([
            'user_id' => $user_id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);
        return new CourseResource($course);

        // Cara 3 - Request All (Menambahkan Relationship di model user)
        // $course = auth()->user()->courses()->create($request->all());
        // return new CourseResource($course);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        // $course = Course::findOrFail($id);

        return new CourseResource($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        // cara 1
        // $course = Course::findOrFail($id);
        // $course->title = $request->input('title');
        // $course->description = $request->input('description');
        // $course->save();
        // return new CourseResource($course);

        // cara 2
        // $course = Course::findOrFail($id);
        // $course->update([
        //     'title' => $request->input('title'),
        //     'description' => $request->input('description'),
        // ]);
        // return new CourseResource($course);

        // cara 3
        $course->update($request->all());
        return new CourseResource($course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        // cara 1
        // $course = Course::destroy($id);

        //cara 2
        // $course = Course::findOrFail($id);
        // $course->detele();

        // Cara 3
        $course->delete();
        return ['status' => 'Ok'];
    }
}
