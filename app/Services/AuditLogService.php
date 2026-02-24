<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class AuditLogService
{
    public static function log(string $action, ?string $targetType = null, ?int $targetId = null, ?string $description = null, array $metadata = [])
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'description' => $description,
            'metadata' => $metadata,
        ]);
    }
}
