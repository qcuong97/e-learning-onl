<?php

return [
    'app_name' => 'Classroom Management',
    'role' => [
    	'1' => 'Admin',
    	'2' => 'Teacher',
    	'3' => 'Student',
    	'change' => 'Change role for user',
    	'role_success' => 'Change role for user successfully',
    	'role_fail' => 'Change role for user fail',
    ],
    'navbar' => [
    	'user_manager' => 'User Management',
    ],
    'action' => [
    	'save' => 'Save',
    	'create' => 'Create',
    	'delete' => 'Delete',
    	'update' => 'Update',
    ],
    'class' => [
        'class_manager' => 'Classroom Management',
        'my_class' => 'My Classroom',
        'my_request' => 'My Request',
        'request_list' => 'Request List',
        'add_class' => 'Add a new classroom',
        'delete_success' => 'Delete classroom successfully',
        'delete_fail' => "Delete classroom fail, You haven't permission to delete" ,
        'join_class' => "Join the class" ,
        'join' => "Join" ,
        'class_null' => "Haven't classroom with this class code",
        'requested' => "have sent your request join, waiting the confirm from teacher",
        'out_success' => 'the student has left the classroom',
        'out_fail' => 'have error, try agian!',
        'invite_success' => 'Successful invite, please wait for confirmation',
        'invite_fail' => 'Failed to join, please try again',
        'accept_success' => 'The student has joined the class',
        'accept_invite_success' => 'Joined the class',
    ],
    'state' => [
        '0' => "Waiting",
        '1' => "Accepted",
        '2' => "Cancelled",
    ]
];
