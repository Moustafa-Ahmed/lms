# 🚀 Career 180 – Full-Stack Laravel Challenge

**Stack:** Laravel 11/12, Livewire 3, Alpine.js, Tailwind CSS, Pest, Filament v3, Plyr.js

## 🎯 Goal

Build a realistic mini-LMS:

## 🔑 Functional Requirements

1. Public Home lists published courses.
2. Registration sends a Welcome email.
3. Enrollment requires login.
4. View Course page is the main entry point of a course.
5. Lessons have a video player (using Plyr: https://plyr.io/ ).
6. Track user progress; send a Course Completion email when finished.
7. Admin (Filament v3) to manage Levels, Courses, Lessons, Users, Enrollments & Progress.
8. Use Action classes for core flows.
9. Use Alpine.js for interactive UI behaviors (see below).

## 10. Auth & Emails

- Home (/) lists published courses (image, title, level).
- Guests must register/login to enroll.
- Registration triggers a Welcome Email.
- The system should gracefully handle concurrent actions (e.g., rapid enrollments or multiple email dispatch attempts) without producing inconsistent data or duplicate notifications.

## 11. View Course (entry point)

- /courses/{slug}: show course image, title, level, description, enroll/continue button, and ordered lessons list.
- If a lesson is is_free_preview = true → visible to guests; otherwise require enrollment.
- Course slugs should be handled in a way that ensures uniqueness and consistency, even when records are deleted and later restored.

## ⚡ Alpine.js Requirement

You must implement at least two interactive UI behaviors with Alpine.js (not Livewire). Examples:

1. Collapsible lesson list (accordion) on the View Course page.
2. Confirmation modal before marking a lesson as completed.
3. Progress bar animation that updates smoothly on completion.
4. Integrating Plyr with Alpine lifecycle hooks (x-data, x-init, x-ref).
5. (Bonus) Global dark mode toggle using Alpine state.

## 3. Lessons & Player

- Lesson fields: course_id, title, order, video_url, duration_seconds (optional), is_free_preview (bool).
- Lesson page: /courses/{slug}/lessons/{lesson}
- Uses Plyr to play video_url.
- Has Next/Previous navigation.
- Mark lesson as completed.

## 4. Progress & Completion

- Track lesson progress (started_at, completed_at, watch_seconds).
- A course is completed when all lessons are completed.
- On completion:
- Create a record in course_completions.
- Send Course Completion Email (once per course per user).
- Progress and completion tracking must remain accurate if course content changes (e.g., lessons added/removed) and emails should not be duplicated due to rapid status changes or retries.
- All emails should be dispatched asynchronously.

## 5. Admin (Filament v3)

- Levels CRUD.
- Courses CRUD with lessons relation (reorder by order).
- Users listing.
- Enrollments & Progress views:
- On Course → show enrolled users with % complete.
- On User → show enrolled courses with % complete.
- The data displayed should accurately reflect each user’s progress in real time without redundant queries or data leaks between users.
- Simple dashboard widget (total courses, enrollments, avg completion).
- Add any other resource that you can see necessary.

## 🛠 Actions Pattern

- All core flows should be implemented as Action classes (single-responsibility, invokable).
- Each Action should handle transactions and concurrency gracefully to preserve data integrity in multi-step flows (e.g., progress recording and completion marking).

## ✅ Testing (Pest)

- Registration sends Welcome Email.
- Enrollment requires login, not possible on draft courses, idempotent.
- Free preview lessons accessible to guests; others require enrollment.
- Recording lesson completion updates lesson_progress.
- Completing all lessons creates course_completions and sends Completion Email once.
- Policies: users cannot modify others’ progress/enrollments.
- Filament admin accessible only to admins.
- Require tests for Levels, Courses (with Lessons relation manager), Users (read-only), and Enrollments/Progress views.
- Include at least one test ensuring database constraints (e.g., unique slugs) and one verifying transactional consistency between progress and completion updates.

## 📦 Deliverables

- GitHub/GitLab repo.
- A video ( or multiple videos) demonstrating the task.
- README with:
- Setup + seeds (1 admin, 1 user, 3 levels, 2–3 courses with lessons, previews).
- How to run tests.
- Any assumptions/limitations.
- A screenshot of all test cases passed.
- “If I had more time...” section.
- Database ERD.

## 📋 Acceptance Checklist

- Home lists published courses.
- View Course page is the entry point.
- Registration sends Welcome Email.
- Enrollment requires auth; free preview works for guests.
- Plyr video player works.
- Lesson progress tracked; course completion detected + Completion Email sent.
- Admin (Filament v3): Levels, Courses & Lessons, Users directory, Course Enrollments with Progress, Dashboard widget.
- Actions pattern applied for business logic.
- At least three Alpine.js interactive features implemented.
- Pest tests cover main behaviors.
- All user data is isolated per account; no cross-user data exposure.
- Application demonstrates efficient database usage and consistent timestamp handling (store in UTC, display in user’s timezone).

Good luck!
