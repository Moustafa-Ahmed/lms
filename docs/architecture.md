# Career 180 LMS Architecture

## 1) Purpose and Scope

This document defines the architecture for the Career 180 mini-LMS challenge.

It covers the end-to-end system design for:

- Public course catalog for published courses.
- Authentication and registration with welcome email dispatch.
- Enrollment and learner access controls.
- Course and lesson learning experience with video playback.
- Progress tracking and completion detection.
- Course completion email dispatch.
- Admin operations with Filament resources and dashboard metrics.

## 2) System Context

### Actors

- Guest: browses published courses and preview lessons.
- Learner: enrolls, watches lessons, and tracks progress.
- Admin: manages catalog and monitors enrollment/progress.
- Queue Worker: processes asynchronous email jobs.

### Subsystems

- Web UI: Blade, Livewire components, Alpine behaviors.
- Application Layer: action classes coordinating core flows.
- Data Layer: Eloquent models and relational database.
- Async Layer: queued mail/jobs/events.
- Admin UI: Filament resources and widgets.

## 3) Domain Model (Conceptual)

### Core Entities

- User: learner/admin account identity.
- Level: difficulty grouping for courses.
- Course: publishable learning container with slug and metadata.
- Lesson: ordered unit inside a course with video URL and preview flag.
- Enrollment: membership of user in course.
- LessonProgress: per-user, per-lesson state including watch/completion timing.
- CourseCompletion: per-user, per-course completion record.

### Key Constraints

- Course slug must be unique and consistent.
- Enrollment must be unique on `(user_id, course_id)`.
- Course completion must be unique on `(user_id, course_id)`.
- Lesson order must be deterministic per course.
- Progress rows should be unique on `(user_id, lesson_id)`.

## 4) Application Architecture

### Layer Responsibilities

- Presentation Layer:
    - Blade routes/views for pages.
    - Livewire components for server-driven interactions.
    - Alpine.js for required client-side interactivity.
- Application Layer:
    - Invokable actions orchestrating business use cases.
- Domain/Persistence Layer:
    - Eloquent models, relationships, scopes, and query constraints.
- Infrastructure Layer:
    - Queue, mail, events, and jobs.

### Dependency Direction

- Controllers/components invoke actions.
- Actions coordinate model reads/writes and dispatch infrastructure work.
- Models do not call UI or controller concerns.
- Mail sending occurs through queued jobs/events from actions.

## 5) Action Pattern Strategy

All core flows follow strict action conventions:

- One core flow maps to one invokable action.
- Write actions own transaction boundaries.
- Critical flows must be idempotent under retries and rapid repeated requests.
- Domain-safe exceptions are surfaced for predictable failure behavior.

### Conceptual Action Categories

- Enrollment actions:
    - Validate course eligibility and create enrollment idempotently.
- Progress actions:
    - Record lesson progress and completion state.
- Completion actions:
    - Detect and persist course completion; trigger email once.
- Access actions:
    - Evaluate lesson/course visibility based on auth and enrollment.

## 6) Key Business Flows

### Flow A: Registration to Welcome Email

1. User registers via auth flow.
2. Account creation succeeds.
3. Action/event dispatches welcome mail job asynchronously.
4. Queue worker sends welcome email.

### Flow B: Enrollment in Published Course

1. Authenticated user requests enrollment.
2. System verifies course is published and enrollable.
3. Enrollment action executes idempotent create/no-op.
4. User is redirected to course entry state (enrolled/continue).

### Flow C: Lesson Access Control

1. User requests lesson page.
2. If lesson is preview, allow guest access.
3. If not preview, require enrollment and authorization.
4. Deny unauthorized access with policy-consistent response.

### Flow D: Lesson Completion to Course Completion

1. User marks lesson completed.
2. Progress action writes/updates lesson progress atomically.
3. Completion action evaluates whether all required lessons are complete.
4. If complete, create one course completion record.
5. Queue completion email once using idempotent guard.

### Flow E: Course Detail Entry Point

1. `/courses/{slug}` resolves course by unique slug.
2. Page shows metadata, level, description, and ordered lessons.
3. UI determines enroll/continue call-to-action from enrollment state.
4. Guests see preview lessons only.

## 7) Authorization and Data Isolation

Policy-first access model:

- Learners can view and mutate only their own enrollments/progress.
- Learners cannot read or update another user’s course data.
- Admin area is restricted to admin-authorized users only.
- Filament resources enforce admin access globally.

Isolation requirements:

- No cross-user progress leakage in learner-facing pages.
- Query scopes must always include authenticated user boundaries where needed.

## 8) Async Processing and Email Delivery

Asynchronous requirements:

- Welcome email is always queued.
- Course completion email is always queued.

Uniqueness and retry safety:

- Completion notification depends on persisted completion state.
- Retries must not generate duplicate completion emails.
- Rapid repeated completion triggers must converge to a single completion + single notification outcome.

## 9) Admin Architecture (Filament Core Resources + Widget)

### Core Resources

- Levels: full CRUD.
- Courses: CRUD with lesson relation management and ordering.
- Lessons: managed primarily through course relation context.
- Users: read/list directory for administration.
- Enrollment/Progress views:
    - Course-centric view of enrolled users and percent completion.
    - User-centric view of enrolled courses and percent completion.

### Dashboard Widget

- Total courses.
- Total enrollments.
- Average completion percentage.

### Query Expectations

- Admin queries must be scoped and aggregated efficiently.
- Resource pages should avoid redundant per-row queries.

## 10) Data Integrity, Concurrency, and Idempotency

Guardrails:

- Unique constraints for slug, enrollments, completions, and progress identity.
- Transaction boundaries around multi-step write flows.
- Atomic checks or locking where race conditions are likely.

Concurrency objectives:

- Repeated enroll requests produce one logical enrollment.
- Repeated lesson completion updates remain consistent.
- Completion generation and email dispatch remain single-outcome under race/retry conditions.

## 11) Performance and Query Strategy

Data access standards:

- Use eager loading for courses, levels, lessons, and progress relations to prevent N+1.
- Prefer aggregate queries for completion percentages.
- Use indexed lookups for slug and user-course/lesson keys.

Suggested index focus:

- `courses.slug` unique index.
- Composite unique/index on enrollment and completion foreign keys.
- Composite key/index on progress keys and status timestamps.

## 12) Testing Strategy (Pest)

Behavioral matrix must validate:

1. Registration queues welcome email.
2. Enrollment requires authentication.
3. Draft/unpublished course enrollment is blocked.
4. Enrollment is idempotent.
5. Preview lessons are accessible to guests.
6. Non-preview lessons require enrollment.
7. Lesson completion writes progress state.
8. Full-course completion creates one completion record.
9. Completion email is sent once under retries/rapid updates.
10. Policies prevent cross-user modification/access.
11. Filament admin area is admin-only.
12. Constraint and transactional consistency scenarios are enforced.

## 13) Milestones

- Milestone 1: Core domain model, published catalog, auth, enrollment.
- Milestone 2: Lesson playback, progress recording, completion tracking, queued emails.
- Milestone 3: Filament resources for Levels/Courses/Lessons/Users and completion metrics widget.
- Milestone 4: Hardening for policy isolation, concurrency/idempotency tests, and query optimization.
