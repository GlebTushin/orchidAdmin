<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Device;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class DeviceEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('device.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Имя'))
                ->placeholder(__('Name')),
                Input::make('device.external_id')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Номер'))
                ->placeholder(__('external_id')),
                Input::make('device.phone_number')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Номер Телефона'))
                ->placeholder(__('phone_number')),
                Input::make('device.status')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Статус'))
                ->placeholder(__('status')),
                Input::make('device.comment')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Комментарий'))
                ->placeholder(__('comment')),

        ];
    }
}
