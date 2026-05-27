<?php

namespace App\Controllers;

use App\Models\ApplicationModel;
use CodeIgniter\Controller;

class Application extends BaseController
{
    public function form()
    {
        return view('application/form');
    }

    public function submit()
    {
        $model = new ApplicationModel();
        $file = $this->request->getFile('resume');
        
        $rules = [
            'name' => 'required|min_length[2]',
            'email' => 'required|valid_email',
            'position' => 'required|min_length[2]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        if (!$file || !$file->isValid()) {
            return redirect()->back()->withInput()->with('error', 'Please upload a valid resume file.');
        }
        
        $fileSize = $file->getSize();
        $fileExt = $file->getExtension();
        $allowedExts = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array(strtolower($fileExt), $allowedExts)) {
            return redirect()->back()->withInput()->with('error', 'Only PDF, DOC, DOCX, JPG, JPEG, or PNG files are allowed.');
        }
        
        if ($fileSize > $maxSize) {
            return redirect()->back()->withInput()->with('error', 'File size must be less than 5MB.');
        }
        
        $originalName = $file->getClientName();
        $originalName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
        
        $newFileName = time() . '_' . $originalName;
        
        if (!$file->move(WRITEPATH . 'uploads', $newFileName)) {
            return redirect()->back()->withInput()->with('error', 'Failed to upload file. Please try again.');
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'position' => $this->request->getPost('position'),
            'message' => $this->request->getPost('message'),
            'resume_file' => $newFileName,
            'status' => 'pending' // Initialize standard application state flags
        ];
        
        if ($model->insert($data)) {
            session()->set('last_id', $model->getInsertID());
            $this->sendEmail($data);
            
            session()->setFlashdata('success', 'Application submitted successfully! We will contact you soon.');
            return redirect()->to('/success');
        } else {
            if (file_exists(WRITEPATH . 'uploads/' . $newFileName)) {
                unlink(WRITEPATH . 'uploads/' . $newFileName);
            }
            return redirect()->back()->withInput()->with('error', 'Failed to save application. Please try again.');
        }
    }
    
    private function sendEmail($applicationData)
    {
        $email = \Config\Services::email();
        $config = new \Config\Email();
        $email->initialize($config);
        
        $email->setFrom(getenv('email.fromEmail') ?: 'noreply@jobsboard.com', getenv('email.fromName') ?: 'Job Applications Board');
        $email->setTo($applicationData['email']);
        $email->setSubject('Application Received - ' . $applicationData['position']);
        
        $message = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #007bff; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Application Received!</h2>
                </div>
                <div class='content'>
                    <p>Dear <strong>" . esc($applicationData['name']) . "</strong>,</p>
                    <p>Thank you for applying for the position of <strong>" . esc($applicationData['position']) . "</strong>.</p>
                    <p>We have received your application and will review it shortly.</p>
                    <p>Best regards,<br><strong>HR Team</strong></p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        $email->setMessage($message);
        
        $textMessage = "Application Received!\n\n";
        $textMessage .= "Dear " . $applicationData['name'] . ",\n\n";
        $textMessage .= "Thank you for applying for the position of " . $applicationData['position'] . ".\n";
        $textMessage .= "We have received your application and will review it shortly.\n\n";
        $textMessage .= "Best regards,\nHR Team";
        
        $email->setAltMessage($textMessage);
        
        if ($email->send()) {
            log_message('info', 'Email sent to: ' . $applicationData['email']);
        } else {
            log_message('error', 'Failed to send email to: ' . $applicationData['email']);
        }
    }
    
    public function success()
    {
        return view('application/success');
    }
}