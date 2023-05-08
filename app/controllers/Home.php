<?php
require_once 'app/models/AnnouncementModel.php';
require_once 'app/models/ProjectModel.php';
require_once 'app/models/EventModel.php';
require_once 'app/models/ServiceModel.php';

class Home extends Controller
{
    public function index()
    {
        $posts = [
            (new AnnouncementModel)->getFrontPage(),
            (new ServiceModel)->getFrontPage(),
            (new ProjectModel)->getFrontPage(),
            (new EventModel)->getFrontpage()
        ];
        $this->view('Home/index', 'Chilaw Pradeshiya Sabha',['posts' => $posts],
            styles:['Home/index','Components/slideshow']);
    }

    public function downloads()
    {
        header('Location: ' . URLROOT .'/Downloads');
    }

    public function emergency()
    {
        $data = ['emergency_details' => $this->model('EmergencyModel')->getAllEmergencyDetails()];
        $this->view('Home/emergency', 'Emergency Details', $data, ['main','emergency']);
    }

    public function portal()
    {
        $this->view('Home/portal', 'Library Portal',styles:['Home/portal','Components/slideshow']);
    }

    public function bookRequest()
    {
        $model = $this->model('BookRequestModel');

        if (isset($_POST['Add'])) {

            [$valid, $err] = $this->validateInputs($_POST, [
                    'email|l[:255]|e',
                    'title|l[:255]',
                    'author|l[:255]',
                    'isbn|l[10:13]',
                    'reason|l[:255]',
                    ], 'Add');

            $data['errors'] = $err;

            $data = array_merge(count($err) > 0 ? ['errors' => $err] : ['Add' => $model->addBookRequest($valid)], $data);
            $this->view('Home/bookRequest', 'Book Request', $data, ['Components/form']);
        } 
        else {
            $this->view('Home/bookRequest', 'Book Request', styles:['Components/form']);
        }
    }

    public function bookCatalogue()
    {
        $model = $this->model('BookModel');
        $this->view('Home/bookCatalogue', 'Book Catalogue', ['Books' => $model->getBooks(),'Category' => $model->get_categories(), 'SubCategory' => $model->get_sub_categories()], styles:['LibraryStaff/index', 'Home/portal', 'Components/table', 'posts']);
    }
    
    public function addComplaint()
    {
        $model = $this->model('ComplaintModel');

        // Retrieve data from the complaint_categories table and store it in an array
        $data = ['complaint_categories' => $model->get_categories()['result']];

        // Check if the 'Add' button has been clicked
        if (isset($_POST['Add'])) {
        
            // Validate user inputs using the validateInputs() function and store the results in variables
            [$valid, $err] = $this->validateInputs(
                $_POST,
                [
                    'name|l[:255]',
                    'email|l[:255]|e',
                    'contact_no|l[10:12]',
                    'address|l[:255]',
                    'category',
                    'description|l[:255]',
                    'date',
                ],
                'Add'
            );

            // Store the validation errors in the $data array
            $data['errors'] = $err;

            // Store the user inputs in the $data array
            $data['old'] = $_POST;

            // If there are validation errors, merge them into the $data array
            // Otherwise, add the new complaint to the database using the addComplaintuser() method and merge the result into the $data array
            $data = array_merge(count($err) > 0 ? ['errors' => $err] : ['Add' => $model->addComplaintuser($valid)], $data);

            // Render the 'Home/AddComplaint' view with the title 'Chilaw Pradeshiya Sabha', the $data array, and the 'Components/form' stylesheet
            $this->view('Home/AddComplaint', 'Chilaw Pradeshiya Sabha', $data, ['Components/form']);
        } else {

            // If the 'Add' button has not been clicked, simply render the 'Home/AddComplaint' view with the title 'Chilaw Pradeshiya Sabha', the $data array, and the 'Components/form' stylesheet
            $this->view('Complaint/AddComplaint', 'Chilaw Pradeshiya Sabha',  $data, styles: ['Components/form']);
        }
    }
}
