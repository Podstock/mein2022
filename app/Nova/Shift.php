<?php

namespace App\Nova;

use App\Models\Shiftrole;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Shift extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Shift::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'description', 'time',
    ];

    public static $group = 'Helfen';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')->rules('required'),
            BelongsTo::make('Bereich', 'help_category', \App\Nova\HelpCategory::class)->sortable(),
            Select::make('Tag', 'day')->options([
                'day-1' => 'Mittwoch Tag -1',
                'day0' => 'Donnerstag Tag 0',
                'day1' => 'Freitag Tag 1',
                'day2' => 'Samstag Tag 2',
                'day3' => 'Sonntag Tag 3',
                'day4' => 'Montag Tag 4',
            ])->rules('required')->displayUsingLabels()->sortable(),
            Text::make('Time')->withMeta([
                'extraAttributes' => [
                    'placeholder' => '23:42',
                ],
            ])->required()->sortable(),
            Number::make('Dauer', 'duration')
                ->rules('required')
                ->min(15)
                ->max(120)
                ->help('in Minuten'),
            Markdown::make('Beschreibung', 'description')
                ->alwaysShow()
                ->help('Versuche die Aufgabe so ausführlich wie möglich zu umschreiben, damit die Teilnehmer*innen eine Vorstellung
                davon haben was zu tun ist.'),
            BelongsTo::make('Erstellt von', 'user', \App\Nova\User::class)->searchable(),
            Boolean::make('Orga', 'orga')->help('Nur für die Orga sichtbar'),
            BelongsToMany::make('Shiftroles')->fields(
                function () {
                    return [
                        Number::make('Anzahl', 'count'),
                    ];
                }
            ),
            BelongsToMany::make('Users')->fields(
                function () {
                    return [
                        //Bug: with BelongsTo App\Nova\User above this field is not working, because User overrides this
                        Select::make('Shiftrole', 'shiftrole_id')->options(Shiftrole::pluck('name', 'id')->toArray())->displayUsingLabels(),
                    ];
                }
            ),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    public static function label()
    {
        return 'Schichten';
    }

    public static function singularLabel()
    {
        return 'Schicht';
    }
}
