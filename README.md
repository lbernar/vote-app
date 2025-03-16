# Simple Voting Module

## Overview
The **Simple Voting Module** is a custom Drupal module that enables users to vote on predefined questions with multiple answer options. Administrators can manage questions, answers, and view results directly from Drupal. The system is integrated into Drupal with a REST API for external applications.

## Features
- Admins can create, edit, and delete questions.
- Each question can have multiple answers, including images and descriptions.
- Users can vote on questions and view results based on permissions.
- Votes are recorded and results are calculated in real-time.
- An API is available for external systems to fetch questions and submit votes.

## Installation
### Requirements
- Drupal 10
- Lando for local development
- PHP 8.1+

### Steps
1. Clone the repository:
   ```sh
   git clone https://github.com/lbernar/simple_voting.git
   ```
2. Navigate to your Drupal installation:
   ```sh
   cd /app/web/modules/custom/
   ```
3. Move the module into place:
   ```sh
   mv ../simple_voting simple_voting
   ```
4. Start your Lando environment:
   ```sh
   lando start
   ```
5. Enable the module:
   ```sh
   lando drush en simple_voting -y
   ```
6. Import configurations:
   ```sh
   lando drush cim -y
   ```
7. Clear cache:
   ```sh
   lando drush cr
   ```

## API Endpoints
The module provides a REST API for managing votes and fetching voting data.

### 1. Get Available Questions
**Endpoint:**
```
GET /api/voting/questions
```
**Response:**
```json
[
  {
    "id": "1",
    "title": "Best programming language?",
    "answers": [
      { "id": "1", "label": "PHP" },
      { "id": "2", "label": "Python" }
    ]
  }
]
```

### 2. Submit a Vote
**Endpoint:**
```
POST /api/voting/vote
```
**Request Body:**
```json
{
  "question_id": "1",
  "answer_id": "2"
}
```
**Response:**
```json
{
  "message": "Vote submitted successfully!"
}
```

### 3. Get Voting Results
**Endpoint:**
```
GET /api/voting/results
```
**Response:**
```json
[
  {
    "question": "Best programming language?",
    "results": [
      { "answer": "PHP", "votes": 10, "percentage": 50 },
      { "answer": "Python", "votes": 10, "percentage": 50 }
    ]
  }
]
```

## Permissions
- `administer simple voting`: Allows full control over questions, answers, and votes.
- `vote on questions`: Allows users to submit votes.
- `view voting results`: Allows users to see voting results.

## Configuration
To enable or disable voting:
1. Navigate to `admin/config/simple-voting/settings`.
2. Toggle the `Enable Voting` checkbox.
3. Save changes.

## Testing with cURL
### Fetch questions:
```sh
curl -X GET "https://vote-app.lndo.site/api/voting/questions" -H "Accept: application/json"
```
### Submit a vote:
```sh
curl -X POST "https://vote-app.lndo.site/api/voting/vote" \
  -H "Content-Type: application/json" \
  -d '{"question_id": "1", "answer_id": "2"}'
```
### Fetch results:
```sh
curl -X GET "https://vote-app.lndo.site/api/voting/results" -H "Accept: application/json"
```

## Development & Contribution
### Running Locally
Use Lando for local development:
```sh
lando start
lando drush cr
```

### Contributing
1. Fork the repository.
2. Create a new branch.
3. Make your changes.
4. Submit a pull request.

## License
This module is licensed under the MIT License. See the `LICENSE` file for more details.

