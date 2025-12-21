<?php

namespace Modules\StudentManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
// use Modules\StudentManagement\Database\Factories\StudentFactory;

class Student extends Authenticatable
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'students';
    protected $guard_name = 'student';

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
        'guardian_name',
        'guardian_phone',
        'enrollment_number',
        'admission_date',
        'grade',
        'section',
        'is_deleted',
        'deleted_at',
        'deleted_by',
        'profile_picture',
        'birth_certificate_number',
        'blood_group',
        'medical_conditions',
        'nationality',
        'religion',
        'language_preference',
    ];

    public function getConnectionName()
    {
        return session('tenant_connection') ?? config('database.default');
    }


    // protected static function newFactory(): StudentFactory
    // {
    //     // return StudentFactory::new();
    // }
}
