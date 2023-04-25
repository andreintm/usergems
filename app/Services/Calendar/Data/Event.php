<?php

namespace App\Services\Calendar\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\DataPipeline;

class Event extends Data
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        public int $id,

        #[WithCast(DateTimeInterfaceCast::class, format: self::DATE_FORMAT)]
        public Carbon $changed,

        #[WithCast(DateTimeInterfaceCast::class, format: self::DATE_FORMAT)]
        public Carbon $start,

        #[WithCast(DateTimeInterfaceCast::class, format: self::DATE_FORMAT)]
        public Carbon $end,

        public string $title,

        #[DataCollectionOf(Person::class)]
        public DataCollection $people,
    ){
    }

    public static function pipeline(): DataPipeline
    {
        return parent::pipeline()
            ->firstThrough(PeopleDataPipe::class);
    }
}
