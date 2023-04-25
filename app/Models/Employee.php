<?php

namespace App\Models;

use App\Enums\CheckInMode;
use App\Models\Scopes\EmployeeScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;
    use RevisionableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_code',

        'user_id',
        'manager_id',
        'department_id',
        'designation_id',

        // Personal
        'first_name',
        'middle_name',
        'last_name',
        'gender', // ['male', 'female', 'other']
        'date_of_birth',
        'birthday',
        'blood_group', // ['A+', 'A−', 'B+', 'B−', 'AB+', 'AB−', 'O+', 'O−']
        'nationality',
        'country_of_birth',
        // Family
        'marital_status', // ['married', 'unmarried']
        'marriage_anniversary',
        'spouse_first_name',
        'spouse_middle_name',
        'spouse_last_name',
        'spouse_date_of_birth',
        'spouse_birthday',
        'number_of_children',
        // Education
        'field_of_study',
        'highest_degree',
        // Identity
        'passport_number',
        'uan',
        'aadhaar_number',
        'pan_number',
        'driving_license_number',
        'voter_id',
        // Contact
        'work_email',
        'work_phone_1',
        'work_phone_2',
        'present_address_line_1',
        'present_address_line_2',
        'present_address_city',
        'present_address_state',
        'present_address_post_code',
        'present_address_country',
        // Personal Contact
        'personal_email',
        'personal_phone',
        'emergency_contact_name',
        'emergency_contact_relation',
        'emergency_contact_phone',
        'permanent_address_line_1',
        'permanent_address_line_2',
        'permanent_address_city',
        'permanent_address_state',
        'permanent_address_post_code',
        'permanent_address_country',
        // Financial
        'bank_account_number',
        'bank_name',
        'bank_ifsc_code',
        'bank_micr_code',
        'bank_swift_code',
        'bank_iban_code',
        'bank_address_line_1',
        'bank_address_line_2',
        'bank_address_city',
        'bank_address_state',
        'bank_address_post_code',
        'bank_address_country',
        'bank_phone',
        'bank_email',
        'check_in_mode',
    ];

    public function getAverageTimeOfArrival($date = null)
    {
        if (empty($date)) $date = now()->format("Y-m-01");
        $date = \Carbon\Carbon::parse($date)->format("Y-m-01");

        $average_time_of_arrival = DB::table('attendances', 'att1')
            ->join('attendances as att2', 'att1.id', '=', 'att2.id')
            ->where('att1.employee_id', $this->id)
            ->where(DB::raw('TIME_TO_SEC(att1.check_in)'), '<', 23400)
            ->selectRaw('DATE(att2.check_in) AS check_in_date,
                            att2.employee_id,
                            TIME_TO_SEC(DATE_FORMAT(MIN(att2.check_in),"%H:%i:%s")) AS check_in_time')
            ->groupByRaw('check_in_date, att2.employee_id')
            ->havingBetween('check_in_date', [$date, today()->addDay()])
            ->groupByRaw('att1.employee_id')
            ->avg('check_in_time');

        if ($average_time_of_arrival !== null) {
            return Carbon::parse($average_time_of_arrival)->tz(config('app.user_timezone'))->format('h:i A');
        }

        return null;
    }

    public function getAverageTimeOfArrivalStatus()
    {
        $average_time_of_arrival = $this->getAverageTimeOfArrival();
        $average_time_of_arrival_sec = \Carbon\Carbon::parse($average_time_of_arrival)->secondsSinceMidnight();
        if ($average_time_of_arrival_sec <= 28800) {
            return "early";
        } elseif ($average_time_of_arrival_sec > 28800 && $average_time_of_arrival_sec <= 32400) {
            return "ontime1";
        } elseif ($average_time_of_arrival_sec > 32400 && $average_time_of_arrival_sec <= 34200) {
            return "ontime2";
        } elseif ($average_time_of_arrival_sec > 34200 && $average_time_of_arrival_sec <= 36000) {
            return "late";
        } elseif ($average_time_of_arrival_sec > 36000) {
            return "superlate";
        }
    }

    protected static function booted()
    {
        static::addGlobalScope(new EmployeeScope);
    }

    public static function import_data($employees_data)
    {
        $employees_table_cols = Schema::getColumnListing(app(Employee::class)->getTable());
        $usable_employees_data = [];
        foreach ($employees_data as $employee_data) {
            if (!isset($employee_data['employee_code']) || empty($employee_data['employee_code'])) {
                continue;
            }
            $employee_code = $employee_data['employee_code'];
            $existing_employee = Employee::where('employee_code', $employee_code);
            $emp_data = array_filter($employee_data, function ($v, $k) use ($employees_table_cols) {
                return in_array($k, $employees_table_cols) !== FALSE;
            }, ARRAY_FILTER_USE_BOTH);
            $first_name = $emp_data['first_name'];
            $last_name = (isset($emp_data['middle_name']) && !empty($emp_data['middle_name'])) ? " {$emp_data['middle_name']} {$emp_data['last_name']}" : $emp_data['last_name'];
            $existing_user_id = User::where('email', $emp_data['work_email'])->pluck('id')->first();
            $emp_data['user_id'] = !empty($existing_user_id) ? $existing_user_id : User::factory()->create([
                'name' => "{$first_name} {$last_name}",
                'email' => $emp_data['work_email'],
                'password' => Hash::make(md5(uniqid()))
            ])->assignRole('employee')->id;
            $emp_data['department_id'] = Department::where('name', $employee_data['department'])->pluck('id')->first();
            $emp_data['designation_id'] = Designation::where('name', $employee_data['designation'])->pluck('id')->first();
            $usable_employees_data[$employee_data['employee_code']] = $emp_data;
            $usable_employees_data[$employee_data['employee_code']]['_operation'] = "ignore";
            if ($existing_employee->count() < 1) {
                $usable_employees_data[$employee_data['employee_code']]['_operation'] = "create";
            } elseif ($existing_employee->first()->updated_at->lt($employee_data['_updated_at'])) {
                $usable_employees_data[$employee_data['employee_code']]['_operation'] = "update";
            }
        }
        $status = [];
        foreach ($usable_employees_data as $employee_code => $usable_employee_data) {
            $status[$employee_code] = "ignored";
            $employee_data = array_filter($usable_employee_data, function ($v, $k) {
                return $k[0] != "_";
            }, ARRAY_FILTER_USE_BOTH);
            if ($usable_employee_data['_operation'] == "create") {
                $status[$employee_code] = "created";
                Employee::create($employee_data);
            } elseif ($usable_employee_data['_operation'] == "update") {
                $status[$employee_code] = "updated";
                Employee::where('employee_code', $employee_code)->update($employee_data);
            }
        }
        foreach ($employees_data as $employee_data) {
            if (!isset($employee_data['employee_code']) || empty($employee_data['employee_code'])) {
                continue;
            }
            $employee_code = $employee_data['employee_code'];
            $manager_employee_code = isset($employee_data['manager_employee_code']) && !empty($employee_data['manager_employee_code']) ? $employee_data['manager_employee_code'] : null;
            if (!empty($manager_employee_code)) {
                $manager_id = Employee::where('employee_code', $manager_employee_code)->pluck('id')->first();
                Employee::where('employee_code', $employee_code)->update(['manager_id' => $manager_id]);
                $status[$employee_code] .= " / manager updated";
            }
        }
        return $status;
    }

    /**
     * This employee has many employees who have this employee as their manager.
     *
     * @return A collection of Employee objects.
     */
    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    /**
     * The manager() function returns the Employee model that is related to the current Employee model
     *
     * @return The manager of the employee.
     */
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    /**
     * > This function returns the designation of the user
     *
     * @return The designation for the employee.
     */
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    /**
     * > This function returns the user that owns the post
     *
     * @return The user that created the question.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * > This function returns the department that owns the post
     *
     * @return The department that created the question.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }


    /**
     * > This function returns the attendances of the employee
     *
     * @return The attendances for the employee.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function clocked_in()
    {
        return $this->attendances()->where('check_out', null)->count() > 0;
    }

    public function clocked_out()
    {
        return $this->attendances()->where('check_out', null)->count() < 1;
    }

    // function to get latest attendance record of the employee
    public function getLastClockTypeAndTime()
    {
        $latest_record = $this->attendances()->latest()->first();
        $time = $latest_record->check_out ?? $latest_record->check_in;
        $type = $latest_record->check_out ? 'out' : 'in';

        // set checkin mode
        $mode = $latest_record->{'check_'.$type.'_device_id'} ? CheckInMode::DEVICE()->description : CheckInMode::WEB()->description;

        // format timezone.
        $time = Carbon::parse($time)->tz(config('app.user_timezone'))->format('M d, h:i A');
        return __("cranberry-punch::cranberry-punch.attendance-kiosk.widget.last-attendance-record-time", ["type" => $type, 'time' => $time, 'mode' => $mode]);
    }

    public function attendance_clock()
    {
        $unchecked_out_attendances_count = $this->attendances()->where('check_out', null)->count();
        $now = now();
        if ($unchecked_out_attendances_count == 1) {
            $unchecked_out_attendance = $this->attendances()->where('check_out', null)->first();
            $last_check_in = Carbon::parse($unchecked_out_attendance->check_in);
            if ($last_check_in->diffInHours($now) > 16) {
                $check_out_time = Carbon::parse($unchecked_out_attendance->check_in)->addHours(9);
                if ($check_out_time->gt($now)) {
                    $check_out_time = $now;
                }
                $unchecked_out_attendance->update([
                    'check_out' => $check_out_time
                ]);
                Attendance::create([
                    'user_id' => $this->user_id,
                    'employee_id' => $this->id,
                    'check_in' => $now
                ]);
            } else {
                $unchecked_out_attendance->update([
                    'check_out' => $now
                ]);
            }
        } elseif ($unchecked_out_attendances_count > 1) {
            $unchecked_out_attendances = $this->attendances()->where('check_out', null);
            $unchecked_out_attendances
                ->update([
                    'check_out' => DB::raw('check_in')
                ]);
            Attendance::create([
                'user_id' => $this->user_id,
                'employee_id' => $this->id,
                'check_in' => $now
            ]);
        } else {
            Attendance::create([
                'user_id' => $this->user_id,
                'employee_id' => $this->id,
                'check_in' => $now
            ]);
        }
    }

    /**
     * > This function returns the leaveRequests of the employee
     *
     * @return The leaveRequests for the employee.
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /**
     * > This function returns the leaveBalances of the employee
     *
     * @return The leaveBalances for the employee.
     */

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }
}
