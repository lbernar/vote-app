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
lando composer install
lando db-import <file>
lando drush cr
```
## License
This module is licensed under the MIT License. See the `LICENSE` file for more details.

