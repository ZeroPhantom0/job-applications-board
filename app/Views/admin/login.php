<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Job Applications Board</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; background: #f1f5f9; min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; }
        
        .login-box { background: #ffffff; border-radius: 16px; padding: 40px; width: 100%; max-width: 440px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3); }
        .login-box h2 { text-align: center; margin-bottom: 8px; color: #0f172a; font-size: 24px; font-weight: 700; }
        .login-subtitle { text-align: center; color: #64748b; font-size: 14px; margin-bottom: 32px; }
        
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; color: #334155; font-size: 14px; }
        
        .input-group { position: relative; }
        .input-group i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 16px; }
        .input-group input { width: 100%; padding: 12px 12px 12px 42px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #334155; outline: none; transition: 0.15s; }
        .input-group input:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15); }
        
        button { width: 100%; padding: 12px; background: #2563eb; color: white; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.15s; }
        button:hover { background: #1d4ed8; }
        
        /* Modern Flat Borders Alerts */
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; text-align: left; font-size: 14px; display: flex; align-items: center; gap: 10px; font-weight: 500; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        
        .demo-info { margin-top: 24px; padding: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #475569; line-height: 1.5; }
        .demo-info strong { color: #334155; }
        
        .back-link { text-align: center; margin-top: 24px; }
        .back-link a { color: #2563eb; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; }
        .back-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <p class="login-subtitle">Access the job applications dashboard panel</p>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div><?= esc(session()->getFlashdata('error')) ?></div>
            </div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i>
                <div><?= esc(session()->getFlashdata('success')) ?></div>
            </div>
        <?php endif; ?>
        
        <form action="/admin/doLogin" method="post">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label>Email Address</label>
                <div class="input-group">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" placeholder="admin@jobsboard.com" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" placeholder="••••••" required>
                </div>
            </div>
            
            <button type="submit">Sign In <i class="bi bi-arrow-right"></i></button>
        </form>
        
        <div class="demo-info">
            <i class="bi bi-info-circle-fill" style="color: #3b82f6; margin-right: 4px;"></i> <strong>Demo Credentials:</strong><br>
            <span style="display:inline-block; margin-top:4px;">Email: admin@jobsboard.com</span><br>
            <span>Password: admin123</span>
        </div>
        
        <div class="back-link">
            <a href="/"><i class="bi bi-arrow-left"></i> Back to Job Application</a>
        </div>
    </div>
</body>
</html>