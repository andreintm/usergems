<?php

namespace App\Repositories;

use App\Enums\AttendeeStatus;
use App\Models\Attendee;
use App\Models\Company;
use App\Models\Event;
use App\Repositories\Interfaces\AttendeeRepositoryInterface;
use App\Services\Person\Data\Person;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Services\Person\Data\Company as PersonCompanyData;

class AttendeeRepository implements AttendeeRepositoryInterface
{
    public function all(): Collection
    {
        return Attendee::all();
    }

    public function find(int $id): Model
    {
        return Attendee::query()->firstOrFail($id);
    }

    public function updateOrCreate(
        Event $event,
        Person $person,
        AttendeeStatus $status,
    ): Model {
        return DB::transaction(function () use ($event, $person, $status) {
            $data = $person->only(
                'email',
                'firstName',
                'lastName',
                'avatarUrl',
                'title',
                'linkedinUrl'
            )->toArray();

            if ($person->company instanceof PersonCompanyData) {
                $company = Company::query()->updateOrCreate([
                    'name' => $person->company->name,
                ], $person->company->toArray());

                $data['company_id'] = $company->id;
            }

            /** @var Attendee $attendee */
            $attendee = $event->attendees()->updateOrCreate(
                ['email' => $person->email],
                $data,
                ['status' => $status]
            );

            return $attendee;
        });
    }

    /**
     * @param Attendee $attendee
     * @param Attendee $withAttendee
     * @return int
     */
    public function totalMeetings(Attendee $attendee, Attendee $withAttendee): int
    {
        return $attendee->events()->whereHas('attendees', function ($query) use ($withAttendee) {
            $query->where('attendees.id', $withAttendee->id);
        })->count();
    }

    public function metWith(Attendee $attendee, Attendee $excludeAttendee): Collection
    {
        return $attendee
            ->events()
            ->with('attendees', static function ($query) use ($excludeAttendee, $attendee) {
                return $query
                    ->where('attendees.company_id', $attendee->company->id)
                    ->where('attendees.id', '<>', $excludeAttendee->id);
            })
            ->get()
            ->pluck('attendees')
            ->flatten(1)
            ->groupBy('id')
            ->map(static fn ($attendees) => [
                'colleague' => $attendees->first()->first_name,
                'count' => $attendees->count()
            ]);
    }
}
