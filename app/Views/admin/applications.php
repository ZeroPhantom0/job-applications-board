<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Job Applications</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; background: #f8fafc; color: #334155; }
        
        /* Layout Header */
        .header { background: #0f172a; color: #f8fafc; padding: 16px 32px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #1e293b; }
        .header h1 { font-size: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .logout-btn { background: #334155; padding: 8px 16px; border-radius: 6px; color: #f8fafc; text-decoration: none; transition: 0.2s; font-size: 14px; display: flex; align-items: center; gap: 6px; }
        .logout-btn:hover { background: #475569; }
        
        .container { max-width: 1440px; margin: 32px auto; padding: 0 24px; }
        
        /* Stats Section */
        .stats { display: flex; gap: 24px; margin-bottom: 24px; }
        .stat-card { flex: 1; background: #ffffff; border: 1px solid #e2e8f0; padding: 24px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; }
        .stat-info h3 { font-size: 28px; font-weight: 700; color: #0f172a; line-height: 1; margin-bottom: 6px; }
        .stat-info p { color: #64748b; font-size: 14px; font-weight: 500; }
        .stat-icon { font-size: 32px; color: #3b82f6; background: #eff6ff; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
        .stat-card.secondary .stat-icon { color: #0ec8a5; background: #e6f9f5; }

        /* Actions Bar / Search & Filter Dropdown */
        .search-box { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 24px; }
        .search-form { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
        
        .search-form .input-wrapper { flex: 2; min-width: 280px; position: relative; display: flex; align-items: center; }
        .search-form .input-wrapper .search-icon { position: absolute; left: 14px; color: #94a3b8; pointer-events: none; }

        .search-form input, .search-form select { padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; color: #334155; outline: none; transition: 0.15s; background-color: #fff; }
        .search-form input { width: 100%; padding-left: 42px; }
        .search-form input:focus, .search-form select:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15); }
        
        .search-form select { flex: 1; min-width: 200px; cursor: pointer; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; background-size: 16px; padding-right: 40px; }
        
        /* Table Styles */
        .table-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background: #f8fafc; padding: 16px; font-weight: 600; color: #475569; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; }
        td { padding: 16px; border-bottom: 1px solid #f1f5f9; font-size: 14px; vertical-align: middle; }
        
        /* Interactive clickable rows styling */
        .app-row { cursor: pointer; transition: background 0.15s ease; }
        .app-row:hover { background: #f1f5f9; }
        
        /* Elements */
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: #f1f5f9; color: #334155; border-radius: 6px; font-size: 13px; font-weight: 500; border: 1px solid #e2e8f0; }
        .btn-sm { padding: 8px 12px; border-radius: 6px; font-size: 13px; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.15s; position: relative; z-index: 5; }
        
        /* Action Buttons Container Grid */
        .action-buttons { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }

        /* Download Buttons Styles */
        .download-btn { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .download-btn:hover { background: #dcfce7; }
        
        /* Shortlist & Status Badge Styles */
        .shortlist-btn, .badge-shortlisted { background: #e6f9f5; color: #0d9488; border: 1px solid #99f6e4; }
        .shortlist-btn:hover { background: #ccfbf1; }
        .badge-shortlisted { display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; border-radius: 6px; font-size: 13px; font-weight: 500; cursor: default; }

        /* Reject & Status Badge Styles */
        .reject-btn, .badge-rejected { background: #fff5f5; color: #e11d48; border: 1px solid #fecdd3; }
        .reject-btn:hover { background: #ffe4e6; }
        .badge-rejected { display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; border-radius: 6px; font-size: 13px; font-weight: 500; cursor: default; }

        /* Delete Button Styles */
        .delete-btn { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .delete-btn:hover { background: #fee2e2; }
        
        .message-preview { max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #64748b; }
        
        /* CodeIgniter Pagination Explicit Style Reset Patch */
        .pagination { margin-top: 32px; display: flex; justify-content: center; }
        .pagination ul { display: flex; gap: 6px; list-style: none; padding: 0; margin: 0; align-items: center; }
        .pagination li { display: inline-block; padding: 0; margin: 0; border: none; }
        .pagination a, .pagination span { display: inline-block; padding: 8px 14px; background: white; border-radius: 6px; text-decoration: none; color: #475569; border: 1px solid #e2e8f0; font-size: 14px; transition: all 0.15s ease; }
        .pagination li.active span, .pagination .active { background: #2563eb; color: white; border-color: #2563eb; font-weight: 600; }
        .pagination a:hover { background: #f1f5f9; color: #0f172a; border-color: #cbd5e1; }
        
        /* Custom Modal Layout */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); display: flex; justify-content: center; align-items: center; z-index: 100; opacity: 0; pointer-events: none; transition: opacity 0.2s ease; }
        .modal-overlay.active { opacity: 1; pointer-events: auto; }
        
        .modal-window { background: #ffffff; border-radius: 16px; width: 100%; max-width: 650px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); transform: scale(0.95); transition: transform 0.2s ease; overflow: hidden; }
        .modal-overlay.active .modal-window { transform: scale(1); }
        
        .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid #e2e8f0; background: #f8fafc; }
        .modal-header h2 { font-size: 18px; color: #0f172a; font-weight: 600; }
        .modal-close-btn { background: none; border: none; font-size: 22px; color: #64748b; cursor: pointer; transition: color 0.1s; display: flex; align-items: center; }
        .modal-close-btn:hover { color: #0f172a; }
        
        .modal-body { padding: 24px; display: flex; flex-direction: column; gap: 18px; max-height: 70vh; overflow-y: auto; }
        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .info-item label { font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px; }
        .info-item p { font-size: 15px; color: #334155; font-weight: 500; word-break: break-all; }
        .info-item.full-width { grid-column: span 2; }
        
        .message-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 16px; border-radius: 8px; font-size: 14px; line-height: 1.6; color: #475569; white-space: pre-wrap; word-break: break-word; max-height: 200px; overflow-y: auto; }

        @media (max-width: 992px) {
            .stats { flex-direction: column; }
            .search-form { flex-direction: column; align-items: stretch; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="bi bi-briefcase-fill"></i> Job Applications Dashboard</h1>
        <a href="/admin/logout" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
    
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 500;">
                <i class="bi bi-check-circle-fill" style="margin-right: 8px;"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div style="background: #fff5f5; border: 1px solid #fecdd3; color: #e11d48; padding: 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 500;">
                <i class="bi bi-x-circle-fill" style="margin-right: 8px;"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-info">
                    <h3><?= $total ?></h3>
                    <p>Total Applications</p>
                </div>
                <div class="stat-icon"><i class="bi bi-collection-fill"></i></div>
            </div>
            <div class="stat-card secondary">
                <div class="stat-info">
                    <h3 id="live-count"><?= count($applications) ?></h3>
                    <p>Visible on This Page</p>
                </div>
                <div class="stat-icon"><i class="bi bi-file-earmark-person"></i></div>
            </div>
        </div>
        
        <div class="search-box">
            <div class="search-form">
                <div class="input-wrapper">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="liveSearchInput" value="<?= esc($search) ?>" placeholder="Live search by name, email, or details..." autocomplete="off">
                </div>

                <select id="positionFilter">
                    <option value="" <?= empty($position) ? 'selected' : '' ?>>All Job Positions</option>
                    <option value="Web Developer" <?= $position === 'Web Developer' ? 'selected' : '' ?>>Web Developer</option>
                    <option value="UI/UX Designer" <?= $position === 'UI/UX Designer' ? 'selected' : '' ?>>UI/UX Designer</option>
                    <option value="Laravel Developer" <?= $position === 'Laravel Developer' ? 'selected' : '' ?>>Laravel Developer</option>
                    <option value="Frontend Developer" <?= $position === 'Frontend Developer' ? 'selected' : '' ?>>Frontend Developer</option>
                    <option value="Project Manager" <?= $position === 'Project Manager' ? 'selected' : '' ?>>Project Manager</option>
                </select>
            </div>
        </div>
        
        <div style="overflow-x: auto;" class="table-card">
            <table id="appsTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Message</th>
                        <th>Resume</th>
                        <th>Applied On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if(empty($applications)): ?>
                        <tr class="no-data-row">
                            <td colspan="7" style="text-align: center; padding: 60px 20px; color: #94a3b8;">
                                <i class="bi bi-folder-x" style="font-size: 40px; display:block; margin-bottom:10px;"></i>
                                No applications match the selected criteria on this page.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($applications as $app): ?>
                        <tr class="app-row" 
                            data-name="<?= esc($app['name']) ?>" 
                            data-email="<?= esc($app['email']) ?>" 
                            data-position="<?= esc($app['position']) ?>" 
                            data-date="<?= date('F d, Y h:i A', strtotime($app['created_at'])) ?>" 
                            data-message="<?= esc($app['message'] ?? 'No message provided.') ?>">
                            
                            <td><strong class="search-target" style="color: #0f172a;"><?= esc($app['name']) ?></strong></td>
                            <td class="search-target"><?= esc($app['email']) ?></td>
                            <td><span class="badge position-target"><?= esc($app['position']) ?></span></td>
                            <td class="message-preview"><?= esc(substr($app['message'] ?? '', 0, 40)) ?><?= strlen($app['message'] ?? '') > 40 ? '...' : '' ?></td>
                            <td>
                                <?php if($app['resume_file']): ?>
                                    <span class="file-link-block"><i class="bi bi-file-earmark-text"></i> <?= esc($app['resume_file']) ?></span>
                                <?php else: ?>
                                    <span style="color:#cbd5e1; font-size:12px;">None</span>
                                <?php endif; ?>
                            </td>
                            <td style="color: #64748b; font-size: 13px; white-space: nowrap;">
                                <?= date('M d, Y h:i A', strtotime($app['created_at'])) ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <?php if($app['resume_file']): ?>
                                        <a href="/admin/download/<?= esc($app['resume_file']) ?>" class="btn-sm download-btn" title="Download Resume" onclick="event.stopPropagation();"><i class="bi bi-download"></i></a>
                                    <?php endif; ?>
                                    
                                    <?php if(isset($app['status']) && $app['status'] == 'pending'): ?>
                                        <a href="/admin/shortlist/<?= $app['id'] ?>" class="btn-sm shortlist-btn" onclick="event.stopPropagation(); return confirm('Shortlist this candidate? They will receive an email.')"><i class="bi bi-check-circle"></i></a>
                                        <a href="/admin/reject/<?= $app['id'] ?>" class="btn-sm reject-btn" onclick="event.stopPropagation(); return confirm('Reject this application? They will receive an email.')"><i class="bi bi-x-circle"></i></a>
                                    <?php elseif(isset($app['status']) && $app['status'] == 'shortlisted'): ?>
                                        <span class="badge-shortlisted"><i class="bi bi-star-fill"></i> Shortlisted</span>
                                    <?php elseif(isset($app['status']) && $app['status'] == 'rejected'): ?>
                                        <span class="badge-rejected"><i class="bi bi-x-circle-fill"></i> Rejected</span>
                                    <?php endif; ?>
                                    
                                    <a href="/admin/delete/<?= $app['id'] ?>" class="btn-sm delete-btn" title="Delete Entry" onclick="event.stopPropagation(); return confirm('Delete this application permanently?')"><i class="bi bi-trash3"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr id="emptySearchRow" style="display: none;">
                            <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">No matches found matching your filters on this page. Try shifting pages.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="pagination" id="paginator">
            <?php 
                if (isset($pager)) {
                    $pager->setPath('/admin/applications');
                    // Appends server-side search strings straight to pagination navigation links
                    echo $pager->links('default', 'default_full'); 
                }
            ?>
        </div>
    </div>

    <div class="modal-overlay" id="appModalOverlay">
        <div class="modal-window">
            <div class="modal-header">
                <h2>Application Details</h2>
                <button class="modal-close-btn" id="closeModalBtn">&times;</button>
            </div>
            <div class="modal-body">
                <div class="info-grid">
                    <div class="info-item">
                        <label>Full Name</label>
                        <p id="modalName"></p>
                    </div>
                    <div class="info-item">
                        <label>Email Address</label>
                        <p id="modalEmail"></p>
                    </div>
                    <div class="info-item">
                        <label>Applied Position</label>
                        <p><span class="badge" id="modalPosition" style="background:#eff6ff; color:#2563eb; border-color:#bfdbfe;"></span></p>
                    </div>
                    <div class="info-item">
                        <label>Submission Date</label>
                        <p id="modalDate" style="color: #64748b; font-size: 14px;"></p>
                    </div>
                    <div class="info-item full-width">
                        <label>Applicant Message / Cover Letter</label>
                        <div class="message-box" id="modalMessage"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('liveSearchInput');
            const positionFilter = document.getElementById('positionFilter');
            const rows = document.querySelectorAll('.app-row');
            const liveCount = document.getElementById('live-count');
            const emptyRow = document.getElementById('emptySearchRow');

            // Modal Elements
            const modalOverlay = document.getElementById('appModalOverlay');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const modalName = document.getElementById('modalName');
            const modalEmail = document.getElementById('modalEmail');
            const modalPosition = document.getElementById('modalPosition');
            const modalDate = document.getElementById('modalDate');
            const modalMessage = document.getElementById('modalMessage');

            let searchTimeout = null;

            // Fluid Live Counter checking row visibilities
            const filterTable = () => {
                const textVal = input.value.toLowerCase().trim();
                const selectedPosition = positionFilter.value.toLowerCase().trim();
                let visibleCount = 0;

                rows.forEach(row => {
                    const nameText = row.getAttribute('data-name').toLowerCase();
                    const emailText = row.getAttribute('data-email').toLowerCase();
                    const msgText = row.getAttribute('data-message').toLowerCase();
                    const rowPosition = row.getAttribute('data-position').toLowerCase().trim();
                    
                    const matchesText = nameText.includes(textVal) || emailText.includes(textVal) || msgText.includes(textVal);
                    const matchesPosition = selectedPosition === "" || rowPosition === selectedPosition;

                    if (matchesText && matchesPosition) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if(liveCount) liveCount.textContent = visibleCount;
                if(emptyRow) emptyRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
            };

            // Updates the browser window URL context natively as you type or pick elements
            const updateURLParams = () => {
                const url = new URL(window.location.href);
                
                if (input.value.trim() !== '') {
                    url.searchParams.set('search', input.value.trim());
                } else {
                    url.searchParams.delete('search');
                }

                if (positionFilter.value !== '') {
                    url.searchParams.set('position', positionFilter.value);
                } else {
                    url.searchParams.delete('position');
                }
                
                // Keep page index context clear when swapping baseline parameters
                url.searchParams.delete('page'); 
                
                history.replaceState(null, '', url.toString());
            };

            // Asynchronous key inputs trigger instantaneous filter visuals, then updates database endpoints
            input.addEventListener('input', () => {
                filterTable();
                
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    // Triggers server query smoothly without interrupting keystroke streams
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', input.value.trim());
                    if(positionFilter.value) url.searchParams.set('position', positionFilter.value);
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                }, 750); // 750ms latency buffer allows natural text typing 
            });

            // Dropdown changes fire structural redirects immediately to refresh the model scopes
            positionFilter.addEventListener('change', () => {
                filterTable();
                updateURLParams();
                const url = new URL(window.location.href);
                if (positionFilter.value !== '') {
                    url.searchParams.set('position', positionFilter.value);
                } else {
                    url.searchParams.delete('position');
                }
                if (input.value.trim() !== '') url.searchParams.set('search', input.value.trim());
                url.searchParams.delete('page');
                window.location.href = url.toString();
            });

            // Open Detail Modal Window Row Binder
            rows.forEach(row => {
                row.addEventListener('click', () => {
                    modalName.textContent = row.getAttribute('data-name');
                    modalEmail.textContent = row.getAttribute('data-email');
                    modalPosition.textContent = row.getAttribute('data-position');
                    modalDate.textContent = row.getAttribute('data-date');
                    modalMessage.textContent = row.getAttribute('data-message');
                    
                    modalOverlay.classList.add('active');
                });
            });

            // Dismiss Modals
            const closeModal = () => modalOverlay.classList.remove('active');
            closeModalBtn.addEventListener('click', closeModal);
            modalOverlay.addEventListener('click', (e) => { if(e.target === modalOverlay) closeModal(); });
            document.addEventListener('keydown', (e) => { if(e.key === 'Escape' && modalOverlay.classList.contains('active')) closeModal(); });

            // Run alignment layouts immediately on load setup
            filterTable();
        });
    </script>
</body>
</html>