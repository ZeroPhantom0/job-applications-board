<?php

namespace App\Controllers;

use App\Models\ApplicationModel;

class Admin extends BaseController
{
    // Show login form
    public function login()
    {
        if (session()->get('isAdminLoggedIn')) {
            return redirect()->to('/admin/applications');
        }
        
        return view('admin/login');
    }
    
    // Process login
    public function doLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $validEmail = 'admin@jobsboard.com';
        $validPassword = 'admin123';
        
        if ($email === $validEmail && $password === $validPassword) {
            session()->set([
                'isAdminLoggedIn' => true,
                'adminEmail' => $email,
                'adminLoginTime' => date('Y-m-d H:i:s')
            ]);
            
            session()->setFlashdata('success', 'Welcome to Admin Panel!');
            return redirect()->to('/admin/applications');
        } else {
            session()->setFlashdata('error', 'Invalid email or password');
            return redirect()->back();
        }
    }
    
    // Logout
    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'You have been logged out');
        return redirect()->to('/admin/login');
    }
    
    // Show paginated applications
    public function applications()
    {
        if (!session()->get('isAdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $model = new ApplicationModel();
        $search = $this->request->getGet('search');
        
        if ($search) {
            $model->groupStart()
                  ->like('name', $search)
                  ->orLike('email', $search)
                  ->orLike('position', $search)
                  ->orLike('message', $search)
                  ->groupEnd();
        }
        
        $applications = $model->orderBy('created_at', 'DESC')->paginate(5);
        $pager = $model->pager;
        
        $data = [
            'applications' => $applications,
            'pager' => $pager,
            'search' => $search,
            'total' => $model->countAllResults(false)
        ];
        
        return view('admin/applications', $data);
    }
    
    // Delete application
    public function delete($id)
    {
        if (!session()->get('isAdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $model = new ApplicationModel();
        $application = $model->find($id);
        
        if ($application) {
            $filePath = WRITEPATH . 'uploads/' . $application['resume_file'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            $model->delete($id);
            session()->setFlashdata('success', 'Application #' . $id . ' has been deleted.');
        } else {
            session()->setFlashdata('error', 'Application not found.');
        }
        
        return redirect()->to('/admin/applications');
    }
    
    // Download resume file natively to maintain true formats
    public function download($filename)
    {
        if (!session()->get('isAdminLoggedIn')) {
            return redirect()->to('/admin/login');
        }
        
        $filename = basename($filename);
        $filePath = WRITEPATH . 'uploads/' . $filename;
        
        if (!file_exists($filePath)) {
            session()->setFlashdata('error', 'File not found.');
            return redirect()->to('/admin/applications');
        }
        
        // Strip the Unix timestamp prefix from the front of the name
        $originalName = preg_replace('/^\d+_/', '', $filename);
        
        // CI4 native handling preserves exact byte streams and avoids .bin issues
        return $this->response->download($filePath, null)->setFileName($originalName);
    }

    // Shortlist application
public function shortlist($id)
{
    if (!session()->get('isAdminLoggedIn')) {
        return redirect()->to('/admin/login');
    }
    
    $model = new ApplicationModel();
    $application = $model->find($id);
    
    if ($application) {
        // Update status
        $model->update($id, ['status' => 'shortlisted']);
        
        // Send shortlist email
        $this->sendStatusEmail($application, 'shortlisted');
        
        session()->setFlashdata('success', 'Candidate has been shortlisted! Email sent.');
    }
    
    return redirect()->to('/admin/applications');
}

// Reject application
public function reject($id)
{
    if (!session()->get('isAdminLoggedIn')) {
        return redirect()->to('/admin/login');
    }
    
    $model = new ApplicationModel();
    $application = $model->find($id);
    
    if ($application) {
        // Update status
        $model->update($id, ['status' => 'rejected']);
        
        // Send rejection email
        $this->sendStatusEmail($application, 'rejected');
        
        session()->setFlashdata('success', 'Application rejected. Email sent to candidate.');
    }
    
    return redirect()->to('/admin/applications');
}

// Send status email
private function sendStatusEmail($application, $status)
{
    $email = \Config\Services::email();
    
    $config = [
        'protocol'  => 'smtp',
        'SMTPHost'  => 'smtp-relay.brevo.com',
        'SMTPUser'  => 'aca188001@smtp-brevo.com',
        'SMTPPass'  => '5IQznWBcGPTVORa8',
        'SMTPPort'  => 587,
        'SMTPCrypto'=> 'tls',
        'mailType'  => 'html'
    ];
    
    $email->initialize($config);
    $email->setFrom('francissabiniano20@gmail.com', 'Job Applications Board');
    $email->setTo($application['email']);
    
    if ($status == 'shortlisted') {
        $email->setSubject('Good News: You\'ve Been Shortlisted! - ' . $application['position']);
        $message = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #28a745; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Congratulations, " . $application['name'] . "!</h2>
                </div>
                <div class='content'>
                    <p>We are pleased to inform you that you have been <strong>shortlisted</strong> for the position of <strong>" . $application['position'] . "</strong>.</p>
                    <p>Our HR team will contact you within 3-5 business days to schedule an interview.</p>
                    <hr>
                    <p><strong>Next Steps:</strong></p>
                    <ul>
                        <li>Check your email regularly for interview scheduling</li>
                        <li>Prepare for the interview (technical assessment may be included)</li>
                        <li>Have your portfolio/demo ready if applicable</li>
                    </ul>
                    <p>We look forward to meeting you!</p>
                    <p>Best regards,<br><strong>HR Team</strong><br>Job Applications Board</p>
                </div>
            </div>
        </body>
        </html>
        ";
    } else {
        $email->setSubject('Update on Your Application - ' . $application['position']);
        $message = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #dc3545; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Thank You for Your Interest</h2>
                </div>
                <div class='content'>
                    <p>Dear <strong>" . $application['name'] . "</strong>,</p>
                    <p>Thank you for applying for the position of <strong>" . $application['position'] . "</strong>.</p>
                    <p>After careful review of all applications, we regret to inform you that you have not been selected to proceed to the next stage.</p>
                    <p>This decision was not easy, as we received many qualified applications. We encourage you to apply for future openings that match your skills.</p>
                    <p>We wish you the best in your job search!</p>
                    <p>Sincerely,<br><strong>HR Team</strong><br>Job Applications Board</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
    
    $email->setMessage($message);
    $email->send();
    
    log_message('info', $status . ' email sent to: ' . $application['email']);
}
}