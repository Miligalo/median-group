<?php

namespace App\Livewire;

use App\Http\Requests\LeadFormRequest;
use App\Services\CrmService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LeadForm extends Component
{
    public string $name    = '';
    public string $phone   = '';
    public string $email   = '';
    public string $message = '';

    public ?bool  $submitted     = null;
    public string $statusMessage = '';

    protected function rules(): array
    {
        return LeadFormRequest::leadRules();
    }

    protected function messages(): array
    {
        return LeadFormRequest::leadMessages();
    }

    public function updated(string $field): void
    {
        $this->validateOnly($field);
    }

    public function submit(CrmService $crm): void
    {
        $validated = $this->validate();

        $result = $crm->submitLead($validated);

        if ($result['success']) {
            $this->submitted     = true;
            $this->statusMessage = 'Thank you! Your message has been sent. We will contact you shortly.';
            $this->reset(['name', 'phone', 'email', 'message']);
        } else {
            $this->submitted     = false;
            $this->statusMessage = $result['message'];
        }
    }

    public function render(): View
    {
        return view('livewire.lead-form');
    }
}
