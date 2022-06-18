<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class DrivingService extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\DrivingService::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'day', 'time'
    ];

    public static $searchRelations = [
        'driver' => ['name'],
        'user' => ['name'],
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Select::make('Am', 'day')->options([
                'Anreise Do 30. Juni' => 'Anreise Do 30. Juni',
                'Anreise Fr 1. Juli' => 'Anreise Fr 1. Juli',
                'Abreise So 3. Juli' => 'Abreise So 3. Juli',
                'Abreise Mo 4. Juli' => 'Abreise Mo 4. Juli',
            ])->sortable(),
            Text::make('Uhrzeit', 'time')->sortable(),
            BelongsTo::make('User')->searchable(),
            BelongsTo::make('Driver', 'driver', \App\Nova\User::class)->nullable()->searchable(),

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
        return 'Fahrdienst';
    }

    public static function singularLabel()
    {
        return 'Fahrdienst';
    }
}
