<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>حالة الدفع</title>
</head>
<body>
    <h1>حالة الدفع</h1>

    @if($status == 'success')
        <p>تم الدفع بنجاح ✅</p>
    @elseif($status == 'failed')
        <p>حدث خطأ أثناء الدفع ❌</p>
    @else
        <p>حالة الدفع غير معروفة ⚠️</p>
    @endif

    <a href="{{ url('/') }}">العودة للرئيسية</a>
</body>
</html>
