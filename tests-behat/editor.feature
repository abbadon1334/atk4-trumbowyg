Feature: Editor
  Check basic functionalities

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "editor-editor" with text "editor content"
    When I use form with button "Save"
    Then Modal opens with text "editor : editor content"

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "editor-editor" with text "editor content"
    When I press editor button "trumbowyg-viewHTML-button"
    When I use form with button "Save"
    Then Modal opens with text "editor : <p>editor content</p>"