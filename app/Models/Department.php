<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
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
        'name',
        'description',
        'parent_id',
    ];

    /**
     * > This function returns the employees of the user
     *
     * @return The employees for the department.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * The `designations()` function returns all the designations that belong to the department
     *
     * @return A collection of Designation objects.
     */
    public function designations()
    {
        return $this->hasMany(Designation::class);
    }

    /**
     * `parent_department()` is a function that returns a relationship between the current department and
     * the parent department
     *
     * @return A collection of all the departments that have the current department as their parent.
     */
    public function parent_department()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    /**
     * The child_departments() function returns all the departments that have the current department as
     * their parent
     *
     * @return A collection of all the child departments of the current department.
     */
    public function child_departments()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }
}
