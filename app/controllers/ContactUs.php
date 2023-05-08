<?php

class ContactUs extends Controller
{

    public function index()
    {
        $model = $this->model('ContactModel');
        $data = [];
        // Handle Adding Cards
        if(isset($_POST['Add']) && (($_SESSION['role'] ?? 'Guest') == 'Admin')) {
            [$valid,$err] = $this->validateInputs($_POST,[
                'name|l[:1000]|u[contact_card]',
                'position|l[:255]',
                'email|e|l[:255]',
                'contact_no|l[:12]',
            ],'Add');
            if(count($err)==0) {
                $data['Add'] = $model->putCard($valid)['success'] ?? false;
            } else {
                $data['errors'] = $err;
            }
        }

        // Handle Deleting Cards
        if(isset($_POST['Delete']) && (($_SESSION['role'] ?? 'Guest') == 'Admin')) {
            $card_id = $_POST['card_id'] ?? false;
            if($card_id) {
                $data['delete'] = $model->deleteCard($card_id);
            }
        }
        $data['cards'] = $model->getCards();
        $this->view('ContactUs/index', 'Contact Us', $data, ['contactUs','Components/table','Components/form']);
    }

    public function cardsApi($method = null,$id = null){
        $reqJSON = file_get_contents('php://input');
        // A macro to check if user is admin
        $authenticate = function(){
            if(($_SESSION['role']??'Guest') == 'Admin') {
                return true;
            } else {
                $this->returnJSON(['error' => 'Unauthorized']);
                return false;
            }
        };
        if($reqJSON) {
            $body = json_decode($reqJSON,associative:true);
            if(!$body) {
                $this->returnJSON(['error' => 'JsonParse']);
            } else {
                $model = $this->model('ContactModel');
                switch($method) {
                    case 'Add':
                        if(!$authenticate()) die();
                        [$valid,$err] = $this->validateInputs($body,[
                            'name|l[:1000]',
                            'position|l[:255]',
                            'email|e|l[:255]|?',
                            'contact_no|?'
                        ],'Add');
                        if(count($err) == 0) {
                            $this->returnJSON($model->putCard($valid));
                        }else{
                            $this->returnJSON($err);
                        }
                        break;
                    case 'Update':
                        if(!$authenticate()) die();
                        [$valid,$err] = $this->validateInputs($body,[
                            'name|l[:1000]|?',
                            'position|l[:255]|?',
                            'email|e|l[:255]|?',
                            'contact_no|?'
                        ],'Update');
                        if(count($err) == 0) {
                            $this->returnJSON($model->editCard($id,$valid));
                        }else{
                            $this->returnJSON($err);
                        }
                        break;
                    case 'Delete':
                        if(!$authenticate()) die();
                        $this->returnJSON(
                            $model->deleteCard($id)
                        );
                        break;
                    case 'Get':
                        if(!$authenticate()) die();
                        $this->returnJSON(
                            $model->getCard($id)
                        );
                        break;
                    default:
                        // if no method is specified, return all cards
                        $this->returnJSON($model->getCards());
                }
            }
        } else {
            $this->returnJSON(['error' => 'Request']);
        }
    }
}
