<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Company;

use App\Models\Company;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CompanyListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'companies';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('company_name', __('company_name'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),


            TD::make('lat', __('lat'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),
            TD::make('lng', __('lng'))
                ->sort()
                ->cantHide()
                ->filter(Input::make()),


            TD::make('created_at', __('Created'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->defaultHidden()
                ->sort(),

            TD::make('updated_at', __('Last edit'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->sort(),
               TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Company $company) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make(__('Edit'))
                            ->route('platform.systems.companies.edit', $company->company_id)
                            ->icon('bs.pencil'),
                        Button::make(__('Delete'))
                            ->icon('bs.trash3')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->method('remove', [
                                'company_id' => $company->company_id,
                            ]),
                    ])),
                    
        ];
    }
}
