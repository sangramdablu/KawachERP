<?php

namespace App\Models;

use Spatie\Multitenancy\Models\Tenant as BaseTenant;
use Illuminate\Support\Facades\DB;

class Tenant extends BaseTenant
{
    protected $table = 'tenants';

    protected $fillable = [
        'school_name',
        'code',
        'database',
        'username',
        'password',
        'host',
        'port', 
        'slugs',
        'domain',
        'affiliation_no',
        'school_type',
        'address',
        'pincode',
        'principal_name',
        'email',
        'phone',
        'admin_username',
        'admin_password',
    ];

    protected $hidden = [
        'admin_password',
    ];

    /**
     * MUST exactly match Spatie's method signature
     */
    public function makeCurrent(): static
    {
        config([
            'database.connections.tenant.host'     => $this->host,
            'database.connections.tenant.port'     => $this->port,
            'database.connections.tenant.database' => $this->database,
            'database.connections.tenant.username' => $this->username,
            'database.connections.tenant.password' => $this->db_password,
        ]);

        DB::purge('tenant');
        DB::setDefaultConnection('tenant');

        return parent::makeCurrent();
    }

    /**
     * MUST be static
     * MUST return ?static
     * MUST match Spatie’s signature EXACTLY
     */
    public static function forgetCurrent(): ?static
    {
        DB::setDefaultConnection(config('database.default'));

        return parent::forgetCurrent();
    }

    public function setAdminPasswordAttribute($value)
    {
        $this->attributes['admin_password'] = bcrypt($value);
    }
}




    // class Tenant extends Authenticatable
// {
//     use Notifiable;

//     protected $table = 'tenants';
//     protected $fillable = [
//         'school_name', 'code', 'db_database', 'db_username', 'db_password', 'affiliation_no', 'school_type', 'address', 'pincode', 'principal_name',
//         'db_host', 'db_port', 'slugs', 'domain', 'email', 'phone', 'admin_username', 'admin_password',
//     ];

//     protected $hidden = [
//         'admin_password',
//     ];

//     public function makeCurrent()
//     {
//         config([
//             'database.connections.tenant.host'     => $this->host,
//             'database.connections.tenant.port'     => $this->port,
//             'database.connections.tenant.database' => $this->database,
//             'database.connections.tenant.username' => $this->username,
//             'database.connections.tenant.password' => $this->db_password,
//         ]);

//         config(['database.default' => 'tenant']);

//         parent::makeCurrent();
//     }
//     public function setAdminPasswordAttribute($value)
//     {
//         $this->attributes['admin_password'] = bcrypt($value);
//     }

// }

// }

