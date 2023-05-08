<?php

class Complaint extends Controller
{
    public function __construct()
    {   // This constructor method is used for authentication purposes
        $this->authenticateRole('Complaint');
    }
    public function index()
    {   //This method renders the Complaint dashboard
        $this->view('Complaint/index', 'Complaint', styles: ['Complaint/dashboard', 'main']);
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
            // Otherwise, add the new complaint to the database using the addComplaint() method and merge the result into the $data array
            $data = array_merge(count($err) > 0 ? ['errors' => $err] : ['Add' => $model->addComplaint($valid)], $data);

            // Render the 'Complaint/addComplaint' view with the title 'Add New Complaint', the $data array, and the 'Components/form' stylesheet
            $this->view('Complaint/addComplaint', 'Add New Complaint', $data, ['Components/form']);
        } else {

            // If the 'Add' button has not been clicked, simply render the 'Complaint/addComplaint' view with the title 'Add New Complaint', the $data array, and the 'Components/form' stylesheet
            $this->view('Complaint/addComplaint', 'Add New Complaint',  $data, styles: ['Components/form']);
        }
    }

    public function newComplaints()
    {
        $model = $this->model('ComplaintModel');

        $this->view('Complaint/newComplaints', 'New Complaints', [
            
            // retrieve the new complaints data and the complaint categories from the ComplaintModel object
            'newComplaints' => $model->get_new_complaints(), 'Category' => $model->get_categories(),

            // specify the styles to be included in the view
        ], styles: ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main']);
    }

    public function allAcceptedComplaints()
    {
        $model = $this->model('ComplaintModel');
        $this->view('Complaint/allAcceptedComplaints', 'All Accepted Complaints',  [
            
            // retrieve all the accepted resolved complaints and the accepted working complaints from the ComplaintModel object
            'allResolved' => $model->get_accepted_resolved_complaints(), 'allWorking' => $model->get_accepted_working_complaints()

        // specify the styles to be included in the view
        ], styles: ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main']);
    }

    public function resolvedComplaints()
    {
        $model = $this->model('ComplaintModel');
        $this->view('Complaint/resolvedComplaints', 'Resolved Complaints', [

            // retrieve all the resolved complaints from the ComplaintModel object
            'resolvedComplaints' => $model->get_resolved_complaints()

        // specify the styles to be included in the view
        ], styles: ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main']);
    }

    public function myWorkingComplaints()
    {
        $model = $this->model('ComplaintModel');
        $this->view('Complaint/myWorkingComplaints', 'My Working Complaints', [

            // retrieve all the working complaints from the ComplaintModel object
            'workingComplaints' => $model->get_working_complaints()

        // specify the styles to be included in the view
        ], styles: ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main']);
    }

    public function viewComplaint($complaint_id)
    {
        $model = $this->model('ComplaintModel');
        $this->view('Complaint/viewComplaint', 'Complaint', [

            // Retrieve the complaint and its notes from the database
            'viewComplaint' => $model->get_complaint($complaint_id), 'notes' => $model->get_notes($complaint_id)

        // specify the styles to be included in the view
        ], styles: ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main']);
    }

    public function acceptComplaint($id)
    {
        $model = $this->model('ComplaintModel');

        // Call the model's acceptComplaint method to update the status of the complaint
        $result = $model->acceptComplaint($id);
        if (!$result['success']) {
            $this->view('Complaint/viewComplaint', 'Complaint', [

                // If the acceptComplaint method did not return success, display an error message
                'error' => 'Error accepting complaint'], 
            
            // specify the styles to be included in the view
            ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main', 'Components/form']);
        }
    }

    public function finishComplaint($id)
    {
        $model = $this->model('ComplaintModel');

        // Call the finishComplaint method of the ComplaintModel and store the result
        $result = $model->finishComplaint($id);
        if (!$result['success']) {
            $this->view('Complaint/viewComplaint', 'Complaint', [

                // If the result was not successful, show an error message in the view
                'error' => 'Error accepting complaint'], 

            // specify the styles to be included in the view
            ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main', 'Components/form']);
        }
    }

    public function addNote()
    {
        $model = $this->model('ComplaintModel');

        // Check if the form has been submitted
        if (isset($_POST['Submit'])) {

            // Validate the input fields
            [$valid, $err] = $this->validateInputs(
                $_POST,
                [
                    'note',
                    'complaint_id',
                    'user_id',
                ],
                'Submit'
            );

            // Store any errors in $data['errors']
            $data['errors'] = $err;

            // Store the old input fields in $data['old']
            $data['old'] = $_POST;

            // If there are no validation errors, add the note to the database and redirect to the complaint view page
            $data = array_merge(count($err) > 0 ? ['errors' => $err] : ['Submit' => $model->addNotes($valid)], $data);

            // Redirect the user back to the viewComplaint page with the complaint_id in the URL
            header('Location: ' . URLROOT . '/Complaint/viewComplaint/' . $_POST['complaint_id']);
        } else {

            // If the Submit button was not clicked, redirect the user back to the viewComplaint page with the complaint_id in the URL
            header('Location: ' . URLROOT . '/Complaint/viewComplaint/' . $_POST['complaint_id']);
        }
    }
    

    public function count()
    {
        $model = $this->model('ComplaintModel');
        $complaintCount = $model->get_complaint_counts();
        var_dump($complaintCount);
        

        $this->view('Complaint/index', 'Dashboard', [

            // Retrieve the complaint and its notes from the database
            'complaintCount' => $complaintCount
        // specify the styles to be included in the view
        ], styles: ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main']);
    }

    
}
