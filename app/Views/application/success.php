<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted - Job Applications Board</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; background: #f8fafc; min-height: 100vh; display: flex; justify-content: center; align-items: center; margin: 0; padding: 20px; }
        
        .success-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 48px; text-align: center; max-width: 520px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.05); }
        
        .checkmark-wrapper { display: inline-flex; width: 80px; height: 80px; background: #f0fdf4; color: #16a34a; border-radius: 50%; font-size: 40px; align-items: center; justify-content: center; margin-bottom: 24px; border: 1px solid #bbf7d0; }
        
        h1 { color: #0f172a; font-size: 26px; font-weight: 700; margin-bottom: 12px; }
        p { color: #64748b; font-size: 15px; line-height: 1.6; margin-bottom: 32px; }
        
        .btn-group { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; font-size: 15px; font-weight: 600; text-decoration: none; border-radius: 8px; transition: 0.15s; }
        
        .btn-primary { background: #2563eb; color: #ffffff; }
        .btn-primary:hover { background: #1d4ed8; }
        
        .btn-secondary { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
        .btn-secondary:hover { background: #e2e8f0; color: #0f172a; }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="checkmark-wrapper">
            <i class="bi bi-check-lg"></i>
        </div>
        <h1>Application Submitted!</h1>
        <p>Thank you for applying. We have received your profile and will review it shortly.<br>A confirmation message has been dispatched to your email address.</p>
        
        <div class="btn-group">
            <a href="/apply" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Submit Another</a>
            <a href="/" class="btn btn-secondary"><i class="bi bi-house"></i> Back to Home</a>
        </div>
    </div>
</body>
</html>