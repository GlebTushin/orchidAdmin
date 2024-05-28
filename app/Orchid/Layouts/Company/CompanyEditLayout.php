<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Company;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class CompanyEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('company.company_name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Company_name'))
                ->placeholder(__('Company_name')),

            Input::make('company.lat')
                ->type('text')
                ->required()
                ->title(__('Lat'))
                ->placeholder(__('Lat')),
            Input::make('company.lng')
                ->type('text')
                ->required()
                ->title(__('Lng'))
                ->placeholder(__('Lng')),
        ];
    }
}
