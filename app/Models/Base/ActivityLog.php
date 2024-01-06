<?php

namespace App\Models\Base;

use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    public function getSubjectTypeFmtAttribute(): ?string
    {
        $x = @config('base.model_morphs')[$this->subject_type] ?: $this->subject_type;

        return $x ? __('permission.'.strtolower($x)) : null;
    }

    public function getCauserTypeFmtAttribute(): ?string
    {
        $x = @config('base.model_morphs')[$this->causer_type] ?: $this->causer_type;

        return $x ? __('permission.'.strtolower($x)) : null;
    }
}
