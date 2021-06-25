<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Models\Area;
use App\Models\EmployeeRole;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['area_id','newsletter','name', 'email', 'sex','description'];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

    public function employee_rol()
    {
        return $this->hasMany(EmployeeRole::class, 'employee_id', 'id');
    }

    /**** Public methods ****/
    public function createOrUpdateEmployeeRol(Request $request)
    {
        if ($request->has('roles')) {
            foreach($request->input('roles') as $rol_id){

                $employee_role = new EmployeeRole;
                $employee_role->employee_id = $this->id;
                $employee_role->role_id = $rol_id;
                $employee_role->save();
            }
        }
    }

}