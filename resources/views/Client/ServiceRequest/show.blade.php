@extends('layouts.app')
@section('title', 'Service Request Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --info-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 24px rgba(0,0,0,0.15);
            --shadow-xl: 0 12px 32px rgba(0,0,0,0.2);
            --radius-xl: 24px;
            --radius-lg: 20px;
            --radius-md: 16px;
            --radius-sm: 12px;
        }

        /* Main Container */
        .details-container {
            background: transparent;
            padding: 0;
            transition: all 0.3s ease;
        }

        /* Page Header */
        .page-header-modern {
            background: var(--primary-gradient);
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .page-header-modern::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(10deg); }
        }

        .header-content-wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .header-left-section {
            flex: 1;
            min-width: 300px;
        }

        .header-title-main {
            color: white;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .header-badges-row {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .status-badge-modern {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 0.95rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
            animation: slideInLeft 0.5s ease;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .status-pending { background: rgba(251, 191, 36, 0.95); color: #78350f; }
        .status-assigned { background: rgba(59, 130, 246, 0.95); color: #1e3a8a; }
        .status-in-progress { background: rgba(168, 85, 247, 0.95); color: #581c87; }
        .status-waiting-for-approval { background: rgba(147, 51, 234, 0.95); color: #4c1d95; }
        .status-approved-for-repair { background: rgba(34, 197, 94, 0.95); color: #14532d; }
        .status-completed { background: rgba(16, 185, 129, 0.95); color: #064e3b; }
        .status-issue-reported { background: rgba(249, 115, 22, 0.95); color: #7c2d12; }
        .status-rescheduled { background: rgba(14, 165, 233, 0.95); color: #0c4a6e; }
        .status-canceled { background: rgba(239, 68, 68, 0.95); color: #7f1d1d; }

        .price-badge-modern {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.95);
            padding: 12px 24px;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 800;
            color: #ea580c;
            box-shadow: 0 4px 16px rgba(234, 88, 12, 0.3);
            border: 2px solid rgba(234, 88, 12, 0.2);
            animation: pulse-glow 2s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 4px 16px rgba(234, 88, 12, 0.3); }
            50% { box-shadow: 0 6px 24px rgba(234, 88, 12, 0.5); }
        }

        .header-right-section {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .btn-back-modern {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 12px 24px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 30px;
            color: white;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-back-modern:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
            color: white;
        }

        /* Card System */
        .card-modern {
            background: white;
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0,0,0,0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 0;
            background: var(--primary-gradient);
            transition: height 0.3s ease;
        }

        .card-modern:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .card-modern:hover::before {
            height: 100%;
        }

        .card-header-modern {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .card-icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: var(--shadow-md);
            animation: bounce-subtle 3s ease-in-out infinite;
        }

        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .card-icon-wrapper.primary { background: var(--primary-gradient); }
        .card-icon-wrapper.success { background: var(--success-gradient); }
        .card-icon-wrapper.warning { background: var(--warning-gradient); }
        .card-icon-wrapper.danger { background: var(--danger-gradient); }
        .card-icon-wrapper.info { background: var(--info-gradient); }

        .card-title-section h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1f2937;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.03em;
        }

        .card-title-section p {
            font-size: 0.9rem;
            color: #6b7280;
            margin: 0;
            font-weight: 500;
        }

        /* Payment Status Card */
        .payment-card-modern {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 3px solid #10b981;
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            text-align: center;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .payment-card-modern.unpaid {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-color: #f59e0b;
        }

        .payment-icon-large {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            animation: scale-pulse 2s ease-in-out infinite;
        }

        @keyframes scale-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .payment-status-title {
            font-size: 2rem;
            font-weight: 800;
            color: #065f46;
            margin-bottom: 1rem;
        }

        .payment-status-title.unpaid {
            color: #92400e;
        }

        .payment-desc {
            font-size: 1.05rem;
            color: #6b7280;
            line-height: 1.6;
        }

        /* Fee Breakdown Card */
        .fee-breakdown-card {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 3px solid #fbbf24;
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
        }

        .fee-content-wrapper {
            background: white;
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .fee-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #fef3c7;
        }

        .fee-icon-big {
            font-size: 4rem;
            animation: rotate-slow 4s linear infinite;
        }

        @keyframes rotate-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .fee-header-text {
            flex: 1;
        }

        .fee-header-text h4 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #92400e;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 0;
        }

        .fee-line-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 0;
            border-bottom: 2px dashed #f3f4f6;
        }

        .fee-line-item:last-of-type {
            border-bottom: none;
        }

        .fee-label {
            font-size: 1.05rem;
            font-weight: 600;
            color: #4b5563;
        }

        .fee-amount {
            font-size: 1.5rem;
            font-weight: 800;
            color: #ea580c;
        }

        .fee-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 0 0 0;
            margin-top: 1.5rem;
            border-top: 3px solid #fbbf24;
        }

        .fee-total-label {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1f2937;
        }

        .fee-total-amount {
            font-size: 2.5rem;
            font-weight: 900;
            color: #ea580c;
        }

        .btn-pay-modern {
            width: 100%;
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1.25rem;
            font-size: 1.25rem;
            font-weight: 800;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-pay-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
        }

        /* Quote Section */
        .quote-card-modern {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 3px solid #3b82f6;
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
            animation: fadeInUp 0.6s ease;
        }

        .quote-card-modern.pending {
            animation: pulse-border 2s ease-in-out infinite;
        }

        @keyframes pulse-border {
            0%, 100% { border-color: #3b82f6; }
            50% { border-color: #60a5fa; }
        }

        .quote-inner-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .quote-price-box {
            background: linear-gradient(135deg, #fffbeb 0%, #fde68a 100%);
            border: 3px solid #f59e0b;
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            text-align: center;
            margin: 2rem 0;
        }

        .quote-price-label {
            font-size: 0.95rem;
            font-weight: 700;
            color: #92400e;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
        }

        .quote-price-value {
            font-size: 3.5rem;
            font-weight: 900;
            color: #ea580c;
            display: flex;
            align-items: baseline;
            justify-content: center;
            gap: 0.5rem;
        }

        .quote-currency {
            font-size: 1.5rem;
            font-weight: 700;
            color: #92400e;
        }

        .quote-actions-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .btn-approve-modern,
        .btn-reject-modern {
            padding: 1.25rem;
            border: none;
            border-radius: var(--radius-md);
            font-size: 1.1rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-approve-modern {
            background: var(--success-gradient);
            color: white;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.4);
        }

        .btn-approve-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 24px rgba(16, 185, 129, 0.5);
        }

        .btn-reject-modern {
            background: var(--danger-gradient);
            color: white;
            box-shadow: 0 4px 16px rgba(239, 68, 68, 0.4);
        }

        .btn-reject-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 24px rgba(239, 68, 68, 0.5);
        }

        /* Issue Alert */
        .issue-alert-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 3px solid #f59e0b;
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
        }

        .issue-alert-card.resolved {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-color: #10b981;
        }

        /* Details Grid */
        .details-grid-modern {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .detail-card-modern {
            background: white;
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            border: 2px solid #f3f4f6;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .detail-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .detail-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: #667eea;
        }

        .detail-card-modern:hover::before {
            transform: scaleX(1);
        }

        .detail-label-modern {
            font-size: 0.8rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-value-modern {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
        }

        /* Technician Card */
        .technician-card-modern {
            background: linear-gradient(135d, #ecfdf5 0%, #d1fae5 100%);
            border: 3px solid #10b981;
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
        }

        .technician-card-modern.not-assigned {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-color: #f59e0b;
        }

        .tech-profile-section {
            background: white;
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .tech-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .tech-avatar-wrapper {
            position: relative;
        }

        .tech-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }

        .tech-status-indicator {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 25px;
            height: 25px;
            background: #10b981;
            border-radius: 50%;
            border: 4px solid white;
            animation: pulse-indicator 2s ease-in-out infinite;
        }

        @keyframes pulse-indicator {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            50% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        }

        .tech-info h3 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 0.75rem;
        }

        .tech-info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .tech-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }

        .tech-stat-card {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            text-align: center;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .tech-stat-card:hover {
            transform: translateY(-5px);
            border-color: #667eea;
            box-shadow: var(--shadow-md);
        }

        .tech-stat-icon {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }

        .tech-stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .tech-stat-label {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Rating Section */
        .rating-card-modern {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 3px solid #fbbf24;
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
        }

        .rating-inner-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .stars-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding: 2rem;
            background: #f9fafb;
            border-radius: var(--radius-md);
            margin-bottom: 2rem;
        }

        .star-button {
            background: none;
            border: none;
            font-size: 3.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            filter: grayscale(100%);
            opacity: 0.3;
        }

        .star-button:hover {
            transform: scale(1.3);
            filter: grayscale(0%);
            opacity: 1;
        }

        .star-button.active {
            filter: grayscale(0%);
            opacity: 1;
            transform: scale(1.2);
            animation: star-bounce 0.5s ease;
        }

        @keyframes star-bounce {
            0%, 100% { transform: scale(1.2); }
            50% { transform: scale(1.4); }
        }

        .rating-textarea {
            width: 100%;
            padding: 1.25rem;
            border: 2px solid #e5e7eb;
            border-radius: var(--radius-md);
            font-size: 1rem;
            resize: vertical;
            min-height: 140px;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .rating-textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .btn-submit-rating-modern {
            width: 100%;
            background: var(--success-gradient);
            color: white;
            border: none;
            padding: 1.25rem;
            font-size: 1.1rem;
            font-weight: 800;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.4);
            margin-top: 1.5rem;
        }

        .btn-submit-rating-modern:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 6px 24px rgba(16, 185, 129, 0.5);
        }

        .btn-submit-rating-modern:disabled {
            background: #d1d5db;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Image & Map Sections */
        .media-section {
            margin-bottom: 2rem;
        }

        .section-title-modern {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .image-container-modern {
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border: 3px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .image-container-modern:hover {
            transform: scale(1.02);
            box-shadow: var(--shadow-xl);
        }

        .service-image-modern {
            width: 100%;
            height: auto;
            display: block;
        }

        .no-image-placeholder {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .no-image-icon {
            font-size: 5rem;
            opacity: 0.4;
        }

        .no-image-text {
            font-size: 1.25rem;
            color: #6b7280;
            font-weight: 600;
        }

        .description-box {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: var(--radius-lg);
            padding: 2rem;
            font-size: 1.05rem;
            line-height: 1.8;
            color: #4b5563;
            box-shadow: var(--shadow-sm);
        }

        .description-box.empty {
            background: #f9fafb;
            color: #9ca3af;
            font-style: italic;
            text-align: center;
            padding: 3rem 2rem;
        }

        .map-wrapper {
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border: 3px solid #e5e7eb;
            height: 450px;
        }

        .coordinates-row {
            display: flex;
            gap: 1.5rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .coordinate-box {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: var(--radius-md);
            padding: 1.25rem 1.75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .coordinate-box:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .coordinate-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
        }

        .coordinate-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            font-family: 'Courier New', monospace;
        }

        /* Timeline */
        .timeline-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
        }

        .timeline-item-modern {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
        }

        .timeline-item-modern:last-child {
            margin-bottom: 0;
        }

        .timeline-item-modern:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 24px;
            top: 50px;
            width: 3px;
            height: calc(100% - 30px);
            background: linear-gradient(to bottom, #667eea, #e5e7eb);
        }

        .timeline-icon-modern {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            z-index: 1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .timeline-icon-modern.created { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
        .timeline-icon-modern.issue { background: linear-gradient(135deg, #fed7aa, #fdba74); }
        .timeline-icon-modern.rescheduled { background: linear-gradient(135deg, #bae6fd, #7dd3fc); }
        .timeline-icon-modern.completed { background: linear-gradient(135deg, #bbf7d0, #86efac); }

        .timeline-content-modern {
            flex: 1;
            padding-top: 0.5rem;
        }

        .timeline-content-modern h4 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .timeline-content-modern p {
            font-size: 0.95rem;
            color: #6b7280;
            font-weight: 500;
        }

        /* Status Messages */
        .status-message-box {
            padding: 2rem;
            border-radius: var(--radius-lg);
            text-align: center;
            font-size: 1.25rem;
            font-weight: 700;
            margin-top: 2rem;
            box-shadow: var(--shadow-md);
        }

        .status-message-box.approved {
            background: var(--success-gradient);
            color: white;
        }

        .status-message-box.rejected {
            background: var(--danger-gradient);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .details-grid-modern {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .page-header-modern {
                padding: 2rem 1.5rem;
            }

            .header-content-wrapper {
                flex-direction: column;
            }

            .header-title-main {
                font-size: 1.5rem;
            }

            .header-badges-row {
                flex-direction: column;
                width: 100%;
            }

            .status-badge-modern,
            .price-badge-modern {
                width: 100%;
                justify-content: center;
            }

            .header-right-section {
                width: 100%;
            }

            .btn-back-modern {
                width: 100%;
                justify-content: center;
            }

            .card-modern {
                padding: 1.5rem;
            }

            .details-grid-modern {
                grid-template-columns: 1fr;
            }

            .quote-actions-grid {
                grid-template-columns: 1fr;
            }

            .tech-header {
                flex-direction: column;
                text-align: center;
            }

            .tech-stats-grid {
                grid-template-columns: 1fr;
            }

            .stars-container {
                gap: 0.5rem;
            }

            .star-button {
                font-size: 2.5rem;
            }

            .quote-price-value {
                font-size: 2.5rem;
            }

            .fee-total-amount {
                font-size: 2rem;
            }

            .coordinates-row {
                flex-direction: column;
            }
        }

        /* Smooth transitions for sidebar collapse */
        .main-content {
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .sidebar.collapsed ~ .main-content .details-grid-modern {
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }

        /* Loading States */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
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
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff"
                            alt="Client">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            @include('layouts.message_admin')

            <div class="details-container">
                <!-- Page Header -->
                <div class="page-header-modern">
                    <div class="header-content-wrapper">
                        <div class="header-left-section">
                            <h1 class="header-title-main">{{ $order->title }}</h1>
                            <div class="header-badges-row">
                                <span class="status-badge-modern status-{{ str_replace('_', '-', $order->status) }}">
                                    @switch($order->status)
                                        @case('pending') ⏳ Pending @break
                                        @case('assigned') 👤 Assigned @break
                                        @case('in_progress') 🔄 In Progress @break
                                        @case('waiting_for_approval') ⏸️ Waiting Approval @break
                                        @case('approved_for_repair') ✔️ Approved @break
                                        @case('issue_reported') ⚠️ Issue Reported @break
                                        @case('rescheduled') 📅 Rescheduled @break
                                        @case('completed') ✅ Completed @break
                                        @case('canceled') ❌ Canceled @break
                                    @endswitch
                                </span>

                                @if ($order->inspection_fee)
                                    @php
                                        $totalCost = $order->inspection_fee;
                                        if ($order->client_approved && $order->repair_cost) {
                                            $totalCost += $order->repair_cost;
                                        }
                                    @endphp
                                    <div class="price-badge-modern">
                                        💰 {{ number_format($totalCost, 2) }} EGP
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="header-right-section">
                            <a href="{{ route('client.service_request.index') }}" class="btn-back-modern">
                                ← Back to Requests
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Payment Status Card -->
                @if($order->payment_status && $order->repair_cost)
                <div class="payment-card-modern {{ $order->payment_status == 'paid' ? '' : 'unpaid' }}">
                    <div class="payment-icon-large">
                        @if($order->payment_status == 'paid') ✅ @else ⏳ @endif
                    </div>
                    <div class="payment-status-title {{ $order->payment_status == 'paid' ? '' : 'unpaid' }}">
                        @if($order->payment_status == 'paid')
                            Payment Completed Successfully
                        @else
                            Payment Pending
                        @endif
                    </div>
                    <div class="payment-desc">
                        @if($order->payment_status == 'paid')
                            Your payment has been processed successfully. Thank you!
                        @else
                            Please complete the payment to proceed with the repair work.
                        @endif
                    </div>
                </div>
                @endif

                <!-- Fee Breakdown -->
                @if ($order->inspection_fee || ($order->repair_cost && $order->client_approved))
                    <div class="fee-breakdown-card">
                        <div class="fee-content-wrapper">
                            <div class="fee-header">
                                <div class="fee-icon-big">💰</div>
                                <div class="fee-header-text">
                                    <h4>Service Fees Breakdown</h4>
                                </div>
                            </div>

                            @if ($order->inspection_fee)
                                <div class="fee-line-item">
                                    <span class="fee-label">Inspection Fee</span>
                                    <span class="fee-amount">{{ number_format($order->inspection_fee, 2) }} EGP</span>
                                </div>
                            @endif

                            @if ($order->repair_cost && $order->client_approved)
                                <div class="fee-line-item">
                                    <span class="fee-label">Repair Cost</span>
                                    <span class="fee-amount">{{ number_format($order->repair_cost, 2) }} EGP</span>
                                </div>
                            @endif

                            @php
                                $total = $order->inspection_fee ?? 0;
                                if ($order->client_approved && $order->repair_cost) {
                                    $total += $order->repair_cost;
                                }
                            @endphp

                            <div class="fee-total-row">
                                <span class="fee-total-label">Total Amount</span>
                                <span class="fee-total-amount">{{ number_format($total, 2) }} EGP</span>
                            </div>

                            @if($order->repair_cost && $order->status == 'approved_for_repair' && $order->client_approved && $order->payment_status == "unpaid")
                                <form action="{{ route('client.service_request.payment', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-pay-modern" onclick="return confirm('Proceed with payment of {{ number_format($total, 2) }} EGP?')">
                                        💳 Pay Now - {{ number_format($total, 2) }} EGP
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Repair Quote Section -->
                @if ($order->repair_cost && $order->status == 'waiting_for_approval')
                    @php
                        if (is_null($order->client_approved)) {
                            $quoteStatus = 'pending';
                        } elseif($order->client_approved) {
                            $quoteStatus = 'approved';
                        } else {
                            $quoteStatus = 'rejected';
                        }
                    @endphp

                    <div class="quote-card-modern {{ $quoteStatus === 'pending' ? 'pending' : '' }}">
                        <div class="card-header-modern">
                            <div class="card-icon-wrapper info">💵</div>
                            <div class="card-title-section">
                                <h3>
                                    @if ($quoteStatus === 'pending') Repair Quote - Awaiting Approval
                                    @elseif($quoteStatus === 'approved') Repair Quote - Approved
                                    @else Repair Quote - Rejected @endif
                                </h3>
                                <p>Submitted by the assigned technician</p>
                            </div>
                        </div>

                        <div class="quote-inner-card">
                            <div class="quote-price-box">
                                <div class="quote-price-label">Estimated Repair Cost</div>
                                <div class="quote-price-value">
                                    {{ number_format($order->repair_cost, 2) }}
                                    <span class="quote-currency">EGP</span>
                                </div>
                            </div>

                            @if ($order->technician_report)
                                <div class="description-box">
                                    <strong style="display: block; margin-bottom: 1rem; color: #1f2937;">📋 Technician Report:</strong>
                                    {{ $order->technician_report }}
                                </div>
                            @endif

                            @if ($quoteStatus === 'pending')
                                <form action="{{ route('client.service_request.respond', $order->id) }}" method="POST">
                                    @csrf
                                    <div class="quote-actions-grid">
                                        <button type="submit" name="action" value="approve" class="btn-approve-modern" onclick="return confirm('Are you sure you want to approve this repair cost?')">
                                            ✅ Approve Quote
                                        </button>
                                        <button type="submit" name="action" value="reject" class="btn-reject-modern" onclick="return confirm('Are you sure you want to reject this repair cost?')">
                                            ❌ Reject Quote
                                        </button>
                                    </div>
                                </form>
                            @elseif($quoteStatus === 'approved')
                                <div class="status-message-box approved">
                                    ✅ You have approved the repair quote. Payment is required to proceed.
                                </div>
                            @else
                                <div class="status-message-box rejected">
                                    ❌ You have rejected the repair quote.
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Issue Alert Section -->
                @if ($order->status === 'issue_reported' || ($order->status === 'rescheduled' && $order->issue_type))
                    <div class="issue-alert-card {{ $order->status === 'rescheduled' ? 'resolved' : '' }}">
                        <div class="card-header-modern">
                            <div class="card-icon-wrapper {{ $order->status === 'rescheduled' ? 'success' : 'warning' }}">
                                @if ($order->status === 'issue_reported') ⚠️ @else ✅ @endif
                            </div>
                            <div class="card-title-section">
                                <h3>
                                    @if ($order->status === 'issue_reported')
                                        Issue Reported by Technician
                                    @else
                                        Issue Resolved - Service Rescheduled
                                    @endif
                                </h3>
                                <p>
                                    @if ($order->status === 'issue_reported')
                                        The technician has reported an issue. Our admin team is reviewing it.
                                    @else
                                        The issue has been resolved. The technician can now resume the work.
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="description-box">
                            <div style="margin-bottom: 1.5rem;">
                                <strong style="display: block; margin-bottom: 0.5rem; color: #1f2937;">Issue Type:</strong>
                                <span style="background: #fef3c7; padding: 8px 16px; border-radius: 20px; color: #92400e; font-weight: 600;">
                                    @switch($order->issue_type)
                                        @case('missing_parts') 🔧 Missing Parts/Tools @break
                                        @case('technical_difficulty') ⚙️ Technical Difficulty @break
                                        @case('client_unavailable') 👤 Client Unavailable @break
                                        @case('additional_work') 📋 Additional Work Required @break
                                        @case('other') ❓ Other Issue @break
                                        @default {{ $order->issue_type }}
                                    @endswitch
                                </span>
                            </div>

                            @if ($order->technician_report)
                                <div style="margin-bottom: 1.5rem;">
                                    <strong style="display: block; margin-bottom: 0.5rem; color: #1f2937;">Technician's Report:</strong>
                                    <p style="margin: 0;">{{ $order->technician_report }}</p>
                                </div>
                            @endif

                            @if ($order->issue_reported_at)
                                <div>
                                    <strong style="display: block; margin-bottom: 0.5rem; color: #1f2937;">Reported At:</strong>
                                    <p style="margin: 0;">{{ $order->issue_reported_at->format('M d, Y') }} at {{ $order->issue_reported_at->format('h:i A') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Details Grid -->
                <div class="details-grid-modern">
                    <div class="detail-card-modern">
                        <div class="detail-label-modern">📂 Category</div>
                        <div class="detail-value-modern">{{ $order->category->name ?? 'N/A' }}</div>
                    </div>

                    <div class="detail-card-modern">
                        <div class="detail-label-modern">📅 Created Date</div>
                        <div class="detail-value-modern">
                            {{ $order->created_at->format('M d, Y') }}
                            <small style="display: block; font-size: 0.9rem; color: #6b7280; font-weight: 500; margin-top: 0.25rem;">
                                {{ $order->created_at->format('h:i A') }}
                            </small>
                        </div>
                    </div>

                    @if ($order->completed_at)
                        <div class="detail-card-modern">
                            <div class="detail-label-modern">✅ Completed Date</div>
                            <div class="detail-value-modern">
                                {{ \Carbon\Carbon::parse($order->completed_at)->format('M d, Y') }}
                                <small style="display: block; font-size: 0.9rem; color: #6b7280; font-weight: 500; margin-top: 0.25rem;">
                                    {{ \Carbon\Carbon::parse($order->completed_at)->format('h:i A') }}
                                </small>
                            </div>
                        </div>
                    @endif

                    <div class="detail-card-modern">
                        <div class="detail-label-modern">📍 Address</div>
                        <div class="detail-value-modern" style="font-size: 1rem;">
                            {{ $order->address ?? 'No address provided' }}
                        </div>
                    </div>
                </div>

                <!-- Technician Section -->
                @if ($technician)
                    <div class="technician-card-modern">
                        <div class="card-header-modern">
                            <div class="card-icon-wrapper success">👨‍🔧</div>
                            <div class="card-title-section">
                                <h3>Assigned Technician</h3>
                                <p>Professional service provider</p>
                            </div>
                        </div>

                        <div class="tech-profile-section">
                            <div class="tech-header">
                                <div class="tech-avatar-wrapper">
                                    <img src="https://ui-avatars.com/api/?name={{ $technician->user->name }}&background=10b981&color=fff"
                                        alt="Technician" class="tech-avatar">
                                    <div class="tech-status-indicator"></div>
                                </div>
                                <div class="tech-info">
                                    <h3>{{ $technician->user->name }}</h3>
                                    <div class="tech-info-item">
                                        <span>📱</span> {{ $technician->user->phone ?? 'N/A' }}
                                    </div>
                                    <div class="tech-info-item">
                                        <span>🔧</span> {{ $technician->category->name }}
                                    </div>
                                </div>
                            </div>

                            <div class="tech-stats-grid">
                                <div class="tech-stat-card">
                                    <div class="tech-stat-icon">⭐</div>
                                    <div class="tech-stat-value">{{ number_format($technician->rating ?? 0, 1) }}</div>
                                    <div class="tech-stat-label">Rating</div>
                                </div>
                                <div class="tech-stat-card">
                                    <div class="tech-stat-icon">✅</div>
                                    <div class="tech-stat-value">{{ $completedOrders ?? 0 }}</div>
                                    <div class="tech-stat-label">Completed</div>
                                </div>
                                @if ($technician->years_of_experience)
                                    <div class="tech-stat-card">
                                        <div class="tech-stat-icon">📅</div>
                                        <div class="tech-stat-value">{{ $technician->years_of_experience }}</div>
                                        <div class="tech-stat-label">Years Exp</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="technician-card-modern not-assigned">
                        <div class="card-header-modern">
                            <div class="card-icon-wrapper warning">⏳</div>
                            <div class="card-title-section">
                                <h3>Waiting for Technician Assignment</h3>
                                <p>Your request is pending. A technician will be assigned soon.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Rating Section -->
                @if ($order->status === 'completed' && $technician)
                    @php
                        $existingRating = \App\Models\Rating::where('service_request_id', $order->id)
                            ->where('client_id', $user->userable_id)
                            ->first();
                    @endphp

                    <div class="rating-card-modern">
                        <div class="card-header-modern">
                            <div class="card-icon-wrapper warning">⭐</div>
                            <div class="card-title-section">
                                <h3>Rate Your Experience</h3>
                                <p>Share your feedback about the service</p>
                            </div>
                        </div>

                        @if ($existingRating)
                            <div class="rating-inner-card">
                                <div style="text-align: center;">
                                    <h4 style="font-size: 1.5rem; font-weight: 800; color: #10b981; margin-bottom: 1.5rem;">
                                        ✅ You have rated this service
                                    </h4>
                                    <div style="font-size: 4rem; margin: 1.5rem 0;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $existingRating->rating) ⭐ @else ☆ @endif
                                        @endfor
                                    </div>
                                    <p style="font-size: 2rem; font-weight: 800; color: #10b981; margin: 1rem 0;">
                                        {{ $existingRating->rating }}/5 Stars
                                    </p>
                                    @if ($existingRating->comment)
                                        <div class="description-box" style="margin-top: 2rem;">
                                            "{{ $existingRating->comment }}"
                                        </div>
                                    @endif
                                    <p style="margin-top: 1.5rem; font-size: 0.95rem; color: #6b7280;">
                                        Rated on {{ $existingRating->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="rating-inner-card">
                                <p style="text-align: center; font-size: 1.1rem; color: #6b7280; margin-bottom: 2rem;">
                                    How was your experience with <strong>{{ $technician->user->name }}</strong>?
                                </p>
                                <form action="{{ route('client.service_request.rating.store') }}" method="POST" id="ratingForm">
                                    @csrf
                                    <input type="hidden" name="service_request_id" value="{{ $order->id }}">
                                    <input type="hidden" name="rating" id="ratingValue" value="0">

                                    <div style="text-align: center; font-size: 1.1rem; font-weight: 700; color: #6b7280; margin-bottom: 1rem;">
                                        Click to rate:
                                    </div>
                                    <div class="stars-container" id="starRating">
                                        <button type="button" class="star-button" data-rating="1">⭐</button>
                                        <button type="button" class="star-button" data-rating="2">⭐</button>
                                        <button type="button" class="star-button" data-rating="3">⭐</button>
                                        <button type="button" class="star-button" data-rating="4">⭐</button>
                                        <button type="button" class="star-button" data-rating="5">⭐</button>
                                    </div>

                                    <textarea name="comment" class="rating-textarea"
                                        placeholder="Share your experience with this technician (optional)..."></textarea>

                                    <button type="submit" class="btn-submit-rating-modern" id="submitRating" disabled>
                                        🌟 Submit Rating
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Image Section -->
                <div class="media-section">
                    <div class="section-title-modern">🖼️ Service Image</div>
                    <div class="image-container-modern">
                        @if ($order->image)
                            <img src="{{ asset($order->image) }}" alt="Service Request Image" class="service-image-modern">
                        @else
                            <div class="no-image-placeholder">
                                <div class="no-image-icon">🔧</div>
                                <div class="no-image-text">No image uploaded</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Description Section -->
                <div class="media-section">
                    <div class="section-title-modern">📝 Description</div>
                    @if ($order->description)
                        <div class="description-box">{{ $order->description }}</div>
                    @else
                        <div class="description-box empty">No description provided</div>
                    @endif
                </div>

                <!-- Map Section -->
                <div class="media-section">
                    <div class="section-title-modern">🗺️ Location</div>
                    <div class="map-wrapper" id="map"></div>
                    <div class="coordinates-row">
                        <div class="coordinate-box">
                            <span class="coordinate-label">Latitude:</span>
                            <span class="coordinate-value">{{ $order->latitude }}</span>
                        </div>
                        <div class="coordinate-box">
                            <span class="coordinate-label">Longitude:</span>
                            <span class="coordinate-value">{{ $order->longitude }}</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Section -->
                <div class="media-section">
                    <div class="section-title-modern">📅 Request Timeline</div>
                    <div class="timeline-card">
                        <div class="timeline-item-modern">
                            <div class="timeline-icon-modern created">📝</div>
                            <div class="timeline-content-modern">
                                <h4>Request Created</h4>
                                <p>{{ $order->created_at->format('M d, Y - h:i A') }}</p>
                            </div>
                        </div>

                        @if ($order->issue_reported_at)
                            <div class="timeline-item-modern">
                                <div class="timeline-icon-modern issue">⚠️</div>
                                <div class="timeline-content-modern">
                                    <h4>Issue Reported</h4>
                                    <p>{{ $order->issue_reported_at->format('M d, Y - h:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($order->status === 'rescheduled')
                            <div class="timeline-item-modern">
                                <div class="timeline-icon-modern rescheduled">📅</div>
                                <div class="timeline-content-modern">
                                    <h4>Service Rescheduled</h4>
                                    <p>Issue resolved, work will resume</p>
                                </div>
                            </div>
                        @endif

                        @if ($order->completed_at)
                            <div class="timeline-item-modern">
                                <div class="timeline-icon-modern completed">✅</div>
                                <div class="timeline-content-modern">
                                    <h4>Request Completed</h4>
                                    <p>{{ \Carbon\Carbon::parse($order->completed_at)->format('M d, Y - h:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Map
            const latitude = {{ $order->latitude }};
            const longitude = {{ $order->longitude }};
            const map = L.map('map').setView([latitude, longitude], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: '<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.3); border: 4px solid white;">📍</div>',
                iconSize: [50, 50],
                iconAnchor: [25, 50]
            });

            const marker = L.marker([latitude, longitude], {
                icon: customIcon
            }).addTo(map);

            marker.bindPopup(`
                <div style="padding: 15px; min-width: 220px;">
                    <h3 style="margin: 0 0 10px 0; font-size: 18px; font-weight: 800; color: #1f2937;">{{ $order->title }}</h3>
                    <p style="margin: 0; font-size: 14px; color: #6b7280; line-height: 1.5;">{{ $order->address ?? 'Service Location' }}</p>
                </div>
            `).openPopup();

            // Rating System
            @if ($order->status === 'completed' && $technician && !isset($existingRating))
                const starButtons = document.querySelectorAll('.star-button');
                const ratingValue = document.getElementById('ratingValue');
                const submitButton = document.getElementById('submitRating');
                const ratingForm = document.getElementById('ratingForm');

                starButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const rating = parseInt(this.getAttribute('data-rating'));
                        ratingValue.value = rating;

                        // Update star display
                        starButtons.forEach((btn, index) => {
                            if (index < rating) {
                                btn.classList.add('active');
                            } else {
                                btn.classList.remove('active');
                            }
                        });

                        // Enable submit button
                        submitButton.disabled = false;
                    });

                    // Hover effect
                    button.addEventListener('mouseenter', function() {
                        const rating = parseInt(this.getAttribute('data-rating'));
                        starButtons.forEach((btn, index) => {
                            if (index < rating) {
                                btn.style.filter = 'grayscale(0%)';
                                btn.style.opacity = '1';
                            }
                        });
                    });

                    button.addEventListener('mouseleave', function() {
                        starButtons.forEach((btn) => {
                            if (!btn.classList.contains('active')) {
                                btn.style.filter = 'grayscale(100%)';
                                btn.style.opacity = '0.3';
                            }
                        });
                    });
                });

                // Form validation
                ratingForm.addEventListener('submit', function(e) {
                    if (ratingValue.value === '0' || ratingValue.value === '') {
                        e.preventDefault();
                        alert('⭐ Please select a rating before submitting.');
                        return false;
                    }
                });
            @endif
        });

        // Notification mark as read
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
            }).then(() => {
                location.reload();
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
