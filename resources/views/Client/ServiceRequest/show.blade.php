@extends('layouts.app')
@section('title', 'Service Request Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .details-container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        }

        .details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border);
        }

        .header-left {
            flex: 1;
        }

        .header-title-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .details-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0;
        }

        .inline-fee-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #FFD54F 0%, #FFC107 100%);
            color: #E65100;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            border: 2px solid #FFB300;
            box-shadow: 0 3px 10px rgba(255, 193, 7, 0.3);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0%, 100% {
                box-shadow: 0 3px 10px rgba(255, 193, 7, 0.3);
            }
            50% {
                box-shadow: 0 5px 20px rgba(255, 193, 7, 0.5);
            }
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn-back {
            padding: 10px 20px;
            border: 2px solid var(--border);
            border-radius: 10px;
            background: white;
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-back:hover {
            border-color: var(--primary-light);
            color: var(--primary-light);
        }

        /* Status Badge Styles */
        .status-badge-large {
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .status-badge-large.status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-badge-large.status-assigned {
            background: #E3F2FD;
            color: #1565C0;
        }

        .status-badge-large.status-in_progress,
        .status-badge-large.status-in-progress {
            background: #F3E5F5;
            color: #6A1B9A;
        }

        .status-badge-large.status-waiting_for_approval {
            background: #F3E8FF;
            color: #6B21A8;
        }

        .status-badge-large.status-approved_for_repair {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-badge-large.status-completed {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .status-badge-large.status-issue_reported,
        .status-badge-large.status-issue-reported {
            background: #FFF3E0;
            color: #E65100;
        }

        .status-badge-large.status-rescheduled {
            background: #E1F5FE;
            color: #01579B;
        }

        .status-badge-large.status-canceled {
            background: #FFEBEE;
            color: #C62828;
        }

        /* Payment Status Card */
        .payment-status-card {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 3px solid #4CAF50;
            box-shadow: 0 5px 25px rgba(76, 175, 80, 0.2);
        }

        .payment-status-card.unpaid {
            background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
            border-color: #FF9800;
        }

        .payment-status-icon {
            font-size: 64px;
            text-align: center;
            margin-bottom: 15px;
        }

        .payment-status-text {
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            color: #2E7D32;
            margin-bottom: 10px;
        }

        .payment-status-text.unpaid {
            color: #E65100;
        }

        .payment-status-desc {
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        /* Inspection Fee Highlight */
        .inspection-fee-highlight {
            background: linear-gradient(135deg, #FFF9C4 0%, #FFECB3 100%);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 3px solid #FFD54F;
            box-shadow: 0 5px 25px rgba(255, 193, 7, 0.2);
        }

        .fee-card-premium {
            background: white;
            padding: 30px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        }

        .fee-icon-large {
            font-size: 64px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .fee-info {
            flex: 1;
        }

        .fee-title {
            font-size: 14px;
            font-weight: 600;
            color: #F57F17;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
        }

        .fee-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .fee-line:last-of-type {
            border-bottom: none;
        }

        .fee-value {
            font-size: 20px;
            font-weight: 700;
            color: #E65100;
        }

        .fee-total-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            margin-top: 10px;
            border-top: 2px solid #FFD54F;
        }

        .fee-total-line strong {
            font-size: 18px;
            color: #E65100;
        }

        .fee-total-value {
            font-size: 28px;
            font-weight: 800;
            color: #E65100;
        }

        .currency-text {
            font-size: 16px;
            font-weight: 600;
            color: #F57F17;
        }

        .btn-pay-now {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 18px 24px;
            font-size: 18px;
            font-weight: 700;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-pay-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #5568d3 0%, #6941a0 100%);
        }

        /* Repair Quote Section */
        .repair-quote-section {
            background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 3px solid #2196F3;
            box-shadow: 0 5px 25px rgba(33, 150, 243, 0.2);
        }

        .repair-quote-section.pending-approval {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 5px 25px rgba(33, 150, 243, 0.2);
            }
            50% {
                box-shadow: 0 8px 35px rgba(33, 150, 243, 0.4);
            }
        }

        .quote-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        }

        .quote-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #E3F2FD;
        }

        .quote-icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
        }

        .quote-title-section h3 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 5px 0;
        }

        .quote-title-section p {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0;
        }

        .quote-price-display {
            background: linear-gradient(135deg, #FFF9C4 0%, #FFE082 100%);
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 20px;
            border: 2px solid #FFD54F;
        }

        .quote-price-label {
            font-size: 14px;
            font-weight: 600;
            color: #F57F17;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .quote-price-amount {
            font-size: 42px;
            font-weight: 800;
            color: #E65100;
            display: flex;
            align-items: baseline;
            justify-content: center;
            gap: 8px;
        }

        .quote-currency {
            font-size: 20px;
            font-weight: 600;
            color: #F57F17;
        }

        .quote-details-box {
            background: #F8F9FA;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .quote-detail-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            display: block;
        }

        .quote-detail-text {
            font-size: 15px;
            color: var(--text-primary);
            line-height: 1.6;
        }

        .quote-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-approve,
        .btn-reject {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-approve {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        }

        .btn-reject {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(244, 67, 54, 0.3);
        }

        .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(244, 67, 54, 0.4);
        }

        .quote-status-approved {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            border: 3px solid #4CAF50;
        }

        .quote-status-rejected {
            background: linear-gradient(135deg, #FFEBEE 0%, #FFCDD2 100%);
            border: 3px solid #f44336;
        }

        .quote-status-message {
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            margin-top: 20px;
        }

        .quote-status-message.approved {
            background: #4CAF50;
            color: white;
        }

        .quote-status-message.rejected {
            background: #f44336;
            color: white;
        }

        /* Issue Alert Section */
        .issue-alert-section {
            background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 2px solid #FFB300;
        }

        .issue-alert-section.resolved {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            border: 2px solid #4CAF50;
        }

        .issue-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .issue-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .issue-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            background: #FFF3E0;
        }

        .issue-icon.resolved {
            background: #E8F5E9;
        }

        .issue-title h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 5px 0;
        }

        .issue-title p {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 0;
        }

        .issue-details {
            margin-top: 20px;
        }

        .issue-detail-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .issue-detail-item:last-child {
            margin-bottom: 0;
        }

        .issue-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: block;
        }

        .issue-value {
            font-size: 15px;
            color: var(--text-primary);
            line-height: 1.6;
        }

        .issue-type-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            background: #FFE0B2;
            color: #E65100;
        }

        .status-timeline {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .timeline-step {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: white;
            border-radius: 8px;
            margin-bottom: 10px;
            border-left: 4px solid #FFB300;
        }

        .timeline-step:last-child {
            margin-bottom: 0;
        }

        .timeline-step.completed {
            border-left-color: #4CAF50;
        }

        .timeline-step-icon {
            font-size: 24px;
        }

        .timeline-step-text {
            flex: 1;
        }

        .timeline-step-text strong {
            display: block;
            font-size: 14px;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .timeline-step-text small {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .detail-card {
            background: var(--background);
            padding: 20px;
            border-radius: 15px;
            border: 2px solid var(--border);
        }

        .detail-card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-card-content {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .detail-card-content.large {
            font-size: 20px;
        }

        /* Technician Section */
        .technician-section {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 2px solid #A5D6A7;
        }

        .technician-section.not-assigned {
            background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
            border: 2px solid #FFCC80;
        }

        .technician-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .technician-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .technician-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .technician-info h3 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .technician-info p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 4px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .technician-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .stat-item {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #dee2e6;
        }

        .stat-icon {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Rating Section */
        .rating-section {
            background: linear-gradient(135deg, #FFF9C4 0%, #FFF59D 100%);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 2px solid #FFF176;
        }

        .rating-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .star-rating {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .star-btn {
            background: none;
            border: none;
            font-size: 48px;
            cursor: pointer;
            transition: all 0.3s ease;
            filter: grayscale(100%);
            opacity: 0.4;
        }

        .star-btn:hover {
            transform: scale(1.3);
            filter: grayscale(0%);
            opacity: 1;
        }

        .star-btn.active {
            filter: grayscale(0%);
            opacity: 1;
            transform: scale(1.2);
        }

        .rating-label {
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 20px;
        }

        .rating-comment {
            width: 100%;
            padding: 15px;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            font-size: 15px;
            resize: vertical;
            min-height: 120px;
            margin-bottom: 20px;
            font-family: inherit;
        }

        .rating-comment:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .btn-submit-rating {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
            width: 100%;
        }

        .btn-submit-rating:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        }

        .btn-submit-rating:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .existing-rating {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
        }

        .existing-rating h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 15px;
        }

        .rating-stars-display {
            font-size: 32px;
            margin: 15px 0;
        }

        .rating-comment-display {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            font-style: italic;
            color: var(--text-secondary);
        }

        .image-section, .description-section, .map-section {
            margin-bottom: 30px;
        }

        .request-image-large {
            width: 100%;
            max-width: 600px;
            height: auto;
            border-radius: 15px;
            border: 3px solid var(--border);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .no-image-large {
            width: 100%;
            max-width: 600px;
            height: 300px;
            border-radius: 15px;
            background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--border);
        }

        .no-image-icon {
            font-size: 64px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .no-image-text {
            font-size: 16px;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .description-content {
            background: var(--background);
            padding: 20px;
            border-radius: 15px;
            border: 2px solid var(--border);
            font-size: 15px;
            line-height: 1.6;
            color: var(--text-primary);
        }

        .description-content.empty {
            color: var(--text-secondary);
            font-style: italic;
            text-align: center;
            padding: 40px 20px;
        }

        .map-container {
            width: 100%;
            height: 400px;
            border-radius: 15px;
            border: 3px solid var(--border);
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .coordinates-info {
            margin-top: 15px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .coordinate-item {
            background: var(--background);
            padding: 12px 20px;
            border-radius: 10px;
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .coordinate-label {
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .coordinate-value {
            font-size: 14px;
            color: var(--text-primary);
            font-weight: 600;
            font-family: monospace;
        }

        .timeline-section {
            background: var(--background);
            padding: 25px;
            border-radius: 15px;
            border: 2px solid var(--border);
        }

        .timeline-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            position: relative;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 19px;
            top: 40px;
            width: 2px;
            height: calc(100% - 20px);
            background: var(--border);
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            z-index: 1;
        }

        .timeline-icon.created {
            background: #E3F2FD;
        }

        .timeline-icon.issue {
            background: #FFF3E0;
        }

        .timeline-icon.rescheduled {
            background: #E1F5FE;
        }

        .timeline-icon.completed {
            background: #E8F5E9;
        }

        .timeline-content h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .timeline-content p {
            font-size: 13px;
            color: var(--text-secondary);
        }

        @media (max-width: 768px) {
            .details-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .header-title-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                width: 100%;
            }

            .inline-fee-badge {
                width: 100%;
                justify-content: center;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .btn-back {
                width: 100%;
                justify-content: center;
            }

            .fee-card-premium {
                flex-direction: column;
                text-align: center;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .technician-header {
                flex-direction: column;
                text-align: center;
            }

            .technician-stats {
                grid-template-columns: 1fr;
            }

            .star-rating {
                gap: 5px;
            }

            .star-btn {
                font-size: 36px;
            }

            .quote-actions {
                grid-template-columns: 1fr;
            }

            .quote-price-amount {
                font-size: 32px;
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
                    {{-- <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <span class="search-icon">🔍</span>
                    </div> --}}
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
                <!-- Header -->
                <div class="details-header">
                    <div class="header-left">
                        <div class="header-title-wrapper">
                            <h2>{{ $order->title }}</h2>
                            @if ($order->inspection_fee)
                                @php
                                    $totalCost = $order->inspection_fee;
                                    if ($order->client_approved && $order->repair_cost) {
                                        $totalCost += $order->repair_cost;
                                    }
                                @endphp
                                <div class="inline-fee-badge">
                                    💰 {{ number_format($totalCost, 2) }} EGP
                                    @if($order->client_approved)
                                        <span style="font-size: 13px;">(Inspection + Repair)</span>
                                    @else
                                        <span style="font-size: 13px;">(Inspection Only)</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="header-actions">
                        <span class="status-badge-large status-{{ str_replace('_', '-', $order->status) }}">
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
                                    ⏸️ Waiting Approval
                                @break
                                @case('approved_for_repair')
                                    ✔️ Approved
                                @break
                                @case('issue_reported')
                                    ⚠️ Issue Reported
                                @break
                                @case('rescheduled')
                                    📅 Rescheduled
                                @break
                                @case('completed')
                                    ✅ Completed
                                @break
                                @case('canceled')
                                    ❌ Canceled
                                @break
                            @endswitch
                        </span>
                        <a href="{{ route('client.service_request.index') }}" class="btn-back">
                            ← Back
                        </a>
                    </div>
                </div>

                <!-- Payment Status Card (if payment exists) -->
                @if($order->payment_status && $order->repair_cost)
                <div class="payment-status-card {{ $order->payment_status == 'paid' ? '' : 'unpaid' }}">
                    <div class="payment-status-icon">
                        @if($order->payment_status == 'paid')
                            ✅
                        @else
                            ⏳
                        @endif
                    </div>
                    <div class="payment-status-text {{ $order->payment_status == 'paid' ? '' : 'unpaid' }}">
                        @if($order->payment_status == 'paid')
                            Payment Completed Successfully
                        @else
                            Payment Pending
                        @endif
                    </div>
                    <div class="payment-status-desc">
                        @if($order->payment_status == 'paid')
                            Your payment has been processed successfully. Thank you!
                        @else
                            Please complete the payment to proceed with the repair work.
                        @endif
                    </div>
                </div>
                @endif

                <!-- Inspection Fee & Payment Section -->
                @if ($order->inspection_fee || ($order->repair_cost && $order->client_approved))
                    <div class="inspection-fee-highlight">
                        <div class="fee-card-premium">
                            <div class="fee-icon-large">💰</div>
                            <div class="fee-info">
                                <span class="fee-title">Service Fees Breakdown</span>

                                @if ($order->inspection_fee)
                                    <div class="fee-line">
                                        <strong>Inspection Fee:</strong>
                                        <span class="fee-value">{{ number_format($order->inspection_fee, 2) }} <span class="currency-text">EGP</span></span>
                                    </div>
                                @endif

                                @if ($order->repair_cost && $order->client_approved)
                                    <div class="fee-line">
                                        <strong>Repair Cost:</strong>
                                        <span class="fee-value">{{ number_format($order->repair_cost, 2) }} <span class="currency-text">EGP</span></span>
                                    </div>
                                @endif

                                @php
                                    $total = $order->inspection_fee ?? 0;
                                    if ($order->client_approved && $order->repair_cost) {
                                        $total += $order->repair_cost;
                                    }
                                @endphp

                                <div class="fee-total-line">
                                    <strong>Total:</strong>
                                    <span class="fee-total-value">{{ number_format($total, 2) }}
                                        <span class="currency-text">EGP</span>
                                    </span>
                                </div>

                                @if($order->repair_cost && $order->status == 'approved_for_repair' && $order->client_approved && $order->payment_status == "unpaid")
                                    <form action="{{ route('client.service_request.payment', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-pay-now" onclick="return confirm('Proceed with payment of {{ number_format($total, 2) }} EGP?')">
                                            💳 Pay Now
                                        </button>
                                    </form>
                                @endif
                            </div>
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

                    <div class="repair-quote-section {{ $quoteStatus === 'pending' ? 'pending-approval' : '' }} {{ $quoteStatus === 'approved' ? 'quote-status-approved' : '' }} {{ $quoteStatus === 'rejected' ? 'quote-status-rejected' : '' }}">
                        <div class="section-title">
                            @if ($quoteStatus === 'pending')
                                💰 Repair Quote - Awaiting Your Approval
                            @elseif($quoteStatus === 'approved')
                                ✅ Repair Quote - Approved
                            @else
                                ❌ Repair Quote - Rejected
                            @endif
                        </div>

                        <div class="quote-card">
                            <div class="quote-header">
                                <div class="quote-icon-wrapper">💵</div>
                                <div class="quote-title-section">
                                    <h3>Proposed Repair Cost</h3>
                                    <p>Submitted by the assigned technician</p>
                                </div>
                            </div>

                            <div class="quote-price-display">
                                <div class="quote-price-label">Estimated Repair Cost</div>
                                <div class="quote-price-amount">
                                    {{ number_format($order->repair_cost, 2) }}
                                    <span class="quote-currency">EGP</span>
                                </div>
                            </div>

                            @if ($order->technician_report)
                                <div class="quote-details-box">
                                    <span class="quote-detail-label">📋 Technician Report</span>
                                    <div class="quote-detail-text">{{ $order->technician_report }}</div>
                                </div>
                            @endif

                            @if ($quoteStatus === 'pending')
                                <form action="{{ route('client.service_request.respond', $order->id) }}" method="POST">
                                    @csrf
                                    <div class="quote-actions">
                                        <button type="submit" name="action" value="approve" class="btn-approve" onclick="return confirm('Are you sure you want to approve this repair cost?')">
                                            ✅ Approve
                                        </button>
                                        <button type="submit" name="action" value="reject" class="btn-reject" onclick="return confirm('Are you sure you want to reject this repair cost?')">
                                            ❌ Reject
                                        </button>
                                    </div>
                                </form>
                            @elseif($quoteStatus === 'approved')
                                <div class="quote-status-message approved">
                                    ✅ You have approved the repair quote. Payment is required to proceed.
                                </div>
                            @else
                                <div class="quote-status-message rejected">
                                    ❌ You have rejected the repair quote.
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Issue Alert Section -->
                @if ($order->status === 'issue_reported' || ($order->status === 'rescheduled' && $order->issue_type))
                    <div class="issue-alert-section {{ $order->status === 'rescheduled' ? 'resolved' : '' }}">
                        <div class="section-title">
                            @if ($order->status === 'issue_reported')
                                ⚠️ Issue Reported by Technician
                            @else
                                ✅ Issue Resolved - Service Rescheduled
                            @endif
                        </div>

                        <div class="issue-card">
                            <div class="issue-header">
                                <div class="issue-icon {{ $order->status === 'rescheduled' ? 'resolved' : '' }}">
                                    @if ($order->status === 'issue_reported')
                                        ⚠️
                                    @else
                                        ✅
                                    @endif
                                </div>
                                <div class="issue-title">
                                    <h3>
                                        @if ($order->status === 'issue_reported')
                                            Service Issue Detected
                                        @else
                                            Issue Has Been Resolved
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

                            <div class="issue-details">
                                <div class="issue-detail-item">
                                    <span class="issue-label">Issue Type</span>
                                    <div class="issue-type-badge">
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
                                                ❓ Other Issue
                                            @break
                                            @default
                                                {{ $order->issue_type }}
                                        @endswitch
                                    </div>
                                </div>

                                @if ($order->technician_report)
                                    <div class="issue-detail-item">
                                        <span class="issue-label">Technician's Report</span>
                                        <div class="issue-value">{{ $order->technician_report }}</div>
                                    </div>
                                @endif

                                @if ($order->issue_reported_at)
                                    <div class="issue-detail-item">
                                        <span class="issue-label">Reported At</span>
                                        <div class="issue-value">
                                            {{ $order->issue_reported_at->format('M d, Y') }} at
                                            {{ $order->issue_reported_at->format('h:i A') }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if ($order->status === 'issue_reported')
                                <div class="status-timeline">
                                    <div class="timeline-step">
                                        <span class="timeline-step-icon">⚠️</span>
                                        <div class="timeline-step-text">
                                            <strong>Issue Reported</strong>
                                            <small>Technician has identified a problem</small>
                                        </div>
                                    </div>
                                    <div class="timeline-step">
                                        <span class="timeline-step-icon">👨‍💼</span>
                                        <div class="timeline-step-text">
                                            <strong>Under Review</strong>
                                            <small>Admin is reviewing the issue</small>
                                        </div>
                                    </div>
                                    <div class="timeline-step">
                                        <span class="timeline-step-icon">🔄</span>
                                        <div class="timeline-step-text">
                                            <strong>Next: Resolution</strong>
                                            <small>Will be rescheduled after resolution</small>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="status-timeline">
                                    <div class="timeline-step completed">
                                        <span class="timeline-step-icon">✅</span>
                                        <div class="timeline-step-text">
                                            <strong>Issue Resolved</strong>
                                            <small>Admin has resolved the issue</small>
                                        </div>
                                    </div>
                                    <div class="timeline-step completed">
                                        <span class="timeline-step-icon">📅</span>
                                        <div class="timeline-step-text">
                                            <strong>Service Rescheduled</strong>
                                            <small>Technician will resume the work</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Details Grid -->
                <div class="details-grid">
                    <div class="detail-card">
                        <div class="detail-card-title">📂 Category</div>
                        <div class="detail-card-content large">
                            {{ $order->category->name ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-card-title">📅 Created Date</div>
                        <div class="detail-card-content">
                            {{ $order->created_at->format('M d, Y') }}<br>
                            <small style="font-size: 13px; color: var(--text-secondary);">
                                {{ $order->created_at->format('h:i A') }}
                            </small>
                        </div>
                    </div>

                    @if ($order->completed_at)
                        <div class="detail-card">
                            <div class="detail-card-title">✅ Completed Date</div>
                            <div class="detail-card-content">
                                {{ \Carbon\Carbon::parse($order->completed_at)->format('M d, Y') }}<br>
                                <small style="font-size: 13px; color: var(--text-secondary);">
                                    {{ \Carbon\Carbon::parse($order->completed_at)->format('h:i A') }}
                                </small>
                            </div>
                        </div>
                    @endif

                    <div class="detail-card">
                        <div class="detail-card-title">📍 Address</div>
                        <div class="detail-card-content">
                            {{ $order->address ?? 'No address provided' }}
                        </div>
                    </div>
                </div>

                <!-- Technician Section -->
                @if ($technician)
                    <div class="technician-section">
                        <div class="section-title">
                            👨‍🔧 Assigned Technician
                        </div>
                        <div class="technician-card">
                            <div class="technician-header">
                                <img src="https://ui-avatars.com/api/?name={{ $technician->user->name }}&background=4CAF50&color=fff"
                                    alt="Technician" class="technician-avatar">
                                <div class="technician-info">
                                    <h3>{{ $technician->user->name }}</h3>
                                    <p><span>📱</span> {{ $technician->user->phone ?? 'N/A' }}</p>
                                    <p><span>🔧</span> {{ $technician->category->name }}</p>
                                </div>
                            </div>

                            <div class="technician-stats">
                                <div class="stat-item">
                                    <div class="stat-icon">⭐</div>
                                    <div class="stat-value">{{ number_format($technician->rating ?? 0, 1) }}</div>
                                    <div class="stat-label">Rating</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">✅</div>
                                    <div class="stat-value">{{ $completedOrders ?? 0 }}</div>
                                    <div class="stat-label">Completed</div>
                                </div>
                                @if ($technician->years_of_experience)
                                    <div class="stat-item">
                                        <div class="stat-icon">📅</div>
                                        <div class="stat-value">{{ $technician->years_of_experience }}</div>
                                        <div class="stat-label">Years Exp</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="technician-section not-assigned">
                        <div class="section-title">
                            ⏳ Waiting for Technician Assignment
                        </div>
                        <p style="color: var(--text-secondary); margin-top: 10px; font-size: 15px;">
                            Your request is pending. A technician will be assigned soon.
                        </p>
                    </div>
                @endif

                <!-- Rating Section -->
                @if ($order->status === 'completed' && $technician)
                    @php
                        $existingRating = \App\Models\Rating::where('service_request_id', $order->id)
                            ->where('client_id', $user->userable_id)
                            ->first();
                    @endphp

                    <div class="rating-section">
                        <div class="section-title">
                            ⭐ Rate Your Experience
                        </div>

                        @if ($existingRating)
                            <div class="existing-rating">
                                <h4>✅ You have rated this service</h4>
                                <div class="rating-stars-display">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $existingRating->rating)
                                            ⭐
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <p style="font-size: 18px; font-weight: 700; color: #4CAF50;">
                                    {{ $existingRating->rating }}/5 Stars
                                </p>
                                @if ($existingRating->comment)
                                    <div class="rating-comment-display">
                                        "{{ $existingRating->comment }}"
                                    </div>
                                @endif
                                <p style="margin-top: 15px; font-size: 13px; color: var(--text-secondary);">
                                    Rated on {{ $existingRating->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        @else
                            <div class="rating-card">
                                <p style="text-align: center; font-size: 16px; color: var(--text-secondary); margin-bottom: 20px;">
                                    How was your experience with <strong>{{ $technician->user->name }}</strong>?
                                </p>
                                <form action="{{ route('client.service_request.rating.store') }}" method="POST" id="ratingForm">
                                    @csrf
                                    <input type="hidden" name="service_request_id" value="{{ $order->id }}">
                                    <input type="hidden" name="rating" id="ratingValue" value="0">

                                    <div class="rating-label">Click to rate:</div>
                                    <div class="star-rating" id="starRating">
                                        <button type="button" class="star-btn" data-rating="1">⭐</button>
                                        <button type="button" class="star-btn" data-rating="2">⭐</button>
                                        <button type="button" class="star-btn" data-rating="3">⭐</button>
                                        <button type="button" class="star-btn" data-rating="4">⭐</button>
                                        <button type="button" class="star-btn" data-rating="5">⭐</button>
                                    </div>

                                    <textarea name="comment" class="rating-comment"
                                        placeholder="Share your experience with this technician (optional)..."></textarea>

                                    <button type="submit" class="btn-submit-rating" id="submitRating" disabled>
                                        🌟 Submit Rating
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Image Section -->
                <div class="image-section">
                    <div class="section-title">🖼️ Service Image</div>
                    @if ($order->image)
                        <img src="{{ asset($order->image) }}" alt="Service Request Image" class="request-image-large">
                    @else
                        <div class="no-image-large">
                            <div class="no-image-icon">🔧</div>
                            <div class="no-image-text">No image uploaded</div>
                        </div>
                    @endif
                </div>

                <!-- Description Section -->
                <div class="description-section">
                    <div class="section-title">📝 Description</div>
                    @if ($order->description)
                        <div class="description-content">{{ $order->description }}</div>
                    @else
                        <div class="description-content empty">No description provided</div>
                    @endif
                </div>

                <!-- Map Section -->
                <div class="map-section">
                    <div class="section-title">🗺️ Location</div>
                    <div class="map-container" id="map"></div>
                    <div class="coordinates-info">
                        <div class="coordinate-item">
                            <span class="coordinate-label">Latitude:</span>
                            <span class="coordinate-value">{{ $order->latitude }}</span>
                        </div>
                        <div class="coordinate-item">
                            <span class="coordinate-label">Longitude:</span>
                            <span class="coordinate-value">{{ $order->longitude }}</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Section -->
                <div class="timeline-section">
                    <div class="section-title">📅 Request Timeline</div>

                    <div class="timeline-item">
                        <div class="timeline-icon created">📝</div>
                        <div class="timeline-content">
                            <h4>Request Created</h4>
                            <p>{{ $order->created_at->format('M d, Y - h:i A') }}</p>
                        </div>
                    </div>

                    @if ($order->issue_reported_at)
                        <div class="timeline-item">
                            <div class="timeline-icon issue">⚠️</div>
                            <div class="timeline-content">
                                <h4>Issue Reported</h4>
                                <p>{{ $order->issue_reported_at->format('M d, Y - h:i A') }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($order->status === 'rescheduled')
                        <div class="timeline-item">
                            <div class="timeline-icon rescheduled">📅</div>
                            <div class="timeline-content">
                                <h4>Service Rescheduled</h4>
                                <p>Issue resolved, work will resume</p>
                            </div>
                        </div>
                    @endif

                    @if ($order->completed_at)
                        <div class="timeline-item">
                            <div class="timeline-icon completed">✅</div>
                            <div class="timeline-content">
                                <h4>Request Completed</h4>
                                <p>{{ \Carbon\Carbon::parse($order->completed_at)->format('M d, Y - h:i A') }}</p>
                            </div>
                        </div>
                    @endif
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
                html: '<div style="background: #3949ab; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 3px 10px rgba(0,0,0,0.3); border: 3px solid white;">📍</div>',
                iconSize: [40, 40],
                iconAnchor: [20, 40]
            });

            const marker = L.marker([latitude, longitude], {
                icon: customIcon
            }).addTo(map);

            marker.bindPopup(`
                <div style="padding: 10px; min-width: 200px;">
                    <h3 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 700; color: #333;">{{ $order->title }}</h3>
                    <p style="margin: 0; font-size: 13px; color: #666;">{{ $order->address ?? 'Service Location' }}</p>
                </div>
            `).openPopup();

            // Rating System
            @if ($order->status === 'completed' && $technician && !$existingRating)
                const starButtons = document.querySelectorAll('.star-btn');
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
                        const currentRating = parseInt(ratingValue.value);
                        starButtons.forEach((btn, index) => {
                            if (!btn.classList.contains('active')) {
                                btn.style.filter = 'grayscale(100%)';
                                btn.style.opacity = '0.4';
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
