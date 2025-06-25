## Project Overview: “Team Tasks Manager” API

Build a JSON-based REST API for managing teams, users, projects, and tasks. Users belong to teams; teams have projects; projects have tasks. Each user can only see and manage data within their own team.

### Core Requirements

1. **Models & Relationships**

   * **Team**: id, name, created\_at, updated\_at
   * **User**: id, name, email (unique), password (hashed), team\_id → belongsTo Team
   * **Project**: id, name, description, team\_id → belongsTo Team
   * **Task**: id, title, description, status (enum: todo, in\_progress, done), due\_date (date), project\_id → belongsTo Project

2. **Authentication & Authorization**

   * Implement token-based auth (suggested: Laravel Sanctum or JWT).
   * **Public**: `POST /api/login`, `POST /api/register` (assigns new user to a team—use a “team\_code” or invite flow).
   * **Protected**: all other endpoints require a valid token.
   * Ensure users can only CRUD resources belonging to their team.

3. **CRUD Endpoints**

   * **Teams** (admin-only—pick an admin flag on the User model)

     * `GET /api/teams`
     * `GET /api/teams/{id}`
     * `POST /api/teams`
     * `PUT /api/teams/{id}`
     * `DELETE /api/teams/{id}`
   * **Users**

     * `GET /api/users` (list users in your team)
     * `GET /api/users/{id}`
     * `PUT /api/users/{id}` (update name/email/password)
     * `DELETE /api/users/{id}`
   * **Projects**

     * `GET /api/projects` (with optional filtering by name)
     * `GET /api/projects/{id}`
     * `POST /api/projects`
     * `PUT /api/projects/{id}`
     * `DELETE /api/projects/{id}`
   * **Tasks**

     * `GET /api/projects/{project_id}/tasks` (filter by status, paginate)
     * `GET /api/tasks/{id}`
     * `POST /api/projects/{project_id}/tasks`
     * `PUT /api/tasks/{id}`
     * `DELETE /api/tasks/{id}`

4. **Validation & Error Handling**

   * Use Form Requests for validation rules.
   * Return proper HTTP status codes (400 for validation errors, 401/403 for auth errors, 404 when not found).
   * JSON error payloads should include a clear message and details where appropriate.

5. **Pagination & Filtering**

   * Paginate project and task lists (configurable via `?page` and `?per_page`).
   * Filter tasks by status (`?status=todo`) and due\_date range (e.g. `?due_from=2025-07-01&due_to=2025-07-31`).

6. **Testing**

   * Write feature tests for at least:

     * Registration/login flow
     * Creating/updating/deleting a project
     * Ensuring a user can’t access another team’s data
   * Use Laravel’s in-memory SQLite for tests.

7. **API Documentation**

   * Publish an OpenAPI (Swagger) spec (e.g. with [DarkaOnLine/L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger)).
   * Document all endpoints, parameters, response schemas, and auth flow.

---

## Stretch Goals

If you finish early or want more challenge:

* **Role-Based Access Control**: add roles (e.g. owner, manager, member) with different permissions.
* **Soft Deletes & Trash**: soft-delete projects and tasks; allow restore.
* **Event-Driven Notifications**: fire events on task status change; queue email notifications.
* **Rate Limiting**: throttle API per user.
* **Caching**: cache GET lists and invalidate on create/update/delete.
* **Dockerize**: provide a `docker-compose.yml` so the app, DB, and docs can run locally easily.
* **CI/CD**: include a GitHub Actions workflow that runs your tests and lints code.

---

## Deliverables

1. **Git Repository**

   * Well-structured branches or a single branch with descriptive commits.
   * README with setup instructions (including seeding a demo team + user).
2. **API Postman/Insomnia Collection**

   * Ready-to-run collection showcasing all endpoints.
3. **OpenAPI Spec**

   * Accessible via a `/api/docs` route or as a standalone YAML/JSON file.
4. **Test Coverage Report**

   * Show coverage percentage for controllers and models.

---

### Evaluation Criteria

* **Correctness**: the API works as specified, passes all tests.
* **Code Quality**: clean, well-organized, PSR-12 compliance, proper use of services/repositories if needed.
* **Security**: passwords hashed, tokens protected, unauthorized access prevented.
* **Documentation**: clear README and API docs.
* **Testing**: meaningful, reliable tests covering edge cases.
* **Extras**: any stretch goal(s) you implemented.

Good luck—this should give you a solid taste of real-world Laravel API development!
