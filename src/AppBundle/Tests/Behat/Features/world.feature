Feature: Test send API request
  In order to test my API
  As a player
  I want to be able to perform HTTP request

  Background:
    Given I set "content-type" header equal to "application/json"

  @dbclean
  Scenario: As a player I can observe the world
    When I send a GET request to "/characters/968ad663-4e4d-4719-8fc7-af72ff931909/tiles"
    And print request and response
    Then the response status code should be 200
    And the JSON node "_embedded.items[0].id" should exist
    And the JSON node "_embedded.items[0].x" should exist
    And the JSON node "_embedded.items[0].y" should exist
