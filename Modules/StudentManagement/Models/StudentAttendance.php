<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\StudentManagement\Database\Factories\StudentAttendanceFactory;

class StudentAttendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'student_attendance';
    protected $fillable = ['student_id','attendance_date','status','marked_by'];

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
