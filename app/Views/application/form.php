<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application - Apply Now</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; background: #f1f5f9; min-height: 100vh; padding: 40px 20px; color: #334155; }
        
        .container { max-width: 720px; margin: 0 auto; }
        .form-card { background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.05); overflow: hidden; }
        
        .header { background: #0f172a; color: white; padding: 32px; text-align: center; border-bottom: 1px solid #1e293b; }
        .header h1 { font-size: 26px; font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .header p { opacity: 0.8; font-size: 15px; }
        
        .form-body { padding: 40px; }
        .form-group { margin-bottom: 24px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #0f172a; font-size: 14px; }
        
        input, select, textarea { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px; color: #334155; background-color: #fff; outline: none; transition: 0.15s; }
        input:focus, select:focus, textarea:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15); }
        
        select { appearance: none; background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-position: right 12px center; background-size: 14px; padding-right: 40px; }
        textarea { resize: vertical; min-height: 120px; }
        
        .file-input { padding: 12px; background: #f8fafc; border: 1px dashed #cbd5e1; cursor: pointer; }
        .file-info { font-size: 13px; color: #64748b; margin-top: 6px; display: flex; align-items: center; gap: 4px; }
        
        button { width: 100%; padding: 14px; background: #2563eb; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.15s; }
        button:hover { background: #1d4ed8; }
        
        .alert { padding: 14px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; display: flex; align-items: center; gap: 10px; font-weight: 500; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        
        .admin-link { text-align: center; margin-top: 24px; }
        .admin-link a { color: #475569; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; }
        .admin-link a:hover { color: #0f172a; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <div class="header">
                <h1><i class="bi bi-pencil-square"></i> Job Application</h1>
                <p>Join our high-performing team and scale your tech career</p>
            </div>
            <div class="form-body">
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
                
                <form action="/submit" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" name="name" value="<?= old('name') ?>" placeholder="Full Name" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" value="<?= old('email') ?>" placeholder="sample@example.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Position Applying For *</label>
                        <select name="position" required>
                            <option value="">Select Position</option>
                            <option value="Web Developer">Web Developer</option>
                            <option value="UI/UX Designer">UI/UX Designer</option>
                            <option value="Codeigniter4 Developer">Codeigniter4 Developer</option>
                            <option value="Laravel Developer">Laravel Developer</option>
                            <option value="Frontend Developer">Frontend Developer</option>
                            <option value="Project Manager">Project Manager</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Cover Message</label>
                        <textarea name="message" placeholder="Tell us why you're the ideal fit for this role..."><?= old('message') ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Upload Resume *</label>
                        <input type="file" name="resume" class="file-input" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                        <div class="file-info">
                            <i class="bi bi-info-circle"></i> 
                            <span>Max file size: 5MB. Allowed formats: PDF, DOC, DOCX, JPG, JPEG, PNG</span>
                        </div>
                    </div>
                    
                    <button type="submit">Submit Application <i class="bi bi-send-fill"></i></button>
                </form>
            </div>
        </div>
        <div class="admin-link">
            <a href="/admin/login"><i class="bi bi-shield-lock-fill"></i> Admin Portal Login</a>
        </div>
    </div>
</body>
</html>