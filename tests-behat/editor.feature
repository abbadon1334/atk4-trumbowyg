Feature: Editor
  Check basic functionalities

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "body-editor" with text "editor content"
    When I press button "Save"
    Then Modal is open with text "body : editor content" in tag "*"

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "body-editor" with text "editor content"
    When I click first element using class "trumbowyg-viewHTML-button"
    When I press button "Save"
    Then Modal is open with text "editor content" in tag "p"