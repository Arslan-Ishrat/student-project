<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Classroom;

class StudentController extends Controller
{
    public function getStudents() {
        $student = Student::all();

        if($student->count() > 0) {
            $response = ['success' => true, 'data' => $student];
            return response()->json($response, 201);
        } else {
            $response = ['success' => true, 'msg' => 'No Student found'];
            return response()->json($response, 404);
        }
    }

    public function createStudent(Request $request)
    {
        $classroom = Classroom::find($request->classroomId);

        if($classroom) {
            $payload = [
                'classroomId' => $request->classroomId,
                'name' => $request->name,
                'fatherName' => $request->fatherName,
                'age' => $request->age
            ];

            $student = new Student($payload);

            if ($student->save()) {
                $response = ['success' => true, 'data'=>$student, 'msg' => 'Student has been added successfully.'];
            } else {
                $response = ['success' => false, 'msg' => 'An Error Occured while adding a Student. please try again.'];
            }
            return response()->json($response, 201);
        } else {
            $response = ['success' => false, 'msg' => 'This classroom does not exist. Please enter this classroom first.'];
            return response()->json($response, 400);
        }

    }

    public function deleteStudent(Request $request) {
        $student = Student::find($request->route('id'));
        if($student) {
            if($student->delete()){
                $response = ['success'=>true, 'msg' => 'Student deleted successfully'];
            }
            else {
                $response = ['success'=>false, 'msg' => 'Error deleting student'];
            }
        } else {
            $response = ['success'=>false, 'msg' => 'Student does not exist'];
        }

        return response()->json($response, 201);
    }

    public function editStudent(Request $request) {
        $student = Student::find($request->route('id'));

        if($student) {
            $response = ['success'=>true, 'data'=>$student];
        }
        else {
            $response = ['success'=>false, 'data'=>'Student does not exist'];
        }

        return response()->json($response, 201);
    }

    public function updateStudent(Request $request) {
        $student = Student::find($request->studentId);

        if($student) {
            $student->name = $request->name;
            $student->fatherName = $request->fatherName;
            $student->age = $request->age;

            if ($student->save()) {
                $response = ['success' => true, 'data'=> $student, 'msg' => 'Student has been updated successfully.'];
            } else {
                $response = ['success' => false, 'msg' => 'An Error Occured while updating student. please try again.'];
            }
            return response()->json($response, 201);
        }
        else {
            $response = ['success'=>false, 'data'=>'Student does not exist'];
        }

        return response()->json($response, 201);
    }

    public function getClasswiseStudents (Request $request) {
        $classroom = Classroom::find($request->route('classId'));
        if($classroom) {
            $students = Student::where('classroomId', $request->route('classId'))->get();

            if($students->count() > 0) {
                $response = ['success'=>true, 'students'=>$students->count(), 'data'=>$students];
            } else {
                $response = ['success'=>true, 'msg'=>'No Student found for this class.'];
            }
        } else {
            $response = ['success'=>false, 'msg'=>'This Classroom does not exist'];
        }

        return response()->json($response, 201);
    }
}
