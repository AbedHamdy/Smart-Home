<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Error' }} - Smart Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .error-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 60px 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-icon {
            font-size: 100px;
            margin-bottom: 20px;
            animation: bounce 1s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .error-code {
            font-size: 72px;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .error-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 15px;
        }

        .error-message {
            font-size: 16px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .error-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 30px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-2px);
        }

        .error-details {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #f1f5f9;
        }

        .error-tip {
            background: #f8fafc;
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            border-radius: 8px;
            text-align: left;
            margin-top: 20px;
        }

        .error-tip-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .error-tip-text {
            font-size: 14px;
            color: #64748b;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .error-container {
                padding: 40px 25px;
            }

            .error-code {
                font-size: 56px;
            }

            .error-title {
                font-size: 22px;
            }

            .error-icon {
                font-size: 80px;
            }

            .error-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- ... نفس الـ HTML قبل كده ... -->

{{-- <div class="error-details">
    <div class="error-tip">
        <div class="error-tip-title">
            💡 Exception Details
        </div>
        <div class="error-tip-text">
            @if(config('app.debug') && isset($exception))
                <p><strong>Message:</strong> {{ $exception->getMessage() }}</p>
                <p><strong>File:</strong> {{ $exception->getFile() }} (Line {{ $exception->getLine() }})</p>
                <pre>{{ $exception->getTraceAsString() }}</pre>
            @else
                The page you're trying to access requires a different request method.
            @endif
        </div>
    </div>
</div> --}}

    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <div class="error-code">{{ $code ?? '405' }}</div>
        <h1 class="error-title">{{ $title ?? 'Method Not Allowed' }}</h1>
        <p class="error-message">
            {{ $message ?? 'The request method is not allowed for this route.' }}
        </p>

        <div class="error-actions">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                ← Go Back
            </a>
            <a href="{{ route('login') }}" class="btn btn-primary">
                🏠 Go to Home
            </a>
        </div>

        <div class="error-details">
            <div class="error-tip">
                <div class="error-tip-title">
                    💡 What happened?
                </div>
                <div class="error-tip-text">
                    The page you're trying to access requires a different request method.
                    This usually happens when you try to access a form submission URL directly.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
