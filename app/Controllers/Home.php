<?php

namespace App\Controllers;

class Home extends BaseController

{
    public function header($data): string
    {
        return view('header', $data);
    }

    public function footer($data): string
    {
        return view('footer', $data);
    }

    public function index(): string
    {
        $data['slug'] = 'index';
        $data['header'] = $this->header($data);
        $data['footer'] = $this->footer($data);

        return view('index', $data);
    }

    public function about(): string
    {
        $data['slug'] = 'about';
        $data['header'] = $this->header($data);
        $data['footer'] = $this->footer($data);

        return view('about', $data);
    }


    public function fund(): string
    {
        $data['slug'] = 'fund';
        $data['header'] = $this->header($data);
        $data['footer'] = $this->footer($data);

        return view('fund', $data);
    }


    public function portfolio(): string
    {
        $data['slug'] = 'portfolio';
        $data['header'] = $this->header($data);
        $data['footer'] = $this->footer($data);

        return view('portfolio', $data);
    }

    public function news(): string
    {
        $data['slug'] = 'news';
        $data['header'] = $this->header($data);
        $data['footer'] = $this->footer($data);

        return view('news', $data);
    }

    public function news_details(): string
    {
        $data = [];
        $data['header'] = $this->header($data);
        $data['footer'] = $this->footer($data);

        return view('news_details', $data);
    }


//    public function sendEmail()
//    {
//        $emailService = \Config\Services::email();
//        $postData = $this->request->getPost();
//        $name = trim($postData['name']);
//        $userEmail = trim($postData['email']);
//        $message = trim($postData['message']);
//        $option = $postData['radio'];
//        $errors = [];
//
//        $pdfPathForDB = '';
//        $pdfFile = $this->request->getFile('pdf');
//
//        if ($pdfFile && $pdfFile->isValid() && !$pdfFile->hasMoved()) {
//            if ($pdfFile->getClientMimeType() === 'application/pdf') {
//                if ($pdfFile->getSize() <= 3 * 1024 * 1024) {
//                    $uploadPath = FCPATH . 'pdfs/';
//                    $pdfName = pathinfo($pdfFile->getName(), PATHINFO_FILENAME) . '_' . uniqid() . '.' . $pdfFile->getClientExtension();
//                    $pdfPathForDB = '/pdfs/' . $pdfName;
//
//                    if (!$pdfFile->move($uploadPath, $pdfName)) {
//                        $response['message'] = 'Failed to move PDF file';
//                        return $this->response->setJSON($response);
//                    }
//                } else {
//                    $errors['err_pdf'] = 'File size exceeds 3 MB. Please upload a smaller file.';
//                }
//            } else {
//                $errors['err_pdf'] = 'Invalid file type. Only PDF files are allowed.';
//            }
//        }
//
//
//        if (empty($name)) {
//            $errors['err_name'] = 'Name is required.';
//        } elseif (strlen($name) < 3) {
//            $errors['err_name'] = 'Name must be at least 3 characters long.';
//        } elseif (strlen($name) > 50) {
//            $errors['err_name'] = 'Name cannot exceed 50 characters.';
//        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $name) ) {
//            $errors['err_name'] = 'Name can only contain letters and spaces.';
//        }
//
//        if (empty($userEmail)) {
//            $errors['err_email'] = 'Email is required.';
//        } elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
//            $errors['err_email'] = 'Invalid email format.';
//        }
//
//        if (empty($message)) {
//            $errors['err_message'] = 'Message is required.';
//        } elseif (strlen($message) < 10) {
//            $errors['err_message'] = 'Message must be at least 10 characters long.';
//        } elseif (strlen($message) > 500) {
//            $errors['err_message'] = 'Message cannot exceed 500 characters.';
//        } elseif (preg_match('/[<>"\'@#$%^&*()_]/', $message)) {
//            $errors['err_message'] = 'Message cannot contain special characters such as <, >, ", \', @, #, $, %, ^, &, *, (, ), _.';
//        }
//
//
//        if (!empty($errors)) {
//            return $this->response->setJSON(['status' => 'error', 'messages' => $errors]);
//        } else {
//            $emailMessage = "
//    <html>
//    <head>
//        <style>
//   body {
//            font-family: Arial, sans-serif;
//            margin: 0;
//            padding: 0;
//            background-color: #f4f4f4;
//        }
//        .container {
//            max-width: 600px;
//            margin: 20px auto;
//            background-color: #ffffff;
//            border-radius: 8px;
//            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
//            overflow: hidden;
//        }
//        .content {
//            padding: 20px;
//        }
//        .details {
//            margin-top: 20px;
//            padding: 15px;
//            background-color: #f9f9f9;
//            border-left: 5px solid #007BFF;
//        }
//        p {
//            line-height: 1.6;
//            color: #333;
//        }
//        strong {
//            color: #007BFF;
//        }
//           </style>
//    </head>
//    <body>
//        <div class='container'>
//            <div class='content'>
//                <p>You have received a new message from a user about '$option'. Here are the details:</p>
//                <div class='details'>
//                    <p><strong>Name:</strong> $name</p>
//                    <p><strong>Email:</strong> $userEmail</p>
//                    <p><strong>Message:</strong><br>$message</p>
//                    <p><strong>Click <a href='" . base_url($pdfPathForDB) . "' target='_blank'>here</a> to view the file.</strong></p>
//
//                </div>
//            </div>
//        </div>
//    </body>
//    </html>
//    ";
//
//            $emailMessageForUser = "
//    <html>
//    <head>
//       <style>
//        body {
//            font-family: Arial, sans-serif;
//            margin: 0;
//            padding: 0;
//            background-color: #f4f4f4;
//        }
//        .container {
//            max-width: 600px;
//            margin: 20px auto;
//            background-color: #ffffff;
//            border-radius: 8px;
//            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
//            overflow: hidden;
//        }
//        .content {
//            padding: 20px;
//        }
//        .details {
//            margin-top: 20px;
//            padding: 15px;
//            background-color: #f9f9f9;
//            border-left: 5px solid #007BFF;
//        }
//        p {
//            line-height: 1.6;
//            color: #333;
//        }
//        strong {
//            color: #007BFF;
//        }
//        a {
//            color: #007BFF;
//            text-decoration: none;
//        }
//        a:hover {
//            text-decoration: underline;
//        }
//    </style>
//    </head>
//    <body>
//        <div class='container'>
//            <div class='content'>
//                <p>Hi $name,</p>
//                <p>Thank you for contacting us! We have received your message and appreciate you taking the time to get in touch.</p>
//                <p>If you have any additional information or questions in the meantime, feel free to reply to this email.</p>
//                <p>Best regards,</p>
//                <div class='details'>
//                    <p><strong>Studio Shoo</strong></p>
//                    <p><strong><a href=\"tel:+37455664651\">+374 55 664 651</a></strong></p>
//                    <p><strong><a href='https://studio.run.am'>Studio.am</a></strong></p>
//                </div>
//            </div>
//
//        </div>
//    </body>
//    </html>
//    ";
//
//            $config = [
//                'protocol' => 'smtp',
//                'SMTPHost' => 'smtp.gmail.com',
//                'SMTPPort' => 587,
//                'SMTPUser' => 'kyoroghlyanmaria@gmail.com',
//                'SMTPPass' => 'fjsuvajemelxcvnp',
//                'mailType' => 'html',
//                'charset' => 'utf-8',
//                'wordWrap' => true,
//                'newline' => "\r\n"
//            ];
//
//            $emailService->initialize($config);
//
//            $emailService->setFrom('kyoroghlyanmaria@gmail.com', 'Studio Shoo');
//            $emailService->setTo('kyoroghlyanmaria@gmail.com');
//            $emailService->setSubject('Message for Studio Shoo');
//            $emailService->setMessage($emailMessage);
//
//            if (!$emailService->send()) {
//                $data = $emailService->printDebugger(['headers']);
//                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to send email to the company.', 'debug' => $data]);
//            }
//
//            $emailService->clear();
//            $emailService->setFrom('kyoroghlyanmaria@gmail.com', 'Studio Shoo');
//            $emailService->setTo($userEmail);
//            $emailService->setSubject('We have received your message');
//            $emailService->setMessage($emailMessageForUser);
//
//            if ($emailService->send()) {
//                return $this->response->setJSON(['status' => 'success', 'message' => 'Emails successfully sent!']);
//            } else {
//                $data = $emailService->printDebugger(['headers']);
//                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to send email to the user.', 'debug' => $data]);
//            }
//        }
//
//    }
}
