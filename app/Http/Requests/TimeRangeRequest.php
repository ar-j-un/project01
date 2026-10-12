<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TimeRangeRequest extends FormRequest
{
    public const PRESETS         = [1, 2, 3, 7, 30];
    public const DEFAULT_RANGE   = '3';
    public const MAX_CUSTOM_DAYS = 30;
    protected $redirectRoute = 'dashboard';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'range' => ['nullable', Rule::in([...self::PRESETS, 'custom'])],

            'from' => [
                'exclude_unless:range,custom',
                'required',
                'date_format:Y-m-d',
                'before_or_equal:today',
            ],
            'to' => [
                'exclude_unless:range,custom',
                'required',
                'date_format:Y-m-d',
                'after_or_equal:from',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'range.in'              => 'Please choose a valid time range.',
            'from.required'         => 'Select a start date for the custom range.',
            'to.required'           => 'Select an end date for the custom range.',
            'from.date_format'      => 'The start date must be in YYYY-MM-DD format.',
            'to.date_format'        => 'The end date must be in YYYY-MM-DD format.',
            'from.before_or_equal'  => 'The start date cannot be in the future.',
            'to.after_or_equal'     => 'The end date must be on or after the start date.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            if ($this->input('range') !== 'custom' || $v->errors()->hasAny(['from', 'to'])) {
                return;
            }

            $from = Carbon::createFromFormat('Y-m-d', $this->input('from'))->startOfDay();
            $to   = Carbon::createFromFormat('Y-m-d', $this->input('to'))->startOfDay();

            if ($from->diffInDays($to) >= self::MAX_CUSTOM_DAYS) {
                $v->errors()->add('to', 'The custom range cannot be longer than '.self::MAX_CUSTOM_DAYS.' days.');
            }
        });
    }

    public function period(): array
    {
        $tz = config('app.timezone');

        if ($this->validated('range') === 'custom') {
            $start = Carbon::createFromFormat('Y-m-d', $this->validated('from'), $tz)->startOfDay();
            $end   = Carbon::createFromFormat('Y-m-d', $this->validated('to'), $tz)->endOfDay();

            return [$start, $end->isFuture() ? now() : $end];
        }

        $days = (int) ($this->validated('range') ?? self::DEFAULT_RANGE);

        return [now()->subDays($days)->startOfHour(), now()];
    }

    public function filters(): array
    {
        return [
            'range' => $this->validated('range') ?? self::DEFAULT_RANGE,
            'from'  => $this->validated('from'),
            'to'    => $this->validated('to'),
        ];
    }
}