<?php
/**
 * Created by PhpStorm.
 * User: doru.muntean
 * Date: 02/08/16
 * Time: 21:56
 */


//The Voya namespace is defined in  /vendor/composer/autoload_psr4.php
namespace Voya\core;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Mink;

use Behat\Behat\Context\Exception;

use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\MinkAwareContext;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Driver\Selenium2Driver;




/**
 * Class VoyaCore contains the basic methods to manipulate the elemens on Voya webpage
 *
 * @package Voya\core
 */
class VoyaCore extends RawMinkContext

{

	//user access
	/**
	 * Valid email to login with
	 */
	const VALID_EMAIL = "mihai@sora.com";

	/**
	 * Valid password to login with
	 */
	const VALID_PASSWORD = "mihai";

	/**
	 * Invalid email
	 */
	const INVALID_EMAIL = "aklsjdsakjdas@asdjasjd.com";

	/**
	 * Invalid password
	 */
	const INVALID_PASSWORD = "aklsjdsaljkdlsakj";


	/**
	 * Store the relative url of the pages with their title, descriptions, breadcrumb, tabs etc. here
	 *
	 * @var array
	 */
	public static $pages = [
							'Login'						=>	[
														'url'						=>	'',
														'title_text'				=>	'Log into your MyLocalMcDs account',
							],
							'Message Center'			=>	[
														'url'						=>	'messages/inbox/received',
														'title_text'				=>	'bla bla',
							],
	];

	/**
	 * Store xpaths and css locators here
	 *
	 * @var array
	 */
	public static $locators = [
							'Login'						=>	[
														'username_field'			=>	'.email.input-element',
														'password_field'			=>	'.password.input-element',
														'login_button'				=>	'.submit-button',
							],
							'Sidebar'					=>	[
														'log_out_button'			=>	'//*[text()="Sign out" and @class="MainNav-item"]',
							],
		];

	/**
	 * Use this function to fail a Behat step with a custom message.
	 *
	 * @param string $message - the text to appear after failing the step
	 * @throws \Exception
	 */
	public function showError($message = "Something went wrong!\n")
	{
		throw new \Exception($message);
	}

	/**
	 *  Generate a random string.
	 *
	 * @param $length - the desired length of the returned string
	 * @return string
	 */
	public function generateRandomLetters($length)
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$string = '';

		$size = strlen($chars);
		for ($i = 0; $i < $length; $i++) {
			$string .= $chars[rand(0, $size - 1)];
		}
		//$string = '0'.$string;

		return $string;
	}

	/**
	 * Generate a random set of digits.
	 * eg. 232432223
	 *
	 * @param $length - the desired length of the returned
	 * @param bool $start_with_zero - returned number will have 0 in front
	 * @return string
	 */
	public function generateRandomDigits($length, $start_with_zero = false)
	{
		$chars = "123456789";
		$string = '';

		if($start_with_zero)
			$length--;

		$size = strlen($chars);
		for ($i = 0; $i < $length; $i++) {
			$string .= $chars[rand(0, $size - 1)];
		}

		if($start_with_zero)
			$string = '0'.$string;

		return $string;
	}

	/**
	 * Generate a random email address.
	 * eg. testabc@abc.com
	 *
	 * @param string $prefix - random email prefix
	 * @return string
	 */
	public function generateRandomEmail($prefix = "test")
	{
		// array of random domains
		$sufix = array(".com", ".net", ".gov", ".org", ".edu", ".biz", ".info");
		$email =  uniqid($prefix) . "@{$prefix}" . $sufix[rand(0,sizeof($sufix)-1)];
		return $email;
	}


}
