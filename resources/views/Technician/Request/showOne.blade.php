@extends("layouts.app")
@section('title', 'Service Request Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .request-details {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 24px;
            padding: 40px;
            margin: 30px 0;
            box-shadow: 0 10px 50px rgba(0,0,0,0.08);
            border: 1px solid rgba(226, 232, 240, 0.6);
            position: relative;
            overflow: hidden;
        }

        .request-details::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.04) 0%, transparent 70%);
            animation: pulse 20s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1) rotate(0deg); opacity: 0.5; }
            50% { transform: scale(1.15) rotate(180deg); opacity: 0.8; }
        }

        .detail-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
            border-radius: 20px;
            padding: 35px;
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(37, 99, 235, 0.3);
        }

        .detail-header::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.15) 50%, transparent 70%);
            animation: shimmer 4s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .detail-header h2 {
            color: white;
            font-size: 32px;
            font-weight: 800;
            margin: 0;
            text-shadow: 0 4px 12px rgba(0,0,0,0.2);
            position: relative;
            z-index: 1;
        }

        /* Status Badges - Premium Design */
        .status-badge {
            padding: 14px 28px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
            text-transform: uppercase;
            letter-spacing: 1px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .status-badge:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 12px 35px rgba(0,0,0,0.25);
        }

        .status-badge.status-pending {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #78350f;
        }

        .status-badge.status-assigned {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            color: white;
        }

        .status-badge.status-in_progress {
            background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
            color: white;
        }

        .status-badge.status-waiting_for_approval {
            background: linear-gradient(135deg, #c084fc 0%, #a855f7 100%);
            color: white;
        }

        .status-badge.status-approved_for_repair {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            color: white;
        }

        .status-badge.status-issue_reported {
            background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
            color: white;
            animation: pulseAlert 2s ease-in-out infinite;
        }

        .status-badge.status-rescheduled {
            background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
            color: white;
        }

        .status-badge.status-completed {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            color: white;
        }

        .status-badge.status-canceled {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: white;
        }

        @keyframes pulseAlert {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 6px 20px rgba(249, 115, 22, 0.3);
            }
            50% {
                transform: scale(1.08);
                box-shadow: 0 10px 35px rgba(249, 115, 22, 0.5);
            }
        }

        /* Issue Alert Banner - Ultra Prominent */
        .issue-alert-banner {
            background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%);
            border: 4px solid #f97316;
            border-radius: 20px;
            padding: 35px;
            margin: 30px 0;
            box-shadow: 0 15px 60px rgba(249, 115, 22, 0.3);
            animation: slideInBounce 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
        }

        .issue-alert-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: alertShine 3s infinite;
        }

        @keyframes slideInBounce {
            0% {
                opacity: 0;
                transform: translateY(-50px) scale(0.8);
            }
            60% {
                transform: translateY(10px) scale(1.05);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes alertShine {
            0% { left: -100%; }
            100% { left: 200%; }
        }

        .issue-alert-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 3px solid #f97316;
            position: relative;
            z-index: 1;
        }

        .issue-alert-icon {
            font-size: 56px;
            animation: shake 1.5s ease-in-out infinite;
            filter: drop-shadow(0 4px 8px rgba(249, 115, 22, 0.3));
        }

        @keyframes shake {
            0%, 100% { transform: rotate(0deg); }
            10%, 30%, 50%, 70%, 90% { transform: rotate(-12deg); }
            20%, 40%, 60%, 80% { transform: rotate(12deg); }
        }

        .issue-alert-title h3 {
            color: #ea580c;
            font-size: 28px;
            margin: 0 0 8px 0;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .issue-alert-subtitle {
            color: #c2410c;
            font-size: 15px;
            font-weight: 600;
            margin: 0;
        }

        .issue-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 25px 0;
            position: relative;
            z-index: 1;
        }

        .issue-detail-box {
            background: white;
            padding: 20px;
            border-radius: 16px;
            border-left: 5px solid #f97316;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .issue-detail-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.2);
        }

        .issue-detail-label {
            font-size: 11px;
            color: #6b7280;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 10px;
        }

        .issue-detail-value {
            font-size: 16px;
            color: #1f2937;
            font-weight: 700;
        }

        .issue-report-text {
            background: white;
            padding: 25px;
            border-radius: 16px;
            margin: 20px 0;
            border-left: 5px solid #f97316;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            position: relative;
            z-index: 1;
        }

        .issue-report-text p {
            color: #374151;
            line-height: 1.9;
            margin: 0;
            font-size: 16px;
            font-weight: 500;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .detail-item {
            padding: 25px;
            background: white;
            border-radius: 16px;
            border: 2px solid transparent;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }

        .detail-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #2563eb 0%, #8b5cf6 100%);
            transition: width 0.4s ease;
        }

        .detail-item::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.04) 0%, rgba(139, 92, 246, 0.04) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .detail-item:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 40px rgba(37, 99, 235, 0.2);
            border-color: rgba(37, 99, 235, 0.3);
        }

        .detail-item:hover::before {
            width: 100%;
        }

        .detail-item:hover::after {
            opacity: 1;
        }

        .detail-label {
            font-size: 11px;
            color: #6b7280;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 12px;
            display: block;
            position: relative;
            z-index: 1;
        }

        .detail-value {
            font-size: 18px;
            color: #1f2937;
            font-weight: 700;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        .phone-link {
            color: #2563eb;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 700;
        }

        .phone-link:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .map-container {
            margin: 35px 0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,0.12);
            border: 3px solid #e5e7eb;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
        }

        .map-container:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 70px rgba(37, 99, 235, 0.2);
            border-color: #2563eb;
        }

        .map-container iframe {
            width: 100%;
            height: 500px;
            border: none;
            display: block;
            filter: grayscale(10%);
            transition: filter 0.3s ease;
        }

        .map-container:hover iframe {
            filter: grayscale(0%);
        }

        /* Status Change & Form Sections */
        .status-change-section,
        .issue-report-section,
        .inspection-report-section,
        .awaiting-approval-section {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            padding: 35px;
            border-radius: 20px;
            margin-top: 35px;
            border: 3px solid #e5e7eb;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .issue-report-section {
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
            border-color: #fb923c;
        }

        .inspection-report-section {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-color: #4ade80;
        }

        .awaiting-approval-section {
            background: linear-gradient(135deg, #fefce8 0%, #fef9c3 100%);
            border-color: #facc15;
        }

        .status-change-section h3,
        .issue-report-section h3,
        .inspection-report-section h3,
        .awaiting-approval-section h3 {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .issue-report-section h3 {
            color: #ea580c;
        }

        .inspection-report-section h3 {
            color: #16a34a;
        }

        .awaiting-approval-section h3 {
            color: #ca8a04;
        }

        .status-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .status-option input[type="radio"] {
            display: none;
        }

        .status-option label {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: white;
            border: 3px solid #e5e7eb;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .status-option input[type="radio"]:checked + label {
            border-color: #2563eb;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.25);
        }

        .status-option label:hover {
            border-color: #60a5fa;
            background: #f0f9ff;
            transform: translateY(-3px);
        }

        .status-icon {
            font-size: 32px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .status-text {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .status-name {
            font-size: 16px;
            color: #1f2937;
        }

        .status-desc {
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group label span {
            color: #ef4444;
        }

        .form-group select,
        .form-group textarea,
        .form-group input {
            width: 100%;
            padding: 15px 18px;
            border: 3px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            font-family: inherit;
            background: white;
        }

        .form-group select:focus,
        .form-group textarea:focus,
        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            transform: translateY(-2px);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        .form-group small {
            color: #6b7280;
            font-size: 13px;
            margin-top: 8px;
            display: block;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 16px 36px;
            border: none;
            border-radius: 14px;
            font-size: 17px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.4);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn span {
            position: relative;
            z-index: 1;
        }

        .btn-update {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            border: 2px solid rgba(37, 99, 235, 0.3);
        }

        .btn-update:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 12px 35px rgba(37, 99, 235, 0.4);
        }

        .btn-report {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: 2px solid rgba(245, 158, 11, 0.3);
        }

        .btn-report:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 12px 35px rgba(245, 158, 11, 0.4);
        }

        .btn-inspection {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: 2px solid rgba(16, 185, 129, 0.3);
        }

        .btn-inspection:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 12px 35px rgba(16, 185, 129, 0.4);
        }

        .btn-back {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            border: 2px solid rgba(107, 114, 128, 0.3);
        }

        .btn-back:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 12px 35px rgba(107, 114, 128, 0.4);
        }

        .btn:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
        }

        .description-box,
        .alert-box {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 30px;
            border-radius: 16px;
            margin: 25px 0;
            border-left: 5px solid #2563eb;
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.12);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .alert-box.danger {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-left-color: #ef4444;
        }

        .alert-box.success {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-left-color: #22c55e;
        }

        .description-box:hover,
        .alert-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(37, 99, 235, 0.18);
        }

        .description-box h3,
        .alert-box h3 {
            color: #1f2937;
            margin-bottom: 15px;
            font-size: 22px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-box.danger h3 {
            color: #dc2626;
        }

        .alert-box.success h3 {
            color: #16a34a;
        }

        .description-box p,
        .alert-box p {
            color: #374151;
            line-height: 1.9;
            font-size: 16px;
            font-weight: 500;
        }

        .alert-info-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            padding: 18px 24px;
            border-radius: 12px;
            margin: 20px 0;
            border-left: 5px solid #3b82f6;
            color: #1e40af;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.15);
        }

        .request-image {
            max-width: 100%;
            border-radius: 20px;
            margin: 25px 0;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            transition: transform 0.3s ease;
        }

        .request-image:hover {
            transform: scale(1.02);
        }

        .cost-summary-box {
            background: linear-gradient(135deg, #fefce8 0%, #fef3c7 100%);
            padding: 30px;
            border-radius: 20px;
            margin: 25px 0;
            border: 3px solid #facc15;
            box-shadow: 0 8px 30px rgba(250, 204, 21, 0.2);
        }

        .cost-summary-box h4 {
            color: #ea580c;
            font-size: 22px;
            margin-bottom: 20px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cost-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 2px solid rgba(0,0,0,0.08);
            font-size: 16px;
        }

        .cost-item:last-child {
            border-bottom: none;
            font-size: 22px;
            font-weight: 900;
            color: #ea580c;
            padding-top: 20px;
            border-top: 3px solid #facc15;
            margin-top: 10px;
        }

        .cost-label {
            font-weight: 700;
        }

        .cost-value {
            font-weight: 800;
            color: #ea580c;
        }

        /* Request Image Styling */
        .image-section {
            margin: 35px 0;
            position: relative;
            z-index: 1;
        }

        .image-section h3 {
            color: #1f2937;
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .image-section h3::before {
            content: '🖼️';
            font-size: 32px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .request-image-container {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid #e5e7eb;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        }

        .request-image-container:hover {
            transform: scale(1.02) translateY(-5px);
            box-shadow: 0 25px 70px rgba(37, 99, 235, 0.25);
            border-color: #2563eb;
        }

        .request-image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0) 0%, rgba(124, 58, 237, 0) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
            pointer-events: none;
        }

        .request-image-container:hover::before {
            opacity: 0.1;
        }

        .request-image-container .request-image {
            width: 100%;
            height: auto;
            max-height: 600px;
            object-fit: contain;
            display: block;
            transition: transform 0.3s ease;
            padding: 15px;
        }

        .request-image-container:hover .request-image {
            transform: scale(1.02);
        }

        .image-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }

        .image-badge::before {
            content: '📸';
            font-size: 16px;
        }

        @media (max-width: 968px) {
            .request-details {
                padding: 30px;
            }

            .detail-header {
                padding: 30px;
            }

            .detail-header h2 {
                font-size: 28px;
            }
        }

        @media (max-width: 768px) {
            .request-details {
                padding: 25px;
                border-radius: 20px;
            }

            .detail-header {
                padding: 25px;
                flex-direction: column;
                align-items: flex-start;
            }

            .detail-header h2 {
                font-size: 24px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .status-options {
                grid-template-columns: 1fr;
            }

            .issue-details-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .map-container iframe {
                height: 350px;
            }

            .issue-alert-icon {
                font-size: 48px;
            }
        }

        @media (max-width: 480px) {
            .request-details {
                padding: 20px;
                border-radius: 16px;
            }

            .detail-header {
                padding: 20px;
            }

            .detail-header h2 {
                font-size: 20px;
            }

            .status-badge {
                padding: 12px 24px;
                font-size: 13px;
            }

            .btn {
                padding: 14px 28px;
                font-size: 15px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-wrapper">
        @include('layouts.sidebar_admin')

        <main class="main-content">
            <header class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle" id="menuToggle">☰</button>
                    <h1 class="page-title">Service Request Details</h1>
                </div>
                <div class="topbar-right">
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff" alt="Technician">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            @include('layouts.message_admin')

            <div class="request-details">
                <div class="detail-header">
                    <h2>Request # {{ $order->title }}</h2>
                    <span class="status-badge status-{{ strtolower($order->status) }}">
                        @switch($order->status)
                            @case('pending')
                                ⏳ Pending
                                @break
                            @case('assigned')
                                👤 Assigned
                                @break
                            @case('in_progress')
                                🔄 In Progress
                                @break
                            @case('waiting_for_approval')
                                ⏸️ Waiting for Approval
                                @break
                            @case('approved_for_repair')
                                ✔️ Approved for Repair
                                @break
                            @case('completed')
                                ✅ Completed
                                @break
                            @case('issue_reported')
                                ⚠️ Issue Reported
                                @break
                            @case('rescheduled')
                                📅 Rescheduled
                                @break
                            @case('canceled')
                                ❌ Canceled
                                @break
                            @default
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        @endswitch
                    </span>
                </div>

                {{-- ISSUE ALERT BANNER --}}
                @if($order->status == 'issue_reported' && $order->issue_type)
                <div class="issue-alert-banner">
                    <div class="issue-alert-header">
                        <div class="issue-alert-icon">⚠️</div>
                        <div class="issue-alert-title">
                            <h3>🚨 Issue Reported - Awaiting Admin Response</h3>
                            <p class="issue-alert-subtitle">You have reported an issue with this request. Please wait for admin response.</p>
                        </div>
                    </div>

                    <div class="issue-details-grid">
                        <div class="issue-detail-box">
                            <div class="issue-detail-label">Issue Type</div>
                            <div class="issue-detail-value">
                                @switch($order->issue_type)
                                    @case('missing_parts')
                                        🔧 Missing Parts/Tools
                                        @break
                                    @case('technical_difficulty')
                                        ⚙️ Technical Difficulty
                                        @break
                                    @case('client_unavailable')
                                        👤 Client Unavailable
                                        @break
                                    @case('additional_work')
                                        📋 Additional Work Required
                                        @break
                                    @case('other')
                                        📝 Other Issue
                                        @break
                                    @default
                                        {{ $order->issue_type }}
                                @endswitch
                            </div>
                        </div>

                        @if($order->issue_reported_at)
                        <div class="issue-detail-box">
                            <div class="issue-detail-label">Reported At</div>
                            <div class="issue-detail-value">
                                📅 {{ $order->issue_reported_at->format('d M Y, h:i A') }}
                            </div>
                        </div>
                        @endif

                        <div class="issue-detail-box">
                            <div class="issue-detail-label">Current Status</div>
                            <div class="issue-detail-value" style="color: #ea580c;">
                                ⏳ Waiting for Admin Action
                            </div>
                        </div>
                    </div>

                    @if($order->technician_report)
                    <div class="issue-report-text">
                        <div class="issue-detail-label">Your Report Details</div>
                        <p>{{ $order->technician_report }}</p>
                    </div>
                    @endif

                    <div class="alert-info-box" style="background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%); border-left-color: #f97316; color: #ea580c;">
                        <strong>💡 What's Next:</strong> The admin will review your issue and either reschedule the request or provide further instructions. You will be notified once a decision is made.
                    </div>
                </div>
                @endif

                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">👤 Client Name</span>
                        <span class="detail-value">{{ $order->client->user->name }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">📱 Client Phone</span>
                        <span class="detail-value">
                            @if($order->client->user->phone)
                                <a href="tel:{{ $order->client->user->phone }}" class="phone-link">
                                    {{ $order->client->user->phone }}
                                </a>
                            @else
                                N/A
                            @endif
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">🔧 Service Category</span>
                        <span class="detail-value">{{ $order->category->name }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">📅 Request Date</span>
                        <span class="detail-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">📍 Address</span>
                        <span class="detail-value">{{ $order->address }}</span>
                    </div>

                    @if($order->title)
                    <div class="detail-item">
                        <span class="detail-label">📋 Title</span>
                        <span class="detail-value">{{ $order->title }}</span>
                    </div>
                    @endif

                    @if($order->inspection_fee)
                    <div class="detail-item" style="border-left-color: #facc15;">
                        <span class="detail-label">💰 Inspection Fee</span>
                        <span class="detail-value" style="color: #ea580c; font-size: 22px;">
                            {{ number_format($order->inspection_fee, 2) }} EGP
                        </span>
                    </div>
                    @endif

                    @if($order->completed_at)
                    <div class="detail-item">
                        <span class="detail-label">✅ Completed At</span>
                        <span class="detail-value">{{ $order->completed_at->format('d M Y, h:i A') }}</span>
                    </div>
                    @endif
                </div>

                @if($order->description)
                <div class="description-box">
                    <h3>📝 Description</h3>
                    <p>{{ $order->description }}</p>
                </div>
                @endif

                @if($order->repair_cost && $order->technician_report)
                <div class="alert-box success">
                    <h3>🔍 Inspection Report Submitted</h3>
                    <p><strong>Report:</strong><br>{{ $order->technician_report }}</p>

                    <div class="cost-summary-box" style="margin-top: 25px;">
                        <h4>💰 Cost Breakdown</h4>
                        <div class="cost-item">
                            <span class="cost-label">Inspection Fee:</span>
                            <span class="cost-value">{{ number_format($order->inspection_fee ?? 0, 2) }} EGP</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Repair Cost:</span>
                            <span class="cost-value">{{ number_format($order->repair_cost, 2) }} EGP</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Total Amount:</span>
                            <span class="cost-value">{{ number_format(($order->inspection_fee ?? 0) + $order->repair_cost, 2) }} EGP</span>
                        </div>
                    </div>

                    @if($order->client_approved === null)
                    <div class="alert-info-box">
                        ⏳ <strong>Status:</strong> Waiting for client approval
                    </div>
                    @elseif($order->client_approved === 1)
                    <div class="alert-info-box" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left-color: #22c55e; color: #16a34a;">
                        ✅ <strong>Approved:</strong> Client has approved the repair cost. You can proceed with the work.
                    </div>
                    @else
                    <div class="alert-info-box" style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border-left-color: #ef4444; color: #dc2626;">
                        ❌ <strong>Rejected:</strong> Client has rejected the repair cost.
                    </div>
                    @endif
                </div>
                @endif

                @if($order->status == 'canceled' && $order->technician_report)
                <div class="alert-box danger">
                    <h3>❌ Cancellation Report</h3>
                    <p>{{ $order->technician_report }}</p>
                </div>
                @endif

                {{-- @if($order->image)
                <div class="image-section">
                    <h3>Request Image</h3>
                    <div class="request-image-container">
                        <div class="image-badge">Attached</div>
                        <img src="{{ asset($order->image) }}" alt="Request Image" class="request-image">
                    </div>
                </div>
                @endif --}}

                @if($order->image)
                <div class="image-section">
                    <h3>Request Image</h3>
                    <div class="request-image-container">
                        <div class="image-badge">Attached</div>
                        <img src="{{ asset($order->image) }}" alt="Request Image" class="request-image">
                    </div>
                </div>
                @endif

                @if($order->latitude && $order->longitude)
                <div>
                    <h3 style="color: #1f2937; margin: 30px 0 20px; font-size: 24px; font-weight: 800;">📍 Location</h3>
                    <div class="map-container">
                        <iframe
                            src="https://maps.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&hl=en&z=15&output=embed"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
                @endif

                @if($order->status == 'in_progress' && !$order->repair_cost)
                <div class="inspection-report-section">
                    <h3>🔍 Submit Inspection Report</h3>
                    <p style="color: #16a34a; margin-bottom: 25px; font-size: 15px; font-weight: 600;">
                        After inspecting the issue, submit your report including the estimated repair cost.
                    </p>

                    <form action="{{ route('technician_request.submit_inspection', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="inspection_report">Inspection Report <span>*</span></label>
                            <textarea
                                name="technician_report"
                                id="inspection_report"
                                placeholder="Describe the issue found during inspection and what needs to be repaired..."
                                required
                            >{{ old('technician_report') }}</textarea>
                            <small>Explain the problem and the required repair work</small>
                        </div>

                        <div class="form-group">
                            <label for="repair_cost">Estimated Repair Cost (EGP) <span>*</span></label>
                            <input
                                type="number"
                                name="repair_cost"
                                id="repair_cost"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                value="{{ old('repair_cost') }}"
                                required
                            >
                            <small>Enter the total cost for repair work (excluding inspection fee)</small>
                        </div>

                        <div class="alert-info-box">
                            <strong>📋 Note:</strong> After submitting this report, the client will be notified and must approve the repair cost before you can proceed with the work.
                        </div>

                        <div class="action-buttons">
                            <button type="submit" class="btn btn-inspection" onclick="return confirm('Are you sure you want to submit this inspection report? The client will be notified.')">
                                <span>📋 Submit Inspection Report</span>
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                @if($order->repair_cost && $order->client_approved === null)
                <div class="awaiting-approval-section">
                    <h3>⏳ Awaiting Client Approval</h3>
                    <p style="color: #92400e; margin-bottom: 20px; font-weight: 600;">
                        Your inspection report has been submitted. Please wait for the client to review and approve the repair cost.
                    </p>
                    <div class="alert-info-box">
                        <strong>💡 Tip:</strong> You will be notified once the client makes a decision.
                    </div>
                </div>
                @endif

                @if($order->repair_cost && $order->client_approved === 1 && $order->status != 'completed')
                <div class="status-change-section" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-color: #22c55e;">
                    <h3 style="color: #16a34a;">✅ Client Approved - Start Repair Work</h3>
                    <p style="color: #16a34a; margin-bottom: 25px; font-weight: 600;">
                        The client has approved the repair cost. You can now complete the repair work.
                    </p>

                    <form action="{{ route('technician_request.update_status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="completed">

                        <div class="action-buttons">
                            <button type="submit" class="btn btn-update" onclick="return confirm('Have you completed the repair work?')">
                                <span>✅ Mark as Completed</span>
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                @if($order->status != 'completed' && $order->status != 'canceled' && $order->status != 'issue_reported' && !$order->repair_cost)
                <div class="status-change-section">
                    <h3>🔄 Update Request Status</h3>

                    <form action="{{ route('technician_request.update_status', $order->id) }}" method="POST" id="statusForm">
                        @csrf
                        @method('PUT')

                        <div class="status-options">
                            @if($order->status == 'assigned' || $order->status == 'rescheduled')
                            <div class="status-option">
                                <input type="radio" name="status" value="in_progress" id="status_in_progress" checked>
                                <label for="status_in_progress">
                                    <span class="status-icon">🔄</span>
                                    <span class="status-text">
                                        <span class="status-name">Start Working</span>
                                        <span class="status-desc">
                                            @if($order->status == 'rescheduled')
                                                Resume the rescheduled work
                                            @else
                                                Mark as In Progress
                                            @endif
                                        </span>
                                    </span>
                                </label>
                            </div>
                            @endif
                        </div>

                        <div class="action-buttons">
                            <button type="submit" class="btn btn-update" onclick="return confirm('Are you sure you want to update the status?')">
                                <span>💾 Update Status</span>
                            </button>
                            <a href="{{ route('technician_request.myRequests') }}" class="btn btn-back">
                                <span>← Back to My Requests</span>
                            </a>
                        </div>
                    </form>
                </div>

                @if($order->status == 'in_progress')
                <div class="issue-report-section">
                    <h3>⚠️ Report an Issue</h3>
                    <p style="color: #92400e; margin-bottom: 25px; font-size: 15px; font-weight: 600;">
                        If you're facing any problems during the service, report them here. The admin will be notified.
                    </p>

                    <form action="{{ route('technician_request.report_issue', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="issue_type">Issue Type <span>*</span></label>
                            <select name="issue_type" id="issue_type" required>
                                <option value="">Select issue type...</option>
                                <option value="missing_parts">🔧 Missing Parts/Tools</option>
                                <option value="technical_difficulty">⚙️ Technical Difficulty</option>
                                <option value="client_unavailable">👤 Client Unavailable</option>
                                <option value="additional_work">📋 Additional Work Required</option>
                                <option value="other">📝 Other Issue</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="technician_report">Detailed Report <span>*</span></label>
                            <textarea
                                name="technician_report"
                                id="technician_report"
                                placeholder="Please describe the issue in detail..."
                                required
                            ></textarea>
                        </div>

                        <div class="action-buttons">
                            <button type="submit" class="btn btn-report" onclick="return confirm('Are you sure you want to report this issue? The admin will be notified.')">
                                <span>📋 Submit Issue Report</span>
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                @elseif($order->status == 'issue_reported')
                <div class="action-buttons" style="margin-top: 35px; padding-top: 30px; border-top: 3px solid #e5e7eb;">
                    <a href="{{ route('technician_request.myRequests') }}" class="btn btn-back">
                        <span>← Back to My Requests</span>
                    </a>
                </div>

                @else
                <div class="action-buttons" style="margin-top: 35px; padding-top: 30px; border-top: 3px solid #e5e7eb;">
                    <a href="{{ route('technician_request.myRequests') }}" class="btn btn-back">
                        <span>← Back to My Requests</span>
                    </a>
                </div>
                @endif
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-format repair cost input
            const repairCostInput = document.getElementById('repair_cost');
            if (repairCostInput) {
                repairCostInput.addEventListener('blur', function() {
                    if (this.value) {
                        this.value = parseFloat(this.value).toFixed(2);
                    }
                });
            }

            // Highlight and scroll to issue banner if exists
            const issueBanner = document.querySelector('.issue-alert-banner');
            if (issueBanner) {
                setTimeout(() => {
                    issueBanner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 600);
            }

            // Add smooth transitions to all form inputs
            const inputs = document.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                input.addEventListener('blur', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endsection
