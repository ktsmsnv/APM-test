<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    public function equipment()
    {
        return $this->hasMany(Equipment::class, 'project_num', 'projNum');
    }

    public function smk_main()
    {
        return $this->hasMany(SmkMain::class, 'project_num', 'projNum');
    }
    
    public function smk_sub()
    {
        return $this->hasMany(SmkSub::class, 'project_num', 'projNum');
    }

    public function expenses()
    {
        return $this->hasMany(Expenses::class, 'project_num', 'projNum');
    }

    public function totals()
    {
        return $this->hasMany(Total::class, 'project_num', 'projNum');
    }

    public function markups()
    {
        return $this->hasMany(Markup::class, 'project_num', 'projNum');
    }

    public function contacts()
    {
        return $this->hasMany(contacts::class, 'project_num', 'projNum');
    }

    public function risks()
    {
        return $this->hasMany(Risks::class, 'project_num', 'projNum');
    }
    public function calc_risks()
    {
        return $this->hasMany(CalcRisk::class, 'project_num', 'projNum');
    }
    public function notes()
    {
        return $this->hasMany(Note::class, 'project_num', 'projNum');
    }
    public function basicReference()
    {
        return $this->hasMany(BasicReference::class, 'project_num', 'projNum');
    }

    public function basicInfo()
    {
        return $this->hasMany(BasicInfo::class, 'project_num', 'projNum');
    }
    public function workGroup()
    {
        return $this->hasMany(workGroup::class, 'project_num', 'projNum');
    }
    public function Changes()
    {
        return $this->hasMany(Change::class, 'project_num', 'projNum');
    }
    public function reports()
    {
        return $this->hasMany(Report::class, 'project_num', 'projNum');
    }
    public function report_team()
    {
        return $this->hasMany(ReportTeam::class, 'project_num', 'projNum');
    }
    public function report_reflection()
    {
        return $this->hasMany(ReportReflection::class, 'project_num', 'projNum');
    }
    public function report_notes()
    {
        return $this->hasMany(ReportNotes::class, 'project_num', 'projNum');
    }
}
