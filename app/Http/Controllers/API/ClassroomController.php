<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classroom;
use App\Student;

class ClassroomController extends Controller
{
    public function getClasses() {
        $classroom = Classroom::all();

        if($classroom->count() > 0) {
            $response = ['success' => true, 'data' => $classroom];
            return response()->json($response, 201);
        } else {
            $response = ['success' => true, 'msg' => 'No Classroom found'];
            return response()->json($response, 404);
        }
    }

    public function createClassroom(Request $request)
    {
        $payload = [
            'standard' => $request->standard
        ];

        $classroom = new Classroom($payload);

        try {
            if ($classroom->save()) {
                $response = ['success' => true, 'data'=>$classroom, 'msg' => 'Classroom has been added successfully.'];
            } else {
                $response = ['success' => false, 'msg' => 'An Error Occured while adding classroom. please try again.'];
            }
            return response()->json($response, 201);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                $response = ['success' => false, 'msg' => 'This classroom standard is already is in use.'];
            } else {
                $response = ['success' => false, 'msg' => $e];
            }
            return response()->json($response, 400);
        }
    }

    public function deleteClassroom(Request $request) {
        $classroom = Classroom::find($request->route('id'));
        if($classroom) {
            $student = Student::where('classroomId', $request->route('id'));
            $student->delete();

            if($classroom->delete()){
                $response = ['success'=>true, 'msg' => 'Classroom deleted successfully'];
            }
            else {
                $response = ['success'=>false, 'msg' => 'Error deleting classroom'];
            }
        } else {
            $response = ['success'=>false, 'msg' => 'Classroom does not exist'];
        }

        return response()->json($response, 201);
    }

    public function editClassroom(Request $request) {
        $classroom = Classroom::find($request->route('id'));

        if($classroom) {
            $response = ['success'=>true, 'data'=>$classroom];
        }
        else {
            $response = ['success'=>false, 'data'=>'Classroom does not exist'];
        }

        return response()->json($response, 201);
    }

    public function updateClassroom(Request $request) {
        $classroom = Classroom::find($request->id);

        if($classroom) {
            $classroom->standard = $request->standard;

            try {
                if ($classroom->save()) {
                    $response = ['success' => true, 'data'=> $classroom, 'msg' => 'Classroom has been updated successfully.'];
                } else {
                    $response = ['success' => false, 'msg' => 'An Error Occured while updating classroom. please try again.'];
                }
                return response()->json($response, 201);
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if ($errorCode == 1062) {
                    $response = ['success' => false, 'msg' => 'This classroom standard is already is in use.'];
                } else {
                    $response = ['success' => false, 'msg' => $e];
                }
                return response()->json($response, 400);
            }
        }
        else {
            $response = ['success'=>false, 'data'=>'Classroom does not exist'];
        }

        return response()->json($response, 201);
    }

    public function getClassesWithStudents() {
        $classrooms = Classroom::with('students')->get();

        if($classrooms->count() > 0) {
            $response = ['success'=>true, 'Classrooms'=> $classrooms->count(), 'data'=>$classrooms];
        } else {
            $response = ['success'=>false,'data'=>'No Classroom Found'];
        }

        return response()->json($response, 201);
    }
}
