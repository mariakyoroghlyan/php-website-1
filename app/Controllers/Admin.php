<?php

namespace App\Controllers;

class Admin extends BaseController

{

// PAGES

// HEADER INCLUDE
    public function header($data): string
    {

        return view('admin/header', $data);
    }

// FOOTER INCLUDE
    public function footer($data): string
    {

        return view('admin/footer', $data);
    }

// LOGIN PAGE
    public function index(): string
    {
        return view('admin/login');
    }

// UPDATE PASSWORD PAGE

    public function update_password(): string
    {
        return view('admin/update_password');
    }

// DASHBOARD PAGE
    public function dashboard(): string
    {
        $this->isLogged();

        $data = [];
        $data['header'] = $this->header($data);
        $data['footer'] = $this->footer($data);

        return view('admin/dashboard', $data);
    }


// NEWS PAGE
    public function news(): string
    {
//        $this->isLogged();

        $data = [];
        $data['header'] = $this->header($data);
        $data['footer'] = $this->footer($data);

        return view('admin/news', $data);
    }


//  NEWS ADD PAGE
    public function news_add(): string
    {
        $data = [];
        $data['header'] = $this->header($data);
        $data['footer'] = $this->footer($data);

        return view('admin/news_add', $data);
    }

// ADD PROJECT PAGE
    public function add_project(): string
    {
        $data = [];
        $data['header'] = $this->header($data);
        $data['footer'] = $this->footer($data);

        return view('admin/add_project', $data);
    }

// EDIT PROJECT PAGE
    public function edit_project(): string
    {
        $id = $this->request->getGet('id');
        $builder = $this->db->table('add_projects');
        $query = $builder->where('id', $id)->get();
        $data['project'] = $query->getRowArray();
        $data['header'] = $this->header($data);
        $data['footer'] = $this->footer($data);

        return view('admin/edit_project', $data);
    }


///////////////////////////////////////////////////////////////////////////////////

// FUNCTIONS

// LOGIN
    public function login()
    {
        $builder = $this->db->table('admin');
        $info = $builder->select('username, password')->get()->getResultArray();
        $db_username = $info[0]['username'];
        $db_password = $info[0]['password'];

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');


        if ($username == $db_username && password_verify($password, $db_password)) {
            $this->session->set('logged_in', true);
            header('Location: /admin/gallery');
            exit;
        } else {
            $this->session->setFlashdata('error', 'Invalid username or password');
            header('Location: /admin');
            exit;
        }
    }


// UPDATE PASSWORD
    public function updatePassword()
    {
        $verify_new_password = $this->request->getPost('verify_new_password');
        $verify_new_password = trim($verify_new_password);

        if (strlen($verify_new_password) >= 6) {
            $data = [
                'password' => password_hash($verify_new_password, PASSWORD_DEFAULT)
            ];

            $this->db->table('admin')->where('id', 1)->update($data);
            $this->session->set('logged_in', true);
            header('Location: /admin/dashboard');
            exit;
        } else {
            $this->session->setFlashdata('error', 'Short password it must contain at least 6 characters');
            header('Location: /admin/update_password');
            exit;
        }
    }

// CHECK IF USER IS LOGGED IN
    public function isLogged()
    {
        if (empty($this->session->get('logged_in')) || $this->session->get('logged_in') == false) {

            header('Location: /admin');
            exit;
        }
    }

// LOGOUT
    public function logout()
    {
        $this->session->destroy();

        header('Location: /admin');
        exit;
    }


    public function newsAdd()
    {
        $postData = $this->request->getPost();
        $response = [
            'status' => 'error',
            'message' => 'An error occurred',
        ];

        //start::image upload part
        $imagePathForDB = '';
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            if (in_array($image->getClientMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                $uploadPath = FCPATH . 'gallery/';
                $imageName = pathinfo($image->getName(), PATHINFO_FILENAME) . '_' . uniqid() . '.' . $image->getClientExtension();
                $imagePathForDB = '/gallery/' . $imageName;
                if (!$image->move($uploadPath, $imageName)) {
                    $response['message'] = 'Failed to move file';
                    return $this->response->setJSON($response);
                }
            } else {
                $response['message'] = 'Invalid image type';
                return $this->response->setJSON($response);
            }
        }
        //end::image upload part

        //start:: db data info for editing
        $data = [
            'title_en' => !empty($postData['title_en']) ? $postData['title_en'] : '',
            'title_am' => !empty($postData['title_am']) ? $postData['title_am'] : '',
            'date' => !empty($postData['date']) ? $postData['date'] : date('Ymd'),
            'info_en' => !empty($postData['info_en']) ? $postData['info_en'] : '',
            'info_am' => !empty($postData['info_am']) ? $postData['info_am'] : '',
            'status_en' => isset($postData['status_en']) && $postData['status_en'] === 'on' ? 1 : 0,
            'status_am' => isset($postData['status_am']) && $postData['status_am'] === 'on' ? 1 : 0,
            'image' => $imagePathForDB,
        ];
        // end:: db data info for editing

        // start:: validation for empty fields
        $requiredFields = ['title_en', 'title_am', 'info_en', 'info_am'];
        $atLeastOneFilled = false;

        foreach ($requiredFields as $field) {
            if (!empty($data[$field])) {
                $atLeastOneFilled = true;
                break;
            }
        }

        if (!$atLeastOneFilled) {
            $response['message'] = 'At least one field (title, information) must be filled.';
            return $this->response->setJSON($response);
        }
        // end:: validation for empty fields

        // start:: adding data to the database
        $builder = $this->db->table('news');
        if ($builder->insert($data)) {
            $response['status'] = 'success';
            $response['message'] = 'Row added successfully';
        } else {
            $response['message'] = 'Failed to add row to the database';
        }

        return $this->response->setJSON($response);
        // end:: adding data to the database

    }


//// ADD PROJECT
//    public function addProjects()
//    {
//
//        $postData = $this->request->getPost();
//
//// start::for showing message in front
//        $response = [
//            'status' => 'error',
//            'message' => 'An error occurred',
//        ];
//// end::for showing message in front
//
//        //start::image upload part
//        $imagePathForDB = '';
//        $image = $this->request->getFile('image');
//        if ($image && $image->isValid() && !$image->hasMoved()) {
//            if (in_array($image->getClientMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
//                $uploadPath = FCPATH . 'gallery/';
//                $imageName = pathinfo($image->getName(), PATHINFO_FILENAME) . '_' . uniqid() . '.' . $image->getClientExtension();
//                $imagePathForDB = '/gallery/' . $imageName;
//                if (!$image->move($uploadPath, $imageName)) {
//                    $response['message'] = 'Failed to move file';
//                    return $this->response->setJSON($response);
//                }
//            } else {
//                $response['message'] = 'Invalid image type';
//                return $this->response->setJSON($response);
//            }
//        }
//        //end::image upload part
//
//        // start::slide image upload part
//        $slideImagePathForDB = '';
//        $slide_image = $this->request->getFile('slide_image');
//        if ($slide_image && $slide_image->isValid() && !$slide_image->hasMoved()) {
//            if (in_array($slide_image->getClientMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
//                $uploadPath = FCPATH . 'gallery/';
//                $imageName = pathinfo($slide_image->getName(), PATHINFO_FILENAME) . '_' . uniqid() . '.' . $slide_image->getClientExtension();
//                $slideImagePathForDB = '/gallery/' . $imageName;
//
//                if (!$slide_image->move($uploadPath, $imageName)) {
//                    $response['message'] = 'Failed to move file';
//                    return $this->response->setJSON($response);
//                }
//            } else {
//                $response['message'] = 'Invalid image type';
//                return $this->response->setJSON($response);
//            }
//        }
//        // end::slide image upload part
//
//
//// start::Dynamic team, material and publication data fetching
//        $teamDataJson = !empty($postData['team']) ? json_encode($postData['team'], JSON_PRETTY_PRINT) : json_encode([]);
//
//        $materialDataJson = !empty($postData['material']) ? json_encode($postData['material'], JSON_PRETTY_PRINT) : json_encode([]);
//
//        $publicationDataJson = !empty($postData['publication']) ? json_encode($postData['publication'], JSON_PRETTY_PRINT) : json_encode([]);
//// end::Dynamic team, material and publication data fetching
//
//
//// start:: dynamically added style images
//        $files = $this->request->getFiles();
//        $styleData = [];
//
//        if (!empty($files['style_images'])) {
//            $styleData = [];
//
//            foreach ($files['style_images'] as $key => $fileSet) {
//                $style = $this->request->getPost("style_images[$key][style]");
//
//                $uniqueTimestamp = $key;
//
//                if (!isset($styleData[$uniqueTimestamp])) {
//                    $styleData[$uniqueTimestamp] = [
//                        'style' => $style,
//                        'style_images' => [],
//                    ];
//                }
//
//                foreach ($fileSet['images'] as $index => $file) {
//                    if ($file->isValid() && !$file->hasMoved()) {
//                        $originalName = str_replace(' ', '_', $file->getName());
//
//                        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
//                        $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
//
//                        $newName = $nameWithoutExt . '_' . time() . '.' . $extension;
//
//                        $file->move(FCPATH . 'style_images', $newName);
//
//                        $filePath = '/style_images/' . $newName;
//
//                        $styleData[$uniqueTimestamp]['style_images'][$index] = '/style_images/' . $newName;
//
//                    }
//                }
//
//                sleep(1);
//            }
//
//        }
//
//        $formattedData = array_values($styleData);
//        $styleImages = json_encode($formattedData, JSON_UNESCAPED_SLASHES);
//
//// end:: dynamically added style images
//
// start:: db data info for editing
//        $data = [
//            'title' => !empty($postData['title']) ? $postData['title'] : '',
//            'date' => !empty($postData['date']) ? $postData['date'] : date('Ymd'),
//            'square' => !empty($postData['square']) ? str_replace(',', '.', $postData['square']) : '',
//            'location' => !empty($postData['location']) ? $postData['location'] : '',
//            'information' => !empty($postData['information']) ? $postData['information'] : '',
//            'category' => !empty($postData['category']) ? $postData['category'] : '',
//            'show' => isset($postData['show']) && $postData['show'] === 'on' ? 1 : 0,
//            'image' => $imagePathForDB,
//            'team' => $teamDataJson,
//            'material' => $materialDataJson,
//            'publication' => $publicationDataJson,
//            'style_images' => $styleImages,
//            'slide_image' => $slideImagePathForDB,
//        ];
//// end:: db data info for editing
//
//// start:: validation for empty fields
//        $requiredFields = ['title', 'square', 'location', 'information', 'category'];
//        $atLeastOneFilled = false;
//
//        foreach ($requiredFields as $field) {
//            if (!empty($data[$field])) {
//                $atLeastOneFilled = true;
//                break;
//            }
//        }
//
//        if (!$atLeastOneFilled) {
//            $response['message'] = 'At least one field (title, square, location, information, category) must be filled.';
//            return $this->response->setJSON($response);
//        }
//// end:: validation for empty fields
//
//// start:: adding data to the database
//        $builder = $this->db->table('add_projects');
//        if ($builder->insert($data)) {
//            $response['status'] = 'success';
//            $response['message'] = 'Row added successfully';
//        } else {
//            $response['message'] = 'Failed to add row to the database';
//        }
//
//        return $this->response->setJSON($response);
//// end:: adding data to the database
//    }


//// EDIT PROJECT
//    public function editProjects()
//    {
//        $postData = $this->request->getPost();
//        $projectId = $this->request->getPost('id');
//
//// start::for showing message in front
//        $response = [
//            'status' => 'error',
//            'message' => 'An error occurred',
//        ];
//// end::for showing message in front
//
//// start::Image upload part
//        $imagePathForDB = '';
//        $image = $this->request->getFile('image');
//        $imageOldPath = $postData['image'];
//
//        if ($image && $image->isValid() && !$image->hasMoved()) {
//            if (in_array($image->getClientMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
//                $uploadPath = FCPATH . 'gallery/';
//                $imageName = pathinfo($image->getName(), PATHINFO_FILENAME) . '_' . uniqid() . '.' . $image->getClientExtension();
//                $imagePathForDB = '/gallery/' . $imageName;
//
//                if (!$image->move($uploadPath, $imageName)) {
//                    $response['message'] = 'Failed to move file';
//                    return $this->response->setJSON($response);
//                }
//            } else {
//                $response['message'] = 'Invalid image type';
//                return $this->response->setJSON($response);
//            }
//        } else {
//            $imagePathForDB = $imageOldPath;
//        }
//// end::Image upload part
//
//// start::Slide Image upload part
//        $slideImagePathForDB = '';
//        $slide_image = $this->request->getFile('slide_image');
//        $slideImageOldPath = $postData['slide_image'];
//
//        if ($slide_image && $slide_image->isValid() && !$slide_image->hasMoved()) {
//            if (in_array($slide_image->getClientMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
//                $uploadPath = FCPATH . 'gallery/';
//                $imageName = pathinfo($slide_image->getName(), PATHINFO_FILENAME) . '_' . uniqid() . '.' . $slide_image->getClientExtension();
//                $slideImagePathForDB = '/gallery/' . $imageName;
//
//                if (!$slide_image->move($uploadPath, $imageName)) {
//                    $response['message'] = 'Failed to move file';
//                    return $this->response->setJSON($response);
//                }
//            } else {
//                $response['message'] = 'Invalid image type';
//                return $this->response->setJSON($response);
//            }
//        } else {
//            $slideImagePathForDB = $slideImageOldPath;
//        }
//// end::Slide Image upload part
//
//// start::Dynamic team, material and publication data fetching
//        $teamDataJson = !empty($postData['team']) ? json_encode($postData['team'], JSON_PRETTY_PRINT) : json_encode([]);
//
//        $materialDataJson = !empty($postData['material']) ? json_encode($postData['material'], JSON_PRETTY_PRINT) : json_encode([]);
//
//        $publicationDataJson = !empty($postData['publication']) ? json_encode($postData['publication'], JSON_PRETTY_PRINT) : json_encode([]);
//// end::Dynamic team, material and publication data fetching
//
//
//// start:: dynamically added style images
//        $files = $this->request->getFiles();
//        $styleData = [];
//
//        if (!empty($files['style_images'])) {
//            foreach ($files['style_images'] as $key => $file) {
//                $style = $this->request->getPost("style_images[$key][style]");
//                $uniqueStyleKey = $key;
//                $oldPaths = $this->request->getPost("style_images[$key][images][old]");
//
//                if (!isset($styleData[$uniqueStyleKey])) {
//                    $styleData[$uniqueStyleKey] = [
//                        'style' => $style,
//                        'style_images' => [],
//                    ];
//                }
//
//                foreach ($file['images'] as $index => $uploadedFile) {
//                    if ($uploadedFile->isValid() && !$uploadedFile->hasMoved()) {
//                        if (in_array($uploadedFile->getClientMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
//                            $uploadPath = FCPATH . 'style_images/';
//                            $imageName = pathinfo($uploadedFile->getName(), PATHINFO_FILENAME) . '_' . uniqid() . '.' . $uploadedFile->getClientExtension();
//                            $styleData[$uniqueStyleKey]['style_images'][$index] = '/style_images/' . $imageName;
//                            $uploadedFile->move($uploadPath, $imageName);
//                        }
//                    } else {
//                        $styleData[$uniqueStyleKey]['style_images'][$index] = $oldPaths[$index];
//                    }
//                }
//            }
//        }
//        $formattedData = array_values($styleData);
//        $styleImages = json_encode($formattedData, JSON_UNESCAPED_SLASHES);
//// end:: dynamically added style images
//
//// start:: db data info for editing
//        $data = [
//            'title' => !empty($postData['title']) ? $postData['title'] : '',
//            'date' => !empty($postData['date']) ? $postData['date'] : date('Ymd'),
//            'square' => !empty($postData['square']) ? str_replace(',', '.', $postData['square']) : '',
//            'location' => !empty($postData['location']) ? $postData['location'] : '',
//            'information' => !empty($postData['information']) ? $postData['information'] : '',
//            'category' => !empty($postData['category']) ? $postData['category'] : '',
//            'show' => isset($postData['show']) && $postData['show'] === 'on' ? 1 : 0,
//            'image' => $imagePathForDB,
//            'team' => $teamDataJson,
//            'material' => $materialDataJson,
//            'publication' => $publicationDataJson,
//            'style_images' => $styleImages,
//            'slide_image' => $slideImagePathForDB,
//        ];
//// end:: db data info for editing
//
//// start:: validation for empty fields
//        $requiredFields = ['title', 'square', 'location', 'information', 'category'];
//        $atLeastOneFilled = false;
//
//        foreach ($requiredFields as $field) {
//            if (!empty($data[$field])) {
//                $atLeastOneFilled = true;
//                break;
//            }
//        }
//
//        if (!$atLeastOneFilled) {
//            $response['message'] = 'At least one field (title, square, location, information, category) must be filled.';
//            return $this->response->setJSON($response);
//        }
//// end:: validation for empty fields
//
//// start:: update project in db
//        $builder = $this->db->table('add_projects');
//        $builder->where('id', $projectId);
//
//        if ($builder->update($data)) {
//            $response['status'] = 'success';
//            $response['message'] = 'Project updated successfully';
//        } else {
//            $response['message'] = 'Failed to update project in the database';
//        }
//
//        return $this->response->setJSON($response);
//// end:: update project in db
//    }
//
//// DELETE PROJECT
//    public function deleteProject()
//    {
//        $projectId = $this->request->getGet('id');
//
//        $builder = $this->db->table('add_projects');
//
//        $builder->where('id', $projectId);
//
//        if ($builder->delete()) {
//            return redirect()->to(base_url('admin/projects_list'))->send();
//        }
//
//    }


}



