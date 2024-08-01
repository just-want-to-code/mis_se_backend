<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MeraController 
{
    function session_year(Request $request){
         $sqlAuth= "SELECT session_year FROM `mis_session_year` WHERE 1";
         $sqlAuthCnt = DB::select($sqlAuth);
         if (count($sqlAuthCnt) <= 0) {
            return $this->sendError('Invalid User. Please try again !', 'You are not authorized');
        }

        return response()->json($sqlAuthCnt, 200);
    }

    function session(Request $request){
         $sqlAuth= "SELECT session FROM `mis_session` WHERE 1";
         $sqlAuthCnt = DB::select($sqlAuth);
         if (count($sqlAuthCnt) <= 0) {
            return $this->sendError('Invalid User. Please try again !', 'You are not authorized');
        }

        return response()->json($sqlAuthCnt, 200);
    }

    function course(Request $request){
         $sqlAuth= "SELECT name,duration,id FROM `cbcs_courses` WHERE 1";
         $sqlAuthCnt = DB::select($sqlAuth);
         if (count($sqlAuthCnt) <= 0) {
            return $this->sendError('Invalid User. Please try again !', 'You are not authorized');
        }

        return response()->json($sqlAuthCnt, 200);
    }

    function branch(Request $request){
         $sqlAuth= "SELECT name,id FROM `cbcs_branches` WHERE 1;";
         $sqlAuthCnt = DB::select($sqlAuth);
        

        return response()->json($sqlAuthCnt, 200);
    }

    function filter(Request $request){
        //Log::channel('stderr')->info($request);
         $sqlAuth= "SELECT sem,A.course_id,name, course_component,B.status, B.sequence FROM `cbcs_course_component` as A INNER JOIN `cbcs_coursestructure_policy` as B ON A.id = B.course_component AND A.course_id=B.course_id WHERE sem='$request->sem' AND A.course_id='$request->course_id' AND name!='Engineering/Science Option'";
         $sqlAuthCnt = DB::select($sqlAuth);

        return response()->json($sqlAuthCnt, 200);
    }

    function getSubjectOffered(Request $request){
         $sqlAuth= "SELECT * FROM `cbcs_subject_offered` WHERE session_year='$request->session_year' AND session='$request->session' AND course_id='$request->course_id' AND branch_id='$request->branch_id' AND semester='$request->sem'";
         $sqlAuthCnt = DB::select($sqlAuth);

        return response()->json($sqlAuthCnt, 200);
    }

    function getCourses(Request $request){
         $sqlAuth= "SELECT * FROM `cbcs_course_master` WHERE wef_year<='$request->session_year'";
         $sqlAuthCnt = DB::select($sqlAuth);

        return response()->json($sqlAuthCnt, 200);
    }

    function deleteOffers(Request $request){
        Log::channel('stderr')->info($request);
         $sqlAuth= "DELETE FROM `cbcs_subject_offered` WHERE id='$request->id'";
         $sqlAuthCnt = DB::select($sqlAuth);

        return response()->json($sqlAuthCnt, 200);
    }
}
