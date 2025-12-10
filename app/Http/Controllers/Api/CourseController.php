<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{

    // public function __construct()
    // {
    //     $user = auth()->user();
    //     if ($user->role !== "admin") {
    //         return response()->json([
    //             "success" => false,
    //             "message" => "You are not admin"
    //         ]);
    //     }
    // }

    public function index()
    {
        $courses = Course::all();
        return CourseResource::collection($courses);
    }


    public function store(Request $request)
    {
        // return response()->json($request);

        $validator = Validator::make($request->all(), [
            "name" => "required|max:60",
            "price" => "required|numeric|min:100",
            "description" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ]);
        }

        $course = new Course();
        $course->name = $request->name;
        $course->price = $request->price;
        $course->description = $request->description;
        $image = $request->image;
        if ($image) {
            $file_name = time() . "." . $image->getClientOriginalExtension();
            $image->move('images', $file_name);
            $course->image = "images/$file_name";
        }
        $course->save();
        return response()->json([
            'success' => true,
            "message" => "Course created successfully"
        ]);
    }


    public function update(Request $request, $id)
    {
        return response()->json($request);

        $validator = Validator::make($request->all(), [
            "name" => "required|max:60",
            "price" => "required|numeric|min:100",
            "description" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ]);
        }

        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                "message" => "Invalid Url"
            ]);
        }

        $course->name = $request->name;
        $course->price = $request->price;
        $course->description = $request->description;
        $image = $request->image;
        if ($image) {
            $file_name = time() . "." . $image->getClientOriginalExtension();
            $image->move('images', $file_name);
            $course->image = "images/$file_name";
        }
        $course->save();
        return response()->json([
            'success' => true,
            "course" => $course,
            "message" => "Course updated successfully"
        ]);
    }

    public function delete($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                "message" => "Invalid Url"
            ]);
        }

        $course->delete();

        return response()->json([
            'success' => true,
            "message" => "Course deleted successfully"
        ]);
    }
}
