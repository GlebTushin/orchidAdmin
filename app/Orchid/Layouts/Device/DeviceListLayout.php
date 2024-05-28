<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Device;

use App\Models\Device;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DeviceListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'devices';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
        

            TD::make(__('Компания'))->render(fn($device)=> $device->company->company_name)
            ->sort()
            ->cantHide()
            ->filter(Input::make()),
            
            TD::make( __('ТС'))->render(fn($device)=> $device->vehicle->name)
            ->sort()
            ->cantHide()
            ->filter(Input::make()),

            TD::make('name', __('Название'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),

            TD::make('external_id', __('Номер'))
                ->sort(),

            TD::make('phone_number', __('Номер Телефона'))
                ->sort(),

            TD::make('status', __('Статус'))
                ->defaultHidden()
                ->sort(),
            
            TD::make('comment', __('Комментарий'))
                ->defaultHidden()
                ->sort(),


            TD::make('created_at', __('Создан'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),

            TD::make('updated_at', __('Изменен'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->sort(),
               TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Device $device) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Изменить'))
                            ->route('platform.systems.devices.edit', $device->device_id)
                            ->icon('bs.pencil'),
                        Button::make(__('Удалить'))
                            ->icon('bs.trash3')
                            ->confirm(__('Устройство будет окончательно удалено'))
                            ->method('remove', [
                                'device_id' => $device->device_id,
                            ]),
                    ])),
                    
        ];
    }
}
