<?php class Emergency extends Controller {
    public function index() {
        $model = $this->model('EmergencyModel');
        $data = [
        ];

        // Handle Adding Categories
        if(isset($_POST['AddCategory']) && ($_SESSION['role'] ?? 'Guest' == 'Admin')) {
            [$valid,$err] = $this->validateInputs($_POST,[
                'category_name|l[1:255]|u[emergency_categories]'
            ],'AddCategory');

            if(count($err) == 0) {
                $data['AddCategory'] = $model->addCategory($valid);
            } else {
                $data['errorsCat'] = $err;
                $data['oldCat'] = $_POST;
            }
        }

        // Handle Adding Places to Categories
        if(isset($_POST['AddPlace']) && ($_SESSION['role'] ?? 'Guest' == 'Admin')) {
            [$valid,$err] = $this->validateInputs($_POST,[
                'place_name|l[1:255]',
                'address|l[1:255]',
                'category_id|i[:]',
                'contact_numbers|l[1:255]'
            ],'AddPlace');

            if(count($err) == 0) {
                $data['AddPlace'] = $model->addPlaceToCategory($valid);
            } else {
                $data['errorsPlace'] = $err;
                $data['oldPlace'] = $_POST;
            }
        }

        // Handle Deleting Places
        if(isset($_POST['DelPlace']) && ($_SESSION['role'] ?? 'Guest' == 'Admin')) {
            [$valid,$err] = $this->validateInputs($_POST,[
                'place_id|i[:]'
            ],'DelPlace');

            if(count($err) == 0) {
                $data['DelPlace'] = $model->deletePlace($valid['place_id']);
            } else {
                $data['errorsPlace'] = $err;
                $data['oldPlace'] = $_POST;
            }
        }

        // retrieve data after handling requests
        $data['categories'] = $model->getCategories();
        $data['places'] = $model->getPlaces();
        $this->view('Home/emergency', 'Emergency Details', $data, ['main','Components/table','Components/form']);
    }

    public function Api() {
        // Check if user is admin
        if(($_SESSION['role'] ?? 'Guest') != 'Admin') {
            $this->returnJSON([
                'error' => 'Unauthorized'
            ]);
            die();
        } else {
            $model = $this->model('EmergencyModel');
            $reqJSON = file_get_contents('php://input');
            if($reqJSON){
            $reqJSON = json_decode($reqJSON,associative:true);
            if($reqJSON){
                // If the body data are valid, then proceed to save the edited data
                if($reqJSON['EditPlace'] ?? false) {
                    [$valid,$err] = $this->validateInputs($reqJSON,[
                        'place_name|l[1:255]|?',
                        'address|l[1:255]|?',
                        'contact_numbers|l[1:255]|?'
                    ],'EditPlace');
                    if(count($err) == 0) {
                        $this->returnJSON(
                            $model->editPlace($reqJSON['EditPlace'],$valid)
                        );
                    } else {
                        $this->returnJSON([
                            'error' => $err
                        ]);
                    }
                } else {
                    $this->returnJSON([
                        'error' => 'Invalid Request'
                    ]);
                }
            } else $this->returnJSON([
                'error'=>'Error Parsing JSON'
            ]);
            }else{
            $this->returnJSON([
                'error' => 'Error getting request'
            ]);
            }
        }
    }
}