Feature: Editor
  Check after save
  Check after save html

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
    When I click first element using class ".trumbowyg-viewHTML-button"
    When I press button "Save"
    Then Modal is open with text "body : &lt;p&gt;editor content&lt;/p&gt;" in tag "*"