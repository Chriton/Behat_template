<?php
/**
 * Created by PhpStorm.
 * User: doru.muntean
 * Date: 02/08/16
 * Time: 21:52
 */

//The Voya namespace is defined in /vendor/composer/autoload_psr4.php
namespace Voya\Voya;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\CustomSnippetAcceptingContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Context\Exception;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkAwareContext;
use Behat\Mink;

use Behat\Testwork\Tester\Result\TestResult;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;


use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Driver\Selenium2Driver;


//this is where all the core methods are defined
use Voya\core\VoyaCore;

date_default_timezone_set('UTC');

/**
 * Chriton. 25.02.2016
 * We can have Behat 3 generate 2 kind of snippets: regex based snippets or turnip based snippets
 * If our class implements 'SnippetAcceptingContext' interface, then Behat 3 will generate turnip based snippets.
 * If our class implements 'CustomSnippetAcceptingContext' interface, then we can choose what kind of snippets Behat 3
 * will generate: turnip or regex based snippets. In this case we must declare the getAcceptedSnippetType() method in our
 * class and have it return a string with 'regex' or 'turnip' like this:
 * public static function getAcceptedSnippetType()
 * {
 * return 'regex';
 * }
 *
 *The difference between turnip and regex is that turnip is more simple to construct and understand
 * https://groups.google.com/forum/#!topic/cukes/0j_5u9zkZng
 *
 * eg.  If we have a step like this: Given I declare this with "1" argument
 *      regex based snippet would be:  @Given /^I declare this with "([^"]*)" argument$/
 *      turnip based snipped would be: @Given I declare this with :arg1 argument
 *
 * Note that PhpStorm 10.0.3 will only generate regex snippets if you are using alt+enter command
 * Behat3 - https://youtu.be/xOgyKTmgYI8
 *
 */


class VoyaContext extends VoyaCore implements CustomSnippetAcceptingContext
{

	public $customParameters;
	public $screenshot_name;


	/**
	 * MyLocalHqContext constructor.
	 * @param $parameters
	 */
	public function __construct($parameters)
	{
		$this->customParameters = !empty($parameters) ? $parameters : array();
	}

	/**
	 * if our class implements CustomSnippetAcceptingContext interface,
	 * then we will use this method to switch between turnip/regex generated snippets
	 *
	 * @return string
	 */
	public static function getAcceptedSnippetType()
	{
		return 'regex';
	}

	/**
	 * Maximize the browser window at runtime and get Scenario Title
	 * @BeforeScenario
	 * @param BeforeScenarioScope $scope
	 * @return string $feature_Name
	 */
	public function getScenarioName(BeforeScenarioScope $scope)
	{
		// Get the window width and height dynamically
		$windowWidth=$this->getSession()->evaluateScript('return window.screen.width');
		$windowHeight=$this->getSession()->evaluateScript('return window.screen.height');
		// Resize the window to the given parameters
		$this->getSession()->getDriver()->resizeWindow($windowWidth,$windowHeight,'current');

		settype($feature_Name, "string");
		$this->screenshot_name = $scope->getScenario()->getTitle();

		return $feature_Name;
	}

	/**
	 * Take screenshot when step fails. Works only with Selenium2Driver
	 * @AfterStep
	 * @param AfterStepScope $scope
	 */
	public function takeScreenshotAfterFailedStep(AfterStepScope $scope)
	{
		if ($scope->getTestResult()->getResultCode() === TestResult::FAILED)
		{
			$driver = $this->getSession()->getDriver();

			if (! $driver instanceof Selenium2Driver) { return; }

			if (! is_dir($this->customParameters['screen_shot_path']))
			{
				mkdir($this->customParameters['screen_shot_path'], 0777, true);
			}

			$screenshot_name = str_replace(' ', '_',$this->screenshot_name). '.png';

			$this->saveScreenshot($screenshot_name, $this->customParameters['screen_shot_path']);
		}
	}

	/**
	 * @When /^I do this$/
	 */
	public function iDoThis()
	{
		//bla bla
	}


}