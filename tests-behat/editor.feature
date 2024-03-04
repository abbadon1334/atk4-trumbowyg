Feature: Editor
  Testing basic functionalities

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "body" with text "editor content"
    Then Editor "body" value should be equal to "editor content"

# Firefox fails : https://github.com/Alex-D/Trumbowyg/issues/999
#  Scenario:
#    Given I am on "index.php"
#    When I fill in "subject" with "the subject"
#    When I type in editor "body" with text "editor content"
#    When I click icon using css ".trumbowyg-viewHTML-button"
#    Then Editor "body" value should be equal to "<p>editor content</p>"

# Firefox fails : https://github.com/Alex-D/Trumbowyg/issues/999
#  Scenario:
#    Given I am on "index.php"
#    When I fill in "subject" with "the subject"
#    When I type in editor "body" with text "editor content"
#    When I click icon using css ".trumbowyg-viewHTML-button"
#    When I click icon using css ".trumbowyg-viewHTML-button"
#    Then Editor "body" value should be equal to "<p>editor content</p>"

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "body" with text "editor content"
    When I press button "Save"
    Then Modal is open with raw text "body : editor content" in tag "p"

  Scenario:
    Given I am on "index.php"
    When I fill in "subject" with "the subject"
    When I type in editor "body" with text "editor content"
    When I click using selector ".trumbowyg-viewHTML-button"
    When I press button "Save"
    Then Modal is open with raw text "body : &lt;p&gt;editor content&lt;/p&gt;" in tag "p"