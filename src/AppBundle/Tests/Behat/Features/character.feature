Feature: Test send API request
  In order to test my API
  As a player
  I want to be able to perform HTTP request

  Background:
    Given I set "content-type" header equal to "application/json"

  @dbclean
  Scenario: The character id cannot be empty
    When I send a POST request to "/characters" with body:
        """
        {
        }
        """
    And print request and response
    Then the response status code should be 400
    And the JSON path expression "violations[?property_path == 'id'].message" should be equal to json '["This value should not be blank."]'

  Scenario: The character prototype cannot be empty
    When I send a POST request to "/characters" with body:
        """
        {
        }
        """
    And print request and response
    Then the response status code should be 400
    And the JSON path expression "violations[?property_path == 'prototype'].message" should be equal to json '["This value should not be blank."]'

  Scenario: The character prototype should be valid
    When I send a POST request to "/characters" with body:
        """
        {
           "id": "4a7fe76a-e99b-4149-acc6-8a0fe7fcfcb0",
           "prototype": "invalid"
        }
        """
    And print request and response
    Then the response status code should be 500
    And the JSON node "message" should be equal to "Unknown prototype 'invalid'"

  Scenario: As a player I can create the character
    When I send a POST request to "/characters" with body:
        """
        {
           "id": "4a7fe76a-e99b-4149-acc6-8a0fe7fcfcb0",
           "prototype": "warrior"
        }
        """
    And print request and response
    Then the response status code should be 201
