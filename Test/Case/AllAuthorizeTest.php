<?php
/**
 * All tests for this plugin
 *
 * @package       Cake.Test.Case.Controller.Component.Auth
 */
class AllAuthorizeTest extends CakeTestCase {

/**
 * Suite define the tests for this suite
 *
 * @return CakeTestSuite
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Authorize test');

		$path = CakePlugin::path('Authorize') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);

		return $suite;
	}
}
