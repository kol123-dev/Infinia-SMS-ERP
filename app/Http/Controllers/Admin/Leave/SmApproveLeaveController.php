<?php

namespace App\Http\Controllers\Admin\Leave;

use App\Role;
use App\User;
use App\SmStaff;
use App\SmParent;
use App\YearCheck;
use App\SmLeaveType;
use App\ApiBaseMethod;
use App\SmLeaveDefine;
use App\SmClassTeacher;
use App\SmLeaveRequest;
use App\SmNotification;
use App\SmGeneralSettings;
use Illuminate\Http\Request;
use App\SmAssignClassTeacher;
use App\Traits\NotificationSend;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Modules\RolePermission\Entities\infixRole;
use App\Notifications\LeaveApprovedNotification;
use App\Http\Requests\Admin\Leave\SmApproveLeaveRequest;
use App\Http\Controllers\Admin\SystemSettings\SmSystemSettingController;

use App\SmStudent;

class SmApproveLeaveController extends Controller
{
    use NotificationSend;
    public function __construct()
    {
        $this->middleware('PM');
        // User::checkAuth();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {
            $user = Auth::user();
            $staff = SmStaff::where('user_id', Auth::user()->id)->first();
            if (Auth::user()->role_id == 1) {
                $apply_leaves = SmLeaveRequest::with('leaveDefine', 'staffs', 'student')->where([['active_status', 1], ['approve_status', '!=', 'P']])->where('school_id', Auth::user()->school_id)->where('academic_id', getAcademicId())->get();
            } else {
                $apply_leaves = SmLeaveRequest::with('leaveDefine', 'staffs', 'student')->where([['active_status', 1], ['approve_status', '!=', 'P'], ['staff_id', '=', $staff->id]])->where('academic_id', getAcademicId())->get();
            }
            $leave_types = SmLeaveType::where('active_status', 1)->get();
            $roles = infixRole::where('is_saas',0)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where(function ($q) {
                $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
            })->get();


            return view('backEnd.humanResource.approveLeaveRequest', compact('apply_leaves', 'leave_types', 'roles'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function pendingLeave(Request $request)
    {
        try {
            $user = Auth::user();
            $staff = SmStaff::where('user_id', Auth::user()->id)->first();

            $leave_types = SmLeaveType::where('active_status', 1)->get();
            $roles = infixRole::where('is_saas',0)->where('id', '!=', 1)->where('id', '!=', 3)->where(function ($q) {
                $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
            })->get();


            return view('backEnd.humanResource.approveLeaveRequest', compact('leave_types', 'roles'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function store(SmApproveLeaveRequest $request)
    {
        try {
            $path = 'public/uploads/leave_request/';
            $fileName = fileUpload($request->attach_file, $path);
            $user = Auth()->user();

            if ($user) {
                $login_id = $user->id;
                $role_id = $user->role_id;
            } else {
                $login_id = $request->login_id;
                $role_id = $request->role_id;
            }
            $leave_request_data = new SmLeaveRequest();
            $leave_request_data->staff_id = $login_id;
            $leave_request_data->role_id =  $role_id;
            $leave_request_data->apply_date = date('Y-m-d', strtotime($request->apply_date));
            $leave_request_data->type_id = $request->leave_type;
            $leave_request_data->leave_from = date('Y-m-d', strtotime($request->leave_from));
            $leave_request_data->leave_to = date('Y-m-d', strtotime($request->leave_to));
            $leave_request_data->approve_status = $request->approve_status;
            $leave_request_data->reason = $request->reason;
            $leave_request_data->file = $fileName;
            $leave_request_data->school_id = Auth::user()->school_id;
            $leave_request_data->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            if (checkAdmin()) {
                $editData = SmLeaveRequest::find($id);
            } else {
                $editData = SmLeaveRequest::where('id', $id)->where('school_id', Auth::user()->school_id)->first();
            }
            $staffsByRole = SmStaff::where('role_id', '=', $editData->role_id)->where('school_id', Auth::user()->school_id)->get();
            $roles = infixRole::where('is_saas',0)->whereOr(['school_id', Auth::user()->school_id], ['school_id', 1])->get();
            $apply_leaves = SmLeaveRequest::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            $leave_types = SmLeaveType::where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.humanResource.approveLeaveRequest', compact('editData', 'staffsByRole', 'apply_leaves', 'leave_types', 'roles'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        Toastr::error('Operation Failed', 'Failed');
        return redirect()->back();
    }


    public function staffNameByRole(Request $request)
    {
        try {
            if ($request->id != 3) {
                $allStaffs = SmStaff::whereRole($request->id)->where('school_id', Auth::user()->school_id)->get(['id', 'full_name', 'user_id']);
                $staffs = [];
                foreach ($allStaffs as $staffsvalue) {
                    $staffs[] = SmStaff::where('id', $staffsvalue->id)->first(['id', 'full_name', 'user_id']);
                }
            } else {
                $staffs = SmParent::where('active_status', 1)->get(['id', 'fathers_name', 'guardians_name', 'user_id']);
            }
            return response()->json([$staffs]);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    protected function sendFcmNotifications($user, $messageKey)
    {
        if ($user) {

            $title = '';
            $desc = '';
            if ($messageKey == 'Leave_Approved') {
                $desc = 'Leave Has Been Approved';
                $title = 'Leave Approved';
            } else if ($messageKey == 'Leave_Declined') {
                $desc = 'Leave Has Been Declined';
                $title = 'Leave Rejected';
            }
            
            $notification = new SmNotification;
            $notification->user_id = $user->id;
            $notification->role_id = 2;
            $notification->date = date('Y-m-d');
            $notification->message = $desc;
            $notification->school_id = Auth::user()->school_id;
            $notification->academic_id = getAcademicId();
            $notification->save();
    
            try {
                $user = User::find($user->id);
                if ($user) {
                    $notificationData = [
                        'id'    => $user->id,
                        'title' => $title,
                        'body'  => $notification->message,
                    ];
                    $systemSettingController = new SmSystemSettingController();
                    $systemSettingController->flutterNotificationApi(new Request($notificationData));
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }
    }

    public function updateApproveLeave(Request $request)
    {

        try {
            if (checkAdmin()) {
                $leave_request_data = SmLeaveRequest::find($request->id);
            } else {
                $leave_request_data = SmLeaveRequest::where('id', $request->id)->where('school_id', Auth::user()->school_id)->first();
            }

            $staff = User::find($leave_request_data->staff_id);
            $role_id = $leave_request_data->role_id;
            $leave_request_data->approve_status = $request->approve_status;
            $leave_request_data->academic_id = getAcademicId();
            $result = $leave_request_data->save();

            $status = '';
            if ($request->approve_status == 'A') {
                $status = 'Leave_Approved';
            } elseif ($request->approve_status == 'C') {
                $status = 'Leave_Declined';
            } else {
                Toastr::success('Operation successful', 'Success');
                return redirect('approve-leave');
            }

            $data['to_date'] = $leave_request_data->leave_to;
            $data['name'] = $leave_request_data->user->full_name;
            $data['from_date'] = $leave_request_data->leave_from;
            $data['teacher_name'] = $leave_request_data->user->full_name;
            if ($leave_request_data->role_id == 2) {
                $this->sent_notifications($status, (array)$leave_request_data->user->id, $data, ['Student', 'Parent']);
            }
            if ($leave_request_data->role_id == 4) {
                $this->sent_notifications($status, (array)$leave_request_data->user->id, $data, ['Teacher']);
            }

            if ($leave_request_data->role_id == 2 || 4) {

            }

            if ($result) {
                Toastr::success('Operation successful', 'Success');
                return redirect('approve-leave');
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function viewLeaveDetails(Request $request, $id)
    {
        try {


            if (checkAdmin()) {
                $leaveDetails = SmLeaveRequest::find($id);
            } else {
                $leaveDetails = SmLeaveRequest::where('id', $id)->where('school_id', Auth::user()->school_id)->first();
            }
            $staff_leaves = SmLeaveDefine::where('user_id', $leaveDetails->staff_id)->where('role_id', $leaveDetails->role_id)->get();


            return view('backEnd.humanResource.viewLeaveDetails', compact('leaveDetails', 'staff_leaves'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
