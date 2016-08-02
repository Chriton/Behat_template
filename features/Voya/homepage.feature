#Always follow this:
#In order to [benefit], as a [stakeholder] I want to [feature]

#@javascript - javascript session and Selenium2
#@insulated - The browser in this case will be fully reloaded and cleaned (before scenario)

@javascript @insulated
Feature: Voya - Login
	In order to access the myAccount section
	As a Voya user
	I want to be able to log in

	@smoke
	Scenario: User login with valid/invalid credentials
		Given I am on homepage
		When I do this


