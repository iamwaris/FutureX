<?php

namespace App\Filament\Pages;

use App\Models\ThemeSetting;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ThemeBuilder extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationLabel = 'Theme Builder';

    protected static ?string $title = 'Theme Builder';

    protected static string $view = 'filament.pages.theme-builder';

    public ?array $data = [];

    private const FONT_OPTIONS = [
        'Inter' => 'Inter',
        'Manrope' => 'Manrope',
        'Space Grotesk' => 'Space Grotesk',
        'Sora' => 'Sora',
        'Plus Jakarta Sans' => 'Plus Jakarta Sans',
        'Outfit' => 'Outfit',
        'Urbanist' => 'Urbanist',
        'DM Sans' => 'DM Sans',
    ];

    public function mount(): void
    {
        $this->form->fill(ThemeSetting::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Theme')
                    ->tabs([
                        Tab::make('Colors')
                            ->schema([
                                ColorPicker::make('primary_color')->label('Primary'),
                                ColorPicker::make('secondary_color')->label('Secondary'),
                                ColorPicker::make('background_color')->label('Background'),
                                ColorPicker::make('surface_color')->label('Surface'),
                                ColorPicker::make('card_color')->label('Card'),
                                ColorPicker::make('border_color')->label('Border'),
                                ColorPicker::make('success_color')->label('Success'),
                                ColorPicker::make('warning_color')->label('Warning'),
                                ColorPicker::make('error_color')->label('Error'),
                                ColorPicker::make('text_primary_color')->label('Text — Primary'),
                                ColorPicker::make('text_secondary_color')->label('Text — Secondary'),
                                ColorPicker::make('text_muted_color')->label('Text — Muted'),
                            ])
                            ->columns(3),
                        Tab::make('Typography')
                            ->schema([
                                Select::make('font_heading')
                                    ->label('Heading Font')
                                    ->options(self::FONT_OPTIONS)
                                    ->native(false),
                                Select::make('font_body')
                                    ->label('Body Font')
                                    ->options(self::FONT_OPTIONS)
                                    ->native(false),
                            ])
                            ->columns(2),
                        Tab::make('Appearance')
                            ->schema([
                                TextInput::make('radius')
                                    ->label('Corner Radius (px)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(32),
                                Select::make('shadow_style')
                                    ->label('Shadow Style')
                                    ->options([
                                        'none' => 'None',
                                        'subtle' => 'Subtle',
                                        'soft' => 'Soft',
                                    ])
                                    ->native(false),
                                Select::make('animation_intensity')
                                    ->label('Animation Intensity')
                                    ->options([
                                        'none' => 'None',
                                        'subtle' => 'Subtle',
                                        'normal' => 'Normal',
                                        'expressive' => 'Expressive',
                                    ])
                                    ->native(false),
                                Select::make('section_spacing')
                                    ->label('Section Spacing')
                                    ->options([
                                        'compact' => 'Compact',
                                        'comfortable' => 'Comfortable',
                                        'spacious' => 'Spacious',
                                    ])
                                    ->native(false),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        ThemeSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('Theme updated')
            ->success()
            ->send();

        $this->dispatch('theme-updated');
    }
}
