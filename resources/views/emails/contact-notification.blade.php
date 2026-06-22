<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Blue Wave Travel - Yeu cau lien he moi</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.5;">
    <h2 style="margin: 0 0 12px; color: #0f4c81;">Blue Wave Travel co yeu cau lien he moi</h2>

    <p><strong>Ho va ten:</strong> {{ $contact['fullname'] }}</p>
    <p><strong>So dien thoai:</strong> {{ $contact['phone'] }}</p>
    <p><strong>Email:</strong> {{ $contact['email'] }}</p>
    <p><strong>Chu de:</strong> {{ $contact['subject'] ?: 'Khong co chu de' }}</p>

    <div style="margin-top: 16px;">
        <strong>Noi dung:</strong>
        <div style="margin-top: 8px; padding: 12px; background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 8px;">
            {!! nl2br(e($contact['message'] ?: 'Khach hang khong nhap noi dung chi tiet.')) !!}
        </div>
    </div>

    <p style="margin-top: 18px; color: #64748b; font-size: 13px;">
        Gui tu form lien he tren website Blue Wave Travel.
    </p>
</body>
</html>
