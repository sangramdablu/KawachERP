<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\StudentManagement\Database\Factories\SubjectFactory;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = [
        'subject_name','subject_code','description','credit_hours','status',
        'created_by','updated_by','deleted_by'
    ];

    /* Subject → Classes Many-to-Many */
    public function classes()
    {
        return $this->belongsToMany(Classes::class,'class_subject','subject_id','class_id');
    }

    /* Subject → Teachers Many-to-Many */
    public function teachers()
    {
        return $this->belongsToMany(Teachers::class,'subject_teacher','subject_id','teacher_id');
    }
}


// class Subject extends Model
// {
//     use HasFactory;

//     /**
//      * The attributes that are mass assignable.
//      */
//     protected $table = 'subject_teacher';
//     protected $fillable = ['subject_id','teacher_id'];

//     public function classes()
//     {
//         return $this->belongsToMany(Classes::class, 'class_subject');
//     }
//     public function teachers()
//     {
//         return $this->belongsToMany(Teachers::class, 'subject_teacher');
//     }

// }
