<?php

class Model_User extends Orm\Model
{

	protected static $_table_name	= 'users';
//	protected static $_belongs_to	= array('notes');
//	protected static $_has_many 	= array('notes', 'teams');
	protected static $_properties	= array('id', 'username', 'password',
											'email', 'profile_fields',
											'group', 'last_login', 'login_hash');
	protected static $_primary_key	= array('id');

	protected static $_validation_rules = array(
		'username'	=>	array(
			array('required'),
			array('min_length', 3),
			array('max_length', 20),
			array('trim'),
			array('valid_string',
				array('alpha', 'numeric', 'dashes', 'dots')),
			array('unique', 'user.username')
			//array('match_field', 'email')
		),

		'password'	=>	array(
			array('required'),
			array('min_length', 3),
			array('max_length', 20),
			array('trim'),
			array('valid_string',
				array('alpha', 'numeric', 'spaces', 'punctuation', 'dashes'))
		),

		'email'		=>	array(
			array('required'),
			array('min_length', 3),
			array('max_length', 80),
			array('trim'),
			array('valid_email'),
			array('unique', 'user.email')
		),

		'group'		=>	array(
			array('required'),
			array('trim'),
			//need to be in array Config::get('simpleauth.groups')
		)
	);

	public static function _validation_rules($field, $update = false)
	{
		if ($update) {
			$rules = static::$_validation_rules[$field];
			foreach ($rules as $key => $rule)
			{
				if (in_array('unique', $rule)) {
					$rule = array('unique', 'user.'.$field, $update);
					return array_replace($rules, array($key => $rule));
				}
			}
		}

		return static::$_validation_rules[$field];
	}
/*
	public static function _validation_unique($input, $field)
	{
		$field = strtolower($field);
		$input = mb_strtolower($input, 'utf-8'); //slower conversion method

		$count = Model_User::find()->where($field, '=', $input)->count();
		if ($count != 0)
			return false;
		else
			return true;
	}*/

	public static function count_users($group = null)
	{
		if ($group === null || $group === 'all')
		{
			return count(Model_User::find('all'));
		}
		else
		{
			return count(Model_User::find_by_group($group));
		}
	}

}

/* End of file user.php */