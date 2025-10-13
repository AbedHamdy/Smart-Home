@if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'technician'))
    <div class="notification-wrapper" style="position: relative; display: inline-block;">
        <button class="notification-btn"
            style="position: relative; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 10px 15px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px;">
            <span style="font-size: 20px;">🔔</span>
            @if (auth()->user()->unreadNotifications->count() > 0)
                <span class="badge"
                    style="position: absolute; top: -5px; right: -5px; background: #dc3545; color: white; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </button>

        <div class="notification-dropdown"
            style="display: none; position: absolute; right: 0; top: calc(100% + 8px); background: white; border: 1px solid #dee2e6; border-radius: 12px; width: 350px; max-height: 450px; overflow-y: auto; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            <div
                style="padding: 15px; border-bottom: 2px solid #f8f9fa; background: #f8f9fa; border-radius: 12px 12px 0 0;">
                <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #212529;">Notifications</h3>
            </div>

            @forelse(auth()->user()->notifications()->latest()->take(3)->get() as $notification)
                {{-- @dd($notification->id); --}}
                <a href="{{ route('notification.read', $notification->id) }}" class="notification-item"
                    data-notification-id="{{ $notification->id }}"
                    style="padding: 15px; border-bottom: 1px solid #f0f0f0; transition: background 0.2s ease; cursor: pointer; display: block; text-decoration: none; {{ $notification->read_at ? 'background: white;' : 'background: #f0f7ff;' }}">
                    <div style="display: flex; align-items: start; gap: 10px;">
                        <div style="flex: 1;">
                            <strong style="display: block; color: #212529; font-size: 14px; margin-bottom: 5px;">
                                {{ $notification->data['title'] ?? 'New Notification' }}
                            </strong>
                            <p style="margin: 0 0 8px 0; color: #6c757d; font-size: 13px; line-height: 1.5;">
                                {{ $notification->data['message'] ?? '' }}
                            </p>
                            <small style="color: #adb5bd; font-size: 12px;">
                                {{ $notification->created_at->diffForHumans() }}
                            </small>
                        </div>
                        @if (!$notification->read_at)
                            <span
                                style="width: 8px; height: 8px; background: #0d6efd; border-radius: 50%; flex-shrink: 0; margin-top: 5px;"></span>
                        @endif
                    </div>
                </a>
            @empty
                <div style="padding: 40px 20px; text-align: center;">
                    <div style="font-size: 48px; margin-bottom: 10px; opacity: 0.3;">🔔</div>
                    <p style="margin: 0; color: #6c757d; font-size: 14px;">No notifications</p>
                </div>
            @endforelse
        </div>
    </div>
@endif
<style>
    .notification-btn:hover {
        background: #e9ecef !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .notification-item:hover {
        background: #f8f9fa !important;
    }

    .notification-dropdown::-webkit-scrollbar {
        width: 6px;
    }

    .notification-dropdown::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .notification-dropdown::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }

    .notification-dropdown::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }
</style>

<script>
    const btn = document.querySelector('.notification-btn');
    const dropdown = document.querySelector('.notification-dropdown');

    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    // إغلاق عند الضغط خارج القائمة
    document.addEventListener('click', (e) => {
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });

    // إغلاق عند الضغط على Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        }
    });

    // تحديد الإشعار كمقروء عند الضغط عليه
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function(e) {
            const notificationId = this.dataset.notificationId;

            // إرسال طلب لتحديد الإشعار كمقروء
            fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(() => {
                // تحديث الواجهة
                this.style.background = 'white';
                const badge = this.querySelector('span[style*="border-radius: 50%"]');
                if (badge) badge.remove();
            });
        });
    });
</script>
