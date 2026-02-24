<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use App\Models\Lesson;
use App\Support\UserTimezone;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    protected static ?string $title = 'Enrolled Users';

    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        $totalLessons = Lesson::query()
            ->where('course_id', $this->getOwnerRecord()->getKey())
            ->count();

        return $table
            ->recordTitleAttribute('id')
            ->modifyQueryUsing(
                fn (Builder $query) => $query
                    ->with('user')
                    ->addSelect([
                        'enrollments.*',
                        DB::raw('(
                        SELECT COUNT(*)
                        FROM lesson_progress lp
                        INNER JOIN lessons l ON lp.lesson_id = l.id
                        WHERE lp.user_id = enrollments.user_id
                            AND l.course_id = enrollments.course_id
                            AND lp.completed_at IS NOT NULL
                    ) as completed_lessons_count'),
                        DB::raw('EXISTS(
                        SELECT 1
                        FROM course_completions cc
                        WHERE cc.user_id = enrollments.user_id
                            AND cc.course_id = enrollments.course_id
                    ) as has_completion'),
                    ])
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('completion_percentage')
                    ->label('Progress')
                    ->getStateUsing(function ($record) use ($totalLessons): string {
                        if ($totalLessons === 0) {
                            return '0%';
                        }

                        return round(($record->completed_lessons_count / $totalLessons) * 100).'%';
                    }),

                Tables\Columns\IconColumn::make('course_completed')
                    ->label('Completed')
                    ->getStateUsing(fn ($record): bool => (bool) $record->has_completion)
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Enrolled At')
                    ->dateTime(timezone: UserTimezone::fromSession())
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
