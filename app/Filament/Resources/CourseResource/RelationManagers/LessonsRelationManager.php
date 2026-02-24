<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('order')
                    ->required()
                    ->integer()
                    ->minValue(1)
                    ->default(fn () => ($this->getOwnerRecord()->lessons()->max('order') ?? 0) + 1),

                Forms\Components\TextInput::make('duration_seconds')
                    ->label('Duration (seconds)')
                    ->integer()
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Auto-populated from the uploaded video.'),

                Forms\Components\SpatieMediaLibraryFileUpload::make('lesson_video')
                    ->label('Video')
                    ->collection('lesson_video')
                    ->disk('public')
                    ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                    ->maxSize(110 * 1024) // 110 MB — matches Herd PHP upload_max_filesize
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_free_preview')
                    ->label('Free Preview')
                    ->default(false),
            ])
            ->columns(2);
    }

    /**
     * Override Filament's bulk CASE WHEN reorder to avoid hitting the unique
     * (course_id, order) constraint during intermediate states.
     *
     * @param  array<int|string>  $order
     */
    public function reorderTable(array $order): void
    {
        if (! $this->getTable()->isReorderable()) {
            return;
        }

        DB::transaction(function () use ($order): void {
            // Phase 1: shift every record to a safe temporary range so no two
            // rows share the same (course_id, order) pair mid-update.
            foreach ($order as $index => $recordKey) {
                Lesson::withoutGlobalScopes()
                    ->whereKey($recordKey)
                    ->update(['order' => 1_000_000 + $index + 1]);
            }

            // Phase 2: apply the real target positions.
            foreach ($order as $index => $recordKey) {
                Lesson::withoutGlobalScopes()
                    ->whereKey($recordKey)
                    ->update(['order' => $index + 1]);
            }
        });

        $this->getOwnerRecord()->recalculateStats();
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->defaultSort('order')
            ->reorderable('order')
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('duration_seconds')
                    ->label('Duration')
                    ->formatStateUsing(fn (?int $state): string => $state !== null ? gmdate('H:i:s', $state) : '—')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_free_preview')
                    ->label('Free Preview')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(fn () => $this->getOwnerRecord()->recalculateStats()),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(fn () => $this->getOwnerRecord()->recalculateStats()),
                Tables\Actions\RestoreAction::make()
                    ->after(fn () => $this->getOwnerRecord()->recalculateStats()),
                Tables\Actions\DeleteAction::make()
                    ->after(fn () => $this->getOwnerRecord()->recalculateStats()),
                Tables\Actions\ForceDeleteAction::make()
                    ->after(fn () => $this->getOwnerRecord()->recalculateStats()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(fn () => $this->getOwnerRecord()->recalculateStats()),
                    Tables\Actions\RestoreBulkAction::make()
                        ->after(fn () => $this->getOwnerRecord()->recalculateStats()),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->after(fn () => $this->getOwnerRecord()->recalculateStats()),
                ]),
            ]);
    }
}
