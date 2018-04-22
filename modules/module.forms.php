<?php class forms extends masterclass {
	
	function gettables() {
		return 
		[
			'forms' => [
				'fields' => [					
					'name'	=> 	[ 'string', 'text', 'search' => TRUE, 'required' => TRUE ],
					'fields' => [ 'text', 'array' ],					
					'split' => [ 'bool', 'checkbox' ],
					'sendmail' => [ 'bool' , 'checkbox' ],
					'mail_topic' => [ 'string' , 'text' ],
					
				],
			],
			'forms_messages' => [
				'fields' => [					
					'form_id'	=> 	[ 'int', 'hidden', 'index' => TRUE ],
					'data' => [ 'text', 'array' ],
					'sent' => [ DB_DATE , WIDGET_DATE],
					
				],
				'fk' => [
					'form_id' => 'forms(id)'
				],
			],
		];		
	}
	
	function extend() {
		$this->options['widgets'] = [
			WIDGET_TEXT 		=> WIDGET_TEXT, 
			WIDGET_TEXTAREA 	=> WIDGET_TEXTAREA, 
			WIDGET_HTML 		=> WIDGET_HTML,
			WIDGET_BBCODE 		=> WIDGET_BBCODE,
			WIDGET_PASS 		=> WIDGET_PASS,
			WIDGET_HIDDEN 		=> WIDGET_HIDDEN,
			WIDGET_CHECKBOX 	=> WIDGET_CHECKBOX,
			WIDGET_RADIO 		=> WIDGET_RADIO,
			WIDGET_SELECT 		=> WIDGET_SELECT,
			WIDGET_MULTSELECT 	=> WIDGET_MULTSELECT,
			WIDGET_DATE			=> WIDGET_DATE,
			WIDGET_CHECKBOXES 	=> WIDGET_CHECKBOXES,
			WIDGET_INFO 		=> WIDGET_INFO,
			WIDGET_KEYVALUES 	=> WIDGET_KEYVALUES,
			WIDGET_EMAIL 		=> WIDGET_EMAIL,
			WIDGET_NUMBER		=> WIDGET_NUMBER,
			WIDGET_URL			=> WIDGET_URL,
			WIDGET_PHONE		=> WIDGET_PHONE,
			WIDGET_SLUG			=> WIDGET_SLUG,
		];
		
		$this->options['dbtypes'] = [
			DB_TEXT 	=> DB_TEXT,
			DB_BLOB 	=> DB_BLOB,
			DB_STRING 	=> DB_STRING,
			DB_BOOL 	=> DB_BOOL, 
			DB_INT 		=> DB_INT, 
			DB_DATE 	=> DB_DATE, 
			DB_FLOAT 	=> DB_FLOAT	
		];
		
		$this->buttons['admin']['messages'] = 'fa-commenting';
	}

	
	
	function getDescription() {
		return 'Module for form creation and management';
	}
	
	
	
	function addField($key = null, $data = null) {
		$this->ajax = true;	
		
		
		return tpl('forms/field', array(
			'key' => $key,
			'types' => $this->options['dbtypes'],
			'widgets' => $this->options['widgets'],
			//'validators' =>$this->options['validators'],
			'data' => $data));
	}


	function view($id = NULL) {
		$data = parent:: view($id);
		$_fields = unserialize($data['fields']);

		$fields = array();

		foreach($_fields as $field) {
			$fields[$field['name']] = [
				$field['type'],
				$field['widget'],
				'required' => (int)@$field['required']
			];
		}
		$data['fields'] = $fields;
		$data['id'] = $id;
		
		return $data;
	}	
	
	function post() { 
		$this->ajax = true;
		
		$formid = $this->post['id'];
		$form = q('forms')->qget($formid)->run();
		$fields = unserialize($form['fields']);
		$fdata = array(); 
		foreach($this->post['form'] as $k => $v) {
			$dbtype = getFieldDBType($k, $fields);
			$fdata[$k] = sqlFormat($dbtype, $v);
		}
		$fdata = moveToBottom($fdata, 'message');

		$data = [
			'form_id' => $formid,
			'data' =>  serialize($fdata),
			'sent' =>   now() ,
		];
		q('forms_messages')->qadd($data)->run();
		
		if($form['sendmail']) {
			$data = [
				'subject' => $form['mail_topic'],
				'body' => mtpl('mail', ['data' => $fdata]),
				'from' => $fdata['email'],
				'to'   => G('adm_mail'),
			];
			//print_r($data);
			sendMail($data);
		}
		
		echo json_encode(array('message' => T('form_submitted'), 'status' => 'ok'));	die();	
	}
	
	function messages() {
		$qMsg = q('forms_messages')->qlist()->order('sent desc');
		/*if($this->id > 0) {
			$qMsg->where(qEq('form_id', $this->id));
		}
		return $qMsg->run();*/
		
		$qForm = q('forms')->qlist();
		
		if($this->id > 0) {
			$qMsg->where(qEq('form_id', $this->id));
			$qForm->where(qEq('id', $this->id));	
		}
		$forms = array();
		$_forms = $qForm->run();
		foreach($_forms as $form) {
			$forms[$form['id']] = unserialize($form['fields']);
		}
		
		$messages = $qMsg->run(); 
		
		$data = [
			'forms' => $forms,
			'messages' => $messages
		];
		
		return $data;
		
	}

		
}


function getFieldDBType($key, $fields) { //inspect($fields); 

	foreach($fields as $field) { 
		if($field['name'] == $key) {;
			return $field['type'];
		}
	}	
	return 'text';
}

function getFieldType($key, $fields) { //inspect($fields); 

	foreach($fields as $field) { 
		if($field['name'] == $key) {;
			return $field['widget'];
		}
	}	
	return 'text';
}