# Detailed Phased Implementation Plan: Career 180 LMS (Laravel 12 + Livewire + Filament)

## Summary

This plan implements the LMS from the current starter-kit baseline into the target architecture in `docs/architecture.md`, using a strict Laravel Action pattern (invokable, transactional writes, idempotent critical flows).

It is split into 6 smaller phases with concrete files, routes, actions, tests, and done criteria so execution can proceed without further design decisions.

## Public APIs / Interfaces / Types (Planned)

- Web routes:
    - `GET /` (published catalog)
    - `GET /courses/{course:slug}` (course entry page)
    - `POST /courses/{course:slug}/enroll` (auth-required enrollment)
    - `GET /courses/{course:slug}/lessons/{lesson}` (lesson page, access-checked)
    - `POST /courses/{course:slug}/lessons/{lesson}/complete` (auth-required completion)
- Action contracts (invokable classes):
    - `EnrollInCourseAction(User $user, Course $course): Enrollment`
    - `AuthorizeLessonAccessAction(?User $user, Course $course, Lesson $lesson): bool`
    - `RecordLessonCompletionAction(User $user, Lesson $lesson): LessonProgress`
    - `FinalizeCourseCompletionAction(User $user, Course $course): ?CourseCompletion`
    - `SendWelcomeEmailAction(User $user): void`
- Policies/interfaces:
    - Enrollment ownership policy
    - Lesson progress ownership policy
    - Admin gate/policy for Filament access

## Phase 1: Foundation and Data Model

### Goals

- Establish LMS schema and Eloquent domain with constraints and indexes for idempotency/concurrency correctness.

### Implementation

1. Create migrations (using artisan) for:
    - `levels` table
    - `courses` table
        - `level_id`, `title`, `slug` (unique), `description`, `image_url` (nullable), `is_published` (bool), timestamps, soft deletes
    - `lessons` table
        - `course_id`, `title`, `order`, `video_url`, `duration_seconds` (nullable), `is_free_preview` (bool), timestamps
        - unique index on `(course_id, order)`
    - `enrollments` table
        - `user_id`, `course_id`, timestamps
        - unique index on `(user_id, course_id)`
    - `lesson_progress` table
        - `user_id`, `lesson_id`, `watch_seconds` default `0`, `started_at` nullable, `completed_at` nullable, timestamps
        - unique index on `(user_id, lesson_id)`
    - `course_completions` table
        - `user_id`, `course_id`, `completed_at`, timestamps
        - unique index on `(user_id, course_id)`
2. Add/modify `users` table for admin capability:
    - Add `is_admin` boolean default `false`.
3. Create models and relationships:
    - `app/Models/Level.php`
    - `app/Models/Course.php`
    - `app/Models/Lesson.php`
    - `app/Models/Enrollment.php`
    - `app/Models/LessonProgress.php`
    - `app/Models/CourseCompletion.php`
    - Update `app/Models/User.php` relationships to enrollments/progress/completions.
4. Add factories:
    - `database/factories/LevelFactory.php`
    - `database/factories/CourseFactory.php`
    - `database/factories/LessonFactory.php`
    - `database/factories/EnrollmentFactory.php`
    - `database/factories/LessonProgressFactory.php`
    - `database/factories/CourseCompletionFactory.php`
    - Update `UserFactory` with `admin()` state.
5. Seed baseline dataset:
    - Update `database/seeders/DatabaseSeeder.php` to create:
        - 1 admin, 1 learner
        - 3 levels
        - 2 to 3 courses (mix published/draft)
        - lessons with preview/non-preview flags.

### Tests

- New file `tests/Feature/Lms/SchemaConstraintsTest.php`:
    - unique slug enforced
    - unique enrollment enforced
    - unique completion enforced
    - unique progress row enforced
- Run targeted tests only for this phase.

### Exit Criteria

- Migrations pass on fresh DB.
- Constraints verified by tests.
- Factories/seeders generate coherent domain data.

## Phase 2: Public Catalog and Course Entry + Enrollment

### Goals

- Deliver user-facing catalog and course entry flow with auth-gated, idempotent enrollment.

### Implementation

1. Routes:
    - Update `routes/web.php` with:
        - `GET /` catalog action/controller
        - `GET /courses/{course:slug}`
        - `POST /courses/{course:slug}/enroll` with `auth` middleware
2. Controllers / Livewire entrypoints:
    - Add lightweight HTTP layer:
        - `app/Http/Controllers/CourseCatalogController.php`
        - `app/Http/Controllers/CourseShowController.php`
        - `app/Http/Controllers/EnrollmentController.php`
3. Actions:
    - `app/Actions/LMS/EnrollInCourseAction.php`
        - Transactional
        - Reject unpublished course
        - `firstOrCreate` + unique index fallback handling for race safety
4. Views:
    - Replace hardcoded home course list in `resources/views/home/design12.blade.php` with published DB-driven rendering.
    - Add `resources/views/courses/show.blade.php`:
        - image/title/level/description
        - enroll or continue CTA
        - ordered lesson list
        - guest sees only preview lessons
5. Policies:
    - `app/Policies/CoursePolicy.php` for enrollability visibility rules if needed.
    - Register policies in `app/Providers/AppServiceProvider.php` (or existing Laravel 12 policy registration pattern).

### Tests

- `tests/Feature/Lms/CatalogAndEnrollmentTest.php`:
    - home lists published only
    - guest cannot enroll
    - auth user can enroll published
    - draft/unpublished enrollment blocked
    - repeated enrollment request remains one row (idempotent)

### Exit Criteria

- Course entry point functional.
- Enrollment behavior matches requirements and tests pass.

## Phase 3: Lesson Access, Player, and Alpine Interactions

### Goals

- Build lesson page with Plyr and enforce preview/enrollment access rules.
- Implement required Alpine interactions (minimum 3 to exceed requirement).

### Implementation

1. Routes:
    - `GET /courses/{course:slug}/lessons/{lesson}`
    - `POST /courses/{course:slug}/lessons/{lesson}/complete` (auth)
2. Access action:
    - `app/Actions/LMS/AuthorizeLessonAccessAction.php`
        - Preview lessons allowed for guests
        - Non-preview requires valid enrollment
3. Controller:
    - `app/Http/Controllers/LessonShowController.php`
    - `app/Http/Controllers/LessonCompletionController.php`
4. Lesson UI:
    - `resources/views/lessons/show.blade.php`:
        - Plyr player integration
        - prev/next lesson navigation
        - completion action button
5. Alpine features (3):
    - Collapsible lesson list accordion.
    - Confirmation modal before completion submit.
    - Plyr lifecycle integration via `x-data`, `x-init`, `x-ref`.
    - Optional fourth: animated progress bar state update.
6. Frontend assets:
    - Update `resources/js/app.js` for Plyr init helpers if needed.
    - Keep styling in existing Tailwind conventions.

### Tests

- `tests/Feature/Lms/LessonAccessTest.php`:
    - preview accessible to guest
    - non-preview blocked for guest
    - non-preview allowed for enrolled user
    - lesson-course mismatch rejected (404/403 based on chosen enforcement)

### Exit Criteria

- Lesson page works with video + navigation.
- Access rules enforced and tested.
- Alpine interaction requirement satisfied.

## Phase 4: Progress, Completion, and Async Emails

### Goals

- Record progress and determine course completion accurately under concurrency/retry conditions.

### Implementation

1. Mailables:
    - `app/Mail/WelcomeEmail.php`
    - `app/Mail/CourseCompletionEmail.php`
    - Both implement queueing pattern (`ShouldQueue` on job/mailable strategy chosen consistently).
2. Actions:
    - `app/Actions/LMS/SendWelcomeEmailAction.php`
    - `app/Actions/LMS/RecordLessonCompletionAction.php`
        - upsert lesson_progress row
        - set `started_at` when first interacted
        - set `completed_at` idempotently
    - `app/Actions/LMS/FinalizeCourseCompletionAction.php`
        - transactional check against current lesson set
        - create `course_completions` once
        - dispatch completion email once only
3. Fortify integration:
    - Update `app/Actions/Fortify/CreateNewUser.php` to dispatch welcome email action after create.
    - Ensure async dispatch, not sync mail send.
4. Concurrency/consistency rules:
    - Use transaction around progress+completion boundary.
    - Handle duplicate-key exceptions as idempotent success where appropriate.
    - Ensure completion recalculates against current lesson set (content changed scenario).

### Tests

- `tests/Feature/Lms/ProgressAndCompletionTest.php`:
    - registration queues welcome email
    - completion writes lesson_progress
    - completing all lessons creates one completion row
    - completion email sent once only under repeated completion calls
    - transactional consistency test between progress write and completion creation

### Exit Criteria

- Emails are queued and deduplicated by persisted state.
- Completion logic stable under repeated requests.

## Phase 5: Authorization Hardening and Filament Admin

### Goals

- Enforce per-user isolation across learner flows and deliver required admin tooling.

### Implementation

1. Policies:
    - `app/Policies/EnrollmentPolicy.php`
    - `app/Policies/LessonProgressPolicy.php`
    - `app/Policies/CourseCompletionPolicy.php`
    - Ensure all learner mutations are owner-scoped.
2. Filament panel/access:
    - Validate/adjust `app/Providers/Filament/AdminPanelProvider.php` for admin-only guard using `is_admin`.
3. Filament resources:
    - `LevelResource` (CRUD)
    - `CourseResource` + Lessons relation manager (sortable by `order`)
    - `UserResource` (read/list focus)
    - Enrollment/progress visibility:
        - On Course view: enrolled users with `% complete`
        - On User view: enrolled courses with `% complete`
4. Dashboard widget:
    - Total courses
    - Total enrollments
    - Average completion %
5. Query performance in admin:
    - centralize aggregates and eager loading in resource queries
    - avoid per-row calculated N+1 queries.

### Tests

- `tests/Feature/Lms/AuthorizationIsolationTest.php`:
    - user cannot modify/read another user progress/enrollment
- `tests/Feature/Admin/FilamentAccessTest.php`:
    - admin allowed, non-admin denied
- `tests/Feature/Admin/FilamentResourcesTest.php`:
    - resource pages load and core relations display expected data

### Exit Criteria

- Admin meets challenge resource requirements.
- Authorization boundaries are test-proven.

## Phase 6: Optimization, Documentation, and Final Acceptance

### Goals

- Final hardening, acceptance validation, and deliverable completeness.

### Implementation

1. Performance pass:
    - Review key queries (catalog, course show, lesson show, admin metrics).
    - Add missing indexes/scopes if tests or profiling indicate bottlenecks.
2. Timezone and timestamp handling:
    - Store in UTC (default Laravel behavior).
    - Document display strategy for user timezone conversion.
3. README completion:
    - setup instructions
    - seed data description
    - run tests instructions
    - assumptions/limits
    - `If I had more time...`
    - ERD image/link placement notes
4. Final quality commands:
    - `vendor/bin/pint --dirty`
    - Targeted tests per module, then full `php artisan test --compact`

### Tests / Acceptance Matrix

- Verify every checklist item from `REQUIREMENTS.md` is mapped to at least one passing test.
- Keep an explicit requirement-to-test mapping in final PR/checklist notes.

### Exit Criteria

- All required tests pass.
- Code formatted with Pint.
- Deliverables complete for submission.

## Cross-Phase Rules (Non-Negotiable)

- Use artisan generators for new Laravel artifacts (`make:model`, `make:migration`, `make:policy`, `make:test --pest`, etc.).
- Keep Action pattern strict for core flows: invokable, transactional writes, idempotent outcomes.
- Use Eloquent relations/scopes; avoid raw `DB::` unless strictly needed.
- Run minimal relevant tests after each phase, not only at the end.

## Assumptions and Defaults Chosen

1. Existing `docs/architecture.md` is the source architecture baseline.
2. Project stays on current stack (Laravel 12, Livewire starter kit, Pest, Filament v3).
3. Home route remains `/`, now dynamically backed by published course data.
4. Enrollment and completion deduplication is guaranteed by both database unique constraints and action-level idempotency logic.
5. Mail delivery is asynchronous via queue in all required flows.
6. Phase completion requires both implementation and passing targeted tests before moving forward.
