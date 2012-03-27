<?php

class EmployeeFixture extends CakeTestFixture {

/**
 * name property
 *
 * @var string 'Employee'
 */
	public $name = 'Employee';

/**
 * fields property
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false),
		'primary_department_id' => array('type' => 'integer', 'null' => true),
		'created' => 'datetime',
		'updated' => 'datetime'
	);

/**
 * records property
 *
 * @var array
 */
	public $records = array(
		array('name' => 'mark', 'created' => '2007-03-17 01:16:23', 'primary_department_id' => 2),
		array('name' => 'jack', 'created' => '2007-03-17 01:18:23', 'primary_department_id' => null),
		array('name' => 'larry', 'created' => '2007-03-17 01:20:23', 'primary_department_id' => null),
		array('name' => 'jose', 'created' => '2007-03-17 01:22:23', 'primary_department_id' => null),
	);
}
