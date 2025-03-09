# Simple Voting Module for Drupal

## Overview
The Simple Voting module provides a straightforward voting system for Drupal sites. It allows users to participate in polls and view results, making it easy to gather opinions and feedback.

## Functional Requirements
- Display voting questions to users.
- Allow users to submit their votes.
- Retrieve and display voting results.
- Provide an API for third-party applications to interact with the voting system.

## Non-Functional Requirements
- The module should be performant and handle multiple votes efficiently.
- It should adhere to Drupal coding standards and best practices.
- The module should be secure, preventing unauthorized access to voting functionalities.

## Installation
1. Download the module files and place them in the `modules/custom/simple_voting` directory of your Drupal installation.
2. Enable the module using the Drupal admin interface or Drush:
   ```
   drush en simple_voting
   ```

## Usage
- After enabling the module, you can add the voting block to any region in your theme.
- Configure the voting questions and options through the admin interface.

## API
The Simple Voting module provides a RESTful API for third-party applications. The following endpoints are available:

- `GET /api/voting/questions`: Retrieve a list of voting questions.
- `POST /api/voting/vote`: Submit a vote for a specific question.
- `GET /api/voting/results/{question_id}`: Retrieve results for a specific voting question.

## Testing
Unit tests are included in the `src/Tests/VotingTest.php` file to ensure the functionality of the voting system. Run the tests using PHPUnit to verify the module's behavior.

## Contributing
Contributions to the Simple Voting module are welcome. Please submit issues and pull requests on the project's repository.

## License
This module is released under the MIT License.