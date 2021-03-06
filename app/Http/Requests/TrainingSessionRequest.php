<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\TrainingSession;
use Carbon\Carbon;

class TrainingSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>['required','string','min:5','max:50','string',Rule::unique('training_sessions')->ignore($this->name,'name')],
            'starts_at'=>[
                $this->routeIs('dashboard.training-sessions.store') ? 'required' : 'nullable',
                'date'
                ,Rule::unique('training_sessions')->ignore($this->starts_at,'starts_at')
            ],
            'finishes_at'=>[
                $this->routeIs('dashboard.training-sessions.store') ? 'required' : 'nullable'
            ,'date',Rule::unique('training_sessions')->ignore($this->finishes_at,'finishes_at'),'after:starts_at'],
            'gym_id' => ['required','int'],
            'coach_id'=>['int',$this->routeIs('dashboard.training-sessions.store') ? 'required' : 'nullable'],
            'count' => 'numeric|max:0',
        ];
    }

    private function count() :int
    {
        $start =  Carbon::parse($this->starts_at);
        $end =  Carbon::parse($this->finishes_at);
       $trainingSessions = TrainingSession::
       whereBetween('starts_at', [$start, $end])
       ->orWhereBetween('finishes_at',[$start, $end])->get();


       if(!$this->routeIs('dashboard.training-sessions.store')) {
         return $trainingSessions->whereNotIn('id', [request()->route('training_session')->id])->count();
       }
       return $trainingSessions->count();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'count' => $this->count(),
        ]);
    }
}
