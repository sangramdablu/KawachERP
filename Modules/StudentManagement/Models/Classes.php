<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\StudentManagement\Database\Factories\ClassesFactory;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'class_name','class_code','class_teacher_id','section','description',
        'total_students','total_subjects','status','created_by','updated_by','deleted_by'
    ];

    /* Class → Subjects Many to Many */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class,'class_subject','class_id','subject_id');
    }

    /* Class → Teacher (Class Teacher One-to-One/BelongsTo) */
    public function teacher()
    {
        return $this->belongsTo(Teachers::class,'class_teacher_id');
    }

    /* Class → Students Many to Many (Future use) */
    public function students()
    {
        return $this->belongsToMany(Student::class,'class_student','class_id','student_id');
    }
}



// class Classes extends Model
// {
//     use HasFactory;

//     /**
//      * The attributes that are mass assignable.
//      */
//     protected $table = 'class_subject';
//     protected $fillable = ['class_id','subject_id'];

//     public function subjects()
//     {
//         return $this->belongsToMany(Subject::class, 'class_subject');
//     }

// }
