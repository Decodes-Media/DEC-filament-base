<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    public function getSubjectTypeFmtAttribute(): ?string
    {
        return __(@config('base.model_morphs')[$this->subject_type] ?: $this->subject_type);
    }

    public function getCauserTypeFmtAttribute(): ?string
    {
        return __(@config('base.model_morphs')[$this->causer_type] ?: $this->causer_type);
    }
}
