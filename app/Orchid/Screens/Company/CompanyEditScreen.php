<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Company;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Company\CompanyEditLayout;

class CompanyEditScreen extends Screen
{
    /**
     * @var Company
     */
    public $company;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Company $company): iterable
    {
        return[
            'company' => $company
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->company->exists ? 'Edit Company' : 'Create Company';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return '';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                ->method('remove')
                ->canSee($this->company->exists),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::block(CompanyEditLayout::class)
                ->title(__('Profile Information'))
                ->description(__('Update your account\'s profile information and email address.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::BASIC)
                        ->icon('bs.check-circle')
                        ->canSee($this->company->exists)
                        ->method('save')
                ),


        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Company $company, Request $request)
    {
        $request->validate([
            'company_name',
        'lat',
        'lng',

        ]);

        $company->fill($request->collect('company')->toArray())->save();

        Toast::info(__('company was saved.'));

        return redirect()->route('platform.systems.companies');
    }

    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Company $company)
    {
        $company->delete();

        Toast::info(__('Company was removed'));

        return redirect()->route('platform.systems.companies');
    }


}
