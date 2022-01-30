Feature: Editor
  Testing basic functionalities

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "body" with text "editor content"
    Then Editor "body" value should be equal to "<p>editor content</p>"

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "body" with text "editor content"
    When I press button "Save"
    Then I wait 1000 ms
    Then Modal is open with text "editor content" in tag "*"

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "body" with text "editor content"
    When I press button "Save"
    Then I wait 1000 ms
    Then Modal is open with text "body : &lt;p&gt;editor content&lt;/p&gt;" in tag "*"

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "body" with text "editor content"
    When I click first element using class ".trumbowyg-viewHTML-button"
    When I press button "Save"
    Then I wait 1000 ms
    Then Modal is open with raw text "body : <p>editor content</p>" in tag "p"

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "body" with text "editor content"
    When I click first element using class ".trumbowyg-viewHTML-button"
    When I press button "Save"
    Then I wait 1000 ms
    Then Modal is open with raw text "body : &lt;p&gt;editor content&lt;/p&gt;" in tag "p"