<?php

namespace Modules\Pkg_CahierText\app\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CahierEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('formateurs')->check() || auth('responsables')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'module_id' => 'required|exists:modules,id',
            'date' => 'required|date',
            'heures_prevues' => 'required|numeric|min:0.5|max:8',
            'heure_debut' => 'required',
            'contenu' => 'nullable|string',
            'objectifs' => 'nullable|string',
        ];
    }
}
