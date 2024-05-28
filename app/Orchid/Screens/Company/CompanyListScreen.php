<?php

namespace App\Orchid\Screens\Company;

use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Group;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Orchid\Layouts\Company\CompanyListLayout;
use App\Orchid\Layouts\Company\CompanyEditLayout;

class CompanyListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return ['companies'=> Company::all()];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Компании';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавление компании')->modal('createCompany')->method('create')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            CompanyListLayout::class,
            Layout::modal('createCompany',Layout::rows([
                Input::make('company_name')->required()->title('Название'),
                Group::make([
                Input::make('lat')->required()->title('Широта'),
                Input::make('lng')->required()->title('Долгота'),
                ]),
            ]))->title('Создать компанию')->applyButton('Добавить компанию'),
            Layout::modal('asyncEditCompanyModal', CompanyEditLayout::class)
        ->async('asyncGetCompany'),
        ];
        
    }
public function asyncCompany(Company $company): iterable
    {
        return [
            'company' => $company,
        ];
    }
  public function create(Request $request):void
  { $request->validate([
    'company_name'=> ['required'],
    'lat' =>    ['required'],
    'lng' =>['required'],
  ]);
    Company::create($request->merge([])->except('_token'));
    Toast::info('Компания добалена');
  }
  public function remove(Request $request): void
  { 
      Company::findOrFail($request->get('company_id'))->delete();

      Toast::info(__('Company was removed'));
  }
}
