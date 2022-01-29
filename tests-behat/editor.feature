Feature: Editor
  Check basic functionalities

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "body-editor" with text "editor content"
    When I press button "Save"
    Then Modal is open with text "body : editor content"

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "body-editor" with text "editor content"
    When I press editor button with class "trumbowyg-viewHTML-button"
    When I press button "Save"
    Then Modal is open with text "body : <p>editor content</p>"