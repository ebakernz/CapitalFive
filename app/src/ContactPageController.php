<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;

class ContactPage_Controller extends PageController {

    private static $allowed_actions = [
		'Form',
		'submitted'
	];

    public function init(){
        parent::init();
    }

	public function Form(){

		if($this->Submitted()) {
			//convert to DBHTMLText object to render html
			return DBHTMLText::create()->setValue($this->SuccessMessage);
			
		} else {
			$fields = FieldList::create(
				TextField::create('Name', 'Name'),
				EmailField::create('Email', 'Email'),
				TextField::create('Phone', 'Phone'),
				TextareaField::create('Message', 'Message')
			);

			$actions = FieldList::create(
				FormAction::create('doForm', 'Submit')
			);

			$validator = RequiredFields::create('Name', 'Email','Phone', 'Message');

			$form = Form::create($this, 'Form', $fields, $actions, $validator)->addExtraClass('contact-form');

			return $form;
		}
	}

    public function doForm($data) {
		$submission = FormSubmission::create();
		$submission->Payload = json_encode($data);
		$submission->OriginID = $this->ID;
		$submission->OriginClass = $this->ClassName;
		$submission->write();
        $submission->SendEmail();

        // check if send confirmation email is set
		if($this->SendCustomerEmail == true )
			$submission->SendConfirmationEmail();

		//set submission session and redirect submitter
		$request = Injector::inst()->get(HTTPRequest::class);
		$session = $request->getSession();
		$session->set($this->ClassName.'_Form_Sent',true);
        $this->redirect($this->Link());      
    }

    /**
     * checks if session has a form submission
     * @return  bool
     */
    public function Submitted() {
		$request = Injector::inst()->get(HTTPRequest::class);
		$session = $request->getSession();

		if( $session->get($this->ClassName.'_Form_Sent') ){
			$session->clear($this->ClassName.'_Form_Sent');
			return true;
		}

		return false;
	}
}