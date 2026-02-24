<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    protected static ?string $title = 'Enrolled Courses';

    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->modifyQueryUsing(function (Builder $query): void {
                $query
                    ->select('enrollments.*')
                    ->with(['course.level'])
                    ->addSelect(DB::raw('
                        (
                            SELECT COUNT(*)
                            FROM lessons
                            WHERE lessons.course_id = enrollments.course_id
                            AND lessons.deleted_at IS NULL
                        ) AS total_lessons
                    '))
                    ->addSelect(DB::raw('
                        (
                            SELECT COUNT(*)
                            FROM lesson_progress
                            INNER JOIN lessons ON lesson_progress.lesson_id = lessons.id
                            WHERE lesson_progress.user_id = enrollments.user_id
                            AND lessons.course_id = enrollments.course_id
                            AND lesson_progress.completed_at IS NOT NULL
                            AND lessons.deleted_at IS NULL
                        ) AS completed_lessons
                    '))
                    ->addSelect(DB::raw('
                        (
                            SELECT COUNT(*)
                            FROM course_completions
                            WHERE course_completions.user_id = enrollments.user_id
                            AND course_completions.course_id = enrollments.course_id
                        ) AS has_completion
                    '));
            })
            ->columns([
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('course.level.name')
                    ->label('Level')
                    ->badge(),

                Tables\Columns\TextColumn::make('completion_percentage')
                    ->label('Progress')
                    ->getStateUsing(function ($record): string {
                        $total = (int) $record->total_lessons;

                        if ($total === 0) {
                            return '0%';
                        }

                        return round(($record->completed_lessons / $total) * 100) . '%';
                    }),

                Tables\Columns\IconColumn::make('course_completed')
                    ->label('Completed')
                    ->getStateUsing(fn($record): bool => (int) $record->has_completion > 0)
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Enrolled At')
                    ->dateTime(timezone: session('userTimezone', 'UTC'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
