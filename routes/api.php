<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api-header'], function () {
    // for classroom
    Route::get('/getClasses', 'API\ClassroomController@getClasses');
    Route::post('/createClassroom', 'API\ClassroomController@createClassroom');
    Route::post('/deleteClassroom/{id}', 'API\ClassroomController@deleteClassroom');
    Route::post('/editClassroom/{id}', 'API\ClassroomController@editClassroom');
    Route::post('/updateClassroom', 'API\ClassroomController@updateClassroom');

    // for student
    Route::get('/getStudents', 'API\StudentController@getStudents');
    Route::post('/createStudent', 'API\StudentController@createStudent');
    Route::post('/deleteStudent/{id}', 'API\StudentController@deleteStudent');
    Route::post('/editStudent/{id}', 'API\StudentController@editStudent');
    Route::post('/updateStudent', 'API\StudentController@updateStudent');

    // get students for the specific class
    Route::get('/getClasswiseStudents/{classId}', 'API\StudentController@getClasswiseStudents');

    // get all classes with all its students
    Route::get('/getClassesWithStudents', 'API\ClassroomController@getClassesWithStudents');
});

