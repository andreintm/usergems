<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\User;
use App\Repositories\Interfaces\EventRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Services\Calendar\Data\Event as CalendarEventData;

class EventRepository implements EventRepositoryInterface
{

    public function all(): Collection
    {
        return Event::all();
    }

    public function find(int $id): Model
    {
        return Event::query()->findOrFail($id);
    }

    public function isNotChanged(User $user, CalendarEventData $calendarEventData): bool
    {
        return $user->events()
            ->whereEventId($calendarEventData->id)
            ->whereChangedAt($calendarEventData->changed)
            ->exists();
    }

    public function updateOrCreate(User $user, CalendarEventData $calendarEventData): Model
    {
        return $user->events()->updateOrCreate([
            'event_id' => $calendarEventData->id
        ], [
            'title' => $calendarEventData->title,
            'start_at' => $calendarEventData->start,
            'end_at' => $calendarEventData->end,
            'changed_at' => $calendarEventData->changed,
        ]);
    }

    /**
     * @param User $user
     * @param Carbon $date
     * @return Collection
     */
    public function byDate(User $user, Carbon $date): Collection
    {
        return $user->events()->whereDate('start_at', $date->format('Y-m-d'))->get();
    }
}
