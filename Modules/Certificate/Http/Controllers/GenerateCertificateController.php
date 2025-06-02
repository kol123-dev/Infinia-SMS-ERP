<?php

namespace Modules\Certificate\Http\Controllers;

use App\User;
use App\SmExam;
use App\SmClass;
use App\SmStaff;
use App\SmSection;
use App\SmStudent;
use App\YearCheck;
use App\SmExamType;
use App\SmMarksGrade;
use App\SmExamSetting;
use App\SmResultStore;
use App\SmAssignSubject;
use App\SmMarksRegister;
use Illuminate\Support\Str;
use App\SmStudentAttendance;
use Illuminate\Http\Request;
use App\Models\StudentRecord;
use App\SmClassOptionalSubject;
use Barryvdh\DomPDF\Facade\Pdf;
use App\SmOptionalSubjectAssign;
use App\Models\ExamMeritPosition;
use Imagick;
use Illuminate\Routing\Controller;
use Spatie\Browsershot\Browsershot;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\Alumni\Entities\Graduate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Renderable;
use Modules\Certificate\QrCode\Facades\QrCode;
use Modules\RolePermission\Entities\InfixRole;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\Certificate\Entities\CertificateSetting;
use Modules\Certificate\Entities\CertificateTemplate;
use Modules\Certificate\Http\Requests\CertificateGenerateRequest;
use Modules\Certificate\Http\Requests\EmployeeCertificateSearchRequest;

class GenerateCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = [];
        $data['title'] = _trans('certificate::Generate Certificate');
        $data['templates'] = CertificateTemplate::where('status', 1)->where('school_id', Auth::user()->school_id)
            ->with('type', 'design')->whereHas('type', function ($q) {
                $q->where('role_id', 2);
            })
            ->whereHas('design', function ($q) {
                $q->whereNotNull('design_content',);
            })
            ->get();
        $data['classes'] = SmClass::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
        $data['exams'] = SmExamType::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
        return view('certificate::generate.index', $data);
    }
    public function staffCertificate()
    {
        $data = [];
        $data['title'] = _trans('certificate::Generate Employee Certificate');
        $data['roles'] = InfixRole::whereNotIn('id', [2, 3])->where('school_id', Auth::user()->school_id)->get();
        $data['templates'] = CertificateTemplate::where('status', 1)->where('school_id', Auth::user()->school_id)
            ->with('type', 'design')->whereHas('type', function ($q) {
                $q->where('role_id', 3);
            })
            ->whereHas('design', function ($q) {
                $q->whereNotNull('design_content',);
            })
            ->get();
        return view('certificate::generate.staff_certificate', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function staffCertificateSearch(EmployeeCertificateSearchRequest $request)
    {
        try {
            $data = [];
            $data['certificate_id'] = $request->certificate;
            $data['templates'] = CertificateTemplate::where('status', 1)->where('school_id', Auth::user()->school_id)
                ->with('type', 'design')->whereHas('type', function ($q) {
                    $q->where('role_id', 3);
                })
                ->whereHas('design', function ($q) {
                    $q->whereNotNull('design_content',);
                })
                ->get();
            $data['role_id'] = $request->role;
            $data['roles'] = InfixRole::whereNotIn('id', [2, 3])->where('school_id', Auth::user()->school_id)->get();
            $data['users'] = User::where('role_id', $request->role)->with('staff', 'staff.departments', 'staff.designations')->where('school_id', Auth::user()->school_id)->get();

            $user_ids = $data['users']->pluck('id')->toArray();

            $existing_certificate = CertificateRecord::where('template_id', $request->certificate)
                ->where('school_id', Auth::user()->school_id)
                ->whereIn('user_id', $user_ids)
                ->pluck('user_id')->toArray();
            $data['existing_certificate'] = $existing_certificate;
            return view('certificate::generate.staff_certificate', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function generateCertificateStaff(Request $request)
    {
        try {
            // return $request;
            $staffs = explode(',', $request->staffs);
            $certificate = CertificateTemplate::with('design')->find($request->certificate);
            $data = [];
            $certificate_background = asset($certificate->background_image);
            $certificate_logo = asset($certificate->logo_image);
            $certificate_signature = '<img src="' . asset($certificate->signature_image) . '" style="width: 100px; height: 100px;">';
            $logo_image = $certificate->logo_image != null ? (file_exists(@asset($certificate->logo_image)) ? asset($certificate->logo_image) : asset(generalSetting()->logo)) : asset(generalSetting()->logo);
            $logo_image = '<img src="' . $logo_image . '" style="width:' . $certificate->user_image_size . 'px; height: auto;">';

            $staff_lists = User::whereIn('id', $staffs)->with('staff', 'staff.departments', 'staff.designations')->get();
            $staff_certificates = [];

            foreach ($staff_lists as $key => $user) {
                $staff = $user->staff;

                $certificate_number = $this->certificateStaffUniqueNumberGeneration($request, $staff->staff_no);

                $design_content = $certificate->design->design_content;
                $design_content = str_replace('{certificate_background}', $certificate_background, $design_content);
                $design_content = str_replace('{certificate_logo}', $certificate_logo, $design_content);
                $design_content = str_replace('{certificate_signature}', $certificate_signature, $design_content);
                $message_format = $this->staffCertificateBodyContent($certificate, $staff, $request) ?? '';
                $qr_code = $this->generateQRCode($certificate, $staff->user_id, $certificate_number);

                $photo = $staff->staff_photo != null ? (file_exists(@$staff->staff_photo) ? asset($staff->staff_photo) : asset('public/uploads/staff/demo/staff.jpg')) : asset('public/uploads/staff/demo/staff.jpg');
                $radius = $certificate->user_photo_style == 1 ? '50' : '0';
                $staff_image = '<img src="' . $photo . '" style="width:' . $certificate->user_image_size . 'px; height: auto; border-radius:' . $radius . '%;">';

                $design_content = str_replace('{qrCode}', $qr_code, $design_content);
                $design_content = str_replace('{certificate_text}', $message_format, $design_content);
                $design_content = str_replace('{certificate_no}', $certificate_number, $design_content);
                $design_content = str_replace('{certificate_text}', $staff->id, $design_content);
                $design_content = str_replace('{user_image}', $staff_image, $design_content);
                $design_content = str_replace('{logo_image}', $logo_image, $design_content);
                $design_content = str_replace('{certificate_name}', $certificate->name, $design_content);
                $design_content = str_replace('{principale}', @$certificate_signature, $design_content);
                $design_content = str_replace('{issue_date}', date('d M Y'), $design_content);

                $certificate_details = [
                    'certificate_id' => $request->certificate,
                    'staff_id' => $staff->id,
                    'user_id' => $staff->user_id,
                    'certificate_number' => $certificate_number,
                    'school_id' => Auth::user()->school_id,
                ];
                $certificate_details = json_encode($certificate_details);

                $design_content = Str::substr($design_content, 0, -6);

                $certificate_details_html = "<input type='hidden' name='certificate_details' class='certificate_details' value='" . $certificate_details . "'></div>";
                $design_content = $design_content . $certificate_details_html;

                $staff_certificates[$staff->id] = $design_content;
            }

            $student_certificates = $staff_certificates;
            return view('certificate::generate_certificate_print', compact('student_certificates', 'certificate'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function getStudentList(CertificateGenerateRequest $request)
    {
        try {
            $data = [];
            $data['certificate_id'] = $request->certificate;
            $data['templates'] = CertificateTemplate::where('status', 1)->where('school_id', Auth::user()->school_id)->get();

            $data['class_id'] = $request->class;
            $data['exam_id'] = $request->exam;
            $data['section_id'] = $request->section;
            $data['classes'] = SmClass::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $data['exams'] = SmExamType::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();

            $data['students'] = StudentRecord::with('student', 'student.user')->when($request->academic_year, function ($query) use ($request) {
                $query->where('academic_id', $request->academic_year);
            })
                ->when($request->class, function ($query) use ($request) {
                    $query->where('class_id', $request->class);
                })
                ->when($request->section, function ($query) use ($request) {
                    $query->where('section_id', $request->section);
                })
                ->when(!$request->academic_year, function ($query) use ($request) {
                    $query->where('academic_id', getAcademicId());
                })->where('school_id', auth()->user()->school_id)->get();

            $user_ids = $data['students']->pluck('student.user.id')->toArray();

            $existing_certificate = CertificateRecord::where('template_id', $request->certificate)
                ->where('school_id', Auth::user()->school_id)
                ->whereIn('user_id', $user_ids)
                ->pluck('user_id')->toArray();
            $data['existing_certificate'] = $existing_certificate;
            return view('certificate::generate.index', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('certificate::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */

    function generateQRCode($template, $user_id, $certificate_number)
    {
        try {

            $user = User::find($user_id);
            $data = [];
            $data['template'] = $template;
            $data['user'] = $user;

            $user_profile = $user->role_id == 2 ? SmStudent::where('user_id', $user->id)->first() : SmStaff::where('user_id', $user->id)->first();

            // return $user_profile;

            $qr_text = "";

            $template_qr_codes = $template->qr_code;
            $template_qr_codes = json_decode($template_qr_codes);

            foreach ($template_qr_codes as $key => $qr_code) {

                switch ($qr_code) {
                    case 'roll_no':
                        $qr_text .= "\n Roll :" . $user_profile->roll_no;
                        break;
                    case 'admission_no':
                        $qr_text .= "\n Admission No :" . $user_profile->admission_no;
                        break;
                    case 'date_of_birth':
                        $qr_text .= "\n Date of birth :" .  $user_profile->date_of_birth;
                        break;
                    case 'staff_id':
                        $qr_text .= "\n Staff ID :" .  $user_profile->staff_no;
                        break;
                    case 'joining_date':
                        $qr_text .= "\n Joining Date :" .  $user_profile->joining_date;
                        break;
                    case 'certificate_number':
                        $qr_text .= "\n Certificate No :" .  $certificate_number;
                        break;
                    case 'link':
                        $url = route('certificate.get-verify-certificate');
                        $qr_text .= "\n Certificate Link :" . $url . '?certificate_number=' . $certificate_number;
                        break;

                    default:
                        $qr_text .= "";
                        break;
                }
            }
            $data['qr_text'] = $qr_text;
            return QrCode::size($template->qr_image_size)
                ->margin(1)
                ->generate(
                    $qr_text,
                );
            // return view('certificate::qr_code',$data)->render();
        } catch (\Throwable $th) {
            return "";
        }
    }

    function certificateUniqueNumberGeneration($request, $student_id)
    {
        try {
            $settings = CertificateSetting::where('school_id', Auth::user()->school_id)->where('key', 'prefix')->first();
            $prefix = $settings->value;
            $certificate_number = $prefix . $student_id . $request->class . $request->section . $request->certificate;
            return $certificate_number;
        } catch (\Throwable $th) {
            return "";
        }
    }
    function certificateStaffUniqueNumberGeneration($request, $staff_id)
    {
        try {
            $settings = CertificateSetting::where('school_id', Auth::user()->school_id)->where('key', 'prefix')->first();
            $prefix = $settings->value;
            $certificate_number = $prefix . $staff_id . $request->certificate;
            return $certificate_number;
        } catch (\Throwable $th) {
            return "";
        }
    }

    public function generateCertificate(Request $request)
    {
        // return $request;
        try {
            $students = $request->students;
            $students = explode(',', $students);
            $certificate = CertificateTemplate::with('design')->find($request->certificate);
            $class = SmClass::find($request->class);

            $student_lists = SmStudent::whereIn('id', $students)->with('allRecords')->get();
            $data = [];



            $certificate_background = asset($certificate->background_image);
            $certificate_logo = asset($certificate->logo_image);
            $certificate_signature = '<img src="' . asset($certificate->signature_image) . '" style="width: 100px; height: 100px;">';

            $logo_image = $certificate->logo_image != null ? (file_exists(@asset($certificate->logo_image)) ? asset($certificate->logo_image) : asset(generalSetting()->logo)) : asset(generalSetting()->logo);
            $logo_image = '<img src="' . $logo_image . '" style="width:' . $certificate->user_image_size . 'px; height: auto;">';

            $student_certificates = [];
            foreach ($student_lists as $key => $student) {
                $certificate_number = $this->certificateUniqueNumberGeneration($request, $student->id);
                $exam_result_array = [];
                if ($request->exam != "") {
                    $exam_result_array = $this->getExamResult($request, $student->id);
                }

                $design_content = $certificate->design->design_content;
                $design_content = str_replace('{certificate_background}', $certificate_background, $design_content);
                $design_content = str_replace('{certificate_logo}', $certificate_logo, $design_content);
                $design_content = str_replace('{certificate_signature}', $certificate_signature, $design_content);
                $message_format = $this->certificateBodyContent($certificate, $student, $request, $exam_result_array) ?? '';
                $qr_code = $this->generateQRCode($certificate, $student->user_id, $certificate_number);
                // return $qr_code;
                $photo = $student->student_photo != null ? (file_exists(@$student->student_photo) ? asset($student->student_photo) : asset('public/uploads/staff/demo/staff.jpg')) : asset('public/uploads/staff/demo/staff.jpg');
                $radius = $certificate->user_photo_style == 1 ? '50' : '0';
                $student_image = '<img src="' . $photo . '" style="width:' . $certificate->user_image_size . 'px; height: auto; border-radius:' . $radius . '%;">';

                $design_content = str_replace('{qrCode}', $qr_code, $design_content);
                $design_content = str_replace('{certificate_text}', $message_format, $design_content);
                $design_content = str_replace('{certificate_no}', $certificate_number, $design_content);
                $design_content = str_replace('{certificate_text}', $student->id, $design_content);
                $design_content = str_replace('{user_image}', $student_image, $design_content);
                $design_content = str_replace('{logo_image}', $logo_image, $design_content);
                $design_content = str_replace('{certificate_name}', $certificate->name, $design_content);
                $design_content = str_replace('{principale}', @$certificate_signature, $design_content);
                $design_content = str_replace('{issue_date}', date('d M Y'), $design_content);

                $certificate_details = [
                    'certificate_id' => $request->certificate,
                    'student_id' => $student->id,
                    'user_id' => $student->user_id,
                    'certificate_number' => $certificate_number,
                    'school_id' => Auth::user()->school_id,
                    'academic_id' => getAcademicId(),
                    'class_id' => $request->class,
                    'section_id' => $request->section,
                    'exam_id' => $request->exam,
                ];
                $certificate_details = json_encode($certificate_details);

                $design_content = Str::substr($design_content, 0, -6);

                $certificate_details_html = "<input type='hidden' name='certificate_details' class='certificate_details' value='" . $certificate_details . "'></div>";
                $design_content = $design_content . $certificate_details_html;


                if ($exam_result_array != []) {
                    // dump($exam_result_array);
                    $grade = $exam_result_array['grade'];
                    if ($grade != null) {
                        $student_certificates[$student->id] = $design_content;
                    }
                } else {
                    $student_certificates[$student->id] = $design_content;
                }
            }
            if ($certificate->layout == 1) {
                return view('certificate::generate.print_view.a4_portrait', compact('student_certificates', 'certificate'));
            } elseif ($certificate->layout == 2) {
                return view('certificate::generate.print_view.a4_landscape', compact('student_certificates', 'certificate'));
            } else {
                return view('certificate::generate.print_view.custom', compact('student_certificates', 'certificate'));
            }

            // return view('certificate::generate_certificate_print', compact('student_certificates', 'certificate'));

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    function certificateBodyContent($template, $student, $request, $exam_result_array)
    {
        try {
            $message_format = $template->content;
            $matches = [];
            preg_match_all('/{(.*?)}/', $message_format, $matches);

            $short_codes = $matches[1];
            $short_codes = array_unique($short_codes);
            foreach ($short_codes as $key => $short_code) {
                $value = $this->getStudentShortCodeValue($student, $short_code, $request, $exam_result_array);
                $message_format = str_replace('{' . $short_code . '}', $value, $message_format);
            }
            return $message_format;
        } catch (\Throwable $th) {
            return "";
        }
    }
    function staffCertificateBodyContent($template, $staff, $request)
    {
        try {
            $message_format = $template->content;
            $matches = [];
            preg_match_all('/{(.*?)}/', $message_format, $matches);

            $short_codes = $matches[1];
            $short_codes = array_unique($short_codes);
            foreach ($short_codes as $key => $short_code) {
                $value = $this->getStaffShortCodeValue($staff, $short_code, $request);
                $message_format = str_replace('{' . $short_code . '}', $value, $message_format);
            }
            return $message_format;
        } catch (\Throwable $th) {
            return "";
        }
    }

    function getStudentShortCodeValue($student, $short_code, $request, $exam_result_array)
    {
        try {
            $record = $student->allRecords->where('academic_id', getAcademicId())->first();
            $value = "";

            switch ($short_code) {
                case 'name':
                    $value = $student->full_name;
                    break;
                case 'dob':
                    $value = date('d M Y', strtotime($student->date_of_birth));
                    break;
                case 'present_address':
                    $value = @$student->current_address;
                    break;
                case 'guardian':
                    $value = @$student->parents->guardians_name;
                    break;
                case 'admission_date':
                    $value = date('d M Y', strtotime($student->admission_date));
                    break;
                case 'cast':
                    $value = @$student->caste;
                    break;
                case 'religion':
                    $value = @$student->religion->base_setup_name;
                    break;
                case 'email':
                    $value = @$student->email;
                    break;
                case 'phone':
                    $value = @$student->mobile;
                    break;
                case 'father_name':
                    $value = @$student->parents->fathers_name;
                    break;
                case 'mother_name':
                    $value = @$student->parents->mothers_name;
                    break;
                case 'institute_name':
                    $value = 'Infix Edu';
                    break;
                case 'institute_address':
                    $value = 'Dhaka, Bangladesh';
                    break;
                case 'class':
                    $value = @$record->class->class_name;
                    break;
                case 'section':
                    $value = @$record->section->section_name;
                    break;
                case 'roll':
                    $value = @$student->roll_no;
                    break;
                case 'roll_no':
                    $value = @$student->roll_no;
                    break;
                case 'gender':
                    $value = @$student->gender->base_setup_name;
                    break;
                case 'category':
                    $value = @$student->category->category_name;
                    break;
                case 'created_at':
                    $value = date('d M Y', strtotime($student->created_at));
                    break;
                case 'admission_no':
                    $value = @$student->admission_no;
                    break;
                default:
                    $value = "";
                    break;
            }
            if ($value == "" && Str::startsWith($short_code, '_')) {
                $value = Str::substr($short_code, 1);
                $custom_filed = $student->custom_field;
                $custom_field = json_decode($custom_filed, true);
                $value = $custom_field[$value] ?? '';
            } else {
                if ($request->exam != "" && $value == "" && $exam_result_array != []) {
                    foreach ($exam_result_array as $key => $result) {
                        if ($short_code == $key) {
                            $value = $result;
                        }
                    }
                }
            }
            return $value;
        } catch (\Throwable $th) {
            return "";
        }
    }
    function getStaffShortCodeValue($staff, $short_code, $request)
    {
        try {
            $value = "";



            switch ($short_code) {
                case 'name':
                    $value = $staff->full_name;
                    break;
                case 'staff_id':
                    $value = $staff->staff_no;
                    break;
                case 'birthday':
                    $value = date('d M Y', strtotime($staff->date_of_birth));
                    break;
                case 'present_address':
                    $value = @$staff->current_address;
                    break;
                case 'permanent_address':
                    $value = @$staff->permanent_address;
                    break;
                case 'joining_date':
                    $value = date('d M Y', strtotime($staff->joining_date));
                    break;
                case 'religion':
                    $value = @$staff->religion->base_setup_name;
                    break;
                case 'email':
                    $value = @$staff->email;
                    break;
                case 'mobileno':
                    $value = @$staff->phone;
                    break;
                case 'department':
                    $value = @$staff->departments->name;
                    break;
                case 'designation':
                    $value = @$staff->designations->title;
                    break;
                case 'qualification':
                    $value = @$staff->qualification;
                    break;
                case 'gender':
                    $value = @$staff->genders->base_setup_name;
                    break;
                case 'total_experience':
                    $value = @$staff->experience;
                    break;
                default:
                    $value = "";
                    break;
            }
            if ($value == "" && Str::startsWith($short_code, '_')) {
                $value = Str::substr($short_code, 1);
                $custom_filed = $staff->custom_field;
                $custom_field = json_decode($custom_filed, true);
                $value = $custom_field[$value] ?? '';
            }
            return $value;
        } catch (\Throwable $th) {

            return "";
        }
    }

    function getExamResult($request, $student_id)
    {
        try {
            $total_class_days = 0;
            $student_attendance = 0;
            $input['exam_id'] = $request->exam;
            $input['class_id'] = $request->class;
            $input['section_id'] = $request->section;
            $input['student_id'] = $student_id;
            $exam_detail = SmExam::find($request->exam);
            $exam_type_id = $exam_detail->exam_type_id;

            // Attendance Part Start
            $exam_content = SmExamSetting::where('exam_type', $exam_type_id)
                ->where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->first();
            if ($exam_content) {
                $total_class_day = SmStudentAttendance::whereBetween('attendance_date', [$exam_content->start_date, $exam_content->end_date])
                    ->where('class_id', $input['class_id'])
                    ->where('section_id', $input['section_id'])
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', Auth::user()->school_id)
                    ->whereNotIn('attendance_type', ["H"])
                    ->get()
                    ->groupBy('attendance_date');

                $total_class_days = count($total_class_day);

                $student_attendance = SmStudentAttendance::where('student_id', $student_id)
                    ->whereBetween('attendance_date', [$exam_content->start_date, $exam_content->end_date])
                    ->where('class_id', $input['class_id'])
                    ->where('section_id', $input['section_id'])
                    ->whereIn('attendance_type', ["P", "L"])
                    ->where('academic_id', getAcademicId())
                    ->where('school_id', Auth::user()->school_id)
                    ->count();
            }else{
                Toastr::error('No format setup was done for this exam', 'Failed');
                return redirect()->route('certificate.generate-certificate');
            }
            // Attendance Part End

            $failgpa = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->min('gpa');

            $failgpaname = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->where('gpa', $failgpa)
                ->first();

            $exams = SmExamType::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $classes = SmClass::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $student_detail = $studentDetails = StudentRecord::where('student_id', $student_id)
                ->where('academic_id', getAcademicId())
                ->where('is_promote', 0)
                ->where('school_id', Auth::user()->school_id)
                ->first();

            $examSubjects = SmExam::where([['exam_type_id', $request->exam], ['section_id', $request->section], ['class_id', $request->class]])
                ->where('school_id', Auth::user()->school_id)
                ->where('academic_id', getAcademicId())
                ->get();
            $examSubjectIds = [];
            foreach ($examSubjects as $examSubject) {
                $examSubjectIds[] = $examSubject->subject_id;
            }

            $subjects = $studentDetails->class->subjects->where('section_id', $request->section)
                ->whereIn('subject_id', $examSubjectIds)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id);
            $subjects = $examSubjects;

            $section_id = $request->section;
            $class_id = $request->class;
            $exam_details = $exams->where('active_status', 1)->find($exam_type_id);
            $exam_titla = $exam_details->title;

            $optional_subject = '';

            $get_optional_subject = SmOptionalSubjectAssign::where('record_id', '=', $student_detail->id)
                ->where('session_id', '=', $student_detail->session_id)
                ->first();

            if ($get_optional_subject != '') {
                $optional_subject = $get_optional_subject->subject_id;
            }

            $optional_subject_setup = SmClassOptionalSubject::where('class_id', '=', $request->class)
                ->first();

            $mark_sheet = SmResultStore::where([['class_id', $request->class], ['exam_type_id', $request->exam], ['section_id', $request->section], ['student_id', $student_id]])
                ->whereIn('subject_id', $subjects->pluck('subject_id')->toArray())
                ->where('school_id', Auth::user()->school_id)
                ->get();


            $grades = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->orderBy('gpa', 'desc')
                ->get();

            $maxGrade = SmMarksGrade::where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->max('gpa');

            if (count($mark_sheet) == 0) {
                Toastr::error('Ops! Your result is not found! Please check mark register', 'Failed');
                return redirect('mark-sheet-report-student');
            }

            $is_result_available = SmResultStore::where([['class_id', $request->class], ['exam_type_id', $request->exam], ['section_id', $request->section], ['student_id', $student_id]])
                ->where('created_at', 'LIKE', '%' . YearCheck::getYear() . '%')
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $marks_register = SmMarksRegister::where('exam_id', $request->exam)
                ->where('student_id', $student_id)
                ->first();

            $subjects = SmAssignSubject::where('class_id', $request->class)
                ->where('section_id', $request->section)
                ->whereIn('subject_id', $examSubjectIds)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $exams = SmExamType::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $classes = SmClass::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $grades = SmMarksGrade::where('active_status', 1)
                ->where('academic_id', getAcademicId())
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $class = SmClass::find($request->class);
            $section = SmSection::find($request->section);
            $exam_detail = SmExam::find($request->exam);
            $exam_id = $request->exam;
            $class_id = $request->class;

            $generalsettingsResultType = generalSetting()->result_type;
            //=========================================================================================================
            $result = [];


            $optional_countable_gpa = 0;
            $main_subject_total_gpa = 0;
            $Optional_subject_count = 0;
            if ($optional_subject != '') {
                $Optional_subject_count = $subjects->count() - 1;
            } else {
                $Optional_subject_count = $subjects->count();
            }
            $sum_gpa = 0;
            $resultCount = 1;
            $subject_count = 1;
            $tota_grade_point = 0;
            $this_student_failed = 0;
            $count = 1;
            $exam_total_mark = 0;
            $total_mark = 0;
            $temp_grade = [];
            $average_passing_mark = averagePassingMark($exam_type_id);

            $result['student_id'] = $student_id;
            $result['student_attendance'] = $student_attendance;
            $result['total_class_days'] = $total_class_days;
            if ($student_attendance == 0 && $total_class_days == 0) {
                Toastr::error('No student attendance found on exam date', 'Failed');
                return redirect()->route('certificate.generate-certificate');
            } else {
                $result['attendance_percentage'] = (round($student_attendance / $total_class_days * 100, 2)) . '%';
            }


            foreach ($mark_sheet as $key => $data) {

                $temp_grade[] = $data->total_gpa_grade;
                if ($data->subject_id == $optional_subject) {
                    continue;
                }

                if (@$generalsettingsResultType == 'mark') {
                    $exam_total_mark += subject100PercentMark();
                } else {
                    $exam_total_mark += subjectFullMark($exam_details->id, $data->subject->id, $class_id, $section_id);
                }

                if (@$generalsettingsResultType == 'mark') {
                    $total_mark += subjectPercentageMark(@$data->total_marks, @subjectFullMark($exam_details->id, $data->subject->id, $class_id, $section_id));
                } else {
                    $total_mark += @$data->total_marks;
                }
                if (@$generalsettingsResultType != 'mark') {
                    $new_result = markGpa(@subjectPercentageMark(@$data->total_marks, @subjectFullMark($exam_details->id, $data->subject->id, $class_id, $section_id)));
                    $main_subject_total_gpa += $new_result->gpa;
                }
                // $result['total_gpa_grade'][$key] = $data->total_gpa_grade;
            }

            //Total Marks
            $result['exam'] = $exam_titla;
            $result['exam_total_mark'] = $exam_total_mark;
            $result['std_total_mark'] = $total_mark;
            //Average Mark
            $average_mark = 0;
            if ($Optional_subject_count) {
                $average_mark = $total_mark / ($Optional_subject_count);
            }
            $result['average_mark'] = number_format($average_mark, 2, '.', '');


            //GPA Without Optional Subject
            if (@$generalsettingsResultType != 'mark') {
                $without_optional = 0;
                if ($Optional_subject_count) {
                    $without_optional = $main_subject_total_gpa / $Optional_subject_count;
                }
                $result['gpa_without_optional'] = number_format($without_optional, 2, '.', '');
            }

            //GPA With Optional Subject

            $final_result = 0;
            if ($Optional_subject_count) {
                $final_result = ($main_subject_total_gpa + $optional_countable_gpa) / $Optional_subject_count;
            }
            if ($final_result >= $maxGrade) {
                $final_gpa = number_format($maxGrade, 2, '.', '');
            } else {
                $final_gpa = number_format($final_result, 2, '.', '');
            }
            $result['gpa_with_optional'] = $final_gpa;

            //GRADE POINT
            if (in_array($failgpaname->grade_name, $temp_grade)) {
                echo $failgpaname->grade_name;
            } else {
                if ($final_result >= $maxGrade) {
                    $grade_details = SmResultStore::remarks($maxGrade);
                } else {
                    $grade_details = SmResultStore::remarks($final_result);
                }
            }
            $result['grade'] = @$grade_details->grade_name;

            //Evaluation
            if (in_array($failgpaname->grade_name, $temp_grade)) {
                echo $failgpaname->description;
            } else {
                if ($final_result >= $maxGrade) {
                    $grade_details = SmResultStore::remarks($maxGrade);
                } else {
                    $grade_details = SmResultStore::remarks($final_result);
                }
            }
            $result['evaluation'] = @$grade_details->description;
            $position = getStudentMeritPosition($class_id, $section_id, $exam_type_id, $student_detail->id);
            $result['position'] = $position != "" ? $this->numberToOrdinal($position) : "";
            return $result;
        } catch (\Throwable $th) {
            return [];
        }
    }

    function numberToOrdinal($number)
    {
        if (!is_numeric($number)) {
            return $number; // Handle non-numeric input
        }

        if ($number % 100 >= 11 && $number % 100 <= 13) {
            return $number . 'th';
        }

        switch ($number % 10) {
            case 1:
                return $number . 'st';
            case 2:
                return $number . 'nd';
            case 3:
                return $number . 'rd';
            default:
                return $number . 'th';
        }
    }
    public function generateCertificateOld($temp_id, $std_id)
    {
        $template = CertificateTemplate::with('design')->find($temp_id);
        $student_record = StudentRecord::where('student_id', $std_id)->with('student')->first();
        $student = $student_record->student;
        $design_content = $template->design->design_content;
        $page_width = floatval($template->width) * 3.7795275591;
        $page_height = floatval($template->height) * 3.7795275591;

        $message_format = $template->content;
        $message_format = str_replace('{name}', $student->full_name, $message_format);
        $message_format = str_replace('{birthday}', date('d M Y', strtotime($student->date_of_birth)), $message_format);
        $message_format = str_replace('{father_name}', @$student->parents->fathers_name, $message_format);
        $message_format = str_replace('{mother_name}', @$student->parents->mothers_name, $message_format);
        $message_format = str_replace('{institute_name}', 'Infix Edu', $message_format);
        $message_format = str_replace('{institute_address}', 'Dhaka, Bangladesh', $message_format);
        $message_format = str_replace('{class}', @$student_record->class->class_name, $message_format);
        $message_format = str_replace('{roll_no}', @$student->roll_no, $message_format);
        $message_format = str_replace('{gender}', @$student->className->class_name, $message_format);
        $message_format = str_replace('{category}', @$student->category->category_name, $message_format);
        $message_format = str_replace('{created_at}', date('d M Y', strtotime($student->created_at)), $message_format);
        $message_format = str_replace('{admission_no}', @$student->admission_no, $message_format);

        $certificate_background = asset($template->background_image);
        $certificate_logo = asset($template->logo_image);
        $certificate_signature = '<img src="' . asset($template->signature_image) . '" style="width: 100px; height: 100px;">';
        $qr_code = $this->generateQRCode($template, $student->user_id);

        $photo = $student->student_photo != null ? (file_exists(@$student->student_photo) ? asset($student->student_photo) : asset('public/uploads/staff/demo/staff.jpg')) : asset('public/uploads/staff/demo/staff.jpg');
        $radius = $template->user_photo_style == 1 ? '50' : '0';
        $student_image = '<img src="' . $photo . '" style="width:' . $template->user_image_size . 'px; height: auto; border-radius:' . $radius . '%;">';

        $logo_image = $template->logo_image != null ? (file_exists(@$template->logo_image) ? asset($template->logo_image) : asset('public/uploads/staff/demo/staff.jpg')) : asset('public/uploads/staff/demo/staff.jpg');
        $logo_image = '<img src="' . $logo_image . '" style="width:' . $template->user_image_size . 'px; height: auto;">';


        $design_content = str_replace('{certificate_background}', $certificate_background, $design_content);
        $design_content = str_replace('{certificate_logo}', $certificate_logo, $design_content);
        $design_content = str_replace('{certificate_signature}', $certificate_signature, $design_content);
        $design_content = str_replace('{qrCode}', $qr_code, $design_content);
        $design_content = str_replace('{certificate_text}', $message_format, $design_content);
        $design_content = str_replace('{student_image}', $student_image, $design_content);
        $design_content = str_replace('{logo_image}', $logo_image, $design_content);
        $design_content = str_replace('{certificate_name}', $template->name, $design_content);
        $design_content = str_replace('{principale}', @$certificate_signature, $design_content);
        $design_content = str_replace('{issue_date}', date('d M Y'), $design_content);

        return view('certificate::generate_certificate_print', compact('template', 'student', 'design_content'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $certificate_details = json_decode($request->certificate_details, true);

            $record = CertificateRecord::where('certificate_number', $certificate_details['certificate_number'])->first();
            if (!$record) {
                $new_record = new CertificateRecord();
                $new_record->certificate_number = $certificate_details['certificate_number'];
                $new_record->user_id = $certificate_details['user_id'];
                $new_record->template_id = $request->template_id;
                $new_record->class_id = $certificate_details['class_id'] ?? null;
                $new_record->section_id = $certificate_details['section_id'] ?? null;
                $new_record->exam_id = $certificate_details['exam_id'] ?? null;
                $new_record->academic_id = $certificate_details['academic_id'] ?? null;
                $new_record->school_id = $certificate_details['school_id'];


                $base64Image = $request->image;
                $img = str_replace('data:image/png;base64,', '', $base64Image);
                $img = str_replace(' ', '+', $img);
                $imageData = base64_decode($img);
                $fileName = $certificate_details['certificate_number'] . '.png';
                $path = public_path() . '/uploads/certificate/' . $fileName;

                if (file_exists($path)) {
                    unlink($path);
                }
                file_put_contents($path, $imageData);

                $new_record->certificate_path = 'public/uploads/certificate/' . $fileName;
                $new_record->save();
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
