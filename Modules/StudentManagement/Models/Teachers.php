<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
// use Modules\StudentManagement\Database\Factories\TeachersFactory;

class Teachers extends Model
{
    use HasRoles;

    protected $table = 'teachers';
    protected $guard_name = 'teacher';

    /**
     * The attributes that are mass assignable.
     */
        protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'dob',
        'gender',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'qualification',
        'experience_years',
        'employee_id',
        'joining_date',
        'designation',
        'status',
        'is_deleted',
        'deleted_at',
        'deleted_by',
        'profile_picture',
        'blood_group',
        'specialization',
        'nationality',
        'religion',
        'language_preference',
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class,'subject_teacher','teacher_id','subject_id');
    }

    /* Teacher → Classes (If teacher is class teacher) */
    public function classAssigned()
    {
        return $this->hasOne(Classes::class,'class_teacher_id');
    }

    // public function subjects()
    // {
    //     return $this->belongsToMany(Subject::class, 'subject_teacher');
    // }

}
