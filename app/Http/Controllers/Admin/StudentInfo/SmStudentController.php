<?php

namespace App\Http\Controllers\Admin\StudentInfo;

use App\Http\Controllers\Controller;
use App\Models\SmStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\SmStaff;
use App\Models\SmAssignSubject;

class SmStudentController extends Controller
{
    public function studentDetails($id)
    {
        try {
            if (teacherAccess()) {
                // Check if teacher has access to this student
                if (!teacherHasAccessToStudent($id)) {
                    Toastr::error('You do not have access to this student\'s details', 'Failed');
                    return redirect()->back();
                }
            }

            $student_detail = SmStudent::with('class', 'section', 'parents', 'bloodGroup', 'religion', 'category', 'route', 'vechile', 'dormitory', 'room', 'gender', 'session')
                ->where('id', $id)
                ->where('school_id', Auth::user()->school_id)
                ->first();

            if ($student_detail == "") {
                Toastr::error('Student not found', 'Failed');
                return redirect()->back();
            }

            return view('backEnd.studentInformation.student_details', compact('student_detail'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function studentDetailsView($id)
    {
        try {
            if (teacherAccess()) {
                // Check if teacher has access to this student
                if (!teacherHasAccessToStudent($id)) {
                    Toastr::error('You do not have access to this student\'s details', 'Failed');
                    return redirect()->back();
                }
            }

            $student_detail = SmStudent::with('class', 'section', 'parents', 'bloodGroup', 'religion', 'category', 'route', 'vechile', 'dormitory', 'room', 'gender', 'session')
                ->where('id', $id)
                ->where('school_id', Auth::user()->school_id)
                ->first();

            if ($student_detail == "") {
                Toastr::error('Student not found', 'Failed');
                return redirect()->back();
            }

            return view('backEnd.studentInformation.student_details_view', compact('student_detail'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    function teacherHasAccessToStudent($student_id, $subject_id = null) {
        try {
            if (!teacherAccess()) {
                return false;
            }
            
            $student = SmStudent::where('id', $student_id)
                ->where('school_id', Auth::user()->school_id)
                ->first();
                
            if (!$student) {
                return false;
            }
            
            $teacher = SmStaff::where('user_id', Auth::user()->id)
                ->where('school_id', Auth::user()->school_id)
                ->first();
                
            if (!$teacher) {
                return false;
            }
            
            $query = SmAssignSubject::where('class_id', $student->class_id)
                ->where('section_id', $student->section_id)
                ->where('teacher_id', $teacher->id)
                ->where('school_id', Auth::user()->school_id)
                ->where('academic_id', getAcademicId());
                
            if ($subject_id) {
                $query->where('subject_id', $subject_id);
            }
            
            return $query->exists();
        } catch (\Exception $e) {
            return false;
        }
    }
} 