<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['kelas_id', 'section_id', 'name', 'email'];

    protected $with = ['kelas', 'section'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }
}
