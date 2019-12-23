Feature: Editor

  Scenario: Test init
    Given I am on "demos/simple.php"
    When I fill in "subject" with "the subject"
    And I type in editor "editor-editor" with text "editor content"
    And I use form with button "Save"
    Then Modal opens with text "editor : editor content"

  Scenario: Test see html
    Given I am on "demos/simple.php"
    When I fill in "subject" with "the subject"
    And I type in editor "editor-editor" with text "editor content"
    And I press editor button "trumbowyg-viewHTML-button"
    And I use form with button "Save"
    Then Modal opens with text "editor : <p>editor content</p>"