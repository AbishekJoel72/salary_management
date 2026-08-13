<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = "designations";
    protected $fillable = [
        "department_id",
        "name",
    ];

    public function get_department()
    {
        return $this->belongsTo(Department::class,"department_id","id");
    }
}
