<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\AuditLog;

class AuditLogService
{
    public function log(?Admin $admin, string $action, string $targetType, string $targetId, array $context = []): void
    {
        AuditLog::query()->create([
            'admin_id' => $admin?->id,
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'context_json' => $context,
        ]);
    }
}
