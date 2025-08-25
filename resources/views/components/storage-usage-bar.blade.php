@php
    $used = $getState()['used'] ?? 0;
    $quota = $getState()['quota'] ?? 1;
    $usedGB = round($used / (1024*1024*1024), 2);
    $quotaGB = round($quota / (1024*1024*1024), 2);
    $percent = $quota > 0 ? min(100, round(($used / $quota) * 100)) : 0;
@endphp
<div style="display: flex; align-items: center; gap: 8px;">
    <span>{{ $usedGB }}/{{ $quotaGB }}GB</span>
    <div style="background: #e5e7eb; border-radius: 8px; width: 100px; height: 10px; overflow: hidden;">
        <div style="background: #4ade80; width: {{ $percent }}%; height: 100%;"></div>
    </div>
</div>
